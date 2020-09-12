<?php

//$this->print_array($_POST);
/**
 * [action] => aptf_form_action
  [consumer_key] => Roo0zrWHjCUrB13fNvsLmBOZN
  [consumer_secret] => 8aU1sfjKaDRK7rmZJ3JXC5cC0zNcunV4CmVYDl8NiuaXtt0NRq
  [access_token] => 256050616-psaikzDyzWQ1tFDNRQzIDpBLSnxNiPB7ieYUKaUG
  [access_token_secret] => 2Rjcetsnc0dYbd8TZlEoUo6Sn51bT1Qa2c9ia8JQUn5g4
  [twitter_username] => @apthemes
  [cache_period] => 60
  [total_feed] => 5
  [feed_template] => template-
  [aptf_nonce_field] => 6f8a90d5c4
  [_wp_http_referer] => /accesspress-twitter-feed/wp-admin/admin.php?page=ap-twitter-feed
  [aptf_settings_submit] => Save Settings
 */
// foreach ($_POST as $key => $val) {
//     $$key = sanitize_text_field($val);
// }

$aptfl_settings_sanitized = array();
$aptfl_settings_sanitized = stripslashes_deep( $this->sanitize_array( $_POST ) );

$aptf_settings = array('consumer_key' => $aptfl_settings_sanitized['consumer_key'],
    'consumer_secret' => $aptfl_settings_sanitized['consumer_secret'],
    'access_token' => $aptfl_settings_sanitized['access_token'],
    'access_token_secret' => $aptfl_settings_sanitized['access_token_secret'],
    'twitter_username' => $aptfl_settings_sanitized['twitter_username'],
    'twitter_account_name'=>$aptfl_settings_sanitized['twitter_account_name'],
    'cache_period' => $aptfl_settings_sanitized['cache_period'],
    'total_feed' => $aptfl_settings_sanitized['total_feed'],
    'feed_template' => $aptfl_settings_sanitized['feed_template'],
    'time_format' => $aptfl_settings_sanitized['time_format'],
    'display_username' => isset($aptfl_settings_sanitized['display_username'])?1:0,
    'display_twitter_actions'=>isset($aptfl_settings_sanitized['display_twitter_actions'])?1:0,
    'fallback_message'=>$aptfl_settings_sanitized['fallback_message'],
    'display_follow_button'=>isset($aptfl_settings_sanitized['display_follow_button'])?1:0,
    'disable_cache'=>isset($aptfl_settings_sanitized['disable_cache'])?1:0
);

$aptf_settings = apply_filters('aptf_settings',$aptf_settings);
update_option('aptf_settings', $aptf_settings);
wp_redirect(admin_url().'admin.php?page=ap-twitter-feed&message=1');

