<?php
// Remove each style one by one
add_filter( 'woocommerce_enqueue_styles', 'marrakesh_dequeue_styles' );
function marrakesh_dequeue_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
	unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
	unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
	return $enqueue_styles;
}
// Or just remove them all in one line
// add_filter( 'woocommerce_enqueue_styles', '__return_false' );


add_action( 'template_redirect', 'marrakesh_remove_woocommerce_styles_scripts', 999 );
function marrakesh_remove_woocommerce_styles_scripts() {
    // if ( function_exists( 'is_woocommerce' ) ) {
    //     if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
            remove_action('wp_enqueue_scripts', [WC_Frontend_Scripts::class, 'load_scripts']);
	        remove_action('wp_print_scripts', [WC_Frontend_Scripts::class, 'localize_printed_scripts'], 5);
	        remove_action('wp_print_footer_scripts', [WC_Frontend_Scripts::class, 'localize_printed_scripts'], 5);
    //     }
    // }
}





function marrakesh_loop_shop_per_page( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options -> Reading
  // Return the number of products you wanna show per page.
  $cols = 50;
  return $cols;
}
add_filter( 'loop_shop_per_page', 'marrakesh_loop_shop_per_page', 20 );

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
add_action( 'woocommerce_before_page_title', 'woocommerce_breadcrumb', 10 );



//remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_before_shop_loop','woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images',20);
//add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_images', 70 );


remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
remove_action('woocommerce_single_product_summary', 'WC_Structured_Data::generate_product_data()', 60);

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );


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


add_filter( 'woocommerce_shortcode_products_query', function( $query_args, $atts, $loop_name ){
    if( $loop_name == 'products' ){
        $query_args['meta_query'] = array( array(
            'key'     => '_stock_status',
            'value'   => 'instock',
            'compare' => 'LIKE',
        ) );
    }
    return $query_args;
}, 10, 3);







add_action( 'pre_get_posts', function ( $query ) {
    if (   !is_admin() && $query->is_main_query() && is_woocommerce() && ($query->is_post_type_archive('product') || $query->is_tax()) ) {
        $query->set( 'meta_key', '_stock' );
        $query->set( 'orderby',  array('meta_value_num' => 'DESC', 'menu_order' => 'ASC') );

        $availability_filter = isset( $_GET['filter_availability'] ) ? wc_clean( wp_unslash( $_GET['filter_availability'] ) ) : array(); // WPCS: input var ok, CSRF ok.
        if ($availability_filter === 'in_stock') {
          $query->set('meta_query', array(
            'key' => '_stock_status',
            'value' => 'instock',
            'compare' => '=',
          ));
        }
    }
}, PHP_INT_MAX );



add_filter( 'woocommerce_before_widget_product_list', function(){
    return '<ul class="prodswipe">';
});


add_filter( 'woocommerce_products_widget_query_args', function( $query_args ){
    $product_visibility_term_ids = wc_get_product_visibility_term_ids();
    $query_args['tax_query'][] = array(
        array(
            'taxonomy' => 'product_visibility',
            'field'    => 'term_taxonomy_id',
            'terms'    => $product_visibility_term_ids['outofstock'],
            'operator' => 'NOT IN',
        ),
    );
    $query_args['meta_query'][] = array(
        array(
            'key' => '_stock_status',
            'value' => 'instock',
            'compare' => '='
        ),
    );
    return $query_args;
},  PHP_INT_MAX);