<?php

/**
 * Testimonial post/page widget
 *
 * @package Accesspress Pro
 */
/**
 * Adds accesspress_store_Testimonial widget.
 */
add_action('widgets_init', 'register_cta_video_widget');

function register_cta_video_widget() {
    register_widget('accesspress_cta_video');
}

if( !class_exists( 'accesspress_cta_video' ) ) :
class accesspress_cta_video extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'accesspress_cta_video', 'AP : Call to Action with Video', array(
            'description' => esc_html__('A widget that shows Call to Action with Video', 'accesspress-store')
                )
        );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        $fields = array(
            'cta_video_title' => array(
                'accesspress_store_widgets_name' => 'cta_video_title',
                'accesspress_store_widgets_title' => esc_html__('Title', 'accesspress-store'),
                'accesspress_store_widgets_field_type' => 'title',
            ),
            'cta_video_phone' => array(
                'accesspress_store_widgets_name' => 'cta_video_desc',
                'accesspress_store_widgets_title' => esc_html__('Description', 'accesspress-store'),
                'accesspress_store_widgets_field_type' => 'textarea',
                'accesspress_store_widgets_row' => '4'
            ),
            'bg_image' => array(
               'accesspress_store_widgets_name' => 'access_store_image',
               'accesspress_store_widgets_title' => esc_html__('Background Upload Image', 'accesspress-store'),
               'accesspress_store_widgets_field_type' => 'upload',
            ),
            'cta_video_email' => array(
                'accesspress_store_widgets_name' => 'cta_video_iframe',
                'accesspress_store_widgets_title' => esc_html__('Video Iframe', 'accesspress-store'),
                'accesspress_store_widgets_field_type' => 'iframe_textarea',
                'accesspress_store_widgets_row' => '4'
            ),
            'cta_video_website' => array(
                'accesspress_store_widgets_name' => 'cta_video_btn_text',
                'accesspress_store_widgets_title' => esc_html__('Button Text', 'accesspress-store'),
                'accesspress_store_widgets_field_type' => 'text',
            ),
            'cta_video_address' => array(
                'accesspress_store_widgets_name' => 'cta_video_btn_url',
                'accesspress_store_widgets_title' => esc_html__('Button Url', 'accesspress-store'),
                'accesspress_store_widgets_field_type' => 'text'
                
            )
            
        );

        return $fields;
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
        extract($args);
        $cta_video_title = isset($instance['cta_video_title']) ? $instance['cta_video_title'] : '';
        $cta_video_desc = isset($instance['cta_video_desc']) ? $instance['cta_video_desc'] : '';
        $cta_video_iframe = isset($instance['cta_video_iframe']) ? $instance['cta_video_iframe'] : '';
        $cta_video_btn_text = isset($instance['cta_video_btn_text']) ? $instance['cta_video_btn_text'] : '';
        $cta_video_btn_url = isset($instance['cta_video_btn_url']) ? $instance['cta_video_btn_url'] : '';
        $bgfull_image = isset($instance['access_store_image'])? $instance['access_store_image'] : '';
        echo wp_kses_post($before_widget);
        $allowed_output_html = array(
            'iframe' => array(
                    'src' => array(),
                    'width' => array(),
                    'height' => array(),
                    'style' => array(),
                    'frameborder' => array(),
                    'allowfullscreen' => array(),
            ),
        );
        $allowed_output_protocol = array(
                'https',
                'javascript',
                'http',
        );
        
?>
    <style type="text/css">
        #ap-cta-video { background-image: url(<?php echo esc_url($bgfull_image); ?>); }
    </style>
        <div class="cta-video clearfix">
            <div class="cta-wrap-left wow fadeInBounce" data-wow-delay="1s" data-wow-duration="2s">
                <?php echo wp_kses( $cta_video_iframe, $allowed_output_html, $allowed_output_protocol); ?>
            </div>
            <div class="cta-wrap-right wow fadeIn" data-wow-delay="1.5s">
                <h2 class="cta-title main-title"><?php echo esc_html($cta_video_title); ?></h2>
                <div class="cta-desc"><?php echo wp_kses_post($cta_video_desc);  ?></div>
                <a class="bttn cta-video-btn" href="<?php echo esc_url($cta_video_btn_url); ?>"><?php echo esc_html($cta_video_btn_text); ?></a>
            </div>
        </div>
        <?php 
        echo wp_kses_post($after_widget);
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param	array	$new_instance	Values just sent to be saved.
     * @param	array	$old_instance	Previously saved values from database.
     *
     * @uses	accesspress_store_widgets_updated_field_value()		defined in widget-fields.php
     *
     * @return	array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ($widget_fields as $widget_field) {

            extract($widget_field);

            // Use helper function to get updated field values
            $instance[$accesspress_store_widgets_name] = accesspress_store_widgets_updated_field_value($widget_field, $new_instance[$accesspress_store_widgets_name]);
        }

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param	array $instance Previously saved values from database.
     *
     * @uses	accesspress_store_widgets_show_widget_field()		defined in widget-fields.php
     */
    public function form($instance) {
        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ($widget_fields as $widget_field) {
            extract($widget_field);
            $accesspress_store_widgets_field_value = !empty($instance[$accesspress_store_widgets_name]) ? esc_attr($instance[$accesspress_store_widgets_name]) : '';
            accesspress_store_widgets_show_widget_field($this, $widget_field, $accesspress_store_widgets_field_value);
        }
    }
}
endif;
