<?php
defined('ABSPATH') or die("No script kiddies please!");
/**
 * Adds WP TFeed Widget
 */
class APTF_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
                'aptf_widget', // Base ID
                __('WP TFeed', 'accesspress-twitter-feed'), // Name
                array('description' => __('WP TFeed Widget', 'accesspress-twitter-feed')) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        $follow_button = (isset($instance['follow_button']) && $instance['follow_button']==1)?'true':'false';
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', esc_attr($instance['title'])) . $args['after_title'];
        }
        
        if(isset($instance['template']) && $instance['template']!=''){
            echo do_shortcode('[ap-twitter-feed template="'.esc_attr($instance['template']).'" follow_button="'.$follow_button.'"]');
        }else
        {
            echo do_shortcode('[ap-twitter-feed follow_button="'.$follow_button.'"]');
        }
      echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = isset($instance['title'])?esc_attr($instance['title']):'';
        $template = isset($instance['template'])?esc_attr($instance['template']):'';
        $follow_button = isset($instance['follow_button'])?esc_attr($instance['follow_button']):0;
        
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'accesspress-twitter-feed'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('template'); ?>"><?php _e('Template:', 'accesspress-twitter-feed'); ?></label> 
            <select class="widefat" id="<?php echo $this->get_field_id('template'); ?>" name="<?php echo $this->get_field_name('template'); ?>" >
                <option value="">Default</option>
                <?php for($i=1;$i<=3;$i++){
                    ?>
                    <option value="template-<?php echo $i;?>" <?php selected($template,'template-'.$i);?>>Template <?php echo $i;?></option>
                    <?php
                }?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('follow_button'); ?>"><?php _e('Display Follow Button:', 'accesspress-twitter-feed'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('follow_button'); ?>" name="<?php echo $this->get_field_name('follow_button'); ?>" type="checkbox" value="1" <?php checked($follow_button,true);?>/>
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        //die(print_r($new_instance));
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? esc_attr($new_instance['title']): '';
        $instance['template'] = (!empty($new_instance['template']) ) ? esc_attr($new_instance['template']): '';
        $instance['follow_button'] = isset($new_instance['follow_button'])?esc_attr($new_instance['follow_button']):0;
        return $instance;
    }

}

// class APS_PRO_Widget
?>