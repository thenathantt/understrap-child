<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package understrap
 */

$container = get_theme_mod( 'understrap_container_type' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="hfeed site" id="page">
	<!-- ******************* Off-Canvas Overlay ******************* -->
	<div class="fj-offcanvas-overlay"></div>

	  <!-- ******************* Mini Cart ******************* -->
	<div class="fj-offcanvas-wrapper fj-offcanvas-wrapper--right fj-offcanvas-wrapper--mini-cart woocommerce hide">
		<button class="fj-offcanvas-toggle fj-offcanvas-toggle--close fj-offcanvas-toggle--wc-sidebar-x" data-toggle="hide" data-target=".fj-offcanvas-wrapper--mini-cart" aria-label="close product filters">✕</button>
		<?php woocommerce_mini_cart(); ?>
	</div>

	<!-- ******************* Mobile Menu ******************* -->
  <div class="fj-offcanvas-wrapper fj-offcanvas-wrapper--left fj-offcanvas-wrapper--mobile-top-nav fj-mobile-nav hide">
		<div class="fj-mobile-nav__user">
			<?php if ( is_user_logged_in() ) : ?>
				<?php global $current_user; wp_get_current_user(); ?>
				<a class="ml-auto" href="<?php echo wc_get_page_permalink( 'myaccount' ); ?>" class="text--italic">Hey, <?php echo $current_user->display_name; ?></a>
			<?php else : ?>
				<a class="mr-auto" href="<?php echo wc_get_page_permalink( 'myaccount' ); ?>">Sign In</a>
				<a class="ml-auto" href="<?php echo wc_get_page_permalink( 'myaccount' ); ?>">New? Register an account</a>
			<?php endif; ?>
		</div>
		<?php if ( have_rows( 'main_mobile_menu', 'option' ) ) : ?>
			<?php while ( have_rows( 'main_mobile_menu', 'option' ) ) : the_row(); ?>
				<?php if ( have_rows( 'lists' ) ) : ?>
					<!-- Level 1 -->
					<div class="fj-mobile-nav fj-mobile-nav__level-one">
						<?php while ( have_rows( 'lists' ) ) : the_row(); ?>
							<?php if ( have_rows( 'list_items' ) ) : ?>
								<ul class="nav navbar-nav">										
									<?php while ( have_rows( 'list_items' ) ) : the_row(); ?>
										<?php $item = get_sub_field( 'item' ); ?>
										<?php if ( $item ) : ?>
											<?php if ( get_sub_field( 'has_second_level_menu' ) == 1 ) : ?>
												<li class="nav-item has-submenu">
													<a class="nav-link fj-offcanvas-toggle" data-toggle="hide" data-target=".fj-mobile-nav__level-two--<?php echo strtolower( $item['title'] ); ?>"><?php echo $item['title']; ?><i class="material-icons">chevron_right</i></a>
												</li>
											<?php else : ?>
												<li class="nav-item">
													<a class="nav-link" href="<?php echo $item['url']; ?>" target="<?php echo $item['target']; ?>"><?php echo $item['title']; ?></a>
												</li>
											<?php endif; ?>
										<?php endif; ?>
									<?php endwhile; ?>
								</ul>
							<?php endif; ?>
						<?php endwhile; ?>
					</div>
					<!-- Level 2 -->
					<?php if ( have_rows( 'lists' ) ) : ?>
						<?php while ( have_rows( 'lists' ) ) : the_row(); ?>
							<?php if ( have_rows( 'list_items' ) ) : ?>
								<?php while ( have_rows( 'list_items' ) ) : the_row(); ?>
									<?php $item = get_sub_field( 'item' ); ?>
									<?php if ( get_sub_field( 'has_second_level_menu' ) == 1 ) : ?>
										<div class="fj-mobile-nav fj-mobile-nav__level-two fj-mobile-nav__level-two--<?php echo strtolower( $item['title']); ?> hide">
											<div class="fj-mobile-nav__back fj-offcanvas-toggle d-flex align-items-center" data-toggle="hide" data-target=".fj-mobile-nav__level-two--<?php echo strtolower( $item['title']); ?>">
												<i class="material-icons">arrow_back_ios</i>
												<span><?php echo $item['title']; ?></span>
											</div>
											<?php if ( have_rows( 'lists' ) ) : ?>
												<div class="mobile-menu__items">
													<?php while ( have_rows( 'lists' ) ) : the_row(); ?>
														<ul class="nav navbar-nav">
															<?php if ( have_rows( 'list_items' ) ) : ?>
																<?php while ( have_rows( 'list_items' ) ) : the_row(); ?>
																	<?php $item = get_sub_field( 'item' ); ?>
																	<?php if ( $item ) { ?>
																		<li class="nav-item">
																			<a class="nav-link" href="<?php echo $item['url']; ?>"target="<?php echo $item['target']; ?>"><?php echo $item['title']; ?></a>
																		</li>
																	<?php } ?>
																<?php endwhile; ?>
															<?php endif; ?>
														</ul>
													<?php endwhile; ?>
												</div>
											<?php endif; ?>
											</div>
									<?php endif; ?>
								<?php endwhile; ?>
							<?php endif; ?>
						<?php endwhile; ?>
					<?php endif; ?>
				<?php endif; ?>
			<?php endwhile; ?>
		<?php endif; ?>
  </div>

  <!-- ******************* Mobile Quick Nav ******************* -->
  <?php if ( get_field('enable_bottom_menu', 'option') && have_rows( 'bottom_mobile_menu', 'option' ) ) : ?>
		<section class="fj-quick-nav d-md-none">
			<div class="fj-quick-nav__level-one">
				<div class="container">
					<div class="row">
						<?php while ( have_rows( 'bottom_mobile_menu', 'option' ) ) : the_row(); ?>
							<?php $link = get_sub_field( 'link' ); ?>
							<?php if ( $link ) : ?>
								<div class="col fj-quick-nav__item fj-quick-nav__item--primary fj-quick-nav__item--<?php echo fj_slug($link['title']); ?> d-flex flex-column justify-content-center">
									<?php if ( get_sub_field( 'has_megamenu' ) == 1 ) { ?>
										<div class="fj-toggle" data-toggle="hide" data-target=".fj-quick-nav__level-two--<?php echo fj_slug($link['title']); ?>">
											<i class="material-icons"><?php the_sub_field( 'link_icon' ); ?></i>
											<span class="d-block"><?php echo $link['title']; ?></span>
										</div>
									<?php } else { ?>
										<a href="<?php echo $link['url']; ?>">
											<i class="material-icons"><?php the_sub_field( 'link_icon' ); ?></i>
											<span class="d-block"><?php echo $link['title']; ?></span>
										</a>
									<?php } ?>
								<?php endif; ?>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
			</div>
			<?php while ( have_rows( 'bottom_mobile_menu', 'option' ) ) : the_row(); ?>
				<?php if ( get_sub_field( 'has_megamenu' ) == 1 ) : ?>
					<?php $target_link = get_sub_field( 'link' ); ?>
					<div class="fj-quick-nav__level-two fj-quick-nav__level-two--<?php echo fj_slug($target_link['title']); ?> hide">
						<div class="container">
							<?php if ( get_sub_field( 'megamenu_type' ) == 'small' ) : ?>
								<?php while ( have_rows( 'link_list' ) ) : the_row() ?>
									<?php $link = get_sub_field( 'link' ); ?>
									<?php if ( $link ) : ?>
										<div class="row my-2">
											<div class="col fj-quick-nav__item fj-quick-nav__item--list hide">
												<a href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>"><?php echo $link['title']; ?></a>
											</div>
										</div>
									<?php endif; ?>
								<?php endwhile; ?>
							<?php elseif (get_sub_field( 'megamenu_type' ) == 'large') : ?>
								<?php while ( have_rows( 'sections' ) ) : the_row(); ?>
									<?php $link = get_sub_field( 'link' ); ?>
									<?php if ( $link ) : ?>
										<div class="col" style="background-image: url('<?php the_sub_field( 'background_image' ); ?>');">
											<a class="d-flex align-items-end justify-content-center" href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>"><?php echo $link['title']; ?></a>
										</div>
									<?php endif; ?>
								<?php endwhile; ?>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
			<?php endwhile; ?>
		</section>
	<?php endif; ?>

	<!-- ******************* The Navbar Area ******************* -->
	<div id="wrapper-navbar" class="nav-down top" itemscope itemtype="http://schema.org/WebSite">
		<!-- ******************* Announcement Bar ******************* -->
		<?php if(get_field('bar_text','option')) : ?>
			<div class="fj-announcement text-center" style="background-color: <?php the_field( 'bar_background_colour', 'option' ); ?>;color: <?php the_field( 'bar_text_colour', 'option' ); ?>">
				<?php the_field( 'bar_text', 'option' ); ?>
			</div>
		<?php endif; ?>		

		<a class="skip-link screen-reader-text sr-only" href="#content"><?php esc_html_e( 'Skip to content', 'understrap' ); ?></a>
	
		<div class="container px-0">
			<nav id="topNav" class="fj-navbar navbar navbar-expand-md">
				<div class="fj-navbar-wrapper fj-navbar-wrapper--toggle d-flex d-md-none">
			    <div class="fj-offcanvas-toggle d-md-none px-0" data-toggle="hide" data-target=".fj-offcanvas-wrapper--mobile-top-nav">
			    	<i class="material-icons">menu</i>
			    </div>
			  </div>
		    <!-- Left Menu -->
		    <?php if ( have_rows( 'left_menu', 'option' ) ) : ?>
		    	<div class="fj-navbar-wrapper fj-navbar-wrapper--left-menu d-none d-md-flex">
		    		<ul class="nav navbar-nav flex-row">
							<?php while ( have_rows( 'left_menu', 'option' ) ) : the_row(); ?>
								<?php $link = get_sub_field( 'link' ); ?>
								<?php if ( $link ) : ?>
									<div class="<?php echo get_sub_field( 'has_megamenu' ) == 1 ? 'fj-has-megamenu' : '' ?>">
										<li class="nav-item fj-nav-item">
											<a class="d-block nav-link hvr-underline-from-center" href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>"><?php echo $link['title']; ?></a>
										</li>
										<?php $columns = sizeof( get_sub_field( 'megamenu_columns' ) ); ?>
										<?php if ( have_rows( 'megamenu_columns' ) ) : ?>
											<!-- fj-megamenu -->
											<div class="fj-megamenu fj-megamenu--left">
												<div class="container px-0">
													<div class="row no-gutters h-100">
														<?php while ( have_rows( 'megamenu_columns' ) ) : the_row(); ?>
															<?php
																$background= '';
																if ( get_sub_field('column_background') ) {	$background = "url('" . get_sub_field( 'column_background' ) . "') center/cover no-repeat"; }
																else { $background = 'none'; }
															?>
															<div class="col" style="background: <?php echo $background; ?>">
																<div class="fj-megamenu__col">
																	<?php if ( have_rows( 'column_layout' ) ): ?>
																		<?php while ( have_rows( 'column_layout' ) ) : the_row(); ?>
																			<?php if ( get_row_layout() == 'menu_list' ) : ?>
																				<!-- Mega Menu List -->
																				<?php $list_heading = get_sub_field( 'list_heading' ); ?>
																				<?php if ( $list_heading ) : ?>
																					<span class="fj-megamenu__col--heading"><?php echo $list_heading; ?></span>
																				<?php endif; ?>
																				<?php if ( have_rows( 'menu_links' ) ) : ?>
																					<ul>
																						<?php while ( have_rows( 'menu_links' ) ) : the_row(); ?>
																							<?php $link = get_sub_field( 'link' ); ?>
																							<?php if ( $link ) : ?>
																								<li><a class="hvr-underline-from-center" href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>"><?php echo $link['title']; ?></a></li>
																							<?php endif; ?>
																						<?php endwhile; ?>
																					</ul>
																				<?php endif; ?>
																			<?php elseif ( get_row_layout() == 'product_showcase' ) : ?>
																				<!-- Mega Menu Feature -->
																				<div class="fj-megamenu__col--featured">
																					<span class="fj-megamenu__heading"style="color: <?php the_sub_field( 'heading_colour' ); ?>"><?php the_sub_field( 'heading' ); ?></span>
																					<p class="fj-megamenu__content"style="color: <?php the_sub_field( 'content_colour' ); ?>"><?php the_sub_field( 'content' ); ?></p>
																					<?php $button_link = get_sub_field( 'button_link' ); ?>
																					<?php if ( $button_link ) : ?>
																						<div class="fj-megamenu__button-wrapper">
																							<a href="<?php echo $button_link['url']; ?>" target="<?php echo $button_link['target']; ?>" class="btn btn-sm btn-outline-light"><?php echo $button_link['title']; ?></a>
																						</div>
																					<?php endif; ?>
																				</div>
																			<?php endif; ?>
																		<?php endwhile; ?>
																	<?php endif;?>
																</div>
															</div> <!-- .col -->
														<?php endwhile; ?>
													</div> <!-- .row -->
												</div> <!-- .container -->
											</div> <!-- .fj-megamenu -->
										<?php endif;?>
									</div>
								<?php endif; ?>
							<?php endwhile; ?>
						</ul>
					</div>
				<?php endif; ?>

				<a class="navbar-brand mx-auto" href="/">
					<img src="<?php the_field( 'header_logo', 'option' ); ?>" class="img-fluid" alt="Finley Logo">
			  </a>

				<!-- Right Menu -->
				<?php if ( have_rows( 'right_menu', 'option' ) ) : ?>
					<div class="fj-navbar-wrapper fj-navbar-wrapper--right-menu d-flex">
						<ul class="nav navbar-nav flex-row align-items-center">
							<?php while ( have_rows( 'right_menu', 'option' ) ) : the_row(); ?>
								<?php $link = get_sub_field( 'link' ); $iconClass = get_sub_field( 'icon_class' ); ?>
								<div class="<?php echo get_sub_field( 'has_dropdown' ) == 1 ? 'fj-has-megamenu' : ''; ?>">
									<li class="nav-item <?php echo get_sub_field( 'hidden_on_mobile' ) == 1 ? 'd-none d-md-block' : 'd-block'; ?>">
										<?php if ( $link ) : ?>
											<a class="d-block nav-link" href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>">
												<i class="material-icons d-block <?php echo ($iconClass) ? $iconClass : '' ; ?>"><?php the_sub_field( 'icon' ); ?></i>
											</a>
										<?php endif; ?>
									</li>
									<?php if ( get_sub_field( 'has_dropdown' ) == 1 ) : ?>
										<div class="fj-megamenu fj-megamenu--right text-center">
											<div class="container px-0">
												<div class="row no-gutters h-100">
													<div class="col">
														<div class="fj-megamenu__col">
															<?php the_sub_field( 'dropdown_content' ); ?>
														</div>
													</div>
												</div>
											</div>
										</div>
									<?php endif; ?>
								</div>
							<?php endwhile; ?>
							<!-- Cart Toggle -->
							<li class="nav-item fj-cart-toggle">
								<button type="button" class="d-flex align-items-center btn fj-btn-pill btn-outline-primary fj-offcanvas-toggle" data-toggle="hide" data-target=".fj-offcanvas-wrapper--mini-cart">
									<i class="material-icons d-inline-block pr-md-1">shopping_cart</i><span class='d-none d-md-inline'>View Cart</span>
								</button>
							</li>
						</ul>
					</div>
				<?php endif; ?>
			</nav>
		</div>

		<!-- .site-navigation -->

	</div><!-- #wrapper-navbar end -->
