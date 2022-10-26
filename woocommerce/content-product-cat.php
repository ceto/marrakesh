<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<li <?php wc_product_cat_class( '', $category ); ?>>
    <div class="tmplcard">
        <a class="tmplcard__fulllink" href="<?php echo get_term_link( $category ); ?>">
            <?php $origcatid = $category->term_id; ?>
            <?php if ($designthumb = get_field('covera', $category->taxonomy.'_'.$origcatid) ) : ?>
            <?= wp_get_attachment_image( $designthumb['id'], 'large', false, array('class'=>'tmplcard__thumb', 'alt'=>$category->name) ); ?>
            <?php else : ?>
            <img src="//placehold.it/768x768/cecece/333333/?text=<?= $category->name;?>"
                class="tmplcard__thumb" alt="<?= $category->name;?>">
            <?php endif; ?>
            <?php if ($coverb = get_field('coverb', $category->taxonomy.'_'.$origcatid)) : ?>
            <?= wp_get_attachment_image( $coverb['id'], 'large', false, array('class'=>'tmplcard__thumb variant', 'alt'=>$category->name) ); ?>
            <?php endif; ?>
            <h3 class="tmplcard__name"><?= $category->name;?></h3>
            <?php //    var_dump($category->taxonomy); ?>
        </a>
    </div>
</li>
