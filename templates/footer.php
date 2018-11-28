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
                            ) );
                            if ( !empty( $the_prcats ) && !is_wp_error( $the_prcats ) ){
                                foreach ( $the_prcats as $design ) {
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
                    <section class="widget %1$s %2$s">
                        <h3 class="widget__title">Contact</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio eum inventore nostrum harum vel aliquam.</p>
                        
                    </section>
                </div>
                <div class="cell auto" >
                    <section class="widget">
                        <h3 class="widget__title">Tile Templates</h3>
                        <ul class="menu menu--designlist">   
                        <?php 
                        	$the_designs = get_terms( array(
                                'taxonomy' => 'pa_design',
                                'hide_empty' => true,
                            ) );
                            if ( !empty( $the_designs ) && !is_wp_error( $the_designs ) ){
                                foreach ( $the_designs as $design ) {
                                    $archive_link = get_term_link( $design, 'pa_design' );
                                    echo $full_line = '<li><a href="' . $archive_link . '">'. $design->name . '<span class="count">'.$design->count.'</span></a></li>';
                                }
                            }
                            
                        ?>
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
                    <p>&copy; <?= date('Y') ?> &middot; Marrakesh Bt. &middot; All rights reserved</p>
                </div>  
                <div class="cell shrink">
                    <p>Site by <a target="_blank" href="http://hydrogene.hu">Hydrogene</a></p>
                </div>   
            </div>
        </div>
    </div>
</footer>
