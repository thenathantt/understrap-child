<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

?>

<?php if ( get_field( 'additional_image' ) || get_field( 'retail_price' ) || have_rows( 'tabs' )) { ?>
	<section class="section product-meta">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-12 col-sm-6 pl-xl-0 pr-xl-4 d-none d-sm-block product-meta__image">
					<?php if ( get_field( 'additional_image' ) ) { ?>
						<?php echo wp_rocket__wp_get_attachment_image__lazyload(get_field('additional_image'), 'full', "", ["class" => "img-fluid", "data-aos" => "fade-up"]); ?>
					<?php } ?>
				</div>
				<div class="col-12 col-sm-6 col-xl-5 pl-xl-4 align-self-center">
					<?php if ( have_rows( 'tabs' ) ) : $t = 0; $t2 = 0; ?>
						<div class="container px-0" data-aos="fade-up">
							<div class="row">
								<div class="col d-flex justify-content-center px-0">
									<ul class="nav nav-pills mt-0" id="pills-tab" role="tablist">
										<?php while ( have_rows( 'tabs' ) ) : the_row(); $t++; ?>
											<li class="nav-item">
												<a class="nav-link no-effect font-weight-bold p-0 mx-2 mx-sm-3<?php if($t == 1){?> active<?php } ?>" id="pills-<?php echo $t;?>-tab" data-toggle="pill" href="#pills-<?php echo $t;?>" role="tab" aria-controls="pills-<?php echo $t;?>" <?php if($t == 1){ ?>aria-selected="true"<?php } else { ?>aria-selected="false"<?php } ?>><?php the_sub_field( 'heading' ); ?></a>
											</li>
										<?php endwhile; ?>
									</ul>
								</div>
							</div>
						</div>
						<div class="container px-0" data-aos="fade-up">
							<div class="product-meta__tab tab-content" id="pills-tabContent">
								<?php while ( have_rows( 'tabs' ) ) : the_row(); $t2++; ?>
									<div class="tab-pane fade <?php if($t2 == 1){ ?>show active<?php } ?>" id="pills-<?php echo $t2;?>" role="tabpanel" aria-labelledby="pills-<?php echo $t2;?>-tab">
										<?php if ( have_rows( 'columns' ) ) : ?>
											<div class="row text-center no-gutters">
												<?php while ( have_rows( 'columns' ) ) : the_row(); ?>
													<div class="col">
														<div class="product-meta__tab-content">
															<div class="product-meta__tab-content--heading"><?php the_sub_field( 'heading' ); ?></div>
															<div class="product-meta__tab-content--content"><?php the_sub_field( 'content' ); ?></div>
														</div>
													</div>
												<?php endwhile; ?>
											</div>
										<?php endif; ?>
									</div>
								<?php endwhile; ?>
							</div>
						</div>
					<?php endif; ?>
					<div class="container px-0" data-aos="fade-up">
						<div class="price-compare">
							<h2 class="price-compare__heading"><?php _e('Us vs. Retail', 'product'); ?></h2>
							<div class="row text-center">
								<div class="col-12">
									<div class="row no-gutters mb-3">
										<div class="col-2 align-self-center"><p class="price-compare__content"><?php _e('Retail', 'product'); ?></p></div>
										<div class="col-2 align-self-center"><p class="price-compare__content">$<?php the_field( 'retail_price' ); ?></p></div>
										<div class="col-8">
											<div class="progress price-compare__bar pl-2">
										  		<div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</div>
									</div>
									<div class="row no-gutters">
										<div class="col-2 align-self-center"><p class="price-compare__content"><?php _e('Finley', 'product'); ?></p></div>
										<div class="col-2 align-self-center">
											<p class="price-compare__content">
												<?php $product = new WC_Product_Variable(get_the_ID()); 
										  		echo '$' . $product->get_price(); ?>
										  	</p>
										</div>
										<div class="col-8">
											<div class="progress price-compare__bar pl-2">
												<?php 
												$product = new WC_Product_Variable(get_the_ID());
												$finley_price = floatval( preg_replace( '#[^\d.]#', '', $product->get_price_excluding_tax(1,$product->get_price()) ));
												$retail_price = get_field( 'retail_price' );
												$percentage = ($finley_price / $retail_price) * 100;
												?>
										  		<div class="progress-bar" role="progressbar" style="width: <?php echo $percentage; ?>%" aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php } ?>