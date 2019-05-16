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
//remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
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


function marrakesh_custom_product_tab( $default_tabs ) {
    $default_tabs['boxing'] = array(
        'label'   =>  __( 'Boxing', 'domain' ),
        'target'  =>  'boxing_product_data',
        'priority' => 25,
        'class'   => array('show_if_simple', 'show_if_variable')
    );
    return $default_tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'marrakesh_custom_product_tab', 10, 1 );


add_action( 'woocommerce_product_data_panels', 'marrakesh_boxing_tab_data' );
function marrakesh_boxing_tab_data() {
    global $woocommerce, $post;
    echo '<div id="boxing_product_data" class="panel woocommerce_options_panel">';
    echo '<div class="options_group">';
    woocommerce_wp_checkbox( array(
        'label' => 'Sold in box?', // Text in the editor label
        // 'class' => '',
        // 'style' => '',
        'wrapper_class' => '', // custom CSS class for styling
        //'value' => get_post_meta( $post->ID, '_isboxed', true ), // meta_value where the id serves as meta_key
        'id' => '_isboxed', // required, it's the meta_key for storing the value (is checked or not)
        'name' => '_isboxed',
        'cbvalue' => 'yes', // "value" attribute for the checkbox
        'desc_tip' => false, // true or false, show description directly or as tooltip
        'custom_attributes' => '', // array of attributes
        'description' => 'Check this if the item can be bought in box only' // provide something useful here
        )
    );
    woocommerce_wp_text_input( array(
        'label' => 'One box covers (m<sup>2</sup>)', // Text in the label in the editor.
        'placeholder' => 'eg. 0.59', // Give examples or suggestions as placeholder
        'class' => '',
        'style' => '',
        'wrapper_class' => '',
        //'value' => '', // if empty, retrieved from post_meta
        'id' => '_sizeperbox', // required, will be used as meta_key
        'name' => '_sizeperbox', // name will be set automatically from id if empty
        //'type' => '',
        'desc_tip' => true,
        'data_type' => '',
        'custom_attributes' => '', // array of attributes you want to pass
        'description' => 'Leave empty if it\'s sold by pieces'
        )
    );
    echo '</div>';
    echo '</div>';
}

add_action('woocommerce_process_product_meta', 'marrakesh_save_wc_custom_boxingfields');
function marrakesh_save_wc_custom_boxingfields( $post_id ) {
    $product = wc_get_product( $post_id );

    $isboxed = isset( $_POST[ '_isboxed' ] ) ? sanitize_text_field( $_POST[ '_isboxed' ] ) : 'no';
    $sizeperbox = isset( $_POST[ '_sizeperbox' ] ) ? sanitize_text_field( $_POST[ '_sizeperbox' ] ) : '';

    $product->update_meta_data( '_isboxed', $isboxed );
    $product->update_meta_data( '_sizeperbox', $sizeperbox );

    $product->save();
}


