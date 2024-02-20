<?php global $product, $product_id, $cats, $datafromprod, $attributes; ?>
<div class="singleproduct__details">
    <?php

        $datapostobject = get_post( $datafromprod['_linfopage'] );
        setup_postdata( $GLOBALS['post'] =& $datapostobject );
        get_template_part('templates/accordioncage');
        wp_reset_postdata();
    ?>
    <?php if (get_the_content()!=='') :?>
    <div class="bodycopy">
        <?php the_content(); ?>
    </div>
    <?php endif; ?>
    <?php
        if (get_field('showsimulator', $product_id)==true) {
            get_template_part('templates/simulatorcta');
        }
    ?>
    <?php
        get_template_part('templates/dlcage');
        wp_reset_postdata();
    ?>
    <!-- <p>
        <?= __('További információk és részletes termék ismertetők az','marrakesh'); ?> <a href="<?php the_permalink(get_field('pageforinfohelp', 'option')) ?>"><?= __('Info &amp; Segítség oldalon.','marrakesh'); ?></a>
    </p> -->
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
        <?php if ( FALSE && /*$display_dimensions &&*/ $product->has_weight() ) : ?>
        <dt><?php _e( 'Weight', 'woocommerce' ) ?></dt>
        <dd class="product_weight">
            <?php echo esc_html( wc_format_weight( $product->get_weight() ) ); ?></dd>
        <?php endif; ?>

        <?php if ( FALSE && /*$display_dimensions &&*/ $product->has_dimensions() ) : ?>
        <dt><?php _e( 'Dimensions', 'woocommerce' ) ?></dt>
        <dd class="product_dimensions">
            <?php echo esc_html( wc_format_dimensions( $product->get_dimensions( false ) ) ); ?>
        </dd>
        <?php endif; ?>
    </dl>


</div>
