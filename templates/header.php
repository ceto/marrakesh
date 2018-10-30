<header class="banner">
    <div class="grid-container">
        <div class="banner__branding">
            <a class="brand" href="<?= esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
        </div>
        <nav class="banner__nav">
                    <?php
                    if (has_nav_menu('primary_navigation')) :
                wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'menu dropdown menu--main', 'items_wrap' => '<ul class="%2$s" data-dropdown-menu data-click-open="true" data-disable-hover="true">%3$s</ul>']);
                endif;
                ?>
        </nav>
    </div>
</header>
