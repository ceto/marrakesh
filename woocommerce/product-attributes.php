<?php global $product, $product_id, $cats, $datafromprod, $attributes; ?>
<div>
    <dl class="singleproduct__catattributes">
        <!-- <dt><?= __('Azonosító', 'marrakesh'); ?></dt>
        <dd><?php the_title(); ?></dd>
        <dt><?= __('Bruttó ár', 'marrakesh'); ?></dt>
        <dd><?php wc_get_template_part( 'loop/price'); ?></dd> -->
        <?php if ($datafromprod['_tileweight']) : ?>
        <dt><?= __('Súly (1db lap)','marrakesh'); ?></dt>
        <dd><?= $datafromprod['_tileweight']; ?>&nbsp;kg</dd>
        <?php endif; ?>
        <?php if ($datafromprod['_tilewidth']) : ?>
        <dt><?= __('Lapméret','marrakesh'); ?></dt>
        <dd><?= $datafromprod['_tilewidth']; ?>&nbsp;&times;&nbsp;<?= $datafromprod['_tileheight']; ?>&nbsp;cm
        </dd>
        <?php endif; ?>
        <?php if ($datafromprod['_tilethickness']) : ?>
        <dt><?= __('Vastagság','marrakesh'); ?></dt>
        <dd><?= $datafromprod['_tilethickness']; ?>&nbsp;cm</dd>
        <?php endif; ?>
        <?php if ($datafromprod['_isboxed']=='yes') : ?>
        <dt><?= __('Kiszerelés','marrakesh'); ?></dt>
        <dd><?= __('dobozban','marrakesh'); ?></dd>
        <dt><?= __('Doboz ár (bruttó)','marrakesh'); ?></dt>
        <dd><?= $product->get_price_html() ?></dd>
        <dt><?= __('Lapok a dobozban','marrakesh'); ?></dt>
        <dd><?= $datafromprod['_tilesperbox']; ?>&nbsp;<?= __('lap/doboz','marrakesh'); ?>
        </dd>
        <dt><?= __('Doboz terítve','marrakesh'); ?></dt>
        <dd><?= $datafromprod['_sizeperbox']; ?>&nbsp;m<sup>2</sup>/<?= __('doboz','marrakesh'); ?>
        </dd>
        <?php else: ?>
        <dt><?= __('Kiszerelés','marrakesh'); ?></dt>
        <dd><?= __('darab','marrakesh'); ?></dd>
        <?php endif; ?>
    </dl>
    <dl class="singleproduct__attributes">
        <dt><?php _e('Termékcsoport', 'marrakesh');?></dt>
        <dd><?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( '', '', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
        </dd>
        <?php foreach ( $attributes as $attribute ) : ?>
        <dt><?php echo wc_attribute_label( $attribute->get_name() ); ?></dt>
        <dd><?php
                $values = array();

                if ( $attribute->is_taxonomy() ) {
                    $attribute_taxonomy = $attribute->get_taxonomy_object();
                    $attribute_values = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );

                    foreach ( $attribute_values as $attribute_value ) {
                        $value_name = esc_html( $attribute_value->name );

                        if ( $attribute_taxonomy->attribute_public ) {
                            $values[] = '<a href="' . esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ) . '" rel="tag">' . $value_name . '</a>';
                        } else {
                            $values[] = $value_name;
                        }
                    }
                } else {
                    $values = $attribute->get_options();

                    foreach ( $values as &$value ) {
                        $value = make_clickable( esc_html( $value ) );
                    }
                }

                echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
            ?></dd>
        <?php endforeach; ?>
        <?php if ( /*$display_dimensions &&*/ $product->has_weight() ) : ?>
        <dt><?php _e( 'Weight', 'woocommerce' ) ?></dt>
        <dd class="product_weight">
            <?php echo esc_html( wc_format_weight( $product->get_weight() ) ); ?></dd>
        <?php endif; ?>

        <?php if ( /*$display_dimensions &&*/ $product->has_dimensions() ) : ?>
        <dt><?php _e( 'Dimensions', 'woocommerce' ) ?></dt>
        <dd class="product_dimensions">
            <?php echo esc_html( wc_format_dimensions( $product->get_dimensions( false ) ) ); ?>
        </dd>
        <?php endif; ?>
    </dl>
</div>
