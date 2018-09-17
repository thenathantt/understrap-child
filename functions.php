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
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/icon?family=Material+Icons', false ); 
    wp_enqueue_style('fj-font-awesome', 'https://use.fontawesome.com/releases/v5.3.1/css/all.css', true);
    wp_enqueue_style( 'hover_css', 'https://cdnjs.cloudflare.com/ajax/libs/hover.css/2.3.1/css/hover-min.css', true );
    wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_script( 'jquery');
	wp_enqueue_script( 'popper-scripts', get_template_directory_uri() . '/js/popper.min.js', array(), false);
    wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );
    wp_enqueue_style( 'select2_css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css' );
    wp_enqueue_script( 'select2_js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js', array('jquery'), '4.0.5', true );
    wp_enqueue_style( 'slick_css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css' );
    wp_enqueue_script( 'slick_js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '1.8.1', true );
    wp_enqueue_style( 'aos_css', 'https://unpkg.com/aos@2.3.1/dist/aos.css' );
    wp_enqueue_script( 'aos_js', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array(), '2.3.1', true );
    wp_enqueue_style( 'swiper_css', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/css/swiper.min.css' );
    wp_enqueue_script( 'swiper_js', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/js/swiper.min.js', array(), '4.3.5', true );
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
 * Load acf functions.
 */
require get_stylesheet_directory() . '/inc/acf-options.php';

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

// strip string, replace spaces with dash (-)
function fj_slug($string) {
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}

add_shortcode( 'fj_slick_products', 'fj_slick_products' );

/**
*
* @param tag - product tag
* @param productcount - the number of products to load
*
*/

function fj_slick_products( $attributes, $content = null ) {
    // Save each attribute's value to its own variable.
    // This creates a variable $align with a value of 'left'.
    extract( shortcode_atts( array(
        'id' => '',
        'tag' => '',
        'product_count' => 3,
    ), $attributes ) ); 

    ob_start();

    echo '<div class="woocommerce">';
    echo '<div class="fj-products fj-loop-start products">';
    echo '<div class="container px-0">';
    echo '<div class="row">';
    echo '<div class="col">';

    if ( $id == '' && $tag != '' ) {
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $product_count,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_tag',
                    'terms' => $tag,
                    'field' => 'slug',
                    )
                )
            );
        $the_query = new WP_Query( $args );

        if ($the_query->have_posts()){
            $fj_slick_products = true;

            echo '<div class="fj-slick-products">';

            while ($the_query->have_posts()){
                $the_query->the_post();
                include ( locate_template( array( "content-product.php", WC()->template_path() . "content-product.php" ) ) );
            }
            
            echo '</div>'; 
        } else {
            echo 'No products found';
        }
    }
    else if ( $id != '' && $tag == '' ) {
        foreach ( $id as $id ) {
            $fj_slick_products = true;

            echo '<div class="fj-slick-products">';

            $post_object = get_post( wc_get_product($id)->get_id() );
            setup_postdata( $GLOBALS['post'] =& $post_object );
            include ( locate_template( array( "content-product.php", WC()->template_path() . "content-product.php" ) ) );

            echo '</div>';
        }
    } else {
        echo 'No Products Found or ID and Tag both specified';
    }

    echo '</div>';
    echo '</div>'; 
    echo '</div>'; 
    echo '</div>'; 
    echo '</div>'; 

    wp_reset_postdata();

    return ob_get_clean();
}

add_shortcode( 'fj_products', 'fj_products' );

/**
*
* @param tag - product tag
* @param productcount - the number of products to load
*
*/

function fj_products( $attributes, $content = null ) {
    // Save each attribute's value to its own variable.
    // This creates a variable $align with a value of 'left'.
    extract( shortcode_atts( array(
        'id' => ''
    ), $attributes ) ); 
    
    ob_start();
        $fj_products = true;

        echo '<div class="woocommerce">';
        echo '<div class="fj-products fj-products--lock-width fj-loop-start products">';
        echo '<div class="container">';
        echo '<div class="row">';

        $post_object = get_post( wc_get_product($id)->get_id() );
        setup_postdata( $GLOBALS['post'] =& $post_object );
        include ( locate_template( array( "content-product.php", WC()->template_path() . "content-product.php" ) ) );
        
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';

        wp_reset_postdata();

    return ob_get_clean();
}
