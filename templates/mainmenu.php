<?php

global $wpdb;

$attributes_query = $wpdb->prepare(
    "SELECT DISTINCT tt.taxonomy, tt.term_id, t.name
    FROM {$wpdb->prefix}term_relationships AS tr
    JOIN {$wpdb->prefix}term_taxonomy AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
    JOIN {$wpdb->prefix}terms AS t ON tt.term_id = t.term_id
    WHERE tr.object_id IN (
        SELECT p.ID
        FROM {$wpdb->prefix}posts AS p
        JOIN {$wpdb->prefix}term_relationships AS tr ON p.ID = tr.object_id
        JOIN {$wpdb->prefix}term_taxonomy AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
        JOIN {$wpdb->prefix}terms AS t ON tt.term_id = t.term_id
        WHERE p.post_type = 'product'
        AND p.post_status = 'publish'
        AND tt.taxonomy = 'product_cat'
        AND t.slug = 'cementlap'
    )
    AND tt.taxonomy LIKE %s",
    'pa_style'
);

$results = $wpdb->get_results($attributes_query);
var_dump($results);
?>
<hr class="fulldivider">

<ul id="menu-main-menu" class="mainmenu">
    <li class="menu-item menu-item-has-children menu-products">
        <a href="<?php the_permalink(get_field('productslistingpage', 'option')); ?>"><?php _e('Products','gls'); ?></a>
        <nav class="mega">
            <div class="mega__menu">
                <h3><?php _e('Products','gls'); ?></h3>
                <?php
                    if (has_nav_menu('product_navigation')) :
                        wp_nav_menu([
                            'theme_location' => 'product_navigation',
                            'menu_class' => 'sub-menu',
                            // 'depth' => 1,
                            'items_wrap' => '<ul class="%2$s">%3$s</ul>'
                        ]);
                    endif;
                ?>
            </div>
            <div class="mega__content">
            </div>
        </nav>
    </li>
    <li class="menu-item menu-item-has-children menu-services">
        <a href="<?php the_permalink(get_field('serviceslistingpage', 'option')); ?>"><?php _e('Services','gls'); ?></a>
        <nav class="mega">
            <div class="mega__menu">
                <h3><?php _e('Services','gls'); ?></h3>
                <?php
                    if (has_nav_menu('service_navigation')) :
                        wp_nav_menu([
                            'theme_location' => 'service_navigation',
                            'menu_class' => 'sub-menu',
                            // 'depth' => 1,
                            'items_wrap' => '<ul class="%2$s">%3$s</ul>'
                        ]);
                    endif;
                ?>
            </div>
            <div class="mega__content">
            </div>
        </nav>
    </li>
    <li class="menu-item menu-item-has-children menu-events">
        <a href="<?php the_permalink(get_field('eventslistingpage', 'option')); ?>"><?php _e('Events','gls'); ?></a>
        <nav class="mega">
            <div class="mega__menu">
                <h3><?php _e('Events','gls'); ?></h3>
                <ul class="sub-menu">
                    <li><a href="<?php the_permalink(get_field('eventslistingpage', 'option')); ?>" ><?= __('All Events') ?></a></li>
                </ul>
            </div>
            <div class="mega__content wide">
            </div>
        </nav>
    </li>
    <li class="menu-item menu-academicuse">
        <a href="<?php the_permalink(get_field('academicusepage', 'option')); ?>"><?php _e('Academic Use','gls'); ?></a>
    </li>
    <li class="menu-item menu-item-has-children menu-about-us">
        <a href="<?php the_permalink(get_field('aboutuspage', 'option')); ?>"><?php _e('About Us','gls'); ?></a>
        <nav class="mega">
            <div class="mega__menu">
                <h3><?php _e('About Us','gls'); ?></h3>
                <?php
                    if (has_nav_menu('aboutus_navigation')) :
                        wp_nav_menu([
                            'theme_location' => 'aboutus_navigation',
                            'menu_class' => 'sub-menu',
                            // 'depth' => 1,
                            'items_wrap' => '<ul class="%2$s">%3$s</ul>'
                        ]);
                    endif;
                ?>
            </div>
            <div class="mega__content">
            </div>
        </nav>

    </li>
    <li class="menu-item menu-blog">
        <a href="<?php the_permalink(get_field('blogpage', 'option')); ?>"><?php _e('Blog','gls'); ?></a>
    </li>
</ul>
