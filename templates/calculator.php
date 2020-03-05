<?php global $datafromprod, $datafromcat, $product; ?>

<div id="buycallout" class="callout singleproduct__callout" data-magellan-target="buycallout">
    <?php if ( $datafromprod['_isboxed']=='yes' && $datafromprod['_sizeperbox'] )  : ?>
    <h3><?php _e( 'Ár kalkulátor', 'marrakesh' ) ?></h3>
    <p><?php _e( 'Kívánt mennyiség alapján megközelítőleg pontos bruttó árat és kiszerelési egységet számolunk neked.', 'marrakesh' ) ?>
    </p>
    <form class="order cart" action="<?php the_permalink(); ?>" method="post" novalidate="novalidate">

        <section class="order-box">

            <div class="grid-x grid-margin-x aalign-center atext-center">
                <div class="cell amedium-6">
                    <label for="sqft">Hány négyzetméter lapra van szükséged<em>*</em></label>
                    <div class="input-group" style="margin:0 0;">
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
        </section>

        <section class="order-submit">
            <div class="order-submit__price">
                <p class="price text-center">
                    <small><?= __( 'ÖSSZESEN (bruttó)', 'marrakesh'); ?></small>
                    0 Ft.
                </p>
            </div>
            <div class="order-submit__actions">
                <input class="pricePerBox" type="hidden" value="<?= wc_get_price_to_display($product) ?>">
                <input class="sqftPerBox" type="hidden" value="<?= $datafromcat['size_per_box'] ?>">
                <input class="pricePerSqft" type="hidden" value="<?= wc_get_price_to_display($product)/$datafromcat['size_per_box'] ?>">
                <input class="orderQuantity" type="hidden" name="quantity" value="0">
            </div>
        </section>
    </form>
    <?php endif; ?>
    <button data-open="requestmodal" class="button large accent expanded"><?= __('Egyedi ajánlatot kérek', 'marrakesh'); ?></button>

</div>

