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


<form class="order cart atext-center"
    action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>"
    enctype="multipart/form-data" method="post" novalidate="novalidate">
    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

    <section class="order-box">

        <div class="grid-x grid-margin-x aalign-center atext-center">
            <div class="cell amedium-6">
                <label for="sqft">Hány négyzetméter lapra van szükséged<em>*</em></label>
                <div class="input-group" style="margin:0 0; amax-width:20rem;">
                    <input class="input-group-field" type="number" name="sqft" id="sqft" value="" placeholder="E.g.: 20"
                        min="4">
                    <span class="input-group-label">m<sup>2</sup></span>
                </div>
                <p class="waste-warning atext-center"><small>*Számolj 10-15% ráhagyással (vágási hullladék, pótlap stb.) A rendelt mennyiséget egész dobozra kerekítjük.</small></p>
                <div class="calculatedsizewrap">
                    <p class="calculatedsizes">
                        <small>Kiszerelés:</small>
                        <span class="box-total">0</span> doboz</p>
                    <p class="calculatedsizes">
                        <small>Tényleges méret</small>
                        <span class="sqft-total">0</span>m<sup>2</sup>
                    </p>
                    <!-- <p class="calculatedsizes">
                        <small>Várható száll.:</small>
                        <span class="est-shipping"><?= date('M. j.');?></span></p> -->
                </div>
            </div>
        </div>

        <?php if ( false && wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
        <span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?> <span
                class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span></span>
        <?php endif; ?>
        <?php // echo wc_get_stock_html( $product ); ?>

    </section>

    <section class="order-submit">
        <div class="order-submit__price">

            <p class="price text-center">
                <small><?= __( 'ÖSSZESEN (bruttó)', 'marrakesh'); ?></small>
                0 Ft.
            </p>
        </div>
        <div class="order-submit__actions" style="display: none;">
            <input class="pricePerBox" type="hidden" value="<?= wc_get_price_to_display($product) ?>">
            <input class="sqftPerBox" type="hidden" value="<?= $datafromcat['size_per_box'] ?>">
            <input class="pricePerSqft" type="hidden"
                value="<?= wc_get_price_to_display($product)/$datafromcat['size_per_box'] ?>">

            <input class="orderQuantity" type="hidden" name="quantity" value="0">

            <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>"
                class="single_add_to_cart_button button expanded alt order-button">
                <?= sprintf( __( '%s %s<br>hozzáadása a kosárhoz', 'marrakesh' ), '<strong>0 m<sup>2</sup></strong>',  get_the_title() ); ?>
            </button>

        </div>
    </section>
    <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
</form>
<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
