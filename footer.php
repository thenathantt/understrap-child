<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

<div class="wrapper" id="wrapper-footer">

	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="row">

			<div class="col-md-12">

				<footer class="site-footer" id="colophon">

					<div class="site-info text-center">
						<p class="mb-2">
							<a href="/privacy-policy">Privacy Policy</a> | <a href="/terms-conditions">Terms & Conditions</a>
						<p>
						<span>&copy;<?php echo date("Y"); ?> Finley Design Studio Inc. </span>
					</div><!-- .site-info -->

				</footer><!-- #colophon -->

			</div><!--col end -->

		</div><!-- row end -->

	</div><!-- container end -->

</div><!-- wrapper end -->

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>

<!-- Beacon -->
<script type="text/javascript">!function(e,t,n){function a(){var e=t.getElementsByTagName("script")[0],n=t.createElement("script");n.type="text/javascript",n.async=!0,n.src="https://beacon-v2.helpscout.net",e.parentNode.insertBefore(n,e)}if(e.Beacon=n=function(t,n,a){e.Beacon.readyQueue.push({method:t,options:n,data:a})},n.readyQueue=[],"complete"===t.readyState)return a();e.attachEvent?e.attachEvent("onload",a):e.addEventListener("load",a,!1)}(window,document,window.Beacon||function(){});</script><script>window.Beacon('init', '8d388c85-1d24-4580-b74b-c5397adf343f')</script>
<style>
@media (max-width: 768px) {
    #HSBeaconFabButton {
      bottom: 10px!important;
      right: 20px!important;
    }
    #HSBeaconFabButton.is-configDisplayLeft {
      left: 20px!important;
      right: initial!important;
    }
    
    // new message
    #BeaconWithResponsiveFrame {
      bottom: 70px!important;
      right: 12px!important;
    }
    #BeaconWithResponsiveFrame.is-configDisplayLeft {
      left: 12px!important;
      right: initial!important;
    }

    //chat open
    #HSBeaconContainerFrame {
      bottom: 80px!important;
      right: 20px!important;
    }
    #HSBeaconContainerFrame.is-configDisplayLeft {
      left: 20px!important;
      right: initial!important;
    }
}

@media (max-width: 576px) {
    #HSBeaconFabButton {
      right: 10px!important;
    }
    #HSBeaconFabButton.is-configDisplayRight {
      left: initial!important;
      right: 10px!important;
    }
    #HSBeaconFabButton.is-configDisplayLeft {
      left: 10px!important;
      right: initial!important;
    }
    
    // new message
    #BeaconWithResponsiveFrame {
      bottom: 70px!important;
      left: 0px!important;
      right: 0px!important;
      width: 100vw!important;
    }
    #BeaconWithResponsiveFrame.is-configDisplayLeft,
    #BeaconWithResponsiveFrame.is-configDisplayRight {
      left: 0!important;
      right: 0!important;
    }

    // chat open
    #HSBeaconContainerFrame {
      bottom: 80px!important;
      left: 0px!important;
      right: 0px!important;
      width: 100vw!important;
    }
    #HSBeaconContainerFrame.is-configDisplayLeft,
    #HSBeaconContainerFrame.is-configDisplayRight {
      left: 0!important;
      right: 0!important;
    }
	}
</style>

</body>

</html>

