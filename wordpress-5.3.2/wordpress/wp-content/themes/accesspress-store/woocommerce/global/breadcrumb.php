<?php
/**
 * Shop breadcrumb
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.2
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $breadcrumb ) {
	echo wp_kses_post($wrap_before);
	foreach ( $breadcrumb as $key => $crumb ) {
		echo wp_kses_post($before);
		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
		} else {
			echo '<span>'.esc_html( $crumb[0] ).'</span>';
		}
		echo wp_kses_post($after);
		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			echo esc_html($delimiter);
		}
	}
	echo wp_kses_post($wrap_after);
}