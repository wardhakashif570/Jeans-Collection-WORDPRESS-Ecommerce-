<?php
function unicon_lite_dynamic_styles() {

    $custom_css = '';

    $tpl_color = get_theme_mod( 'tpl_color', '#e24545' );
    $tpl_color_lighter = accesspress_store_colour_brightness($tpl_color, 0.8);
    $tpl_color_darker = accesspress_store_colour_brightness($tpl_color, -0.49);
    $tpl_color_rgb = accesspress_store_hex2rgb($tpl_color);

    if( $tpl_color ) {
       
        /** Background Color **/
        $custom_css .= "
            .ticker-title,
            .headertwo .headertwo-wrap .search-form button.searchsubmit:hover,
            .main-navigation ul ul li a,
            .caption-read-more1::before,
            .widget.widget_accesspress_storemo .btn.promo-link-btn,
            span.onsale,
            #ap-cta-video .cta-video .cta-wrap-right .bttn.cta-video-btn,
            .item-wishlist:hover,
            .style_two .caption .promo-link-btn,
            #content .page_header_wrap #accesspress-breadcrumb span,
            .woocommerce .entry-header .woocommerce-breadcrumb span,
            .woocommerce ul.products li.product .price-cart .gridlist-buttonwrap a.button:hover,
            .woocommerce ul.products li.product .price-cart .add_to_cart_button,
            .woocommerce ul.products li.product .price-cart .added_to_cart,
            .woocommerce ul.products.grid li.product .onsale,
            .woocommerce span.onsale,
            .woocommerce .widget_price_filter .ui-slider .ui-slider-range,
            .woocommerce.widget_price_filter .price_slider_wrapper .price_slider_amount button,
            .woocommerce a.remove:hover,
            .gridlist-toggle a#grid.active,
            .gridlist-toggle a#grid:hover,
            .content-area article .entry-content a.read-more,
            button, input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"],
            .content-area nav .nav-links a,
            #respond input#submit,
            .woocommerce .wishlist_table td.product-add-to-cart a,
            nav.woocommerce-MyAccount-navigation ul li,
            .woocommerce.single.single-product .entry-summary form button.button,
            .woocommerce a.button,
            .woocommerce #respond input#submit,
            .content-area .description_tab.active:before,
            .content-area .reviews_tab.active:before,
            form.woocommerce-ordering:after,
            .content-area .additional_information_tab.active::before,
            .woocommerce.single.single-product .entry-summary .show a,
            .search-form button.searchsubmit,
            .style_one .promo-link-btn,
            .edit-link a{
              background: {$tpl_color};
            }";
            
        /** Darker Background Color **/
            $custom_css .= "
                .main-navigation ul ul li:hover > a,
                .woocommerce #respond input#submit.alt:hover,
                .woocommerce a.button.alt:hover,
                .woocommerce button.button.alt:hover,
                .woocommerce input.button.alt:hover{
                    background: {$tpl_color_darker};
                }";
            
        /** Lighter Background Color **/
            $custom_css .= "
                .woocommerce .cart .button,
                .woocommerce .cart input.button,
                .woocommerce #respond input#submit.alt,
                .woocommerce a.button.alt,
                .woocommerce button.button.alt,
                .woocommerce input.button.alt{
                    background: {$tpl_color_lighter};
                }";
                
        /** 0.51 opacity background **/
            $custom_css .= "
                .page-template .add_to_cart_button,
                .page-template .product_type_simple,
                .page-template .product_type_external,
                .page-template .added_to_cart,
                .woocommerce ul.products li.product a.item-wishlist{
                    background: rgba({$tpl_color_rgb[0]}, {$tpl_color_rgb[1]}, {$tpl_color_rgb[2]}, 0.51);
                }";
        
        /** Color **/
            $custom_css .= "
                .header-callto a i,
                .widget a:hover,
                .widget a:hover:before,
                .headertwo .headertwo-wrap a:hover,
                #site-navigation li a:hover,
                .headertwo .home_navigation .inner_home #menu #site-navigation .store-menu > ul > li:hover > a,
                .headertwo .home_navigation .inner_home #menu #site-navigation .menu > li.current-menu-item > a,
                .headertwo .home_navigation .inner_home #menu #site-navigation .menu > li.current_page_item > a,
                .price del span,
                #ap-cta-video .widget_accesspress_cta_simple .cta-banner .banner-btn a,
                #ap-cta-video .widget_accesspress_cta_simple .cta-banner .banner-btn a i,
                .style_two .caption .promo-link-btn:hover,
                .style_two .caption .promo-desc,
                #top-footer .cta-banner .banner-btn a,
                .top-footer-block .widget_pages a:hover,
                #ak-top:before,
                #content .page_header_wrap header>h1.entry-title,
                .woocommerce .entry-header h1.entry-title,
                .woocommerce ul.products li.product .price-cart .gridlist-buttonwrap a.button:hover,
                .woocommerce ul.products li.product .price-cart .added_to_cart:hover,
                .woocommerce #respond input#submit:hover,
                .woocommerce a.button:hover,
                .woocommerce button.button:hover,
                .woocommerce input.button:hover,
                .woocommerce ul.products li.product .price-cart .gridlist-buttonwrap a.button:hover:before,
                .woocommerce nav.woocommerce-pagination ul li a,
                .woocommerce nav.woocommerce-pagination ul li span,
                #secondary.sidebar ul li:hover>a,
                #secondary.sidebar ul li:hover,
                .woocommerce.widget_price_filter .price_slider_wrapper .price_label,
                .woocommerce .widget_price_filter .price_slider_amount button:hover,
                #secondary.sidebar ul li a span:hover,
                #secondary.sidebar ul li del span.amount,
                .woocommerce a.remove,
                .woocommerce-shipping-calculator a,
                .shop_table a,
                .blog_desc .entry-header p.meta-info a,
                .content-area article .entry-content a.read-more:hover,
                button:hover, input[type=\"button\"]:hover,
                input[type=\"reset\"]:hover,
                input[type=\"submit\"]:hover,
                .content-area article .entry-content span.cat-name,
                .content-area article .entry-content p.meta-info a,
                #respond input#submit:hover,
                .woocommerce .woocommerce-info::before,
                .woocommerce-info a,
                nav.woocommerce-MyAccount-navigation ul li:hover a,
                nav.woocommerce-MyAccount-navigation ul li.is-active a,
                .style_one .promo-desc-title,
                .search-results article .entry-footer .comments-link a:hover,
                .search-results article .entry-footer .cat-links a:hover,
                .search-results article .entry-footer .comments-link a:hover:before,
                .woocommerce ul.products li.product .price-cart .add_to_cart_button:hover,
                .woocommerce.single.single-product .entry-summary form button.button:hover,
                .woocommerce.single.single-product .entry-summary form button.button:hover:before,
                .woocommerce .star-rating span::before, .woocommerce .star-rating::before,
                .woocommerce.single.single-product .woocommerce-tabs ul.tabs li.active a,
                .woocommerce.single.single-product .entry-summary .add_to_wishlist:hover,
                .style_one .promo-link-btn:hover,
                .blog_desc .entry-header span.cat-name,
                .site-info a,
                a{
                   color: {$tpl_color};
                }";
            
        /** Color Important **/
            $custom_css .= "
                .aptf-tweet-content .aptf-tweet-name,
                .aptf-tweet-content a{
                    color: {$tpl_color} !important;
                }";
            
        /** Border Color **/
            $custom_css .= "
                .widget.widget_accesspress_storemo .btn.promo-link-btn,
                .apwidget_title .prod-title::after,
                .apwidget_title .prod-title::after,
                #ap-cta-video .widget_accesspress_cta_simple .cta-banner .banner-btn:after,
                .style_two .caption .promo-link-btn,
                .style_two .caption .promo-link-btn:hover,
                .woocommerce .content-area .products,
                .woocommerce ul.products li.product .price-cart .gridlist-buttonwrap a.button:hover,
                .woocommerce ul.products li.product .price-cart .added_to_cart:hover,
                .woocommerce ul.products li.product .price-cart .add_to_cart_button,
                .woocommerce ul.products li.product .price-cart .added_to_cart,
                .woocommerce .widget_price_filter .price_slider_amount button:hover,
                .woocommerce.widget_price_filter .price_slider_wrapper .price_slider_amount button,
                .woocommerce #respond input#submit,
                .woocommerce a.button,
                .woocommerce button.button,
                .woocommerce input.button,
                .content-area article .entry-content a.read-more:hover,
                #respond .comment-form-author input,
                #respond .comment-form-email input,
                #respond input,
                #respond textarea,
                #respond input#submit,
                #respond input#submit:hover,
                .woocommerce .woocommerce-info,
                .apwidget_title .checkout .woocommerce-billing-fields h3,
                .apwidget_title .checkout .woocommerce-shipping-fields h3,
                .apwidget_title .checkout.woocommerce-checkout > h3#order_review_heading::before,
                .woocommerce.single.single-product .woocommerce-tabs ul.tabs li.active,
                .content-area .description_tab.active:after,
                .content-area .reviews_tab.active:after,
                .search-form button.searchsubmit,
                .style_one .promo-link-btn,
                .style_one .promo-link-btn:hover,
                .inner_home,
                .woocommerce.single.single-product .entry-summary .show a:hover,
                .woocommerce.single.single-product .entry-summary .show a,
                nav.woocommerce-MyAccount-navigation{
                   border-color: {$tpl_color}; 
                }";

        /** Lighter Border Color **/
            $custom_css .= "
                .search-results header.entry-header h2{
                    border-color: {$tpl_color_lighter};
                }";
        
        /** Border Left Color **/
            $custom_css .= "
                .ticker-title:after,
                .main-navigation ul ul li.menu-item-has-children:hover::after{
                    border-left-color: {$tpl_color}; 
                }";
        
        /** Border Right Color **/
            $custom_css .= "
                span.onsale:after,
                .woocommerce ul.products li.product .onsale:after,
                .woocommerce span.onsale:after,
                #content .page_header_wrap #accesspress-breadcrumb span:after,
                .woocommerce .entry-header .woocommerce-breadcrumb span:after{
                    border-right-color: {$tpl_color};
                }";
            
        /** Border Bottom Color **/
            $custom_css .= "
                .main-navigation ul.menu > li > ul::after,
                .apwidget_title .top-footer-block .widget-title,
                .apwidget_title #secondary.sidebar .widget-title,
                .apwidget_title .comments-title,
                .apwidget_title .comments-area .comment-respond h3.comment-reply-title,
                .apwidget_title.woocommerce-cart .cross-sells h2,
                .content-area .description_tab.active::after,
                .content-area .reviews_tab.active::after,
                .content-area .additional_information_tab.active::after,
                .apwidget_title.woocommerce-cart .cart_totals h2{
                    border-bottom-color: {$tpl_color} !important;
                }";
            
        /** Border Top Color **/
            $custom_css .= "
                .headertwo .home_navigation .inner_home #menu .main-navigation ul.menu > li:hover::after,
                .main-navigation ul.menu > li:hover::after{
                    border-top-color: {$tpl_color};                
                }";

        /** Media Query **/
            $custom_css .= "
                @media (max-width: 688px){
                    #menu{
                        border-color: {$tpl_color} !important;
                    }
                }";

                
    }

    wp_add_inline_style( 'accesspress-store-style', $custom_css );
}

add_action( 'wp_enqueue_scripts', 'unicon_lite_dynamic_styles' );

function accesspress_store_colour_brightness($hex, $percent) {
    // Work out if hash given
    $hash = '';
    if (stristr($hex, '#')) {
        $hex = str_replace('#', '', $hex);
        $hash = '#';
    }
    /// HEX TO RGB
    $rgb = array(hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2)));
    //// CALCULATE 
    for ($i = 0; $i < 3; $i++) {
        // See if brighter or darker
        if ($percent > 0) {
            // Lighter
            $rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1 - $percent));
        } else {
            // Darker
            $positivePercent = $percent - ($percent * 2);
            $rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1 - $positivePercent));
        }
        // In case rounding up causes us to go to 256
        if ($rgb[$i] > 255) {
            $rgb[$i] = 255;
        }
    }
    //// RBG to Hex
    $hex = '';
    for ($i = 0; $i < 3; $i++) {
        // Convert the decimal digit to hex
        $hexDigit = dechex($rgb[$i]);
        // Add a leading zero if necessary
        if (strlen($hexDigit) == 1) {
            $hexDigit = "0" . $hexDigit;
        }
        // Append to the hex string
        $hex .= $hexDigit;
    }
    return $hash . $hex;
}

function accesspress_store_hex2rgb($hex) {
    $hex = str_replace("#", "", $hex);

    if (strlen($hex) == 3) {
        $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
        $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
        $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
    } else {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    }
    $rgb = array($r, $g, $b);
    //return implode(",", $rgb); // returns the rgb values separated by commas
    return $rgb; // returns an array with the rgb values
}