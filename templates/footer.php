<footer class="sitefooter">
    <div class="sitefooter__top">
        <div class="grid-container">
            <div class="grid-x grid-margin-x">
                <div class="cell small-auto medium-6 large-3">
                    <section class="widget">
                        <h3 class="widget__title">Products</h3>
                        <ul class="menu vertical">
                            <?php
                        	$the_prcats = get_terms( array(
                                'taxonomy' => 'product_cat',
                                'hide_empty' => true,
                                'parent' => 0,
                            ) );
                            if ( !empty( $the_prcats ) && !is_wp_error( $the_prcats ) ){
                                foreach ( $the_prcats as $design ) {
                                    //print_r($design);
                                    $archive_link = get_term_link( $design, 'pa_design' );
                                    echo $full_line = '<li><a href="' . $archive_link . '">'. $design->name . '<span class="count">'.$design->count.'</span></a></li>';
                                }
                            }

                        ?>
                        </ul>
                    </section>

                </div>
                <div class="cell small-auto medium-6 large-3">
                    <section class="widget">
                        <h3 class="widget__title">Help & Info</h3>
                        <?php
                            if (has_nav_menu('secondary_navigation')) :
                            wp_nav_menu(['theme_location' => 'secondary_navigation', 'menu_class' => 'menu vertical', 'items_wrap' => '<ul class="%2$s">%3$s</ul>']);
                            endif;
                        ?>
                    </section>
                </div>
                <div class="cell small-auto medium-6 large-3">
                    <section class="widget %1$s %2$s">
                        <h3 class="widget__title">Contact</h3>
                        <ul class="menu vertical">
                            <li><a href="#">+360707705653</a></li>
                            <li><a href="#">info@orintdekor.sk</a></li>
                        </ul>


                    </section>
                </div>
                <?php dynamic_sidebar('sidebar-footer'); ?>
            </div>
        </div>
    </div>
    <div class="sitefooter__bottom">
        <div class="grid-container">
            <div class="grid-x grid-margin-x">
                <div class="cell auto">
                    <p>&copy; <?= date('Y') ?> &middot; Orient Dekor Ltd. &middot; All rights reserved</p>
                </div>
                <div class="cell shrink">
                    <p>Site by <a target="_blank" href="http://hydrogene.hu">Hydrogene</a></p>
                </div>
            </div>
        </div>
    </div>
</footer>