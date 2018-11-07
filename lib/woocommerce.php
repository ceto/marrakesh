<?
// Remove each style one by one
add_filter( 'woocommerce_enqueue_styles', 'jk_dequeue_styles' );
function jk_dequeue_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
	unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
	unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
	return $enqueue_styles;
}
// Or just remove them all in one line
// add_filter( 'woocommerce_enqueue_styles', '__return_false' );


// add_action( 'template_redirect', 'marrakesh_remove_woocommerce_styles_scripts', 999 );
// function marrakesh_remove_woocommerce_styles_scripts() {
//     if ( function_exists( 'is_woocommerce' ) ) {
//         if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
//             remove_action('wp_enqueue_scripts', [WC_Frontend_Scripts::class, 'load_scripts']);
// 	    remove_action('wp_print_scripts', [WC_Frontend_Scripts::class, 'localize_printed_scripts'], 5);
// 	    remove_action('wp_print_footer_scripts', [WC_Frontend_Scripts::class, 'localize_printed_scripts'], 5);
//         }
//     }
// }



add_filter( 'loop_shop_per_page', 'marrakesh_loop_shop_per_page', 20 );

function marrakesh_loop_shop_per_page( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options -> Reading
  // Return the number of products you wanna show per page.
  $cols = 30;
  return $cols;
}

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
add_action( 'woocommerce_before_page_title', 'woocommerce_breadcrumb', 10 );


function woocommerce_template_loop_product_link_open() {
    global $product;
    $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
    echo '<a href="' . esc_url( $link ) . '" class="prodcard__productlink">';
}


function woocommerce_template_loop_product_thumbnail() {
    global $product;
    echo '<figure class="prodcard__prodimage">';
    echo woocommerce_get_product_thumbnail(); // WPCS: XSS ok.
    echo wp_get_attachment_image( get_field('singleimg'), 'tiny' );
    echo '</figure>';
}

function woocommerce_template_loop_product_title() {
    echo '<h2 class="prodcard__title">' . get_the_title() . '</h2>';
}

