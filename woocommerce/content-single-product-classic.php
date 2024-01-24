<?php
defined( 'ABSPATH' ) || exit;

global $product, $post, $datafromprod, $sitepress;
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
<?php

    $product_id = wc_get_product()->get_id();

    $colors   = wc_get_product_terms( $product_id, 'pa_color', array( 'fields' => 'ids' ) );
    $styles   = wc_get_product_terms( $product_id, 'pa_style', array( 'fields' => 'ids' ) );
    $cats     = wc_get_product_terms( $product_id, 'product_cat', array( 'fields' => 'ids', 'orderby' => 'parent', 'order' => 'ASC' ) );

    $datafromprod['_isboxed'] = get_post_meta($product_id, '_isboxed', true );
    $datafromprod['_sizeperbox'] = get_post_meta($product_id, '_sizeperbox', true );
    $datafromprod['_tilesperbox'] = get_post_meta($product_id, '_tilesperbox', true );
    $datafromprod['_tileweight'] = get_post_meta($product_id, '_tileweight', true );
    $datafromprod['_tilewidth'] = get_post_meta($product_id, '_tilewidth', true );
    $datafromprod['_tileheight'] = get_post_meta($product_id, '_tileheight', true );
    $datafromprod['_tilethickness'] = get_post_meta($product_id, '_tilethickness', true );

    $datafromprod['_linfopage'] = get_post_meta($product_id, '_linfopage', true );

?>

<div class="ps ps--thin ps--xlight ps--bordered">
    <div class="grid-container">
        <section class="brblock brblock--smaller">
            <?php woocommerce_breadcrumb(array('home'=>'')); ?>
        </section>
    </div>
</div>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('singleproduct', $product ); ?>>

    <header class="scprhead">
        <figure class="scprhead__fig">
            <?php echo wp_get_attachment_image( get_field('wallimg', $product_id, false), 'full' ); ?>
        </figure>

        <div class="scprhead__content">
            <div class="scprhead__content__one">
                <figure class="singleproduct__prodthumb">
                    <?php if (get_field('singleimg', $product_id, false)) : ?>
                    <?php echo wp_get_attachment_image( get_field('singleimg', $product_id, false), 'tiny' ); ?>
                    <?php else : ?>
                    <?php echo woocommerce_get_product_thumbnail('medium'); ?>
                    <?php endif; ?>
                </figure>


                <h1 class="singleproduct__title entry-title"><?php the_title(); ?></h1>
                <?php if ( $product->is_on_sale() ) : ?>
                <?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product ); ?>
                <?php endif;?>
                <?php if (has_excerpt() ) :?>
                    <div class="singleproduct__shortdesc"><?php the_excerpt(); ?></div>
                <?php endif; ?>



                <p class="singleproduct__price">
                    <?php wc_get_template_part( 'loop/price'); ?>
                </p>

                <div class="singleproduct__status">
                    <?php echo wc_get_stock_html( $product ); // WPCS: XSS ok. ?>
                </div>
            </div>

            <div class="scprhead__content__two">
                <?php if ($datafromprod['_isboxed']=='yes') : ?>
                <?php get_template_part('templates/calculator'); ?>
                <?php else : ?>
                <?php do_action( 'woocommerce_single_product_summary' ); ?>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <?php do_action( 'woocommerce_after_single_product' ); ?>
    <?php get_template_part('templates/photoswipedom'); ?>
    <?php get_template_part('templates/requestmodal'); ?>
