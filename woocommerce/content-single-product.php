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

                            <figure class="singleproduct__prodthumb">
                                <?php echo wp_get_attachment_image( get_field('singleimg',false,false), 'tiny' ); ?>
                            </figure>





                            <h1 class="singleproduct__title entry-title"><?php the_title(); ?></h1>
                            <?php if ( $product->is_on_sale() ) : ?>
                            <?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product ); ?>
                            <?php endif;?>
                            <?php echo wc_get_stock_html( $product ); // WPCS: XSS ok. ?>

                            <p class="singleproduct__price price"><?php echo $product->get_price_html(); ?></p>

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




                        </header>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="aps--xlight ps--bordered">
        <div class="psgallery thumbswipe">
            <figure class="thumbswipe__item psgallery__item" itemprop="associatedMedia" itemscope
                itemtype="http://schema.org/ImageObject">
                <a href="<?php $targimg = wp_get_attachment_image_src( get_field('singleimg',false,false),'full'); echo $targimg[0];?>"
                    data-size="<?= $targimg['1'].'x'.$targimg['2']; ?>">
                    <?php echo wp_get_attachment_image( get_field('singleimg',false,false), $gallery_thumbnail ); ?>
                </a>
            </figure>
            <figure class="thumbswipe__item psgallery__item" itemprop="associatedMedia" itemscope
                itemtype="http://schema.org/ImageObject">
                <a href="<?php $targimg = wp_get_attachment_image_src(get_post_thumbnail_id(),'full'); echo $targimg[0];?>"
                    data-size="<?= $targimg['1'].'x'.$targimg['2']; ?>">
                    <?php echo woocommerce_get_product_thumbnail($gallery_thumbnail); ?>
                </a>
            </figure>
            <figure class="thumbswipe__item psgallery__item" itemprop="associatedMedia" itemscope
                itemtype="http://schema.org/ImageObject">
                <a href="<?php $targimg = wp_get_attachment_image_src(get_field('wallimg',false,false),'full'); echo $targimg[0];?>"
                    data-size="<?= $targimg['1'].'x'.$targimg['2']; ?>">
                    <?php echo wp_get_attachment_image( get_field('wallimg',false,false), $gallery_thumbnail ); ?>
                </a>
            </figure>
            <?php
                $attachment_ids = $product->get_gallery_image_ids();
                $gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );

                if ( $attachment_ids && $product->get_image_id() ) {
                    foreach ( $attachment_ids as $attachment_id ) : ?>
                        <figure class="thumbswipe__item psgallery__item" itemprop="associatedMedia" itemscope
                            itemtype="http://schema.org/ImageObject">
                            <a href="<?php $targimg = wp_get_attachment_image_src($attachment_id,'full'); echo $targimg[0];?>"
                                data-size="<?= $targimg['1'].'x'.$targimg['2']; ?>">
                                <?php echo wp_get_attachment_image( $attachment_id, $gallery_thumbnail ); ?>
                            </a>
                        </figure>
                    <?php endforeach;
                }

            ?>
        </div>
    </div>

    <div class="ps aps--xlight ps--bordered">
        <div class="grid-container">
            <div class="grid-x grid-margin-x align-justify">

                <div class="cell large-8 xxlarge-7">
                    <!-- <h3><?php _e('Product information', 'marrakesh');?></h3> -->
                    <ul class="tabs tabs--singleproduct" data-active-collapse="true" data-deep-link="true"
                        data-update-history="true" data-deep-link-smudge="true" data-deep-link-smudge-delay="500"
                        data-tabs id="productinfotabs">
                        <li class="tabs-title is-active">
                            <a href="#prodinfopanel" aria-selected="true">
                                <?php esc_html_e( 'Info & Description', 'marrakesh' ); ?>
                            </a>
                        </li>
                        <li class="tabs-title">
                            <a href="#techinfopanel">
                                <?php esc_html_e( 'Technical Parameters', 'marrakesh' ) ?>
                            </a>
                        </li>
                        <li class="tabs-title">
                            <a href="#shipmentpanel">
                                <?php esc_html_e( 'Shipping & Buying', 'marrakesh' ); ?>
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
                            <h3><?php _e('Product information', 'marrakesh');?></h3>
                                <?php if ( $short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ) : ?>
                                <div
                                    class="lead singleproduct__shortdesc woocommerce-product-details__short-description">
                                    <?php echo $short_description; // WPCS: XSS ok. ?>
                                </div>
                                <?php endif; ?>
                                <?php the_content(); ?>
                                <!-- <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fugiat nobis cumque
                                    adipisci quasi dicta dolore, quas quam est sapiente eligendi nemo repellendus quis
                                    natus impedit quos necessitatibus debitis officia officiis!</p> -->
                                <?php
                                $catids = $product->get_category_ids();
                                $catatts = array();
                                foreach ($catids as $categoryid) {
                                    $cat=get_term_by('id', $categoryid, 'product_cat' );
                                    $catatts = array_merge($catatts, get_field('attributes', 'product_cat_' . $categoryid));
                                    //print_r(get_field('attributes', 'product_cat_' . $categoryid));
                                    //echo '<h4>'.$cat->name.'</h4>';
                                    echo term_description( $categoryid, 'product_cat' );
                                }
                            ?>


                                <div class="singleproduct__meta meta">
                                    <?php do_action( 'woocommerce_product_meta_start' ); ?>
                                    <?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
                                    <span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?> <span
                                            class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span></span>
                                    <?php endif; ?>
                                    <?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( '', '', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
                                    <?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
                                    <?php do_action( 'woocommerce_product_meta_end' ); ?>
                                </div>
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
                        </div>
                        <div class="tabs-panel" id="techinfopanel">
                            <h3><?php _e('Technical information', 'marrakesh');?></h3>
                            <div class="lead">
                                <p>Consectetur adipisicing elit. Nostrum facilis fuga repellat perspiciatis minus hic, reiciendis ad distinctio maxime dicta optio. Iste tenetur illo id explicabo enim nisi voluptas quibusdam!</p>
                            </div>
                            <!-- <figure class="singleproduct__prodimage">
                                <?php echo woocommerce_get_product_thumbnail('medium_large'); ?>
                                <?php echo wp_get_attachment_image( get_field('singleimg',false,false), 'tiny' ); ?>
                            </figure> -->
                            <dl class="singleproduct__catattributes">
                                <?php
                            //var_dump($catatts);
                            foreach ($catatts as $pairs) : ?>
                                <dt><?= $pairs['label'] ?></dt>
                                <dd><?= $pairs['value']?></dd>
                                <?php endforeach; ?>
                            </dl>
                        </div>
                        <div class="tabs-panel" id="shipmentpanel">
                            <h3><?php _e('Shipping information', 'marrakesh');?></h3>
                            <div class="lead">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt odit cumque
                                    molestiae necessitatibus asperiores accusamus voluptas non. Reiciendis mollitia
                                    repudiandae commodi molestias, officiis libero error optio. Nesciunt omnis veritatis
                                    ipsa?</p>
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero mollitia sed deleniti
                                blanditiis, possimus quos ea ducimus est. Nulla excepturi alias ipsum officiis doloribus
                                omnis sint maiores ratione accusamus iusto!</p>
                        </div>
                        <div class="tabs-panel" id="installpanel">
                            <h3><?php _e('Application & Installation', 'marrakesh');?></h3>
                            <div class="lead">
                                <p>Amet consectetur adipisicing elit. Nesciunt odit cumque
                                    molestiae necessitatibus asperiores accusamus voluptas non. Reiciendis mollitia
                                    repudiandae commodi molestias, officiis libero error optio.</p>
                            </div>
                            <p>Aamet consectetur adipisicing elit, rem ipsum dolor sit amet consectetur adipisicing
                                elit. Similique!</p>
                            <p>Lorem ipsum dolor sit. Vero mollitia sed deleniti
                                blanditiis, possimus quos ea ducimus est. Nulla excepturi alias ipsum officiis doloribus
                                omnis sint maiores ratione accusamus iusto!</p>
                            <a href="#" class="button small">Go to installation manual</a>


                        </div>
                    </div>


                </div>


                <!-- <div class="cell tablet-6 large-4">
                    <div class="callout">
                        <h3>Add to cart section</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe!</p>
                        <select name="" id=""></select>
                        <a href="#" class="button">Add to Cart</a>
                    </div>
                </div> -->


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
    <?php get_template_part('templates/photoswipedom');
