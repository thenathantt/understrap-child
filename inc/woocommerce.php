<?php
/**
* Understrap already unhooks woocommerce wrappers and adds its own but here we add 
* different wrappers if we are on a single product page
*/

/**
* First unhook the WooCommerce wrappers
*/
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

/**
* Then hook in your own functions to display the wrappers your theme requires
*/
add_action('woocommerce_before_main_content', 'understrap_woocommerce_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'understrap_woocommerce_wrapper_end', 10);

function understrap_woocommerce_wrapper_start() {
	if ( ! is_single() ) {
		$container   = get_theme_mod( 'understrap_container_type' );
		echo '<div class="wrapper" id="woocommerce-wrapper">';
	  echo '<div class="' . esc_attr( $container ) . '" id="content" tabindex="-1">';
		echo '<div class="row">';
		get_template_part( 'global-templates/left-sidebar-check' );
		echo '<main class="site-main" id="main">';
	} else {
		echo '<div class="wrapper" id="woocommerce-wrapper">';
		echo '<main class="site-main" id="main">';
	}
}

function understrap_woocommerce_wrapper_end() {
	if ( ! is_single() ) {
		echo '</main><!-- #main -->';
		get_template_part( 'global-templates/right-sidebar-check' );
	  echo '</div><!-- .row -->';
		echo '</div><!-- Container end -->';
		echo '</div><!-- Wrapper end -->';
	} else {
		echo '</main><!-- #main -->';
		echo '</div><!-- Wrapper end -->';
	}
}

/**
* Add custom sidebar to WooCommerce Product Archives
*/

add_action('woocommerce_before_shop_loop', 'finley_wc_sidebar', 5);

function finley_wc_sidebar(){
	echo '<section id="finley-wc-sidebar" class="">';
		dynamic_sidebar( 'wc-sidebar' );
	echo '</section>';
}

/**
* SINGLE PRODUCT SPECIFIC
*/

/**
* Add wrappers to single product summary
*/

add_action( 'woocommerce_before_single_product_summary', 'finley_single_product_summary_wrapper', 5 );
 
function finley_single_product_summary_wrapper() {
	echo '<section class="single-product-summary">';
	echo '<div class="container">';
	echo '<div class="row">';
}

add_action( 'woocommerce_after_single_product_summary', 'finley_single_product_summary_wrapper_end', 5 );
 
function finley_single_product_summary_wrapper_end() {
	echo '</div><!-- Row end -->';
	echo '</div><!-- Container end -->';
	echo '</section><!-- Section end -->';
}

/**
* Add notice under the add to cart button on single product pages
*/ 

add_action( 'woocommerce_single_product_summary', 'finley_product_notice', 60 );

function finley_product_notice() {
	if ( get_field('notice_under_add_to_cart') ) {
    echo '<div class="product__notice">';
    the_field( 'notice_under_add_to_cart' );
    echo '</div>';
  }
}

/**
* Add custom product meta
*/
add_action('woocommerce_after_single_product_summary', 'finley_custom_product_meta', 10);

function finley_custom_product_meta() {
	wc_get_template_part( 'content', 'custom-product-meta' );
}

/**
* Add wrappers to upsell display
*/

add_action( 'woocommerce_after_single_product_summary', 'finley_upsell_display_wrapper', 14 );
 
function finley_upsell_display_wrapper() {
	echo '<section class="upsell-display">';
	echo '<div class="container">';
	echo '<div class="row">';
}

// default: add_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

add_action( 'woocommerce_after_single_product_summary', 'finley_upsell_display_wrapper_end', 16 );
 
function finley_upsell_display_wrapper_end() {
	echo '</div><!-- Row end -->';
	echo '</div><!-- Container end -->';
	echo '</section><!-- Section end -->';
}

/**
* Add wrappers to related products
*/

add_action( 'woocommerce_after_single_product_summary', 'finley_related_products_wrapper', 19 );
 
function finley_related_products_wrapper() {
	echo '<section class="related-products">';
	echo '<div class="container">';
	echo '<div class="row">';
}

// default: add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_action( 'woocommerce_after_single_product_summary', 'finley_related_products_wrapper_end', 21 );
 
function finley_related_products_wrapper_end() {
	echo '</div><!-- Row end -->';
	echo '</div><!-- Container end -->';
	echo '</section><!-- Section end -->';
}

/**
* Add wrappers to tabs
*/

add_action( 'woocommerce_after_single_product_summary', 'finley_tabs_wrapper', 24 );
 
function finley_tabs_wrapper() {
	echo '<section class="info-tabs">';
	echo '<div class="container">';
	echo '<div class="row">';
}

// Move tabs below related products
// Default
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
// New position
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 25);

add_action( 'woocommerce_after_single_product_summary', 'finley_tabs_wrapper_end', 26 );
 
function finley_tabs_wrapper_end() {
	echo '</div><!-- Row end -->';
	echo '</div><!-- Container end -->';
	echo '</section><!-- Section end -->';
}
