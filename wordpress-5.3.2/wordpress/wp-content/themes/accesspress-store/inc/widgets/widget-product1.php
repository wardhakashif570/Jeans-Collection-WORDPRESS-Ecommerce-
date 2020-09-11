<?php
/**
 ** Widget Product 1
 **/
add_action('widgets_init', 'register_product_widget');
function register_product_widget(){
  register_widget('accesspress_store_product');
}
class accesspress_store_product extends WP_Widget {
    /**
     * Register Widget with Wordpress
     * 
     */
    public function __construct() {
      parent::__construct(
        'accesspress_store_product', 'AP: WooCommerce Product Slider', array(
          'description' => __('The Product Slide Choose your type', 'accesspress-store')
          )
        );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {

      $prod_type = array(
        'category' => esc_html__('Category', 'accesspress-store'),
        'latest_product' => esc_html__('Latest Product', 'accesspress-store'),
        'upsell_product' => esc_html__('UpSell Product', 'accesspress-store'),
        'feature_product' => esc_html__('Feature Product', 'accesspress-store'),
        'on_sale' => esc_html__('On Sale Product', 'accesspress-store'),
        );
      $taxonomy     = 'product_cat';
      $empty        = 1;
      $orderby      = 'name';  
          $show_count   = 0;      // 1 for yes, 0 for no
          $pad_counts   = 0;      // 1 for yes, 0 for no
          $hierarchical = 1;      // 1 for yes, 0 for no  
          $title        = '';  
          $empty        = 0;
          $args = array(
            'taxonomy'     => $taxonomy,
            'orderby'      => $orderby,
            'show_count'   => $show_count,
            'pad_counts'   => $pad_counts,
            'hierarchical' => $hierarchical,
            'title_li'     => $title,
            'hide_empty'   => $empty

            );
          $woocommerce_categories = array();
          $woocommerce_categories_obj = get_categories($args);
          $woocommerce_categories[''] = 'Select Product Category: ';
          foreach ($woocommerce_categories_obj as $category) {
            $woocommerce_categories[$category->term_id] = $category->name;
          }

          $fields = array(
            'product_title' => array(
              'accesspress_store_widgets_name' => 'product_title',
              'accesspress_store_widgets_title' => esc_html__('Title', 'accesspress-store'),
              'accesspress_store_widgets_field_type' => 'text',

              ),
            'product_type' => array(
              'accesspress_store_widgets_name' => 'product_type',
              'accesspress_store_widgets_title' => esc_html__('Select Product Type', 'accesspress-store'),
              'accesspress_store_widgets_field_type' => 'select',
              'accesspress_store_widgets_field_options' => $prod_type

              ),
            'product_category' => array(
              'accesspress_store_widgets_name' => 'product_category',
              'accesspress_store_widgets_title' => esc_html__('Select Product Category (This category option does not work on Feature Product and On Sale Products)', 'accesspress-store'),
              'accesspress_store_widgets_field_type' => 'select',
              'accesspress_store_widgets_field_options' => $woocommerce_categories

              ),
            
            'product_number' => array(
              'accesspress_store_widgets_name' => 'number_of_prod',
              'accesspress_store_widgets_title' => esc_html__('Select the number of Product to show', 'accesspress-store'),
              'accesspress_store_widgets_field_type' => 'number',
              ),
            

            );
return $fields;
}
public function widget($args, $instance){
  extract($args);
  if($instance!=null){
    $product_title      =   isset($instance['product_title']) ? $instance['product_title'] : '';
    $product_type       =   isset($instance['product_type']) ? $instance['product_type'] : '';
    $product_category   =   isset($instance['product_category']) ? $instance['product_category'] : '';
    $product_number     =   isset($instance['number_of_prod']) ? $instance['number_of_prod'] : '';
    $product_label_custom = '';
    $product_args       =   '';
    if($product_type == 'category'){
      $product_args = array(
        'post_type' => 'product',
        'tax_query' => array(array('taxonomy'  => 'product_cat',
         'field'     => 'term_id', 
         'terms'     => $product_category                                                                 
         )),
        'posts_per_page' => $product_number
        );
    }
    elseif($product_type == 'latest_product'){
      $product_label_custom = __('New!', 'accesspress-store');
      $product_args = array(
        'post_type' => 'product',
        'tax_query' => array(array('taxonomy'  => 'product_cat',
         'field'     => 'term_id', 
         'terms'     => $product_category                                                                 
         )),
        'posts_per_page' => $product_number
        );
    }

    elseif($product_type == 'upsell_product'){
      $product_args = array(
        'post_type'         => 'product',
        'posts_per_page'    => 10,
        'meta_key'          => 'total_sales',
        'orderby'           => 'meta_value_num',
        'tax_query' => array(array('taxonomy'  => 'product_cat',
         'field'     => 'term_id', 
         'terms'     => $product_category                                                                 
         )),
        'posts_per_page'    => $product_number
        );
    }

    elseif($product_type == 'feature_product'){
      $tax_query[] = array(
        'taxonomy' => 'product_visibility',
        'field'    => 'name',
        'terms'    => 'featured',
        'operator' => 'IN',
      );
      $product_args = array(
        'post_type'        => 'product',   
        'post_status'         => 'publish',
        'ignore_sticky_posts' => 1,
        'orderby'  => 'date',
        'order'    => 'desc',         
        'posts_per_page'   => $product_number,
        'tax_query'           => $tax_query,
       );
    }

    elseif($product_type == 'on_sale'){
      $product_args = array(
        'post_type'      => 'product',
        'meta_query'     => array(
          'relation' => 'OR',
          array( // Simple products type
            'key'           => '_sale_price',
            'value'         => 0,
            'compare'       => '>',
            'type'          => 'numeric'
            ),
          array( // Variable products type
            'key'           => '_min_variation_sale_price',
            'value'         => 0,
            'compare'       => '>',
            'type'          => 'numeric'
            )
          )
        );
    }

    if($product_type == 'category' && !empty($product_category)){
    // category link view all
      $cat_id = get_term($product_category,'product_cat');
      $category_id = $cat_id->term_id;
      $category_link = get_term_link( $category_id,'product_cat' );

    }
    else{
      $category_link = get_permalink( wc_get_page_id( 'shop' ) );
    }
    ?>
    <section class="product-slider">
      <div class="ak-container">
        <?php echo wp_kses_post($before_widget); ?>
        <div class="title-bg">
         <h2 class="prod-title"><?php echo esc_attr($product_title); ?></h2>
       </div>
       <ul class="new-prod-slide remove-overload">
        <?php
            $count = 0;        
            $product_loop = new WP_Query( $product_args );
            while ( $product_loop->have_posts() ) : $product_loop->the_post();
            $productcount = $product_loop->found_posts;
            global $product; 
            $count+=0.5;
        ?>
          <li class="span3 wow flipInY <?php if($productcount <= 3){ echo 'access_tab_product_full'; } ?>" data-wow-delay="<?php echo absint($count); ?>s">
            <div class="item-img">
              <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">  
                <?php
                  if ($product_label_custom != ''){
                    echo '<span class="label-new">' . esc_html($product_label_custom) . '</span>';
                  }
                ?>
                <?php
                  /**
                   * woocommerce_before_shop_loop_item_title hook
                   *
                   * @hooked woocommerce_show_product_loop_sale_flash - 10
                   * @hooked woocommerce_template_loop_product_thumbnail - 10
                   */
                  do_action( 'woocommerce_before_shop_loop_item_title' );
                ?>
              </a>
              <?php
            woocommerce_template_loop_add_to_cart( $product_loop->post, $product );
            ?>            
            </div>
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">  
              <h3><?php the_title(); ?></h3>
              <p class="short_desc"><?php echo esc_html(get_the_excerpt()); ?></p>
              <span class="price"><?php echo wp_kses_post($product->get_price_html()); ?></span>
            </a>        
          </li>
        <?php endwhile; 
      }
      ?>
      <?php wp_reset_query(); ?>
    </ul>
    <?php 
    echo wp_kses_post($after_widget);
    ?>
  </div>
</section>
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
     * @uses  accesspress_store_widgets_updated_field_value()   defined in widget-fields.php
     *
     * @return  array Updated safe values to be saved.
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
     * @param array $instance Previously saved values from database.
     *
     * @uses  accesspress_store_widgets_show_widget_field()   defined in widget-fields.php
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