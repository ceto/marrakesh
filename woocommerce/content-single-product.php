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

global $product, $post, $datafromcat;
$attributes = $product->get_attributes();

$designterm = get_term_by('id', $attributes['pa_design']['options'][0],'pa_design');
$linkeddesigngallery = get_field('linkedgallery', $designterm);
//var_dump($linkeddesigngallery);
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
    $catids = $product->get_category_ids();
    $datafromcat = array(
        'isboxed' => false,
        'weight' => false,
        'length' => false,
        'width' => false,
        'height' => false,
        'pcs_per_sqm' => false,
        'pcs_per_box' => false,
        'size_per_box' => false,
        'productinfo' => false,
        'order' => false,
        'application' => false,
    );
    foreach ($catids as $categoryid) {
        $datafromcat['isboxed'] = $datafromcat['isboxed'] || get_field('isboxed', 'product_cat_' . $categoryid);

        if ($hvar = get_field('weight', 'product_cat_' . $categoryid)) {
            $datafromcat['weight'] = $hvar;
        }
        if ($hvar = get_field('length', 'product_cat_' . $categoryid)) {
            $datafromcat['length'] = $hvar;
        }
        if ($hvar = get_field('width', 'product_cat_' . $categoryid)) {
            $datafromcat['width'] = $hvar;
        }
        if ($hvar = get_field('height', 'product_cat_' . $categoryid)) {
            $datafromcat['height'] = $hvar;
        }
        if ($hvar = get_field('pcs_per_sqm', 'product_cat_' . $categoryid)) {
            $datafromcat['pcs_per_sqm'] = $hvar;
        }
        if ($hvar = get_field('pcs_per_box', 'product_cat_' . $categoryid)) {
            $datafromcat['pcs_per_box'] = $hvar;
        }
        if ($hvar = get_field('size_per_box', 'product_cat_' . $categoryid)) {
            $datafromcat['size_per_box'] = $hvar;
        }
        if ($hvar = get_field('productinfo', 'product_cat_' . $categoryid)) {
            $datafromcat['productinfo'] = $hvar;
        }
        if ($hvar = get_field('order', 'product_cat_' . $categoryid)) {
            $datafromcat['order'] = $hvar;
        }
        if ($hvar = get_field('application', 'product_cat_' . $categoryid)) {
            $datafromcat['application'] = $hvar;
        }

        //$cat=get_term_by('id', $categoryid, 'product_cat' );
        //echo '<h4>'.$cat->name.'</h4>';
        //print_r(get_field('productinfo', 'product_cat_' . $categoryid));
        //echo term_description( $categoryid, 'product_cat' );
    }
    //echo '<hr>';
    //var_dump($datafromcat);

?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('singleproduct'); ?>>
    <div class="singleproduct__top">
        <aside class="singleproduct__top__bg">
            <?php echo wp_get_attachment_image( get_field('wallimg',false,false), 'full' ); ?>
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


                            <!-- <figure class="singleproduct__prodimage">
                                <?php echo woocommerce_get_product_thumbnail('medium_large'); ?>
                                <?php echo wp_get_attachment_image( get_field('singleimg',false,false), 'tiny' ); ?>
                            </figure> -->




                            <h1 class="singleproduct__title entry-title"><?php the_title(); ?></h1>
                            <?php if ( $product->is_on_sale() ) : ?>
                            <?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product ); ?>
                            <?php endif;?>
                            <?php echo wc_get_stock_html( $product ); // WPCS: XSS ok. ?>

                            <!-- <p class="singleproduct__price price"><?php echo $product->get_price_html(); ?></p> -->

                        </header>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="ps--xlight ps--bordered singleproduct__images">
        <div class="psgallery thumbswipe">
            <figure class="thumbswipe__item psgallery__item" itemprop="associatedMedia" itemscope
                itemtype="http://schema.org/ImageObject">
                <a href="<?php $targimg = wp_get_attachment_image_src( get_field('singleimg',false,false),'full'); echo $targimg[0];?>"
                    data-size="<?= $targimg['1'].'x'.$targimg['2']; ?>">
                    <?php echo wp_get_attachment_image( get_field('singleimg',false,false), 'medium' ); ?>
                </a>
            </figure>
            <figure class="thumbswipe__item psgallery__item" itemprop="associatedMedia" itemscope
                itemtype="http://schema.org/ImageObject">
                <a href="<?php $targimg = wp_get_attachment_image_src(get_post_thumbnail_id(),'full'); echo $targimg[0];?>"
                    data-size="<?= $targimg['1'].'x'.$targimg['2']; ?>">
                    <?php echo woocommerce_get_product_thumbnail('medium'); ?>
                </a>
            </figure>
            <figure class="thumbswipe__item psgallery__item" itemprop="associatedMedia" itemscope
                itemtype="http://schema.org/ImageObject">
                <a href="<?php $targimg = wp_get_attachment_image_src(get_field('wallimg',false,false),'full'); echo $targimg[0];?>"
                    data-size="<?= $targimg['1'].'x'.$targimg['2']; ?>">
                    <?php echo wp_get_attachment_image( get_field('wallimg',false,false), 'medium' ); ?>
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

            <?php if ( $gallery = get_field('gallery', $linkeddesigngallery) ) : ?>
            <?php foreach ( $gallery as $attachment_id ) : ?>
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

    <div class="ps aps--xlight aps--bordered">
        <div class="grid-container">
            <div class="grid-x grid-margin-x align-justify">

                <div class="cell tablet-6 large-5 xxlarge-4 large-order-2">
                    <div class="callout singleproduct__callout">

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
                            <?php echo wp_get_attachment_image( get_field('singleimg',false,false), 'tiny' ); ?>
                        </figure>

                        <h1 class="singleproduct__title entry-title"><?php the_title(); ?></h1>
                        <?php if ( $product->is_on_sale() ) : ?>
                        <?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product ); ?>
                        <?php endif;?>
                        <?php echo wc_get_stock_html( $product ); // WPCS: XSS ok. ?>

                        <p class="singleproduct__price price"><?php echo $product->get_price_html(); ?></p>

                        <dl class="singleproduct__catattributes">
                            <dt><?= __('Single Weight','marrakesh'); ?></dt>
                            <dd><?= $datafromcat['weight']; ?>&nbsp;kg</dd>
                            <dt><?= __('Single Size','marrakesh'); ?></dt>
                            <dd><?= $datafromcat['width']; ?>&nbsp;&times;&nbsp;<?= $datafromcat['length']; ?>&nbsp;&times;&nbsp;<?= $datafromcat['height']; ?>&nbsp;cm</sup>
                            </dd>
                            <?php if ($datafromcat['isboxed']) : ?>
                            <dt><?= __('Can be bought','marrakesh'); ?></dt>
                            <dd><?= __('in box','marrakesh'); ?></dd>
                            <dt><?= __('Tiles needed for 1m<sup>2</sup>','marrakesh'); ?></dt>
                            <dd><?= $datafromcat['pcs_per_sqm']; ?>&nbsp;tiles/m<sup>2</sup></dd>
                            <dt><?= __('Tiles per Box','marrakesh'); ?></dt>
                            <dd><?= $datafromcat['pcs_per_box']; ?>&nbsp;tiles/box</dd>
                            <dt><?= __('Cover Size per Box','marrakesh'); ?></dt>
                            <dd><?= $datafromcat['size_per_box']; ?>&nbsp;m<sup>2</sup>/box</dd>
                            <?php else: ?>
                            <dt><?= __('Can be bought','marrakesh'); ?></dt>
                            <dd><?= __('by pieces','marrakesh'); ?></dd>
                            <?php endif; ?>
                        </dl>
                        <dl class="singleproduct__attributes">
                            <dt><?php _e('Product Category', 'marrakesh');?></dt>
                            <dd><?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( '', '', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
                            </dd>
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
                            <dd class="product_weight">
                                <?php echo esc_html( wc_format_weight( $product->get_weight() ) ); ?></dd>
                            <?php endif; ?>

                            <?php if ( /*$display_dimensions &&*/ $product->has_dimensions() ) : ?>
                            <dt><?php _e( 'Dimensions', 'woocommerce' ) ?></dt>
                            <dd class="product_dimensions">
                                <?php echo esc_html( wc_format_dimensions( $product->get_dimensions( false ) ) ); ?>
                            </dd>
                            <?php endif; ?>
                        </dl>
                    </div>
                    <!-- <hr> -->
                    <div class="callout singleproduct__callout">
                        <h5><?php _e('Buy Online - Set up Your Order', 'marrakesh'); ?></h5>
                        <?php
                            /**
                            * Hook: woocommerce_single_product_summary.
                            *
                            * @hooked woocommerce_template_single_title - 5
                            * @hooked woocommerce_template_single_rating - 10
                            * @hooked woocommerce_template_single_price - 10
                            * @hooked woocommerce_template_single_excerpt - 20
                            * @hooked woocommerce_template_single_add_to_cart - 30
                            * @hooked woocommerce_template_single_meta - 40
                            * @hooked woocommerce_template_single_sharing - 50
                            * @hooked WC_Structured_Data::generate_product_data() - 60
                            */
                            do_action( 'woocommerce_single_product_summary' );
                        ?>
                    </div>
                    <div class="singleproduct__meta meta">
                        <?php do_action( 'woocommerce_product_meta_start' ); ?>
                        <?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
                        <span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?> <span
                                class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span></span>
                        <?php endif; ?>
                        <?php //echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( '', '', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
                        <?php //echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
                        <?php do_action( 'woocommerce_product_meta_end' ); ?>
                    </div>
                </div>

                <div class="cell large-7 xxlarge-6 large-order-1">
                    <!-- <h3><?php _e('Product Information', 'marrakesh');?></h3> -->
                    <ul class="tabs tabs--singleproduct" data-active-collapse="true" data-deep-link="true"
                        data-update-history="true" data-deep-link-smudge="true" data-deep-link-smudge-delay="500"
                        data-tabs id="productinfotabs">
                        <li class="tabs-title is-active">
                            <a href="#prodinfopanel" aria-selected="true">
                                <?php esc_html_e( 'Info & Description', 'marrakesh' ); ?>
                            </a>
                        </li>
                        <li class="tabs-title">
                            <a href="#obspanel">
                                <?php esc_html_e( 'Order & Buying', 'marrakesh' ); ?>
                            </a>
                        </li>
                        <li class="tabs-title">
                            <a href="#installpanel">
                                <?php esc_html_e( 'Installation', 'marrakesh' ) ?>
                            </a>
                        </li>
                    </ul>
                    <div class="tabs-content" data-tabs-content="productinfotabs">
                        <div class="tabs-panel is-active" id="prodinfopanel">
                            <div class="singleproduct__details">
                                <h3><?php _e('Product Information', 'marrakesh');?></h3>
                                <?php /* if ( $short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ) : ?>
                                <div
                                    class="lead singleproduct__shortdesc woocommerce-product-details__short-description">
                                    <?php echo $short_description; // WPCS: XSS ok. ?>
                                </div>
                                <?php endif; */?>
                                <?php the_content(); ?>
                                <div
                                    class="lead singleproduct__shortdesc woocommerce-product-details__short-description">
                                    <?php echo apply_filters('the_excerpt', get_the_excerpt($datafromcat['productinfo']) ); ?>
                                </div>
                                <?php echo apply_filters('the_content', get_post_field('post_content', $datafromcat['productinfo'])); ?>
                            </div>
                        </div>
                        <div class="tabs-panel" id="obspanel">
                            <h3><?php _e('How to Order', 'marrakesh');?></h3>
                            <div class="lead">
                                <?php echo apply_filters('the_excerpt', get_the_excerpt($datafromcat['order']) ); ?>
                            </div>
                            <?php echo apply_filters('the_content', get_post_field('post_content', $datafromcat['order'])); ?>
                        </div>
                        <div class="tabs-panel" id="installpanel">
                            <h3><?php _e('Installation &amp; Application Guide', 'marrakesh');?></h3>
                            <div class="lead">
                                <?php echo apply_filters('the_excerpt', get_the_excerpt($datafromcat['application']) ); ?>
                            </div>
                            <?php echo apply_filters('the_content', get_post_field('post_content', $datafromcat['application'])); ?>
                        </div>
                    </div>


                </div>





            </div>
        </div>
    </div>



    <div class="ps ps--xlight ps--bordered">

        <div class="grid-container">
            <div class="grid-x grid-margin-x">
                <div class="cell">
                    <?php
                    $upsells = wc_products_array_orderby( array_filter( array_map( 'wc_get_product', $product->get_upsell_ids() ), 'wc_products_array_filter_visible' ), 'rand', 'desc');
                    $upsellproducts = $upsells;
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
                    <h3 class="atext-center"><?php esc_html_e( 'Products related', 'marrakesh' ); ?></h3>
                    <ul class="tabs tabs--singleproduct" data-active-collapse="true" data-deep-link="true"
                        data-update-history="true" data-deep-link-smudge="true" data-deep-link-smudge-delay="500"
                        data-tabs id="producttabs">
                        <?php if ( $relproducts ) : ?><li class="tabs-title is-active"><a href="#similarpanel"
                                aria-selected="true"><?php esc_html_e( 'Similar Products', 'marrakesh' ); ?></a></li>
                        <?php endif;  ?>
                        <?php if ( $reldesignproducts  ) : ?><li class="tabs-title"><a
                                href="#colvarpanel"><?php esc_html_e( 'Color Variations', 'marrakesh' ); ?></a></li>
                        <?php endif;  ?>
                        <?php if ( $upsellproducts  ) : ?><li class="tabs-title"><a
                                href="#upsellpanel"><?php esc_html_e( 'You may also like&hellip;', 'marrakesh' ) ?></a>
                        </li><?php endif;  ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="tabs-content" data-tabs-content="producttabs">

            <?php if ( $relproducts ) : ?>
            <div class="tabs-panel is-active" id="similarpanel">
                <section class="related products">
                    <ul class="prodswipe">
                        <?php foreach ( $relproducts as $related_product ) : ?>
                        <?php
                            $post_object = get_post( $related_product->get_id() );
                            setup_postdata( $GLOBALS['post'] =& $post_object );
                            wc_get_template_part( 'content-widget-product' ); ?>
                        <?php endforeach; wp_reset_postdata(); ?>
                    </ul>
                </section>
            </div>
            <?php endif;  ?>

            <?php if ( $reldesignproducts ) : ?>
            <div class="tabs-panel" id="colvarpanel">
                <section class="related products">
                    <ul class="prodswipe">
                        <?php foreach ( $reldesignproducts as $related_product ) : ?>
                        <?php
                            $post_object = get_post( $related_product->get_id() );
                            setup_postdata( $GLOBALS['post'] =& $post_object );
                            wc_get_template_part( 'content-widget-product' );
                        ?>
                        <?php endforeach; wp_reset_postdata(); ?>
                    </ul>
                </section>
            </div>
            <?php endif;  ?>


            <?php if ( $upsellproducts ) : ?>
            <div class="tabs-panel" id="upsellpanel">
                <section class="up-sells upsells products">
                    <ul class="prodswipe">
                        <?php foreach ( $upsellproducts as $upsell ) : ?>
                        <?php
                            $post_object = get_post( $upsell->get_id() );
                            setup_postdata( $GLOBALS['post'] =& $post_object );
                            wc_get_template_part( 'content-widget-product' );
                        ?>
                        <?php endforeach;  wp_reset_postdata(); ?>
                    </ul>
                </section>
            </div>
            <?php endif; ?>

        </div>
        <div class="grid-container">
            <div class="grid-x grid-margin-x">
                <div class="cell">
                    <?php
                        /**
                         * Hook: woocommerce_after_single_product_summary.
                         *
                         * @hooked woocommerce_output_product_data_tabs - 10
                         * @hooked woocommerce_upsell_display - 15
                         * @hooked woocommerce_output_related_products - 20
                         */
                        do_action( 'woocommerce_after_single_product_summary' );
                    ?>
                </div>
            </div>
        </div>


    </div>

    <?php do_action( 'woocommerce_after_single_product' ); ?>
    <?php get_template_part('templates/photoswipedom'); ?>