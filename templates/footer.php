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
                <!-- <div class="cell small-auto medium-6 large-3">
                    <section class="widget %1$s %2$s">
                        <h3 class="widget__title"><?php _e('Kapcsolat', 'marrakesh'); ?></h3>
                        <ul class="menu vertical">
                            <li><a
                                    href="tel:<?= preg_replace("/[^\+0-9]/", "", get_field('cphone', 'option')); ?>"><?php the_field('cphone', 'option'); ?></a>
                            </li>
                            <li><a
                                    href="mailto:<?php the_field('cemail', 'option'); ?>"><?php the_field('cemail', 'option'); ?></a>
                            </li>
                        </ul>
                    </section>
                </div> -->
                <div class="cell small-auto medium-6 large-3">
                    <section class="widget %1$s %2$s">
                        <h3 class="widget__title"><?php _e('Belvárosi bemutatóterem', 'marrakesh'); ?></h3>
                        <p>H-1088 Budapest, Bródy Sándor u. 34.</p>
                        <h6>Nyitvatartás</h6>
                        <p>Hétfőtől - Péntekig: 10:00-18:00<br>
                            Szombat: 10:00-14:00<br>
                            Vasárnap: zárva</p>
                        <h6>Kapcsolat</h6>
                        <p>Telefon: <a
                                href="tel:<?= preg_replace("/[^\+0-9]/", "", get_field('cphone', 'option')); ?>"><?php the_field('cphone', 'option'); ?></a><br>
                            E-mail: <a
                                href="mailto:<?php the_field('cemail', 'option'); ?>"><?php the_field('cemail', 'option'); ?></a>

                        </p>
                        <p><small>A bemutatóteremben csak minta készletet tartunk, áru átvételre nincs lehetőség. <a
                                    href="<?php the_permalink(get_field('pageforcontact', 'option')) ?>">Térkép és
                                    részletek&hellip;</a></small></p>
                    </section>
                </div>
                <div class="cell small-auto medium-6 large-3">
                    <section class="widget %1$s %2$s">
                        <h3 class="widget__title"><?php _e('Raktár és áruátvétel', 'marrakesh'); ?></h3>
                        <p>H-2045 Törökbálint, Depo u. 34.</p>
                        <h6>Nyitvatartás</h6>
                        <p>Hétfőtől - Péntekig: 10:00-18:00<br>
                            Szombat: zárva<br>
                            Vasárnap: zárva</p>
                        <h6>Kapcsolat</h6>
                        <p>Telefon: <a href="tel:<?= preg_replace("/[^\+0-9]/", "", '(+36) 30 582 2377'); ?>">+36 (30)
                                582 2377</a>
                        </p>
                        <p><small><a href="<?php the_permalink(get_field('pageforcontact', 'option')) ?>">Térkép és
                                    részletek&hellip;</a></small></p>

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
                    <p>Site by <a target="_blank" href="http://hydrogene.hu">Hydrogene</a></p>
                </div>
            </div>
        </div>
    </div>
</footer>
