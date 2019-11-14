<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

//get_header( 'shop' );
?>

<?php
    if ( is_shop()) {
        $theterm = get_term_by('id', 39, 'product_cat' );
        $ctax = get_taxonomy($theterm->taxonomy);
        $theterm->name = __('Teljes kínálat','marrakesh');
        $ctaxname = __('Teljes kínálat','marrakesh');
        $reltaxes = get_terms( array(
            'taxonomy' => $ctax->name,
            'parent' => 0,
        ) );
        $mastheadbg = get_field('mhbg', 'option');

    } else {
        $theterm = get_queried_object();
        $ctax = get_taxonomy($theterm->taxonomy);
        $ctaxname = $ctax->labels->singular_name;
        $reltaxes = get_terms( array(
            'taxonomy' => $ctax->name,
            'exclude' => array($theterm->term_id),
            'parent' => 0,
        ) );

        if ( !( $mastheadbg = get_field('masthead-bg', $theterm, true) ) )  {
            if ( !( $mastheadbg = get_field('thumbnail', $theterm, true) ) )  {
                $mastheadbg = get_field('mhbg', 'option');
            }
        };

    }
    // var_dump($theterm);
?>

<div class="masthead">
    <div class="grid-container">
        <div class="grid-x grid-margin-x align-right">
            <?php if ($archthumb = get_field('template', $theterm) ) : ?>
            <div class="cell small-3 xlarge-2">
                <figure class="woocommerce-products-header__thumb">
                    <?php echo wp_get_attachment_image( $archthumb['ID'], 'medium' ); ?>
                </figure>
            </div>
            <div class="cell small-9 tablet-9 xlarge-10">
                <?php else: ?>
                <div class="cell tablet-9 xlarge-10">
                    <?php endif;  ?>

                    <header class="woocommerce-products-header">
                        <?php //do_action( 'woocommerce_before_page_title' ); ?>
                        <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
                        <select class="taxchooser" name="taxchooser" id="taxchooser"
                            onChange="window.location.href=this.value;">
                            <option value="<?= get_term_link( $theterm->term_id) ?>"><?= $theterm->name ?></option>
                            <?php foreach( $reltaxes as $reltax ): ?>
                            <option value="<?= get_term_link( $reltax->term_id) ?>"><?= $reltax->name ?></option>
                            <?php endforeach; ?>
                            <option value="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">
                                <?= __('Teljes kínálat', 'marrakesh') ?></option>
                        </select>
                        <a class="js-taxchooserstart"><?= $ctaxname ?> &#9662;</a>

                        <h1 class="woocommerce-products-header__title page-title">
                            <?php woocommerce_page_title(); ?>
                            <?php
                            $termdecr=wp_strip_all_tags(term_description());
                            if ($termdecr!=='') :
                        ?>
                            <span class="page-title__tip" data-tooltip tabindex="1" title='<?= $termdecr; ?>'>
                                <svg class="icon">
                                    <use xlink:href="#icon-info-outline"></use>
                                </svg>
                            </span>
                            <?php endif; ?>
                        </h1>
                        <p class="woocommerce-products-header__count"><?php woocommerce_result_count() ?></p>
                        <?php endif; ?>

                        <?php
                        /**
                         * Hook: woocommerce_archive_description.
                         *
                         * @hooked woocommerce_taxonomy_archive_description - 10
                         * @hooked woocommerce_product_archive_description - 10
                         */
                        //do_action( 'woocommerce_archive_description' );
                    ?>
                    </header>
                </div>
            </div>
        </div>

        <figure class="masthead__bg">
            <?php echo wp_get_attachment_image( $mastheadbg['ID'], 'xlarge' ); ?>
        </figure>

    </div>


    <?php
    /**
     * Hook: woocommerce_before_main_content.
     *
     * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
     * @hooked woocommerce_breadcrumb - 20
     * @hooked WC_Structured_Data::generate_website_data() - 30
     */
    do_action( 'woocommerce_before_main_content' );

?>
    <div class="ps--xlight ps--bordered ">
        <div class="grid-container">
            <div class="grid-x grid-margin-x align-right">
                <div class="cell tablet-9 xlarge-10">
                    <section class="pratopstatus">
                        <?php $availability_filter = isset( $_GET['filter_availability'] ) ? wc_clean( wp_unslash( $_GET['filter_availability'] ) ) : array(); ?>
                        <aside class="stock-filter">
                            <div class="switch switch--stock small">
                                <input class="switch-input" id="instockyesno" type="checkbox" name="instockyesno"
                                    <?= $availability_filter ? 'checked' : '' ?>>
                                <label class="switch-paddle" for="instockyesno">
                                    <span class="show-for-sr">Raktárról azonnal</span>
                                    <span class="switch-active" aria-hidden="true">RAKTÁRRÓL AZONNAL</span>
                                    <span class="switch-inactive" aria-hidden="true">RAKTÁRRÓL AZONNAL</span>
                                </label>
                            </div>
                        </aside>
                        <?php
                                the_widget( 'WC_Widget_Layered_Nav_Filters', array(
                                    'title' => __('Bekapcsolt szűrők', 'marrakesh')
                                    ),
                                    array(
                                        'before_widget' => '<section class="pratopstatus__filters %1$s">',
                                        'after_widget'  => '</section>',
                                        'before_title'  => '<h3>',
                                        'after_title'   => '</h3>'
                                    )
                                );
                        ?>

                    </section>
                </div>
            </div>
        </div>
    </div>
    <div class="grid-container ps ps--narrow">
        <div class="grid-x grid-margin-x">
            <div class="cell show-for-tablet tablet-3 xlarge-2" data-sticky-container>
                <div class="prarchive__sidebar" class="sticky" data-margin-top="2" data-sticky
                    data-anchor="prarchive__main">
                    <!-- <p><?php woocommerce_result_count() ?></p> -->
                    <?php
                    $wargs = array(
                        'before_widget' => '<section class="cell widget widget--sidebar %1$s">',
                        'after_widget'  => '</section>',
                        'before_title'  => '<h3 class="widget__title">',
                        'after_title'   => '</h3>'
                    );
                ?>
                    <aside id="sidebar--wcfilters" class="sidebar sidebar--wcfilters grid-x grid-margin-x">
                        <?php /*
                                the_widget( 'WC_Widget_Status_Filter', array(

                                ), $wargs );
                        */ ?>
                        <?php /*
                                the_widget( 'WC_Widget_Layered_Nav_Filters', array(
                                    'title' => __('Bekapcsolt szűrők', 'marrakesh')
                                ), $wargs );
                        */?>

                        <?php
                            if (!is_tax('pa_color')) {
                                the_widget( 'WC_Widget_Layered_Nav', array(
                                    'title' => __('Színek szerint', 'marrakesh'),
                                    'attribute' => 'color',
                                    'query_type' => 'or',

                                ), $wargs );
                            }

                        ?>
                        <?php
                            if (!is_tax('pa_design') && !is_tax('pa_style')) {
                                the_widget( 'WC_Widget_Layered_Nav', array(
                                    'title' => __('Lapok stílusa', 'marrakesh'),
                                    'attribute' => 'style',
                                    'query_type' => 'or',

                                ), $wargs );
                            }
                        ?>

                        <?php
                                // the_widget( 'WC_Widget_Product_Categories', array(
                                //     title => 'Product categories',
                                //     dropdown => 1,
                                //     count => 1,
                                //     hide_empty => 1,
                                //     orderby => 'count',
                                // ), $wargs );
                        ?>
                        <?php //dynamic_sidebar('sidebar-primary'); ?>
                        <?php
                        /**
                         * Hook: woocommerce_sidebar.
                         *
                         * @hooked woocommerce_get_sidebar - 10
                         */
                        do_action( 'woocommerce_sidebar' );
                    ?>
                    </aside>
                </div>
            </div>
            <div class="cell tablet-9 xlarge-10">
                <div id="prarchive__main" class="prarchive__main">
                    <?php
                        if ( woocommerce_product_loop() ) {

                            /**
                             * Hook: woocommerce_before_shop_loop.
                             *
                             * @hooked woocommerce_output_all_notices - 10
                             * @hooked woocommerce_result_count - 20
                             * @hooked woocommerce_catalog_ordering - 30
                             */
                            do_action( 'woocommerce_before_shop_loop' );

                            woocommerce_product_loop_start();

                            if ( wc_get_loop_prop( 'total' ) ) {
                                while ( have_posts() ) {
                                    the_post();

                                    /**
                                     * Hook: woocommerce_shop_loop.
                                     *
                                     * @hooked WC_Structured_Data::generate_product_data() - 10
                                     */
                                    do_action( 'woocommerce_shop_loop' );

                                    wc_get_template_part( 'content', 'product' );
                                }
                            }

                            woocommerce_product_loop_end();

                            /**
                             * Hook: woocommerce_after_shop_loop.
                             *
                             * @hooked woocommerce_pagination - 10
                             */
                            do_action( 'woocommerce_after_shop_loop' );
                        } else {
                            /**
                             * Hook: woocommerce_no_products_found.
                             *
                             * @hooked wc_no_products_found - 10
                             */
                            do_action( 'woocommerce_no_products_found' );
                        }
                    ?>
                    <?php  if ( $gallery = get_field('gallery', get_field('linkedgallery', $theterm)) ) : ?>
                    <div class="ps aps--narrow ps--nobottom ">
                        <div class="psgallery thumbswipe thumbswipe--medium thumbswipe--noleftpad">
                            <?php foreach ( $gallery as $attachment_id ) : ?>
                            <figure class="thumbswipe__item psgallery__item" itemprop="associatedMedia" itemscope
                                itemtype="http://schema.org/ImageObject">
                                <a href="<?php $targimg = wp_get_attachment_image_src($attachment_id,'full'); echo $targimg[0];?>"
                                    data-size="<?= $targimg['1'].'x'.$targimg['2']; ?>">
                                    <?php echo wp_get_attachment_image( $attachment_id, 'medium' ); ?>
                                </a>
                            </figure>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php get_template_part('templates/photoswipedom'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    /**
     * Hook: woocommerce_after_main_content.
     *
     * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
     */
    do_action( 'woocommerce_after_main_content' );
?>



    <div data-sticky-container class="hide-for-tablet">
        <div class="sticky sticky--toggler" data-sticky data-anchor="prarchive__main" data-sticky-on="small"
            data-stick-to="bottom" data-margin-bottom="0">
            <div class="grid-container">
                <button class="filtertoggler button small expanded hollow"
                    data-toggle="prarchive__filtermodal"><?php _e('Color and style filters&hellip;','marrakesh'); //woocommerce_result_count() ?></button>
            </div>
        </div>
    </div>
    <div id="prarchive__filtermodal" class="reveal prarchive__filtermodal" data-reveal
        data-animation-in="scale-in-down fast" data-animation-out="scale-out-up fast">
        <div class="grid-container">
            <aside id="filtermodal__wcfilters"
                class="filtermodal__wcfilters grid-x grid-margin-x small-up-2 medium-up-3 aalign-center">

                <?php
                if (!is_tax('pa_color')) {
                    the_widget( 'WC_Widget_Layered_Nav', array(
                        'title' => 'Filter by Color',
                        'attribute' => 'color',
                        'query_type' => 'or',

                    ), $wargs );
                }

            ?>
                <?php
                if (!is_tax('pa_design') && !is_tax('pa_style')) {
                    the_widget( 'WC_Widget_Layered_Nav', array(
                        'title' => 'Filter by Style',
                        'attribute' => 'style',
                        'query_type' => 'or',

                    ), $wargs );
                }
            ?>
                <?php
              the_widget('WC_Widget_Status_Filter', array(), $wargs );
            ?>
            </aside>
            <button class="filtermodal__close" data-close aria-label="Close modal" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    <?php
//get_footer( 'shop' );
