<?php
/**
 * Add to wishlist template
 *
 * @author YITH
 * @package YITH\Wishlist\Templates\AddToWishlist
 * @version 3.0.0
 */

/**
 * Template variables:
 *
 * @var $wishlist_url              string Url to wishlist page
 * @var $exists                    bool Whether current product is already in wishlist
 * @var $show_exists               bool Whether to show already in wishlist link on multi wishlist
 * @var $show_count                bool Whether to show count of times item was added to wishlist
 * @var $product_id                int Current product id
 * @var $product_type              string Current product type
 * @var $label                     string Button label
 * @var $browse_wishlist_text      string Browse wishlist text
 * @var $already_in_wishslist_text string Already in wishlist text
 * @var $product_added_text        string Product added text
 * @var $icon                      string Icon for Add to Wishlist button
 * @var $link_classes              string Classed for Add to Wishlist button
 * @var $available_multi_wishlist  bool Whether add to wishlist is available or not
 * @var $disable_wishlist          bool Whether wishlist is disabled or not
 * @var $template_part             string Template part
 * @var $container_classes         string Container classes
 * @var $fragment_options          array Array of data to send through ajax calls
 * @var $ajax_loading              bool Whether ajax loading is enabled or not
 * @var $var                       array Array of available template variables
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly

global $product;
?>

<div class="yith-wcwl-add-button">

    <?php if (! YITH_WCWL()->is_product_in_wishlist( $product_id ) ){
        $add=true;
    } else {
        $add=false;
    }
    ?>

    <?php
        $target = get_permalink();
        if (!is_singular('product')) {
            global $wp;
            $target = home_url( add_query_arg( array(), $wp->request ) );
        }
    ?>
    <a
        href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'add_to_wishlist', $product_id, $target ), 'add_to_wishlist' ) ); ?>"
        class="button button--yithwcwladd"
        data-product-id="<?= $product_id; ?>"
        data-tooltip title="<?= __('Hozzáadás a személyes listához') ?>"
        rel="nofollow"
        style="<?= $add?'':'display:none'; ?>"
    >
        <svg class="icon"><use xlink:href="#icon-star-outline"></use></svg>
    </a>
    <a
            href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'remove_from_wishlist', $product_id, $target ), 'remove_from_wishlist' ) ); ?>"
            class="button button--yithwcwlremove"
            data-product-id="<?php echo esc_attr( $product_id ); ?>"
            data-tooltip title="<?= __('Eltávolítás a személyes listából') ?>"
            rel="nofollow"
            style="<?= $add?'display:none':''; ?>"
    >
        <svg class="icon"><use xlink:href="#icon-star-checked"></use></svg>
    </a>

</div>
