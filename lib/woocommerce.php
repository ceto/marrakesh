<?php
//* Enqueue scripts and styles

function marrakesh_remove_woocommerce_js() {
    wp_deregister_script( 'sourcebuster-js' );
    wp_dequeue_script( 'sourcebuster-js' );

}
add_action( 'wp_enqueue_scripts', 'marrakesh_remove_woocommerce_js');

function marrakesh_deregister_woocommerce_block_styles() {
    wp_deregister_style( 'wc-blocks-style' );
    wp_dequeue_style( 'wc-blocks-style' );

    wp_deregister_style( 'wc-block-editor' );
    wp_dequeue_style( 'wc-block-editor' );
}
add_action( 'enqueue_block_assets', 'marrakesh_deregister_woocommerce_block_styles' );

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
    if ( function_exists( 'is_woocommerce' ) ) {
        if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
            remove_action('wp_enqueue_scripts', [WC_Frontend_Scripts::class, 'load_scripts']);
	        remove_action('wp_print_scripts', [WC_Frontend_Scripts::class, 'localize_printed_scripts'], 5);
	        remove_action('wp_print_footer_scripts', [WC_Frontend_Scripts::class, 'localize_printed_scripts'], 5);
        }
    }
}


function marrakesh_loop_shop_per_page( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options -> Reading
  // Return the number of products you wanna show per page. recommended value 84
  $cols = 84;
  return $cols;
}
add_filter( 'loop_shop_per_page', 'marrakesh_loop_shop_per_page', 20 );

remove_action( 'woocommerce_before_single_product', 'wc_print_notices', 10);
add_action( 'marrakesh_after_banner', 'wc_print_notices', 10 );


remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
add_action( 'marrakesh_after_banner', 'woocommerce_output_all_notices', 10 );


remove_action( 'woocommerce_before_cart', 'woocommerce_output_all_notices', 10);
add_action( 'marrakesh_after_banner', 'woocommerce_output_all_notices', 10 );

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
function woocommerce_template_loop_product_link_close() {
    echo '</a>';
    echo do_shortcode('[yith_wcwl_add_to_wishlist]');
}

function woocommerce_template_loop_product_thumbnail() {
    // global $product;
    echo '<figure class="prodcard__prodimage">';
    echo woocommerce_get_product_thumbnail('medium'); // WPCS: XSS ok.
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
        // $query->set( 'meta_key', '_stock' );
        $query->set( 'orderby',  array('title' => 'ASC') );

        $availability_filter = isset( $_GET['filter_availability'] ) ? wc_clean( wp_unslash( $_GET['filter_availability'] ) ) : array(); // WPCS: input var ok, CSRF ok.
        $comingsoon_filter = isset( $_GET['filter_cs'] ) ? wc_clean( wp_unslash( $_GET['filter_cs'] ) ) : array(); // WPCS: input var ok, CSRF ok.
        $onsale_filter = isset( $_GET['filter_onsale'] ) ? wc_clean( wp_unslash( $_GET['filter_onsale'] ) ) : array(); // WPCS: input var ok, CSRF ok.
        $meta_query = array();
        // $meta_query[] = array('relation' => 'or');

        if ($availability_filter === 'in_stock') {
            if ($comingsoon_filter === '1') {
                $meta_query[]  = array(
                    'relation' => 'OR',
                    array(
                        'key' => '_csstock',
                        'value' => '0',
                        'compare' => '>',
                    ),
                    array(
                        'key' => '_stock_status',
                        'value' => 'instock',
                        'compare' => '=',
                    )
                );
            } else {
                $meta_query[]  = array(
                    'key' => '_stock_status',
                    'value' => 'instock',
                    'compare' => '=',
                );
            }
        } elseif ($comingsoon_filter === '1') {
            $meta_query[]  = array(
                'key' => '_csstock',
                'value' => '0',
                'compare' => '>',
            );
        };
        if ($onsale_filter === '1') {
            $product_ids_on_sale = wc_get_product_ids_on_sale();
            $query->set( 'post__in', $product_ids_on_sale );
        };
        $query->set('meta_query', $meta_query );
    }
}, PHP_INT_MAX );



add_filter( 'woocommerce_before_widget_product_list', function(){
    return '<ul class="prodswipe">';
});

add_filter( 'woocommerce_after_widget_product_list', function(){
    return '</ul><nav class="scroller" data-target="prodswipe">
    <a href="#" class="js-scrollleft">‹</a>
    <a href="#" class="js-scrollright">›</a>
</nav>';
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
    $productid = $product->get_id();
    if (get_post_meta($productid, '_isboxed', true )=='yes') {
        $price.='/'.__('doboz','marrakesh');
    }
    else {$price.='/'.__('db','marrakesh');}
    return $price;
}

add_filter( 'woocommerce_cart_item_price', 'marrakesh_united_cartitem_price', 10, 2 );
function marrakesh_united_cartitem_price( $price, $cart_item) {
    if (get_post_meta($cart_item[data]->get_id(), '_isboxed', true )=='yes') {
        $price.='/'.__('doboz','marrakesh');
    }
    else {$price.='/'.__('db','marrakesh');}
    return $price;
}


/****** Stock Quantity unit Display Tricks */
function marrakesh_add_stock_quantity_unit( $stock_quantity, $product ) {
    $productid = $product->get_id();
    if ( get_post_meta($productid, '_isboxed', true ) && ($sizeperbox = get_post_meta($productid, '_sizeperbox', true ) ) ) {
        $stock_quantity=number_format($stock_quantity*$sizeperbox,1);
        $stock_quantity.=__('m<sup>2</sup>','marrakesh');
    } else {
        $stock_quantity.=' '.__('db','marrakesh');
    }
    return '<strong>'.$stock_quantity.'</strong>';
};

add_filter( 'woocommerce_format_stock_quantity', 'marrakesh_add_stock_quantity_unit', 10, 2 );






// define the woocommerce_get_availability_text callback
function marrakesh_change_get_availability_text( $availability, $instance ) {
    $csstock = get_post_meta($instance->get_id(), '_csstock', true );
    $csdate = get_post_meta($instance->get_id(), '_csarrival', true );

    if ( ! $instance->is_in_stock() ) {
        $availability = __( 'Out of stock', 'woocommerce' );
    } elseif ( $instance->managing_stock() && $instance->is_on_backorder( 1 ) ) {
        //$availability = $instance->backorders_require_notification() ? __( 'Coming soon', 'marrakesh' ) : '';
        if ( $instance->backorders_require_notification() ) {

            if ( $csstock && $csdate ) {
                $availability = ''; //__( 'Hamarosan raktáron', 'marrakesh' );
            } else {
                $availability = __( 'Rendelhető', 'marrakesh' );
                $tooltip=__( '10-12 hét', 'marrakesh' );
                $shipclassslug = $instance->get_shipping_class();
                if ($theshipclass = get_term_by('slug', $shipclassslug, 'product_shipping_class' )) {
                    $tooltip = wp_strip_all_tags(term_description( $theshipclass ), true);
                }
                $availability='<span class="ninfo">'.__('Várható szállítás','marrakesh').': '.$tooltip.'</span>';
            }

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

        /*---------*/
    } else {
        $availability = '';
    }

    if ( $csstock && $csdate ) {
        $availability .= '<span class="cs">' . __( 'Érkezik', 'marrakesh' ).': '.date('M. j.',strtotime($csdate)).' <strong>'.wc_format_stock_quantity_for_display( $csstock, $instance ).'</strong></span>';
    }


    return $availability;
};
add_filter( 'woocommerce_get_availability_text', 'marrakesh_change_get_availability_text', 10, 2 );


// Change backorder notification - Shop page
function marrakesh_cart_item_backorder_notification( $html, $product_id ){

    $availability = __( '10-12 hét', 'marrakesh' );

    $csstock = get_post_meta($product_id, '_csstock', true );
    $csdate = get_post_meta($product_id, '_csarrival', true );
    $product= get_product($product_id);


    if ( $csstock && $csdate ) {
        $availability = date('M. j.',strtotime($csdate));
    } else {
        $shipclassslug = $product->get_shipping_class();
        if ($theshipclass = get_term_by('slug', $shipclassslug, 'product_shipping_class' )) {
            $availability = wp_strip_all_tags(term_description( $theshipclass ), true);
        }
    }


    return '<p class="backorder_notification">'.__( 'Várható szállítás', 'marrakesh' ).': '.$availability.'</p>';
}
add_filter( 'woocommerce_cart_item_backorder_notification', 'marrakesh_cart_item_backorder_notification', 10, 2 );


// Add from stock text on cart page
function marrakesh_cart_item_fromstock_notification( $cart_item, $cart_item_key ){
    $instance = get_product($cart_item['product_id']);
    if (!$instance->is_on_backorder( $cart_item['quantity'] ) ) {
        echo '<p class="backorder_notification">'.__( 'Raktárról azonnal', 'woocommerce' ). '</p>';
    }
}

add_filter( 'woocommerce_after_cart_item_name', 'marrakesh_cart_item_fromstock_notification', 10, 2 );


function marrakesh_add_meta_on_checkout_order_review_item( $quantity , $cart_item , $cart_item_key  ) {

    $productid = $cart_item['product_id'];
    $datafromprodisboxed = get_post_meta($productid, '_isboxed', true );
    $datafromprodsizeperbox = get_post_meta($productid, '_sizeperbox', true );
    if ($datafromprodisboxed=='yes') {
        echo '<br><strong class="product-quantity">'
        .$cart_item[ 'quantity' ]*$datafromprodsizeperbox.'&nbsp;m<sup>2</sup>'
        .' ('.$cart_item[ 'quantity' ].'&nbsp;'.__('doboz','marrakesh').')'
        .'</strong>';
    } else {
        echo '<br><strong class="product-quantity">×&nbsp;'.$cart_item[ 'quantity' ].'&nbsp;'.__('db.','marrakesh').'</strong>';
    }
}
add_filter( 'woocommerce_checkout_cart_item_quantity', 'marrakesh_add_meta_on_checkout_order_review_item', 1, 3 );

/**
 * Widget rating filter class.
 */
class WC_Widget_Status_Filter extends WC_Widget {
    /**
     * Constructor.
     */
    public function __construct() {
        $this->widget_cssclass    = 'woocommerce widget_status_filter';
        $this->widget_description = __( 'Display a list of additional options to filter products in your store.', 'woocommerce' );
        $this->widget_id          = 'woocommerce_status_filter';
        $this->widget_name        = __( 'Filter Products by Status', 'woocommerce' );
        $this->settings           = array(
            'title' => array(
                'type'  => 'text',
                'std'   => __( 'Raktárkészlet', 'woocommerce' ),
                'label' => __( 'Title', 'woocommerce' ),
            ),
        );
        parent::__construct();
    }

    /**
     * Output widget.
     *
     * @see WP_Widget
     * @param array $args     Arguments.
     * @param array $instance Widget instance.
     */
    public function widget( $args, $instance ) {
        if ( ! is_shop() && ! is_product_taxonomy() ) {
            return;
        }

        $availability_filter = isset( $_GET['filter_availability'] ) ? wc_clean( wp_unslash( $_GET['filter_availability'] ) ) : array(); // WPCS: input var ok, CSRF ok.
        $csavailability_filter = isset( $_GET['filter_cs'] ) ? wc_clean( wp_unslash( $_GET['filter_cs'] ) ) : array(); // WPCS: input var ok, CSRF ok.
        $onsale_filter = isset( $_GET['filter_onsale'] ) ? wc_clean( wp_unslash( $_GET['filter_onsale'] ) ) : array(); // WPCS: input var ok, CSRF ok.


        $this->widget_start( $args, $instance );

        echo '<ul class="woocommerce-widget-layered-nav-list">';

        $class       = $availability_filter ? 'wc-availability-in-stock chosen' : 'wc-availability-in-stock';
        $link        = apply_filters( 'woocommerce_availability_filter_link', ! $availability_filter ? add_query_arg( 'filter_availability', 'in_stock' ) : remove_query_arg( 'filter_availability' ) );
        $rating_html = __('Azonnal vihető', 'marrakesh');
        $count_html  = ''; ////////// ADD COUNT LATER

        printf( '<li class="%s"><a href="%s">%s</a> %s</li>', esc_attr( $class ), esc_url( $link ), $rating_html, $count_html ); // WPCS: XSS ok.

        $class       = $csavailability_filter ? 'wc-availability-in-stock chosen' : 'wc-availability-in-stock';
        $link        = apply_filters( 'woocommerce_availability_filter_link', ! $csavailability_filter ? add_query_arg( 'filter_cs', '1' ) : remove_query_arg( 'filter_cs' ) );
        $rating_html = __('Hamarosan raktáron', 'marrakesh');
        $count_html  = ''; ////////// ADD COUNT LATER

        printf( '<li class="%s"><a href="%s">%s</a> %s</li>', esc_attr( $class ), esc_url( $link ), $rating_html, $count_html ); // WPCS: XSS ok.


        $class       = $onsale_filter ? 'wc-availability-in-stock chosen' : 'wc-availability-in-stock';
        $link        = apply_filters( 'woocommerce_availability_filter_link', ! $onsale_filter ? add_query_arg( 'filter_onsale', '1' ) : remove_query_arg( 'filter_onsale' ) );
        $rating_html = __('Akciós termékek', 'marrakesh');
        $count_html  = ''; ////////// ADD COUNT LATER

        printf( '<li class="%s"><a href="%s">%s</a> %s</li>', esc_attr( $class ), esc_url( $link ), $rating_html, $count_html ); // WPCS: XSS ok.

        echo '</ul>';

        $this->widget_end( $args );
    }
} // end class WC_Widget_Status_Filter extends WC_Widget

add_action( 'widgets_init', function(){ register_widget( 'WC_Widget_Status_Filter' );});


function marrakesh_laynavlink($link, $term, $taxonomy ) {
    $availability_filter = isset( $_GET['filter_availability'] ) ? wc_clean( wp_unslash( $_GET['filter_availability'] ) ) : array(); // WPCS: input var ok, CSRF ok.
    $csavailability_filter = isset( $_GET['filter_cs'] ) ? wc_clean( wp_unslash( $_GET['filter_cs'] ) ) : array(); // WPCS: input var ok, CSRF ok.

    return add_query_arg(array(
        'filter_availability' => $availability_filter,
        'filter_cs' => $csavailability_filter
        ),$link);
}
add_filter( 'woocommerce_layered_nav_link', 'marrakesh_laynavlink', 10, 3 );



  // define the woocommerce_layered_nav_count callback
function filter_woocommerce_layered_nav_count( $span_class_count_absint_count_span, $count, $term ) {
    // make filter magic happen here...
    return '';
};

// add the filter
add_filter( 'woocommerce_layered_nav_count', 'filter_woocommerce_layered_nav_count', 10, 3 );



//Cart an checkout stuffs

add_filter( 'woocommerce_cart_needs_shipping_address', '__return_false');

add_filter( 'woocommerce_checkout_fields', 'marrakesh_checkout_fields' );
function marrakesh_checkout_fields( $woo_checkout_fields_array ) {
    unset( $woo_checkout_fields_array['billing']['billing_last_name'] );
    unset( $woo_checkout_fields_array['billing']['billing_country']);
    unset( $woo_checkout_fields_array['billing']['billing_address_2'] );
    unset( $woo_checkout_fields_array['billing']['billing_state'] );
    unset( $woo_checkout_fields_array['billing']['billing_company'] );

    $woo_checkout_fields_array['billing']['billing_first_name']['label'] = __('Név', 'marrakesh');

    $woo_checkout_fields_array['order']['order_comments']['placeholder'] = __('pl.: Céges számlaigény, adószám stb...', 'marrakesh');

	return $woo_checkout_fields_array;
}


function marrakesh_cartcount() {
    global $woocommerce;
    if ($woocommerce->cart->cart_contents_count != 0) {
      return '<span class="badge">'. $woocommerce->cart->cart_contents_count.'</span>';
    } else {
      return '';
    }
  }
  function marrakesh_carttotal() {
    global $woocommerce;
    return '<span class="total">'.$woocommerce->cart->get_cart_total().'</span>';
  }





add_filter('wpseo_title', 'custom_titles', 10, 1);
function custom_titles() {
    global $wp;
    $current_slug = $wp->request;
    if ($current_slug == 'foobar') {
        return 'Foobar';
    }
}

function marrakesh_product_title($title) {

    if ( is_singular('product') ) {
        global $post;
        $title = mb_strtoupper(get_the_title($post));
        if ( has_excerpt($post) ) {
            $title .= ' - '.wp_strip_all_tags(get_the_excerpt($post), true);
        } else {
            $cats     = wc_get_product_terms( $post->ID, 'product_cat', array( 'fields' => 'ids', 'orderby' => 'parent', 'order' => 'ASC' ) );
            $title .= ' - '.get_term($cats[0])->name;
        }
    } elseif ( is_tax('product_cat') ) {
            $category = get_queried_object();
            $title = mb_strtoupper($category->name);
            $root = get_term( end( get_ancestors( $category->term_id, 'product_cat' ) ), 'product_cat');
            if ( !is_wp_error( $root ) ) {
                $title .= ' - '.$root->name;
            } else {
                $title .= ' - '.get_bloginfo('name');
            }
    }
    return $title;
}
add_filter( 'pre_get_document_title', 'marrakesh_product_title', 20 );





function marrakesh_override_prod_category_display( $value = null, $object_id, $meta_key, $single ){
    $browse=false;
    if ( $_GET[ 'browse' ] ) {
        $browse=true;
    }
    $term = get_term( $object_id, 'product_cat' );
    if( is_object( $term ) && $meta_key === 'display_type' && $browse ) {
        $display_type = 'products';
    } else {   //  else return nothing, this meta is not "display_type"
        return;
    }

    return ( $single === true ) ? $display_type : array( $display_type );
}
//	Attach function with wordpress filter
add_filter( 'get_term_metadata', 'marrakesh_override_prod_category_display', 10, 4 );


function marrakesh_wc_layered_nav_link_hack( $link, $term, $taxonomy ) {
    if( $_GET[ 'browse' ] ) {
        return add_query_arg( 'browse', '1', $link);
    } else {
        return $link;
    }
}
add_filter( 'woocommerce_layered_nav_link', 'marrakesh_wc_layered_nav_link_hack', 10, 4 );


// function marrakesh_product_onslae_query( $q ) {
//     if ( is_admin() ) return;

//     // Isset & NOT empty
//     if ( isset( $_GET['filter_onsale'] ) ) {
//         // Equal to 1
//         if ( $_GET['filter_onsale'] == 1 ) {
//             //  Function that returns an array containing the IDs of the products that are on sale.
//             $product_ids_on_sale = wc_get_product_ids_on_sale();

//             $q->set( 'post__in', $product_ids_on_sale );
//         }
//     }
// }
// add_action( 'woocommerce_product_query', 'marrakesh_product_onslae_query', 10, 1 );
