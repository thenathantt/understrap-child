<?php
function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {

	// Get the theme data
	$the_theme = wp_get_theme();
    wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_script( 'jquery');
	wp_enqueue_script( 'popper-scripts', get_template_directory_uri() . '/js/popper.min.js', array(), false);
    wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );
    wp_enqueue_script( 'finley-global-js', get_stylesheet_directory_uri() . '/js/global.js', array(), $the_theme->get( 'Version' ), true );
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

function add_child_theme_textdomain() {
    load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );

/**
 * Load widget functions.
 */
require get_stylesheet_directory() . '/inc/widgets.php';

/**
 * Load WooCommerce functions.
 */
require get_stylesheet_directory() . '/inc/woocommerce.php';

//make wp_get_attachment_image lazyloadable
function wp_rocket__wp_get_attachment_image__lazyload( $attachment_id, $size = 'thumbnail', $icon = false, $attr = '' ) {
    $image_html = wp_get_attachment_image( $attachment_id, $size, $icon, $attr );
    if( function_exists( 'rocket_lazyload_images' ) ) {
        return rocket_lazyload_images( $image_html );
    }
    return $image_html;
}

//remove product data tabs
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {

    unset( $tabs['description'] );          // Remove the description tab
    unset( $tabs['additional_information'] );   // Remove the additional information tab

    return $tabs;
}

//add metal type to the loop and single product
remove_action('woocommerce_shop_loop_item_title' , 'woocommerce_template_loop_product_title');
add_action('woocommerce_shop_loop_item_title', 'finley_template_loop_product_title');
if ( ! function_exists( 'finley_template_loop_product_title' ) ) {

    function finley_template_loop_product_title() {
        echo '<p class="product-card__name mt-3 mb-1">' . get_the_title() . '</p>';
        global $product;
        $metal_type = $product->get_attribute('pa_metal-type');
        echo '<p class="product-card__metal-type">' . $metal_type . '</p>';
    }
}

add_action('woocommerce_single_product_summary', 'finley_single_product_metal_type', 6);
if ( ! function_exists( 'finley_single_product_metal_type' ) ) {

    function finley_single_product_metal_type() {
        global $product;
        $metal_type = $product->get_attribute('pa_metal-type');
        echo '<p class="product-card__metal-type mt-0">' . $metal_type . '</p>';
    }
}

//add the notice under the add to cart button on single product pages
// add_action('woocommerce_single_product_summary', 'finley_after_add_to_cart_content', 50);
// function finley_after_add_to_cart_content() {
//     if(get_field('notice_under_add_to_cart')) {
//         echo '<div class="product__notice">';
//         the_field( 'notice_under_add_to_cart' );
//         echo '</div>';
//     }
// }


//add custom product meta data
// add_action('woocommerce_after_single_product_summary', 'finley_custom_product_meta', 10);
// function finley_custom_product_meta() {
//     wc_get_template_part( 'content', 'custom-product-meta' );
// }