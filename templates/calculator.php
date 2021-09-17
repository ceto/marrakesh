<?php global $datafromprod, $product; ?>

<div id="buycallout" class="callout singleproduct__callout" data-magellan-target="buycallout">
    <?php if ( $datafromprod['_isboxed']=='yes' && $datafromprod['_sizeperbox'] )  : ?>
    <h3><?php _e( 'Ár kalkulátor', 'marrakesh' ) ?></h3>
    <p><?php _e( 'Add meg a kívánt mennyiséget, hogy megközelítőleg pontos árat számoljunk neked. A kalkulált ár 27% ÁFA-t tartalamaz.', 'marrakesh' ) ?>
    </p>
    <form class="order cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' novalidate="novalidate">

        <section class="order-box">

            <div class="grid-x grid-margin-x aalign-center atext-center">
                <div class="cell amedium-6">
                    <label for="sqft"><?= __('Hány négyzetméter lapra van szükséged','marrakesh'); ?><em>*</em></label>
                    <div class="input-group" style="margin:0 0;">
                        <input class="input-group-field" type="number" name="sqft" id="sqft" value="" placeholder="E.g.: 20">
                        <span class="input-group-label">m<sup>2</sup></span>
                    </div>
                    <p class="waste-warning atext-center"><small>*<?= __('Számolj 10-15% ráhagyással (vágási hullladék, pótlap stb.) A rendelt mennyiséget egész dobozra kerekítjük.','marrakesh'); ?></small></p>
                    <div class="calculatedsizewrap">
                        <p class="calculatedsizes">
                            <small><?= __('Kiszerelés','marrakesh'); ?>:</small>
                            <span class="box-total">0</span> <?= __('doboz','marrakesh'); ?></p>
                        <p class="calculatedsizes">
                            <small><?= __('Tényleges méret','marrakesh'); ?></small>
                            <span class="sqft-total">0</span>m<sup>2</sup>
                        </p>
                        <p class="calculatedsizes">
                            <small><?= __('Átvehető','marrakesh'); ?>:</small>
                            <span class="est-shipping">na.</span></p>
                    </div>
                </div>
            </div>
        </section>

        <section class="order-submit">
            <div class="order-submit__price">
                <p class="price text-center">
                    <small><?= __('ÖSSZESEN', 'marrakesh'); ?>:</small>
                    0 <?= get_woocommerce_currency_symbol() ?>
                </p>
            </div>
            <div class="order-submit__actions">
                <input class="pricePerBox" type="hidden" value="<?= wc_get_price_to_display($product) ?>">
                <input class="sqftPerBox" type="hidden" value="<?= $datafromprod['_sizeperbox'] ?>">
                <input class="pricePerSqft" type="hidden" value="<?= wc_get_price_to_display($product)/$datafromprod['_sizeperbox'] ?>">
                <input
                    class="orderQuantity"
                    type="hidden"
                    name="quantity"
                    value="<?= isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : 0 ?>"
                    min="<?= apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ); ?>"
                    max="<?= apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ); ?>"
                >
            </div>
        </section>
        <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button large accent expanded"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
    </form>
    <?php endif; ?>
    <button data-open="requestmodal" class="button hollow small expanded"><?= __('Ajánlatot kérek', 'marrakesh'); ?></button>


</div>

