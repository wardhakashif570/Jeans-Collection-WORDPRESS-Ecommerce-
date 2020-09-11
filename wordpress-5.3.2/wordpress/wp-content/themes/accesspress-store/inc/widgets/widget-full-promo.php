<?php

/**
 * Full Width Promo Widget
 *
 * @package Accesspress Store
 */
/**
 * Adds accesspress_store_full_widget Promo.
 */
add_action('widgets_init', 'register_full_promo_widget');

function register_full_promo_widget() {
    register_widget('accesspress_store_full_promo');
}

if( !class_exists( 'accesspress_store_full_promo' ) ) :
class accesspress_store_full_promo extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'accesspress_store_full_promo', 'AP : Promo FullWidth Widget', array(
                'description' => __('A widget that Gives Full Width Promo of the object', 'accesspress-store')
                )
            );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        $fields = array(
            'promo_title' => array(
                'accesspress_store_widgets_name' => 'promo_title',
                'accesspress_store_widgets_title' => esc_html__('Title', 'accesspress-store'),
                'accesspress_store_widgets_field_type' => 'text',
                ),
            
            'promo_image' => array(
                'accesspress_store_widgets_name' => 'promo_image',
                'accesspress_store_widgets_title' => esc_html__('Upload Image', 'accesspress-store'),
                'accesspress_store_widgets_field_type' => 'upload',
                ),

            'promo_style' => array(
                'accesspress_store_widgets_name' => 'promo_style',
                'accesspress_store_widgets_title' => esc_html__('Select FullWidth Style', 'accesspress-store'),
                'accesspress_store_widgets_field_type' => 'select',
                'accesspress_store_widgets_field_options' => array('style_one' => 'Style One', 'style_two' => 'Style Two')                
            ),

            'promo_title_sub' => array(
                'accesspress_store_widgets_name' => 'promo_title_sub',
                'accesspress_store_widgets_title' => esc_html__('Sub Title', 'accesspress-store'),
                'accesspress_store_widgets_field_type' => 'text',
                ),
            
            'promo_desc' => array(
                'accesspress_store_widgets_name' => 'promo_desc',
                'accesspress_store_widgets_title' => esc_html__('Enter Promo Desc', 'accesspress-store'),
                'accesspress_store_widgets_field_type' => 'textarea',   
                'accesspress_store_widgets_row' =>'4',
                ),

            'promo_link_btn' => array(
                'accesspress_store_widgets_name' => 'promo_link_btn',
                'accesspress_store_widgets_title' => esc_html__('Enter Promo Button Text', 'accesspress-store' ),
                'accesspress_store_widgets_field_type' => 'text'
                ),
            
            'promo_link' => array(
                'accesspress_store_widgets_name' => 'promo_link',
                'accesspress_store_widgets_title' => esc_html__('Enter Promo Link', 'accesspress-store' ),
                'accesspress_store_widgets_field_type' => 'url'
                ),
            
            
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
        if($instance!=null){        
            $promo_title = isset( $instance['promo_title'] ) ? $instance['promo_title'] : '';
            $promo = isset( $instance['promo_image'] ) ? $instance['promo_image'] : '';
            $promo_title_sub = isset( $instance['promo_title_sub'] ) ? $instance['promo_title_sub'] : '';
            $promo_desc = isset( $instance['promo_desc'] ) ? $instance['promo_desc'] : '';
            $promo_style = isset($instance['promo_style']) ? $instance['promo_style'] : 'style_one';
            if(isset($instance['promo_link_btn'])){
                $promo_link_btn = $instance['promo_link_btn'];            }
            $promo_link = isset( $instance['promo_link'] ) ? $instance['promo_link'] : '';

            echo wp_kses_post($before_widget); 
            ?>
            <div class="promo-widget-wrap-full <?php echo esc_attr($promo_style); ?>">
               <a href="<?php echo esc_url($promo_link); ?>">
                   <div class="promo-image">
                    <?php if (!empty($promo)): ?>
                        <img src = "<?php echo esc_url($promo); ?>" alt="<?php echo esc_attr($promo_title); ?>" />
                    <?php endif; ?>
                    <div class="caption wow fadeIn" data-wow-delay="1s">
                        <?php if (!empty($promo_title)): ?>
                            <h4 class="widget-title"><?php echo esc_html($promo_title); ?></h4>
                        <?php endif; ?>
                        
                        <?php if (!empty($promo_title_sub)): ?>
                            <div class="promo-desc-title"><?php echo esc_html($promo_title_sub); ?></div>
                        <?php endif; ?> 

                        <?php if (!empty($promo_desc)): ?>
                            <div class="promo-desc"><?php echo wp_kses_post($promo_desc); ?></div>
                        <?php endif; ?> 

                        <?php if (!empty($promo_link_btn)): ?>
                            <span class="btn promo-link-btn"><?php echo esc_html($promo_link_btn); ?></span>
                        <?php endif; ?>   
                    </div>                 
                </div>
            </a>                        
        </div>        
        <?php 
        echo wp_kses_post($after_widget);
    }
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

            // Make array elements available as variables
            extract($widget_field);
            $accesspress_store_widgets_field_value = !empty($instance[$accesspress_store_widgets_name]) ? esc_attr($instance[$accesspress_store_widgets_name]) : '';
            accesspress_store_widgets_show_widget_field($this, $widget_field, $accesspress_store_widgets_field_value);
        }
    }
}
endif;