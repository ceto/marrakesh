<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
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

global $product, $datafromcat;

if ( ! $product->is_purchasable() ) {
	return;
}

//echo wc_get_stock_html( $product ); // WPCS: XSS ok.

if ( FALSE && $product->is_in_stock() ) : ?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
<form class="cart"
    action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>"
    method="post" enctype='multipart/form-data'>
    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

    <div class="quantitysqm">
        <label class="screen-reader-text" for="quantity-sqm">SQ METERS needed*</label>
        <input type="number" id="quantity-sqm" class="input-text qty text" step="1" min="1" max="" name="quantity-sqm"
            value="0.52" title="Qty Sqm" size="4" inputmode="numeric">
    </div>
    <hr>
    <?php
		do_action( 'woocommerce_before_add_to_cart_quantity' );

		woocommerce_quantity_input( array(
			'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
			'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
			'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
		) );

		do_action( 'woocommerce_after_add_to_cart_quantity' );
		?>

    <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>"
        class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

    <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>

<!-- ezt tesztelem    -->

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
<form class="order cart"
    action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>"
    enctype="multipart/form-data" method="post" novalidate="novalidate">
    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

    <section class="order-box">

        <div class="order-box__input">
            <label for="sqft">Total Square Meters needed<em>*</em></label>
            <input type="number" name="sqft" id="sqft" value="<?= $datafromcat['size_per_box'] ?>" min="4">
        </div>

        <div class="sqft-total">
            <p>Total size in full boxes: <strong><?= $datafromcat['size_per_box'] ?> </strong>m<sup>2</sup></p>
            <p class="waste-warning"><small>*Make sure to order an additional 10-15% for overage/waste</small></p>
        </div>

        <div class="strike">
            <span>or</span>
        </div>

        <div class="order-box__input">
            <label for="boxes">Number Of Boxes Needed</label>
            <input type="number" name="boxes" disabled id="boxes" value="1" min="1">
        </div>

        <?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
        <span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?> <span
                class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span></span>
        <?php endif; ?>
        <?php echo wc_get_stock_html( $product ); ?>

    </section>

    <section class="order-submit">
        <div class="order-submit__price">
            <p class="singleproduct__price price"><?php echo $product->get_price_html(); ?></p>
        </div>
        <div class="order-submit__actions">
            <input class="pricePerBox" type="hidden" value="<?= $product->get_price() ?>">
            <input class="sqftPerBox" type="hidden" value="<?= $datafromcat['size_per_box'] ?>">
            <input class="pricePerSqft" type="hidden" value="<?= $product->get_price()/$datafromcat['size_per_box'] ?>">

            <input class="orderQuantity" type="hidden" name="quantity" value="1">

            <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>"
                class="single_add_to_cart_button button alt order-button">
                <?php echo esc_html( $product->single_add_to_cart_text() ); ?>
                <strong><?= $datafromcat['size_per_box'] ?> m<sup>2</sup></strong>
            </button>

        </div>
    </section>
    <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
</form>
<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>