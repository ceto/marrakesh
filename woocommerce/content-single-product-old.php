<?php

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

    <div class="singleproduct__top <?= (get_field('dontcoverwp', $product_id)===true)?'dontcoverwp':''; ?>">
        <aside class="singleproduct__top__bg">
            <?php echo wp_get_attachment_image( get_field('wallimg', $product_id, false), 'full' ); ?>
        </aside>

        <div class="singleproduct__top__content">

            <div class="grid-container">
                <div class="grid-x grid-margin-x">
                    <div class="cell">
                        <header class="summary entry-summary singleproduct__header">

                            <?php
                                /**
                                 * Hook: woocommerce_before_single_product_summary.
                                 *
                                 * @hooked woocommerce_show_product_sale_flash - 10
                                 * @hooked woocommerce_show_product_images - 20
                                 */
                                do_action( 'woocommerce_before_single_product_summary' );
                            ?>

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

                            <div class="singleproduct__headeractions" data-magellan>
                                <a href="#buycallout" class="button accent expanded"><?= __('Vásárlás és rendelés', 'marrakesh'); ?></a>
                                <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
                            </div>

                        </header>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="aps--xlight aps--bordered singleproduct__images">
        <div class="psgallery thumbswipe">
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



    <br><br><br>
    <div class="grid-container">
        <div class="grid-x grid-margin-x align-justify">
            <div class="cell">
                <ul class="tabs tabs--prdata" data-tabs id="productinfotabs">
                    <li class="tabs-title is-active">
                        <a href="#prodinfopanel" aria-selected="true">
                            <?php esc_html_e( 'Termék információ', 'marrakesh' ); ?>
                        </a>
                    </li>
                    <li class="tabs-title">
                        <a href="#datapanel" aria-selected="true">
                            <?php esc_html_e( 'Méretek, kiszerelés', 'marrakesh' ); ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="ps ps--xlight ps--narrow ps--bordered">
        <div class="grid-container">
            <div class="grid-x grid-margin-x align-justify">
                <div class="cell large-7 xxlarge-6 large-order-1">

                    <div class="tabs-content" data-tabs-content="productinfotabs">
                        <div class="tabs-panel is-active" id="prodinfopanel">
                            <?php wc_get_template_part( 'product-details' ); ?>
                        </div>
                        <div class="tabs-panel" id="datapanel">
                            <?php wc_get_template_part( 'product-attributes' ); ?>
                        </div>
                    </div>
                </div>
                <div class="cell large-5 xxlarge-4 large-order-2">
                    <?php if ($datafromprod['_isboxed']=='yes') : ?>
                    <?php get_template_part('templates/calculator'); ?>
                    <?php else : ?>
                    <?php do_action( 'woocommerce_single_product_summary' ); ?>
                    <?php endif; ?>

                    <div class="singleproduct__meta meta">
                        <?php do_action( 'woocommerce_product_meta_start' ); ?>
                        <?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
                        <span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?> <span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span></span>
                        <?php endif; ?>
                        <?php //echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( '', '', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
                        <?php //echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
                        <?php do_action( 'woocommerce_product_meta_end' ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php wc_get_template_part( 'related-products' ); ?>;




    <?php do_action( 'woocommerce_after_single_product' ); ?>
    <?php get_template_part('templates/photoswipedom'); ?>
    <?php get_template_part('templates/requestmodal'); ?>
