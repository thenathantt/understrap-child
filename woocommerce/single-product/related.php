<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : ?>

	<section class="fj-featured-products related products">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-3">
					<h2 class="featured-products__heading"><?php _e('You might also like these…', 'woocommerce'); ?></h2>
				</div>
				<div class="col-12 col-lg-9 px-0 px-lg-3">
					<?php woocommerce_product_loop_start(); ?>
						<div class="fj-related-products-wrapper" style="max-width: 100%;">
							<?php foreach ( $related_products as $related_product ) : ?>
									<?php 
										$post_object = get_post( $related_product->get_id() ); 

										setup_postdata( $GLOBALS['post'] =& $post_object ); 

										wc_get_template_part( 'content', 'product' ); ?>
							<?php endforeach; ?>
						</div>
					<?php woocommerce_product_loop_end(); ?>
				</div>
			</div>
		</div>
	</section>

<?php endif;

wp_reset_postdata();
