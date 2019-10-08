<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
?>
<?php if ( (get_post_meta($product->get_id(), '_isboxed', true )=='yes') && ($sizeperbox=get_post_meta($product->get_id(), '_sizeperbox', true )) )  : ?>
<span
    class="price"><?php echo wc_price(wc_get_price_to_display($product)/$sizeperbox, array(decimals => 0 )); ?>/m<sup>2</sup></span>
<?php elseif ( $price_html = $product->get_price_html() ) : ?>
<span class="price"><?php echo $price_html; ?></span>
<?php endif; ?>