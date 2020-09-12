<?php
defined('ABSPATH') or die('No script kiddies please!');
/**
 * Plugin Name: WP TFeed
 * Plugin URI: https://accesspressthemes.com/wordpress-plugins/accesspress-twitter-feed/
 * Description: A plugin to show your twitter feed in your site with various configurable settings
 * Version: 1.6.2
 * Author: AccessPress Themes
 * Author URI: http://accesspressthemes.com
 * Text Domain: accesspress-twitter-feed
 * Domain Path: /languages/
 * License: GPL
 */
/**
 * Declartion of necessary constants for plugin
 * */
if (!defined('APTF_IMAGE_DIR')) {
    define('APTF_IMAGE_DIR', plugin_dir_url(__FILE__) . 'images');
}
if (!defined('APTF_JS_DIR')) {
    define('APTF_JS_DIR', plugin_dir_url(__FILE__) . 'js');
}
if (!defined('APTF_CSS_DIR')) {
    define('APTF_CSS_DIR', plugin_dir_url(__FILE__) . 'css');
}
if (!defined('APTF_VERSION')) {
    define('APTF_VERSION', '1.6.2');
}

if (!defined('APTF_TD')) {
    define('APTF_TD', 'accesspress-twitter-feed');
}
include_once('inc/backend/widget.php');
include_once('inc/backend/slider-widget.php');
include_once("twitteroauth/twitteroauth.php");
if (!class_exists('APTF_Class')) {

    class APTF_Class {

        var $aptf_settings;

        /**
         * Initialization of plugin from constructor
         */
        function __construct() {
            $this->aptf_settings = get_option('aptf_settings');
            add_action('init', array($this, 'load_text_domain')); //loads plugin text domain for internationalization
            add_filter( 'admin_footer_text', array( $this, 'aptf_admin_footer_text' ) );
            add_action('admin_menu', array($this, 'add_plugin_admin_menu')); //adds the menu in admin section
            add_action('admin_enqueue_scripts', array($this, 'register_admin_scripts')); //registers scripts and css for admin section
            register_activation_hook(__FILE__, array($this, 'load_default_settings')); //loads default settings for the plugin while activating the plugin

            add_action('admin_post_aptf_form_action', array($this, 'aptf_form_action')); //action to save settings
            add_action('admin_post_aptf_restore_settings', array($this, 'aptf_restore_settings')); //action to restore default settings
            add_filter( 'plugin_row_meta', array( $this, 'aptf_plugin_row_meta' ), 10, 2 );
            add_action('admin_post_aptf_delete_cache', array($this, 'aptf_delete_cache')); //action to delete cache
            add_shortcode('ap-twitter-feed', array($this, 'feed_shortcode')); //registers shortcode to display the feeds
            add_shortcode('ap-twitter-feed-slider', array($this, 'feed_slider_shortcode')); //registers shortcode to display the feeds as slider
            add_action('widgets_init', array($this, 'register_widget')); //registers the widget
            add_action('wp_enqueue_scripts',array($this,'register_front_assests'));//registers assets for the frontend
        }

        /**
         * Loads Plugin Text Domain
         * 
         */
        function load_text_domain() {
            load_plugin_textdomain('accesspress-twitter-feed', false, basename(dirname(__FILE__)) . '/languages');
        }

        
        /**
         * Loads Default Settings
         */
        function load_default_settings() {
            $default_settings = $this->get_default_settings();
            if (!get_option('aptf_settings')) {
                update_option('aptf_settings', $default_settings);
            }
            delete_transient('aptf_tweets');
        }

        /**
         * Adds plugin's menu in the admin section
         */
        function add_plugin_admin_menu() {
            add_menu_page(__('WP TFeed', 'accesspress-twitter-feed'), __('WP TFeed', 'accesspress-twitter-feed'), 'manage_options', 'ap-twitter-feed', array($this, 'main_setting_page'), 'dashicons-twitter');
        }

        /**
         * Plugin's main setting page
         */
        function main_setting_page() {
            include('inc/backend/settings.php');
        }

        /**
         * Register all the scripts in admin section
         */
        function register_admin_scripts() {
            if (isset($_GET['page']) && $_GET['page'] == 'ap-twitter-feed') {
                wp_enqueue_script('aptf-admin-script', APTF_JS_DIR . '/backend.js', array('jquery'), APTF_VERSION);
                wp_enqueue_style('aptf-backend-css', APTF_CSS_DIR . '/backend.css', array(), APTF_VERSION);
            }
        }
        
        /**
         * Return default settings array
         * @return array
         */
        function get_default_settings() {
            $default_settings = array('consumer_key' => '',
                'consumer_secret' => '',
                'access_token' => '',
                'access_token_secret' => '',
                'twitter_username' => '',
                'twitter_account_name',
                'cache_period' => '',
                'total_feed' => '5',
                'feed_template' => 'template-1',
                'time_format' => 'elapsed_time',
                'display_username' => 1,
                'display_twitter_actions'=>1,
                'fallback_message'=>'',
                'display_follow_button'=>0
            );
            return $default_settings;
        }
        
       

        /**
         * Prints array in pre format
         */
        function print_array($array) {
            echo "<pre>";
            print_r($array);
            echo "</pre>";
        }

        /**
         * Saves settings in option table
         */
        function aptf_form_action() {
            if (!empty($_POST) && wp_verify_nonce($_POST['aptf_nonce_field'], 'aptf_action_nonce')) {
                include('inc/backend/save-settings.php');
            } else {
                die('No script kiddies please!');
            }
        }

        /**
         * Restores Default Settings
         */
        function aptf_restore_settings() {
            if (!empty($_GET) && wp_verify_nonce($_GET['_wpnonce'], 'aptf-restore-nonce')) {
                $aptf_settings = $this->get_default_settings();
                update_option('aptf_settings', $aptf_settings);
                wp_redirect(admin_url() . 'admin.php?page=ap-twitter-feed&message=3');
            } else {
                die('No script kiddies please!');
            }
        }

        /**
         * Registers shortcode to display feed
         */
        function feed_shortcode($atts) {
            ob_start();
            include('inc/frontend/shortcode.php');
            $html = ob_get_contents();
            ob_get_clean();
            return $html;
        }
        
        /**
         * Register shortcode for feeds slider
         */
        function feed_slider_shortcode($atts){
            ob_start();
            include('inc/frontend/slider-shortcode.php');
            $html = ob_get_contents();
            ob_get_clean();
            return $html;
        }

        /**
         * Deletes Feeds from cache
         */
        function aptf_delete_cache() {
            delete_transient('aptf_tweets');
            wp_redirect(admin_url() . 'admin.php?page=ap-twitter-feed&message=2');
        }
        
        /**
         * 
         * @param varchar $date
         * @param string $format
         * @return type
         */
        function get_date_format($date, $format) {
            $unformatted_date = $date;
            switch($format){
            case 'full_date':
                $date = strtotime($date);
                $date = date('F j, Y, g:i a',$date);
            break;
            case 'date_only':
                $date = strtotime($date);
                $date = date('F j, Y',$date);
            break;
            case 'elapsed_time':
            $current_date = strtotime(date('h:i A M d Y'));
            $tweet_date = strtotime($date);
            $total_seconds = $current_date - $tweet_date;
           
            $seconds = $total_seconds % 60;
            $total_minutes = $total_seconds / 60;
            ;
            $minutes = $total_minutes % 60;
            $total_hours = $total_minutes / 60;
            $hours = $total_hours % 24;
            $total_days = $total_hours / 24;
            $days = $total_days % 365;
            $years = $total_days / 365;

            if ($years >= 1) {
                if($years == 1){
                    $date = $years . __(' year ago', 'accesspress-twitter-feed');
                }
                else
                {
                    $date = $years . __(' year ago', 'accesspress-twitter-feed');    
                }
                
            } elseif ($days >= 1) {
                if($days == 1){
                $date = $days . __(' day ago', 'accesspress-twitter-feed');    
                }
                else
                {
                    $date = $days . __(' days ago', 'accesspress-twitter-feed');
                }
                
            } elseif ($hours >= 1) {
                if($hours == 1){
                 $date = $hours . __(' hour ago', 'accesspress-twitter-feed');    
                }
                else
                {
                    $date = $hours . __(' hours ago', 'accesspress-twitter-feed');
                }
                
            } elseif ($minutes > 1) {
                                    $date = $minutes . __(' minutes ago', 'accesspress-twitter-feed');
                
                
            } else {
                $date = __("1 minute ago", 'accesspress-twitter-feed');
                }
                break;
                default:
                break;
            }
            $date = apply_filters('aptf_date_value',$date,$unformatted_date); 
           return $date;
        }
        
        /**
         * Registers Widget
         */
        function register_widget() {
            register_widget('APTF_Widget');
            register_widget('APTF_Slider_Widget');
        }
        
        /**
         * Registers Assets for frontend
         */
        function register_front_assests(){
            wp_enqueue_script('aptf-bxslider',APTF_JS_DIR.'/jquery.bxslider.min.js',array('jquery'),APTF_VERSION);
            wp_enqueue_style('aptf-bxslider',APTF_CSS_DIR.'/jquery.bxslider.css',array(),APTF_VERSION);
            wp_enqueue_script('aptf-front-js',APTF_JS_DIR.'/frontend.js',array('jquery','aptf-bxslider'),APTF_VERSION);
            wp_enqueue_style('aptf-front-css',APTF_CSS_DIR.'/frontend.css',array(),APTF_VERSION);
            wp_enqueue_style('aptf-font-css',APTF_CSS_DIR.'/fonts.css',array(),APTF_VERSION);
        }
        
        /**
         * New Functions
         * */
         function get_oauth_connection($cons_key, $cons_secret, $oauth_token, $oauth_token_secret){
        	$ai_connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
        	return $ai_connection;
        }

        function get_twitter_tweets($username,$tweets_number){
            $aptf_settings = get_option('aptf_settings');
            $tweets = get_transient('aptf_tweets');
            $tweets = (isset($aptf_settings['disable_cache']) && $aptf_settings['disable_cache']==1)?false:$tweets;
            if (false === $tweets) {
                $aptf_settings = $this->aptf_settings;
                $consumer_key = esc_attr($aptf_settings['consumer_key']);
                $consumer_secret = esc_attr($aptf_settings['consumer_secret']);
                $access_token = esc_attr($aptf_settings['access_token']);
                $access_token_secret = esc_attr($aptf_settings['access_token_secret']);
        	    $oauth_connection = $this->get_oauth_connection($consumer_key, $consumer_secret, $access_token, $access_token_secret);
                $api_url = "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$username."&count=".$tweets_number.'&exclude_replies=true';
                $tweets = $oauth_connection->get(apply_filters('aptf_api_url',$api_url,$username,$tweets_number));
                $cache_period = intval(esc_attr($aptf_settings['cache_period'])) * 60;
                $cache_period = ($cache_period < 1) ? 3600 : $cache_period;
                if(!isset($tweets->errors)){
                    set_transient('aptf_tweets', $tweets, $cache_period);
                }
                
            } 
            
        	return $tweets;
        }
        
        function makeClickableLinks($s) {
            return preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.-]*(\?\S+)?)?)?)@', '<a href="$1" target="_blank">$1</a>', $s);
        }
        
        function aptf_plugin_row_meta( $links, $file )
        {
            if ( strpos( $file, 'accesspress-twitter-feed.php' ) !== false ) 
            {
                $new_links = array(
                  'demo' => '<a href="https://demo.accesspressthemes.com/wordpress-plugins/accesspress-twitter-feed-pro/" target="_blank"><span class="dashicons dashicons-welcome-view-site"></span>Live Demo</a>',
                  'doc' => '<a href="https://accesspressthemes.com/documentation/documentation-plugin-instruction-accesspress-twitter-feed-pro/" target="_blank"><span class="dashicons dashicons-media-document"></span>Documentation</a>',
                  'support' => '<a href="http://accesspressthemes.com/support" target="_blank"><span class="dashicons dashicons-admin-users"></span>Support</a>',
                  'pro' => '<a href="https://1.envato.market/c/1302794/275988/4415?u=https%3A%2F%2Fcodecanyon.net%2Fitem%2Faccesspress-twitter-feed-pro%2F11029697" target="_blank"><span class="dashicons dashicons-cart"></span>Premium version</a>'
                );

                $links = array_merge( $links, $new_links );
            }

          return $links;
        }
        
        public function aptf_admin_footer_text($text) 
        {
            if ( isset($_GET['page'] ) && $_GET['page'] == 'ap-twitter-feed' ) {
              $link = 'https://wordpress.org/support/plugin/accesspress-twitter-feed/reviews/#new-post';
              $pro_link = 'https://1.envato.market/c/1302794/275988/4415?u=https%3A%2F%2Fcodecanyon.net%2Fitem%2Faccesspress-twitter-feed-pro%2F11029697';
              $text = 'Enjoyed WP TFeed? <a href="' . $link . '" target="_blank">Please leave us a ★★★★★ rating</a> We really appreciate your support! | Try premium version of <a href="' . $pro_link . '" target="_blank">Accesspress Twitter Feed Pro</a> - more features, more power!';
              return $text;
            } else {
              return $text;
            }
        }

        /**
         * Sanitizes Multi-Dimensional Array
         * @param array $array
         * @param array $sanitize_rule
         * @return array
         *
         * @since 1.6.0
         */
        function sanitize_array($array = array(), $sanitize_rule = array()) 
        {
          if (!is_array($array) || count($array) == 0) 
          {
              return array();
          }

          foreach ($array as $k => $v) {
              if (!is_array($v)) {
                  $default_sanitize_rule = (is_numeric($k)) ? 'html' : 'text';
                  $sanitize_type = isset($sanitize_rule[$k]) ? $sanitize_rule[$k] : $default_sanitize_rule;
                  $array[$k] = self:: sanitize_value($v, $sanitize_type);
              }

              if (is_array($v)) {
                  $array[$k] = self:: sanitize_array($v, $sanitize_rule);
              }
          }

          return $array;
        }

        /**
         * Sanitizes Value
         *
         * @param type $value
         * @param type $sanitize_type
         * @return string
         *
         * @since 1.6.0
         */
        function sanitize_value($value = '', $sanitize_type = 'html') 
        {
          switch ($sanitize_type) 
          {
              case 'text':
                  $allowed_html = wp_kses_allowed_html('post');
                  // var_dump($allowed_html);
                  return wp_kses($value, $allowed_html);
                  break;
              default:
                  return sanitize_text_field($value);
                  break;
          }
        }
    }

    /**
     * Plugin Initialization
     */
    $aptf_obj = new APTF_Class();
}

