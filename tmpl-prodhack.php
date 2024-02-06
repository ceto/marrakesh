<?php
/**
 * Template Name: Product Hack Page
 */
?>
<?php use Roots\Sage\Titles; ?>
<?php while (have_posts()) : the_post(); ?>
<?php get_template_part('templates/page-header'); ?>
<?php endwhile; ?>
<?php
    $page = 12;
    $productsquery = new WP_Query(array(
        // 'post_status' => 'any',
        'post_type' => array('product'),
        'posts_per_page' => 300,
        'paged' => $page
    ));
    $products = $productsquery->get_posts();
    // var_dump($products);
?>
<div class="pagewrap">
    <h2><?= $page ?>. page</h2>
    <ul >

    <?php foreach ( $products as $product ) : ?>
        <li>

        <?php
            $post_id = $product->ID;
            if ( ($sizetocount = get_post_meta($post_id, '_sizeperbox', true)) && ($pricetocount = get_post_meta($post_id, '_regular_price', true)) ) {
                update_post_meta( $post_id, '_dunitprice', $pricetocount/$sizetocount );
                echo $post_id.' updated: '. $pricetocount/$sizetocount;
            } else {
                update_post_meta( $post_id, '_dunitprice', get_post_meta($post_id, '_regular_price', true) );
                echo $post_id.' updated: with _regular_price value';
            }
        ?>
        </li>
    <?php endforeach; wp_reset_postdata(); ?>
    </ul>
</div>

