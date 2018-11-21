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

global $product, $post;
$attributes = $product->get_attributes();

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('singleproduct'); ?>>
    <aside class="singleproduct__bg">
        <?php echo wp_get_attachment_image( get_field('wallimg',false,false), 'full' ); ?>
    </aside>

    <div class="grid-container">
        <div class="grid-x grid-margin-x">
            <div class="cell medium-6 large-4">
                <header class="summary entry-summary singleproduct__header">
                    <?php do_action( 'woocommerce_before_single_product_summary' ); ?>

                    <?php if ( $product->is_on_sale() ) : ?>
                        <?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product ); ?>
                    <?php endif;?>

                    <div class="singleproduct__meta meta">
                        <?php do_action( 'woocommerce_product_meta_start' ); ?>
                        <?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
                            <span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?> <span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span></span>
                        <?php endif; ?>
                        <?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( '', '', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
                        <?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
                        <?php do_action( 'woocommerce_product_meta_end' ); ?>
                    </div>
                    <h1 class="singleproduct__title entry-title"><?php the_title(); ?></h1>
                    
                    <?php echo wc_get_stock_html( $product ); // WPCS: XSS ok. ?>

                    <?php if ( $short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ) : ?>
                    <div class="singleproduct__shortdesc woocommerce-product-details__short-description">
                        <?php echo $short_description; // WPCS: XSS ok. ?>
                    </div>
                    <?php endif; ?>
                    <dl class="singleproduct__attributes">
                        <?php foreach ( $attributes as $attribute ) : ?>
                            <dt><?php echo wc_attribute_label( $attribute->get_name() ); ?></dt>
                            <dd><?php
                                $values = array();

                                if ( $attribute->is_taxonomy() ) {
                                    $attribute_taxonomy = $attribute->get_taxonomy_object();
                                    $attribute_values = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );

                                    foreach ( $attribute_values as $attribute_value ) {
                                        $value_name = esc_html( $attribute_value->name );

                                        if ( $attribute_taxonomy->attribute_public ) {
                                            $values[] = '<a href="' . esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ) . '" rel="tag">' . $value_name . '</a>';
                                        } else {
                                            $values[] = $value_name;
                                        }
                                    }
                                } else {
                                    $values = $attribute->get_options();

                                    foreach ( $values as &$value ) {
                                        $value = make_clickable( esc_html( $value ) );
                                    }
                                }

                                echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
                            ?></dd>
                        <?php endforeach; ?>
                        <?php if ( /*$display_dimensions &&*/ $product->has_weight() ) : ?>
                            <dt><?php _e( 'Weight', 'woocommerce' ) ?></dt>
                            <dd class="product_weight"><?php echo esc_html( wc_format_weight( $product->get_weight() ) ); ?></dd>
                        <?php endif; ?>

                        <?php if ( /*$display_dimensions &&*/ $product->has_dimensions() ) : ?>
                            <dt><?php _e( 'Dimensions', 'woocommerce' ) ?></dt>
                            <dd class="product_dimensions"><?php echo esc_html( wc_format_dimensions( $product->get_dimensions( false ) ) ); ?></dd>
                        <?php endif; ?>
                    </dl>

                    
                    <?php do_action( 'woocommerce_single_product_summary' ); ?>
                    <hr>
                    <p class="singleproduct__price price"><?php echo $product->get_price_html(); ?></p>
                    

                </header>
           </div>            
        </div>
    </div>


    
    
    <div class="grid-container">
        <div class="grid-x grid-margin-x">
            <div class="cell">
                <?php
                    woocommerce_upsell_display( $limit = '-1', $columns = 4, $orderby = 'rand', $order = 'desc' );
                    //woocommerce_output_related_products();
                ?>
                <?php
                    $designs   = wc_get_product_terms( $product->id, 'pa_design', array( 'fields' => 'ids' ) );
                    $colors   = wc_get_product_terms( $product->id, 'pa_color', array( 'fields' => 'ids' ) );
                    $styles   = wc_get_product_terms( $product->id, 'pa_style', array( 'fields' => 'ids' ) );
                    $cats      = wc_get_product_terms( $product->id, 'product_cat', array( 'fields' => 'ids' ) );
                    $reldesignproducts = wc_get_products(array(
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'exclude' => array($product->id),
                        'tax_query'      => array(
                            'relation' => 'AND',
                            array(
                                'taxonomy'     => 'product_cat',
                                'field'        => 'id',
                                'terms'        => $cats,
                                'operator'     => 'IN'
                                    
                            ),
                            array(
                                'taxonomy'     => 'pa_design',
                                'field'        => 'id',
                                'terms'        => $designs,
                                'operator'     => 'IN'
                            )
                        )
                    ) );
                    $exclarr=array($product->id);
                    foreach ($reldesignproducts as $tempprod) {
                        $exclarr[]= $tempprod->id;
                        
                    }
                    $relproducts = wc_get_products(array(
                        'post_status' => 'publish',
                        'posts_per_page' => 10,
                        'post__not_in' => $exclarr,
                        'tax_query'      => array(
                            'relation' => 'AND',
                            array(
                                'taxonomy'     => 'pa_color',
                                'field'        => 'id',
                                'terms'        => $colors,
                                'operator'     => 'IN'
                            ),
                            array(
                                'taxonomy'     => 'pa_style',
                                'field'        => 'id',
                                'terms'        => $styles,
                                'operator'     => 'IN'
                            )
                        )
                    ) );
                    ?>
                    <ul class="tabs" data-tabs id="example-tabs">
                        <?php if ( $reldesignproducts  ) : ?><li class="tabs-title is-active"><a data-tabs-target="panel1" href="#panel1" aria-selected="true"><?php esc_html_e( 'Color Variations', 'marrakesh' ); ?></a></li><?php endif;  ?>
                        <?php if ( $relproducts ) : ?><li class="tabs-title"><a data-tabs-target="panel2" href="#panel2"><?php esc_html_e( 'Similar Products', 'marrakesh' ); ?></a></li><?php endif;  ?>
                    </ul>
                    
                    <div class="tabs-content" data-tabs-content="example-tabs">

                    <?php if ( $reldesignproducts ) : ?>
                        <div class="tabs-panel is-active" id="panel1">

                        <section class="related products">

                            <ul class="prodgrid prodgrid--columns-6">

                                <?php foreach ( $reldesignproducts as $related_product ) : ?>

                                    <?php
                                        $post_object = get_post( $related_product->get_id() );

                                        setup_postdata( $GLOBALS['post'] =& $post_object );

                                        wc_get_template_part( 'content', 'product' ); ?>

                                <?php endforeach; wp_reset_postdata(); ?>

                            </ul>

                        </section>
                        </div>

                    <?php endif;  ?>

                    <?php if ( $relproducts ) : ?>
                        <div class="tabs-panel" id="panel2">

                        <section class="related products">


                            <ul class="prodgrid prodgrid--columns-6">

                                <?php foreach ( $relproducts as $related_product ) : ?>

                                    <?php
                                        $post_object = get_post( $related_product->get_id() );

                                        setup_postdata( $GLOBALS['post'] =& $post_object );

                                        wc_get_template_part( 'content', 'product' ); ?>

                                <?php endforeach; wp_reset_postdata(); ?>

                            </ul>

                        </section>
                        </div>
                    <?php endif;  ?>
                    </div>
                    <?php

                    // woocommerce_related_products( 
                    //     array( 
                    //         'posts_per_page' => 12,
                    //         'columns' => 5,
                    //         'orderby'=> 'rand',
                    //     )
                    // );

                    do_action( 'woocommerce_after_single_product_summary' );
                ?>
            </div>
        </div>
    </div>
    

</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
