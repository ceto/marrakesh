<footer class="sitefooter">
    <div class="sitefooter__top">
        <div class="grid-container">
            <div class="grid-x grid-margin-x small-up-2 large-up-4">
                <div class="cell">
                    <?php 
                        the_widget( 'WC_Widget_Product_Categories', array(
                            title => 'Products',
                            dropdown => 0,
                            count => 1,
                            hide_empty => 1,
                            orderby => 'count',
                        ), array(
                            'before_widget' => '<section class="widget widget--footer %1$s">',
                            'after_widget'  => '</section>',
                            'before_title'  => '<h3 class="widget__title">',
                            'after_title'   => '</h3>'
                        ));
                    ?>
                    
                </div>
                <div class="cell">
                  <section class="widget">
                        <h3 class="widget__title">Help & Info</h3>
                        <?php
                            if (has_nav_menu('secondary_navigation')) :
                            wp_nav_menu(['theme_location' => 'secondary_navigation', 'menu_class' => 'menu vertical', 'items_wrap' => '<ul class="%2$s">%3$s</ul>']);
                            endif;
                            if (has_nav_menu('secondary_navigation')) :
                                wp_nav_menu(['theme_location' => 'secondary_navigation', 'menu_class' => 'menu vertical', 'items_wrap' => '<ul class="%2$s">%3$s</ul>']);
                                endif;
                        ?>
                    </section>
                </div>
                <div class="cell" >
                    <section class="widget %1$s %2$s">
                        <h3 class="widget__title">Contact</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio eum inventore nostrum harum vel aliquam.</p>
                        <?php
                            if (has_nav_menu('secondary_navigation')) :
                                wp_nav_menu(['theme_location' => 'secondary_navigation', 'menu_class' => 'menu vertical', 'items_wrap' => '<ul class="%2$s">%3$s</ul>']);
                                endif;
                        ?>
                        
                    </section>
                </div>
                <div class="cell" >
                    <section class="widget %1$s %2$s">
                        <h3 class="widget__title">Lorem ipsum dolor sit amet</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio eum inventore nostrum harum vel aliquam, et numquam repellat excepturi, accusamus possimus dignissimos illum error eaque ipsam, assumenda enim ipsa repellendus.</p>
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
                    <p>&copy; <?= date('Y') ?> &middot; Marrakesh Bt. &middot; All rights reserved</p>
                </div>  
                <div class="cell shrink">
                    <p>Site by <a target="_blank" href="http://hydrogene.hu">Hydrogene</a></p>
                </div>   
            </div>
        </div>
    </div>
</footer>
