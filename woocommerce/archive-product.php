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



<div class="ps ps--black ps--narrow">
    <div class="grid-container">
        <div class="grid-x grid-margin-x align-right">
            <div class="cell tablet-9 xlarge-10">
                <header class="woocommerce-products-header">
                    <?php do_action( 'woocommerce_before_page_title' ); ?>
                    <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
                        <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
                    <?php endif; ?>

                    <?php
                        /**
                         * Hook: woocommerce_archive_description.
                         *
                         * @hooked woocommerce_taxonomy_archive_description - 10
                         * @hooked woocommerce_product_archive_description - 10
                         */
                        do_action( 'woocommerce_archive_description' );
                    ?>
                </header>
            </div>
        </div>
    </div>
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

<div class="grid-container ps ps--narrow">
    <div class="grid-x grid-margin-x">
        <div class="cell show-for-tablet tablet-3 xlarge-2" data-sticky-container>
            <div class="prarchive__sidebar" class="sticky" data-margin-top="2" data-sticky data-anchor="prarchive__main">
                <p><?php woocommerce_result_count() ?></p>
                <?php 
                    $wargs = array(
                        'before_widget' => '<section class="cell widget widget--sidebar %1$s">',
                        'after_widget'  => '</section>',
                        'before_title'  => '<h3 class="widget__title">',
                        'after_title'   => '</h3>'
                    );
                ?>
                <aside id="sidebar--wcfilters" class="sidebar sidebar--wcfilters grid-x grid-margin-x">

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
                                // the_widget( 'WC_Widget_Layered_Nav_Filters', array(
                                //     title => 'Active filters'
                                // ), $wargs );
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
        <div id="prarchive__main" class="prarchive__main cell tablet-9 xlarge-10">
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
    <div class="sticky sticky--toggler" data-sticky data-anchor="prarchive__main" data-sticky-on="small" data-stick-to="bottom" data-margin-bottom="0">
        <div class="grid-container">
                <button class="filtertoggler button small expanded hollow" data-toggle="prarchive__filtermodal"><?php woocommerce_result_count() ?></button>     
        </div>
    </div>
</div>
<div id="prarchive__filtermodal" class="reveal prarchive__filtermodal" data-reveal>
    <div class="grid-container">
        <aside id="filtermodal__wcfilters" class="filtermodal__wcfilters grid-x grid-margin-x small-up-2 medium-up-3 align-center">
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
        </aside>
    </div>
</div>
<?php
//get_footer( 'shop' );
