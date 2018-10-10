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
// add_action( 'woocommerce_before_main_content',  'fj_metal_type_prompt', 10);
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

add_filter('woocommerce_style_smallscreen_breakpoint','woo_custom_breakpoint');

function woo_custom_breakpoint($px) {
  $px = '767px';
  return $px;
}

add_filter( 'woocommerce_add_to_cart_fragments', function($fragments) {

    ob_start();
    ?>

    <?php woocommerce_mini_cart(); ?>

    <?php $fragments['.fj-mini-cart'] = ob_get_clean();

    return $fragments;

} );

add_shortcode('display_my_account_contents', 'my_account_contents_shortcode');

function my_account_contents_shortcode() {

	if(is_user_logged_in()) : ?>
		<ul class="text-center">
			<?php global $current_user; wp_get_current_user(); ?>
			<li><h5 class="mt-0 mb-3">Hey, <?php echo $current_user->display_name; ?></h5></li>
			<li><a class="hvr-underline-from-center" href="/my-account"><?php _e('Your Account', 'my_account_dropdown'); ?></a></li>
			<li><a class="hvr-underline-from-center" href="/my-account/orders"><?php _e('Your Orders', 'my_account_dropdown'); ?></a></li>
			<li><a class="hvr-underline-from-center" href="/my-account/gift-cards"><?php _e('Your Gift Cards', 'my_account_dropdown'); ?></a></li>
			<li><a class="hvr-underline-from-center" href="/my-account/edit-address"><?php _e('Your Addresses', 'my_account_dropdown'); ?></a></li>
			<li><a class="hvr-underline-from-center" href="<?php echo wp_logout_url(); ?>"><?php _e('Logout', 'my_account_dropdown'); ?></a></li>
		</ul>
	 <?php else : ?>
	 	<h5 class="mt-0 mb-3">Login</h5>
		<form name="loginform" id="loginform" class="loginform fj-loginform" action="<?php echo site_url( '/wp-login.php' ); ?>" method="post">
			<p class="form-row">
				<input id="user_login" type="text" placeholder="<?php _e('Username or email address', 'woocommerce'); ?>" value="" name="log">
			</p>
			<p class="form-row">
				<input id="user_pass" type="password" value="" name="pwd" placeholder="<?php _e('Password', 'woocommerce'); ?>">
			</p>

			<p><input id="wp-submit" type="submit" value="<?php _e('Login', 'woocommerce'); ?>" name="wp-submit" class="btn btn-green"></p>

			<input type="hidden" value="<?php echo site_url( '/my-account' ); ?>" name="redirect_to">
			<input type="hidden" value="1" name="testcookie">
		</form>
		 <?php if ( shortcode_exists( 'yith_wc_social_login' ) ) {
			echo do_shortcode( '[yith_wc_social_login]' ); 
		 } ?> 
		<a class="loginform__link" href="/my-account"><?php _e('Register', 'woocommerce'); ?></a>
		<a class="loginform__link" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
	<?php endif;
}

/**
* SHOP LOOP / GENERAL
*
* Add wrappers conditional classes for breadcrumbs
* Add metal type toggle
* Add custom sidebar to WooCommerce Product Archives
* Remove result count
* Add Off-Cavnas sidebar trigger
* Add divider after filter and sort
* Move product_link_close to after product thumbnail so YITH swatches to not redirect to single product page
* Add product_link tags around product name
* Move add to cart to below product thumnail, this also moves YITH swatches
* Add metal type to the loop and single product
* Remove variation information from product name
* Display currency after price
* Change number of related products output
*/

add_filter('woof_get_request_data', 'my_woof_get_request_data');
 
function my_woof_get_request_data($request)
{
    $request['pa_metal-type'] = '925-sterling-silver';
    return $request;
}


/**
* Add wrappers conditional classes for breadcrumbs
*/

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

add_action( 'woocommerce_before_main_content', 'fj_woocommerce_breadcrumb_wrapper_open', 20 );

function fj_woocommerce_breadcrumb_wrapper_open(){
	$class = '';
	if ( is_product() ) { 
		$class = 'fj-wc-breadcrumb--single-product'; 
	}
	echo '<div class="fj-wc-breadcrumb ' . $class . '">';
}

add_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 25 );

add_action( 'woocommerce_before_main_content', 'fj_woocommerce_breadcrumb_wrapper_close', 30 );

function fj_woocommerce_breadcrumb_wrapper_close(){
	echo '</div>';
}

/**
* Add metal type toggle
*/

add_action( 'woocommerce_archive_description', 'fj_metal_type_toggle', 15 );
 
function fj_metal_type_toggle() {
	wc_get_template_part( 'content', 'metal-type-toggle' );
}

/**
* Add custom sidebar to WooCommerce Product Archives
*/

add_action('woocommerce_before_shop_loop', 'fj_wc_sidebar', 5);

function fj_wc_sidebar(){
	echo '<section class="fj-offcanvas-wrapper fj-offcanvas-wrapper--left fj-offcanvas-wrapper--wc-sidebar hide" class="">';
		echo '<button class="fj-offcanvas-toggle fj-offcanvas-toggle--close fj-offcanvas-toggle--wc-sidebar-x" data-toggle="hide" data-target=".fj-offcanvas-wrapper--wc-sidebar" aria-label="close product filters">✕</button>';
		dynamic_sidebar( 'wc-sidebar' );
	echo '</section>';
}

/**
* Remove result count
*/
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

/**
 * Change number or products per row to 4
 */
add_filter('loop_shop_columns', 'fj_loop_columns');
function fj_loop_columns() {
	return 4;
}

/**
* Add Off-Cavnas sidebar trigger
*/

add_action('woocommerce_before_shop_loop', 'fj_wc_sidebar_trigger', 15);

function fj_wc_sidebar_trigger(){
	echo '<button type="button" class="btn btn-primary fj-offcanvas-toggle" data-toggle="hide" data-target=".fj-offcanvas-wrapper--wc-sidebar" aria-label="open product filters">Filter</button>';
}

/**
* Add divider after filter and sort
*/

add_action( 'woocommerce_before_shop_loop', 'fj_divider', 40 );
function fj_divider(){

	echo '<div class="mt-3 mt-md-4"></div>';

}

/**
* Move product_link_close to after product thumbnail so YITH swatches to not redirect to single product page
*/

add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 20 );

/**
* Add product_link tags around product name
*/
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 5 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 1 );

/**
* Move add to cart to below product thumnail, this also moves YITH swatches
*/

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 1 );

/**
* Add metal type to the loop and single product
*/

add_action('woocommerce_after_shop_loop_item_title', 'fj_template_loop_product_title', 1);
function fj_template_loop_product_title() {
  global $product;
  $metal_type = $product->get_attribute('pa_metal-type');
  echo '<p class="fj-woocommerce-loop-product__custom-attribute">' . $metal_type . '</p>';
}

add_action('woocommerce_single_product_summary', 'fj_single_product_metal_type', 6);
if ( ! function_exists( 'fj_single_product_metal_type' ) ) {

    function fj_single_product_metal_type() {
        global $product;
        $metal_type = $product->get_attribute('pa_metal-type');
        echo '<p class="fj-woocommerce-loop-product__custom-attribute">' . $metal_type . '</p>';
    }
}

/**
* Remove variation information from product name
*/

add_filter( 'woocommerce_product_variation_title_include_attributes', '__return_false' );

/**
* Display currency after price
*/

add_action('woocommerce_price_format', 'fj_add_currency_code', 1, 2);

function fj_add_currency_code($format, $currency_pos) {
	switch ( $currency_pos ) {
		case 'left' :
			$currency = get_woocommerce_currency();
			$format = '%1$s%2$s&nbsp;' . $currency;
		break;
	}
 
	return $format;
}


/**
 * Change number of related products output
 */ 
function woo_related_products_limit() {
  global $product;
	
	$args['posts_per_page'] = 3;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'fj_related_products_args' );
  function fj_related_products_args( $args ) {
	$args['posts_per_page'] = 3; // 4 related products
	$args['columns'] = 3; // arranged in 2 columns
	return $args;
}

/**
* SINGLE PRODUCT SPECIFIC
* 
* Change dropdown text
* Copy title, rating, price and excerpt above image for mobile and add wrappers
* Add wrappers around product images
* Add wrappers to single product summary
* Add notice under the add to cart button
* Add custom product meta (ACF Fields)
* Add wrappers to upsell display
* Add wrappers to related products
* Add wrappers to tabs
* Move tabs below related products
* Remove product meta
* Remove product data tabs
*/


/**
* Chnage dropdown text
*/

add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'fj_wc_filter_dropdown_args', 10 );
function fj_wc_filter_dropdown_args( $args ) {
    $args['show_option_none'] = 'Select...';
    return $args;
}

/**
* Add wrappers around product images and summary
*/
add_action( 'woocommerce_before_single_product_summary', 'fj_product_wrapper_open', 5 );

function fj_product_wrapper_open(){
	echo '<section class="fj-product-wrapper">';
	echo '<div class="container">';
	echo '<div class="row">';
}

add_action( 'woocommerce_after_single_product_summary', 'fj_product_wrapper_close', 5 );

function fj_product_wrapper_close(){
	echo '</div>';
	echo '</div>';
	echo '</section>';
}


/**
* Copy title, rating, price and excerpt above image for mobile and add wrappers
*/

add_action( 'woocommerce_before_single_product_summary', 'fj_single_product_summary_wrapper_mobile_open', 5 );

function fj_single_product_summary_wrapper_mobile_open() {
	echo '<section class="fj-summary-wrapper fj-summary-wrapper--mobile  d-lg-none">';
	echo '<div class="container">';
	echo '<div class="row">';
	echo '<div class="col">';
}

add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_before_single_product_summary', 'fj_single_product_metal_type', 5 );
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_rating', 5 );
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_price', 5 );
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_excerpt', 5 );

add_action( 'woocommerce_before_single_product_summary', 'fj_single_product_summary_wrapper_mobile_close', 5 );

function fj_single_product_summary_wrapper_mobile_close() {
	echo '</div><!-- Col end -->';
	echo '</div><!-- Row end -->';
	echo '</div><!-- Container end -->';
	echo '</section><!-- Section end -->';
}

/**
* Add wrappers around product images
*/

add_action( 'woocommerce_before_single_product_summary', 'fj_image_wrapper_open', 5 );

function fj_image_wrapper_open() {
	echo '<div class="fj-product-image-wrapper col-12 col-lg-6 px-0 pr-lg-3">';
}

add_action( 'woocommerce_before_single_product_summary', 'fj_image_wrapper_close', 30 );

function fj_image_wrapper_close() {
	echo '</div>';
}

/**
* Add wrappers to single product summary
*/

add_action( 'woocommerce_before_single_product_summary', 'fj_single_product_wrapper_open', 40 );
 
function fj_single_product_wrapper_open() {
	echo '<div class="fj-summary-wrapper col-12 col-lg-6 d-flex align-items-center justify-content-center">';
}

add_action( 'woocommerce_after_single_product_summary', 'fj_single_product_wrapper_close', 4 );
 
function fj_single_product_wrapper_close() {
	echo '</div>';
}

/**
* Add notice under the add to cart button on single product pages
*/ 

add_action( 'woocommerce_single_product_summary', 'fj_product_notice', 60 );

function fj_product_notice() {
	if ( get_field('notice_under_add_to_cart') ) {
    echo '<div class="product__notice">';
    the_field( 'notice_under_add_to_cart' );
    echo '</div>';
  }
}

/**
* Add custom product meta
*/
add_action('woocommerce_after_single_product_summary', 'fj_custom_product_meta', 10);

function fj_custom_product_meta() {
	wc_get_template_part( 'content', 'custom-product-meta' );
}

/**
* Add wrappers to upsell display
*/

add_action( 'woocommerce_after_single_product_summary', 'fj_upsell_display_wrapper', 14 );
 
function fj_upsell_display_wrapper() {
	echo '<section class="upsell-display">';
	echo '<div class="container">';
	echo '<div class="row">';
	echo '<div class="col">';
}

// default: add_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

add_action( 'woocommerce_after_single_product_summary', 'fj_upsell_display_wrapper_end', 16 );
 
function fj_upsell_display_wrapper_end() {
	echo '</div><!-- Col end -->';
	echo '</div><!-- Row end -->';
	echo '</div><!-- Container end -->';
	echo '</section><!-- Section end -->';
}

/**
* Add wrappers to related products
*/

add_action( 'woocommerce_after_single_product_summary', 'fj_related_products_wrapper', 19 );
 
function fj_related_products_wrapper() {
	echo '<section class="related-products">';
	echo '<div class="container">';
	echo '<div class="row">';
	echo '<div class="col">';
}

// default: add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_action( 'woocommerce_after_single_product_summary', 'fj_related_products_wrapper_end', 21 );
 
function fj_related_products_wrapper_end() {
	echo '</div><!-- Col end -->';
	echo '</div><!-- Row end -->';
	echo '</div><!-- Container end -->';
	echo '</section><!-- Section end -->';
}

/**
* Add wrappers to tabs
*/

add_action( 'woocommerce_after_single_product_summary', 'fj_tabs_wrapper', 24 );
 
function fj_tabs_wrapper() {
	echo '<section class="info-tabs">';
	echo '<div class="container">';
	echo '<div class="row">';
	echo '<div class="col">';
}

/**
* Move tabs below related products
*/

// Default
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);

// New position
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 25);

add_action( 'woocommerce_after_single_product_summary', 'fj_tabs_wrapper_end', 26 );
 
function fj_tabs_wrapper_end() {
	echo '</div><!-- Col end -->';
	echo '</div><!-- Row end -->';
	echo '</div><!-- Container end -->';
	echo '</section><!-- Section end -->';
}

/**
* Remove product meta
*/
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

/**
* Remove product data tabs 
*/

add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {

    unset( $tabs['description'] );          // Remove the description tab
    unset( $tabs['additional_information'] );   // Remove the additional information tab

    return $tabs;
}

/**
* CART WIDGET
* Remove default buttons and insert new buttons with BS classes
*/

/**
* Remove default buttons and insert new buttons with BS classes
*/
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );

add_action( 'woocommerce_widget_shopping_cart_buttons', 'fj_woocommerce_widget_shopping_cart_button_view_cart', 10 );
add_action( 'woocommerce_widget_shopping_cart_buttons', 'fj_woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );

function fj_woocommerce_widget_shopping_cart_button_view_cart() {
	echo '<div class="col-6 pr-1">';
	echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="btn btn-block btn-outline-secondary wc-forward">' . esc_html__( 'View cart', 'woocommerce' ) . '</a>';
	echo '</div>';
}

function fj_woocommerce_widget_shopping_cart_proceed_to_checkout() {
	echo '<div class="col-6 pl-1">';
	echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="btn btn-block btn-primary checkout wc-forward">' . esc_html__( 'Checkout', 'woocommerce' ) . '</a>';
	echo '</div>';
}

/**
* CART SPECIFIC
* 
* Remove attributes from product title
* Display the Meta type in cart and checkout
* Remove cross sells
*/

/**
* Removes the attribute from the product title, in the cart.
* 
* @return string
*/

add_filter( 'woocommerce_cart_item_name', 'remove_variation_from_product_title', 10, 3 );
function remove_variation_from_product_title( $title, $cart_item, $cart_item_key ) {
	$_product = $cart_item['data'];
	$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );

	if ( $_product->is_type( 'variation' ) ) {
		if ( ! $product_permalink ) {
			return $_product->get_title();
		} else {
			return sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_title() );
		}
	}

	return $title;
}

/**
* Display the Meta type in cart and checkout
*/

add_filter( 'woocommerce_get_item_data', 'display_attribute_metal_type', 90, 2 );
function display_attribute_metal_type( $cart_item_data, $cart_item ){
    if( $cart_item['variation_id'] > 0 ) {
        // Get the parent variable product object instance
        $product = wc_get_product( $cart_item['product_id'] );

        // Get the "Metal type" product attribute term name
        $term_names = $product->get_attribute( 'metal-type' );

        if( isset($term_names) && ! empty($term_names) ){
            // Add "Metal type" data to be displayed
            $cart_item_data[] = array(
                'name' => __('Metal Type'),
                'value' => $term_names,
            );
        }
    }
    return $cart_item_data;
}

/**
* Remove cross sell
*/

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');

/**
* CHECKOUT SPECIFIC
* 
* Uncheck Ship to Different Address
*/

/**
* Uncheck Ship to Different Address
*/
add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );