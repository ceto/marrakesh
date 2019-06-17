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

remove_action( 'woocommerce_before_single_product', 'wc_print_notices', 10);
add_action( 'marrakesh_after_banner', 'wc_print_notices', 10 );


remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
add_action( 'marrakesh_after_banner', 'woocommerce_output_all_notices', 10 );


// remove_action( 'woocommerce_before_cart', 'woocommerce_output_all_notices', 10);
// add_action( 'marrakesh_after_banner', 'woocommerce_output_all_notices', 10 );



remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
add_action( 'woocommerce_before_page_title', 'woocommerce_breadcrumb', 10 );

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

add_action( 'woocommerce_product_options_inventory_product_data', 'marrakesh_add_custom_fields' );
function marrakesh_add_custom_fields() {
    $field = array(
        'id' => '_csstock',
        'label' => __( 'Coming soon quantity', 'marrakeshadmin' ),
        'data_type' => 'stock',
        'description' => 'Leave empty or set to 0 if no planned transport available',
        'desc_tip' => true
    );
    woocommerce_wp_text_input( $field );
    $field = array(
        'id' => '_csarrival',
        'label' => __( 'Arrival', 'marrakeshadmin' ),
        'class' => 'short hasDatepicker',
        'custom_attributes' => array('pattern' => '[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])'),
        //'data_type' => 'date',
        'placeholder' => 'YYYY-MM-DD',
        'description' => 'Leave empty if no planned transport available',
        'desc_tip' => true
    );
    woocommerce_wp_text_input( $field );
}

/* Boxing Tab on WC product admin */
function marrakesh_custom_product_tabs( $default_tabs ) {
    $default_tabs['boxing'] = array(
        'label'   =>  __( 'Boxing', 'marrakeshadmin' ),
        'target'  =>  'boxing_product_data',
        'priority' => 25,
        'class'   => array('show_if_simple', 'show_if_variable')
    );
    $default_tabs['linkedinfopages'] = array(
        'label'   =>  __( 'Info Pages', 'marrakeshadmin' ),
        'target'  =>  'linkedinfopages_product_data',
        'priority' => 26,
        'class'   => array()
    );
    return $default_tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'marrakesh_custom_product_tabs', 10, 1 );


/**
 * Add a bit of style.
 */
function marrakesh_custom_style() { ?>
<style>
#woocommerce-coupon-data ul.wc-tabs li.linkedinfopages_options a::before,
#woocommerce-product-data ul.wc-tabs li.linkedinfopages_options a::before,
.woocommerce ul.wc-tabs li.linkedinfopages_options a::before {
    content: "\f123"
}

#woocommerce-coupon-data ul.wc-tabs li.boxing_options a::before,
#woocommerce-product-data ul.wc-tabs li.boxing_options a::before,
.woocommerce ul.wc-tabs li.boxing_options a::before {
    content: "\f480"
}
</style>
<?php }
add_action( 'admin_head', 'marrakesh_custom_style' );


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
        'label' => 'Box covers (m<sup>2</sup>)', // Text in the label in the editor.
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
    woocommerce_wp_text_input( array(
        'label' => 'Tiles in box (pcs.)', // Text in the label in the editor.
        'placeholder' => 'eg. 13', // Give examples or suggestions as placeholder
        'class' => '',
        'style' => '',
        'wrapper_class' => '',
        //'value' => '', // if empty, retrieved from post_meta
        'id' => '_tilesperbox', // required, will be used as meta_key
        'name' => '_tilesperbox', // name will be set automatically from id if empty
        //'type' => '',
        'desc_tip' => true,
        'data_type' => '',
        'custom_attributes' => '', // array of attributes you want to pass
        'description' => ''
        )
    );
    echo '</div>';
    echo '<h4 style="padding:0 12px;">Single Tile Size</h4><div class="options_group">';
    woocommerce_wp_text_input( array(
        'label' => 'Weight (kg)', // Text in the label in the editor.
        'placeholder' => 'eg. 1.5', // Give examples or suggestions as placeholder
        'class' => '',
        'style' => '',
        'wrapper_class' => '',
        //'value' => '', // if empty, retrieved from post_meta
        'id' => '_tileweight', // required, will be used as meta_key
        'name' => '_tileweight', // name will be set automatically from id if empty
        //'type' => '',
        'desc_tip' => true,
        'data_type' => '',
        'custom_attributes' => '', // array of attributes you want to pass
        'description' => ''
        )
    );
    woocommerce_wp_text_input( array(
        'label' => 'Width (cm)', // Text in the label in the editor.
        'placeholder' => 'eg. 20', // Give examples or suggestions as placeholder
        'class' => '',
        'style' => '',
        'wrapper_class' => '',
        //'value' => '', // if empty, retrieved from post_meta
        'id' => '_tilewidth', // required, will be used as meta_key
        'name' => '_tilewidth', // name will be set automatically from id if empty
        //'type' => '',
        'desc_tip' => true,
        'data_type' => '',
        'custom_attributes' => '', // array of attributes you want to pass
        'description' => ''
        )
    );
    woocommerce_wp_text_input( array(
        'label' => 'Height (cm)', // Text in the label in the editor.
        'placeholder' => 'eg. 20', // Give examples or suggestions as placeholder
        'class' => '',
        'style' => '',
        'wrapper_class' => '',
        //'value' => '', // if empty, retrieved from post_meta
        'id' => '_tileheight', // required, will be used as meta_key
        'name' => '_tileheight', // name will be set automatically from id if empty
        //'type' => '',
        'desc_tip' => true,
        'data_type' => '',
        'custom_attributes' => '', // array of attributes you want to pass
        'description' => ''
        )
    );
    woocommerce_wp_text_input( array(
        'label' => 'Thickness (cm)', // Text in the label in the editor.
        'placeholder' => 'eg. 1.5', // Give examples or suggestions as placeholder
        'class' => '',
        'style' => '',
        'wrapper_class' => '',
        //'value' => '', // if empty, retrieved from post_meta
        'id' => '_tilethickness', // required, will be used as meta_key
        'name' => '_tilethickness', // name will be set automatically from id if empty
        //'type' => '',
        'desc_tip' => true,
        'data_type' => '',
        'custom_attributes' => '', // array of attributes you want to pass
        'description' => ''
        )
    );


    echo '</div>';
    echo '</div>';
}










add_action( 'woocommerce_product_data_panels', 'marrakesh_linkedinfopages_tab_data' );
function marrakesh_linkedinfopages_tab_data() {
    global $post;
    echo '<div id="linkedinfopages_product_data" class="panel woocommerce_options_panel">';
    echo '<div class="options_group">';

    $linfopagevalue = get_post_meta( $post->ID, '_linfopage', true );
    if( empty( $linfopagevalue ) ) $linfopagevalue = '';

    $linstallpagevalue = get_post_meta( $post->ID, '_linstallpage', true );
    if( empty( $linstallpagevalue ) ) $linstallpagevalue = '';

    $lhowtopagevalue = get_post_meta( $post->ID, '_lhowtopage', true );
    if( empty( $lhowtopagevalue ) ) $lhowtopagevalue = '';


    $thepages= new WP_Query( array(
        'post_type' => array('page'),
        'posts_per_page' => -1
    ));

    $options[''] = __( 'Select a page', 'marrakeshadmin'); // default value
    while ($thepages->have_posts()) {
        $thepages->the_post();
        $options[get_the_id()] = get_the_title();
    }
    wp_reset_query();
    wp_reset_postdata();


    //var_dump($options);
    woocommerce_wp_select( array(
        'id' => '_linfopage', // required, will be used as meta_key
        'label' => __('Product Information', 'marrakeshadmin' ), // Text in the label in the editor.
        'options' =>  $options,
        'value' => $linfopagevalue // if empty, retrieved from post_meta
        )
    );

    woocommerce_wp_select( array(
        'id' => '_linstallpage', // required, will be used as meta_key
        'label' => __('Installation & Maintance', 'marrakeshadmin' ), // Text in the label in the editor.
        'options' =>  $options,
        'value' => $linstallpagevalue // if empty, retrieved from post_meta
        )
    );

    woocommerce_wp_select( array(
        'id' => '_lhowtopage', // required, will be used as meta_key
        'label' => __('How to Order & Buy', 'marrakeshadmin' ), // Text in the label in the editor.
        'options' =>  $options,
        'value' => $lhowtopagevalue // if empty, retrieved from post_meta
        )
    );


    echo '</div>';
    echo '</div>';
}






function marrakesh_validDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

add_action('woocommerce_process_product_meta', 'marrakesh_save_wc_custom_fields');
function marrakesh_save_wc_custom_fields( $post_id ) {
    $product = wc_get_product( $post_id );

    $csstock = isset( $_POST[ '_csstock' ] ) ? sanitize_text_field( $_POST[ '_csstock' ] ) : '';
    $csarrival = (isset( $_POST[ '_csarrival' ] ) && marrakesh_validDate( $_POST[ '_csarrival' ]) ) ? sanitize_text_field( date('Y-m-d', strtotime($_POST[ '_csarrival' ]) ) ) : '';

    $isboxed = isset( $_POST[ '_isboxed' ] ) ? sanitize_text_field( $_POST[ '_isboxed' ] ) : 'no';
    $sizeperbox = isset( $_POST[ '_sizeperbox' ] ) ? sanitize_text_field( $_POST[ '_sizeperbox' ] ) : '';
    $tilesperbox = isset( $_POST[ '_tilesperbox' ] ) ? sanitize_text_field( $_POST[ '_tilesperbox' ] ) : '';

    $tileweight = isset( $_POST[ '_tileweight' ] ) ? sanitize_text_field( $_POST[ '_tileweight' ] ) : '';
    $tilewidth = isset( $_POST[ '_tilewidth' ] ) ? sanitize_text_field( $_POST[ '_tilewidth' ] ) : '';
    $tileheight = isset( $_POST[ '_tileheight' ] ) ? sanitize_text_field( $_POST[ '_tileheight' ] ) : '';
    $tilethickness = isset( $_POST[ '_tilethickness' ] ) ? sanitize_text_field( $_POST[ '_tilethickness' ] ) : '';

    $linfopage = isset( $_POST[ '_linfopage' ] ) ? esc_attr( $_POST[ '_linfopage' ] ) : '';
    $linstallpage = isset( $_POST[ '_linstallpage' ] ) ? esc_attr( $_POST[ '_linstallpage' ] ) : '';
    $lhowtopage = isset( $_POST[ '_lhowtopage' ] ) ? esc_attr( $_POST[ '_lhowtopage' ] ) : '';


    $testselect = isset( $_POST[ '_testselect' ] ) ?  esc_attr( $_POST[ '_testselect' ] ) : '';

    $product->update_meta_data( '_csstock', $csstock );
    $product->update_meta_data( '_csarrival', $csarrival );

    $product->update_meta_data( '_isboxed', $isboxed );
    $product->update_meta_data( '_sizeperbox', $sizeperbox );
    $product->update_meta_data( '_tilesperbox', $tilesperbox );

    $product->update_meta_data( '_tileweight', $tileweight );
    $product->update_meta_data( '_tilewidth', $tilewidth );
    $product->update_meta_data( '_tileheight', $tileheight );
    $product->update_meta_data( '_tilethickness', $tilethickness );

    $product->update_meta_data( '_linfopage', $linfopage );
    $product->update_meta_data( '_linstallpage', $linstallpage );
    $product->update_meta_data( '_lhowtopage', $lhowtopage );

    $product->save();
}

/****** Price unit Display Tricks */
add_filter( 'woocommerce_get_price_html', 'marrakesh_price_html', 100, 2 );
function marrakesh_price_html( $price, $product ){
    if (get_post_meta($product->get_id(), '_isboxed', true )=='yes') {
        $price.='/box';
    }
    else {$price.='/pcs.';}
    return $price;
}

add_filter( 'woocommerce_cart_item_price', 'marrakesh_united_cartitem_price', 10, 2 );
function marrakesh_united_cartitem_price( $price, $cart_item) {
    if (get_post_meta($cart_item[data]->get_id(), '_isboxed', true )=='yes') {
        $price.='/box';
    }
    else {$price.='/pcs.';}
    return $price;
}


/****** Stock Quantity unit Display Tricks */
function marrakesh_add_stock_quantity_unit( $stock_quantity, $product ) {
    if ( get_post_meta($product->get_id(), '_isboxed', true ) && ($sizeperbox = get_post_meta($product->get_id(), '_sizeperbox', true ) ) ) {
        $stock_quantity=number_format($stock_quantity/$sizeperbox,1);
        $stock_quantity.=__('m<sup>2</sup>','marrakesh');
    }
    return '<strong>'.$stock_quantity.'</strong>';
};

add_filter( 'woocommerce_format_stock_quantity', 'marrakesh_add_stock_quantity_unit', 10, 2 );






// define the woocommerce_get_availability_text callback
function marrakesh_change_get_availability_text( $availability, $instance ) {
    if ( ! $instance->is_in_stock() ) {
        $availability = __( 'Out of stock', 'woocommerce' );
        $availability.=' <span data-tooltip title="'.__( 'Production on order only. Est. shipping time: 8-10 weeks', 'marrakesh' ).'" ><svg class="icon"><use xlink:href="#icon-info"></use></svg></span>';
    } elseif ( $instance->managing_stock() && $instance->is_on_backorder( 1 ) ) {
        //$availability = $instance->backorders_require_notification() ? __( 'Coming soon', 'marrakesh' ) : '';
        if ( $instance->backorders_require_notification() ) {
            $availability = __( 'Coming soon', 'marrakesh' );
            $availability.=' <span data-tooltip title="'.__( '42.5 m2 arrive at 2019.08.12.', 'marrakesh' ).'" ><svg class="icon"><use xlink:href="#icon-info"></use></svg></span>';
        } else {
            $availability = '';
        }

    } elseif ( $instance->managing_stock() ) {
        //$availability = wc_format_stock_for_display( $instance );
        /*---------*/
        $availability      = __( 'In stock', 'woocommerce' );
        $stock_amount = $instance->get_stock_quantity();

        switch ( get_option( 'woocommerce_stock_format' ) ) {
            case 'low_amount':
                if ( $stock_amount <= get_option( 'woocommerce_notify_low_stock_amount' ) ) {
                    /* translators: %s: stock amount */
                    $availability = sprintf( __( 'Only %s left in stock', 'woocommerce' ), wc_format_stock_quantity_for_display( $stock_amount, $instance ) );
                }
                break;
            case '':
                /* translators: %s: stock amount */
                $availability = sprintf( __( '%s in stock', 'woocommerce' ), wc_format_stock_quantity_for_display( $stock_amount, $instance ) );
                break;
        }

        if ( $instance->backorders_allowed() && $instance->backorders_require_notification() ) {
            $availability .= ' &<br> ' . __( 'also coming soon', 'marrakesh' );
            $availability.=' <span data-tooltip title="'.__( '42.5 m2 arrive at 2019.08.12.', 'marrakesh' ).'" ><svg class="icon"><use xlink:href="#icon-info"></use></svg></span>';
        }



        /*---------*/
    } else {
        $availability = '';
    }
    return $availability;
};
add_filter( 'woocommerce_get_availability_text', 'marrakesh_change_get_availability_text', 10, 2 );