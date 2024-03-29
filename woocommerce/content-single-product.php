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
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $product_id, $colors, $styles, $cats, $post, $datafromprod, $attributes, $sitepress;
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
        <div class="scprhead__media">
            <figure class="scprhead__fig">
                <?php echo wp_get_attachment_image( get_field('wallimg', $product_id, false), 'full' ); ?>
            </figure>
            <div class="scprhead__thumbs">
                <div class="psgallery thumbswipe sima">
                        <?php if (get_field('singleimg', $product_id, false)) : ?>
                        <figure class="thumbswipe__item psgallery__item" itemprop="associatedMedia" itemscope
                            itemtype="http://schema.org/ImageObject">
                            <a href="<?php $targimg = wp_get_attachment_image_src( get_field('singleimg', $product_id, false),'full'); echo $targimg[0];?>"
                                data-size="<?= $targimg['1'].'x'.$targimg['2']; ?>">
                                <?php echo wp_get_attachment_image( get_field('singleimg', $product_id, false), 'medium' ); ?>
                            </a>
                        </figure>
                        <?php endif; ?>
                        <figure class="thumbswipe__item psgallery__item" itemprop="associatedMedia" itemscope
                            itemtype="http://schema.org/ImageObject">
                            <a href="<?php $targimg = wp_get_attachment_image_src(get_post_thumbnail_id( $product_id),'full'); echo $targimg[0];?>"
                                data-size="<?= $targimg['1'].'x'.$targimg['2']; ?>">
                                <?php echo woocommerce_get_product_thumbnail('medium'); ?>
                            </a>
                        </figure>
                        <figure class="thumbswipe__item psgallery__item" itemprop="associatedMedia" itemscope
                            itemtype="http://schema.org/ImageObject">
                            <a href="<?php $targimg = wp_get_attachment_image_src(get_field('wallimg', $product_id, false),'full'); echo $targimg[0];?>"
                                data-size="<?= $targimg['1'].'x'.$targimg['2']; ?>">
                                <?php echo wp_get_attachment_image( get_field('wallimg', $product_id, false), 'medium' ); ?>
                            </a>
                        </figure>
                        <?php $attachment_ids = $product->get_gallery_image_ids(); ?>
                        <?php if ( $attachment_ids && $product->get_image_id() ) : ?>
                        <?php foreach ( $attachment_ids as $attachment_id ) : ?>
                        <figure class="thumbswipe__item psgallery__item" itemprop="associatedMedia" itemscope
                            itemtype="http://schema.org/ImageObject">
                            <a href="<?php $targimg = wp_get_attachment_image_src($attachment_id,'full'); echo $targimg[0];?>"
                                data-size="<?= $targimg['1'].'x'.$targimg['2']; ?>">
                                <?php echo wp_get_attachment_image( $attachment_id, 'medium' ); ?>
                            </a>
                        </figure>
                        <?php endforeach; ?>
                        <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="scprhead__content">
            <div class="scprhead__content__one">
                <h1 class="singleproduct__title entry-title"><?php the_title(); ?></h1>
                <?php if ( $product->is_on_sale() ) : ?>
                <?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product ); ?>
                <?php endif;?>
                <div class="singleproduct__shortdesc">
                    <?php if (has_excerpt() ) :?>
                        <?php the_excerpt(); ?>
                    <?php endif; ?>
                    <p class="singleproduct__price">
                        <?php wc_get_template_part( 'loop/price'); ?>
                    </p>
                    <?php if ($catdescr=term_description(end($cats))) : ?>
                        <?= $catdescr; ?>
                    <?php endif; ?>
                    <?php wc_get_template_part( 'product-attributes' ); ?>

                </div>
                <?php echo wc_get_stock_html( $product ); // WPCS: XSS ok. ?>
            </div>
            <div class="scprhead__content__two">
                <div class="singleproduct__headeractions" data-magellan>
                    <a href="#buycallout" class="button accent expanded"><?= __('Vásárlás és rendelés', 'marrakesh'); ?></a>
                    <?php echo do_shortcode('[yith_wcwl_add_to_wishlist tpye="fullbutton"]'); ?>
                </div>
            </div>
        </div>
    </header>

    <div class="scprconto">
        <div class="scprconto__one">
            <?php wc_get_template_part( 'product-details' ); ?>
        </div>
        <div class="scprconto__two">
            <div class="wrap">
                <?php if ($datafromprod['_isboxed']=='yes') : ?>
                    <?php get_template_part('templates/calculator'); ?>
                    <?php else : ?>
                    <?php do_action( 'woocommerce_single_product_summary' ); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php wc_get_template_part( 'related-products' ); ?>;


    <?php do_action( 'woocommerce_after_single_product' ); ?>
    <?php get_template_part('templates/photoswipedom'); ?>
    <?php get_template_part('templates/requestmodal'); ?>
