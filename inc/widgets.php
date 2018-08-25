<?php
/**
 * Declaring widgets
 *
 * @package finley
 */

add_action( 'widgets_init', 'finley_widgets_init' );

function finley_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'WooCommerce Sidebar', 'finley' ),
		'id'            => 'wc-sidebar',
		'description'   => 'Widget area for WooCommerce Product Archive pages',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}