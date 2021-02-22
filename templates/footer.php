<footer class="sitefooter">
    <div class="sitefooter__top">
        <div class="grid-container">
            <div class="grid-x grid-margin-x">
                <div class="cell small-auto medium-6 large-3">
                    <section class="widget">
                        <h3 class="widget__title"><?= __('Termékek', 'marrakesh'); ?></h3>
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
                    <section class="widget">
                        <h3 class="widget__title"><?php _e('Marrakesh Bt.', 'marrakesh'); ?></h3>
                        <?php
                            if (has_nav_menu('footer_navigation')) :
                            wp_nav_menu(['theme_location' => 'footer_navigation', 'menu_class' => 'menu vertical', 'items_wrap' => '<ul class="%2$s">%3$s</ul>']);
                            endif;
                        ?>
                    </section>

                </div>
                <div class="cell small-auto medium-6 large-3">
                    <section class="widget">
                        <h3 class="widget__title"><?php _e('Infó & Segítség', 'marrakesh'); ?></h3>
                        <?php
                            if (has_nav_menu('secondary_navigation')) :
                            wp_nav_menu(['theme_location' => 'secondary_navigation', 'menu_class' => 'menu vertical', 'items_wrap' => '<ul class="%2$s">%3$s</ul>']);
                            endif;
                        ?>
                    </section>
                    <section class="widget %1$s %2$s">
                        <h3 class="widget__title"><?php _e('Inspirációkért kövess', 'marrakesh'); ?></h3>
                        <ul class="menu menu--footersocial">
                            <li><a target="_blank" href="https://facebook.com/MarrakeshCementlap/"><svg class="icon"><use xlink:href="#icon-facebook2"></use></svg></a></li>
                            <li><a target="_blank" href="https://instagram.com/marrakeshcementtile/"><svg class="icon"><use xlink:href="#icon-instagram"></use></svg></a></li>
                            <li><a target="_blank" href="https://pinterest.com/marrcementtiles/"><svg class="icon"><use xlink:href="#icon-pinterest2"></use></svg></a></li>
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
                    <p>&copy; <?= date('Y') ?> &middot; <?php bloginfo('name'); ?> &middot; All rights reserved</p>
                </div>
                <div class="cell shrink">
                    <p>Site by <a target="_blank" href="https://hydrogene.hu">Hydrogene</a></p>
                </div>
            </div>
        </div>
    </div>
</footer>
