    <?php global $product, $product_id, $cats, $styles, $colors; ?>
    <div class="ps ps--narrow aps--xlight ps--bordered">
        <div class="grid-container">
            <div class="grid-x grid-margin-x">
                <div class="cell">
                    <?php
                    $upsells = wc_products_array_orderby( array_filter( array_map( 'wc_get_product', $product->get_upsell_ids() ), 'wc_products_array_filter_visible' ), 'rand', 'desc');
                    $upsellproducts = $upsells;
                    ?>
                    <?php
                        $samecatproducts = wc_get_products(array(
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'exclude' => array($product_id),
                            'tax_query'      => array(
                                'relation' => 'AND',
                                array(
                                    'taxonomy'     => 'product_cat',
                                    'field'        => 'id',
                                    'terms'        => end($cats),
                                    'operator'     => 'IN'

                                )
                            )
                        ) );
                        $exclarr=array($product_id);
                        foreach ($samecatproducts as $tempprod) {
                            $exclarr[]= $tempprod->get_id();
                        }
                        $relproducts = wc_get_products(array(
                            'post_status' => 'publish',
                            'posts_per_page' => 10,
                            'post__not_in' => $exclarr,
                            'tax_query'      => array(
                                'relation' => 'AND',
                                array(
                                    'taxonomy'     => 'pa_color',
                                    'field'        => 'id',
                                    'terms'        => $colors,
                                    'operator'     => 'IN'
                                ),
                                array(
                                    'taxonomy'     => 'pa_style',
                                    'field'        => 'id',
                                    'terms'        => $styles,
                                    'operator'     => 'IN'
                                ),
                                array(
                                    'taxonomy'     => 'product_cat',
                                    'field'        => 'id',
                                    'terms'        => $cats[0],
                                    'operator'     => 'IN'

                                ),
                            )
                        ) );
                    ?>
                    <h3><?php _e( 'Kapcsolódó termékek', 'marrakesh' ); ?></h3>
                    <ul class="tabs tabs--singleproduct" data-active-collapse="true" data-tabs id="producttabs">
                        <?php if ( $upsellproducts  ) : ?><li class="tabs-title is-active"><a
                                href="#upsellpanel" aria-selected="true"><?php _e( 'Ehhez ajánljuk', 'marrakesh' ) ?></a>
                        </li><?php endif;  ?>
                        <?php if ( $relproducts ) : ?><li class="tabs-title <?= !$upsellproducts?'is-active':''; ?>"><a href="#similarpanel"
                            <?= !$upsellproducts?'aria-selected="true"':''; ?>><?php _e( 'Hasonló termékek', 'marrakesh' ); ?></a></li>
                        <?php endif;  ?>
                        <?php if ( $samecatproducts  ) : ?><li class="tabs-title <?= (!$upsellproducts && empty($relproducts))?'is-active':''; ?>"><a
                                href="#colvarpanel"><?php _e( 'Színvariációk', 'marrakesh' ); ?></a></li>
                        <?php endif;  ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="tabs-content" data-tabs-content="producttabs">

            <?php if ( $upsellproducts ) : ?>
            <div class="tabs-panel is-active" id="upsellpanel">
                <section class="up-sells upsells products">
                    <ul class="prodswipe prodswipe--upsells">
                        <?php foreach ( $upsellproducts as $upsell ) : ?>
                        <?php
                            $post_object = get_post( $upsell->get_id() );
                            setup_postdata( $GLOBALS['post'] =& $post_object );
                            wc_get_template_part( 'content-widget-product' );
                        ?>
                        <?php endforeach;  wp_reset_postdata(); ?>
                    </ul>
                </section>
                <nav class="scroller" data-target="prodswipe--upsells">
                    <a href="#" class="js-scrollleft">‹</a>
                    <a href="#" class="js-scrollright">›</a>
                </nav>
            </div>
            <?php endif; ?>

            <?php if ( $relproducts ) : ?>
            <div class="tabs-panel <?= !$upsellproducts?'is-active':''; ?>" id="similarpanel">
                <section class="related products">
                    <ul class="prodswipe prodswipe--similar">
                        <?php foreach ( $relproducts as $related_product ) : ?>
                        <?php
                            $post_object = get_post( $related_product->get_id() );
                            setup_postdata( $GLOBALS['post'] =& $post_object );
                            wc_get_template_part( 'content-widget-product' ); ?>
                        <?php endforeach; wp_reset_postdata(); ?>
                    </ul>
                </section>
                <nav class="scroller" data-target="prodswipe--similar">
                    <a href="#" class="js-scrollleft">‹</a>
                    <a href="#" class="js-scrollright">›</a>
                </nav>
            </div>
            <?php endif;  ?>

            <?php if ( $samecatproducts ) : ?>
            <div class="tabs-panel <?= (!$upsellproducts && empty($relproducts))?'is-active':''; ?>" id="colvarpanel">
                <section class="related products">
                    <ul class="prodswipe prodswipe--related">
                        <?php foreach ( $samecatproducts as $related_product ) : ?>
                        <?php
                            $post_object = get_post( $related_product->get_id() );
                            setup_postdata( $GLOBALS['post'] =& $post_object );
                            wc_get_template_part( 'content-widget-product' );
                        ?>
                        <?php endforeach; wp_reset_postdata(); ?>
                    </ul>
                </section>
                <nav class="scroller" data-target="prodswipe--related">
                    <a href="#" class="js-scrollleft">‹</a>
                    <a href="#" class="js-scrollright">›</a>
                </nav>
            </div>
            <?php endif;  ?>

        </div>
        <div class="grid-container">
            <div class="grid-x grid-margin-x">
                <div class="cell">
                    <?php
                        /**
                         * Hook: woocommerce_after_single_product_summary.
                         *
                         * @hooked woocommerce_output_product_data_tabs - 10
                         * @hooked woocommerce_upsell_display - 15
                         * @hooked woocommerce_output_related_products - 20
                         */
                        do_action( 'woocommerce_after_single_product_summary' );
                    ?>
                </div>
            </div>
        </div>


    </div>
