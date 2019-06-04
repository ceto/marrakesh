<header class="banner">
    <div class="banner__toprow">
        <div class="grid-container">
            <div class="grid-x grid-margin-x">
                <div class="shrink cell">
                    <ul class="menu menu--topbar align-right">
                        <li class="menu-item"><a
                                href="tel:<?= preg_replace("/[^\+0-9]/", "", get_field('cphone', 'option')); ?>"><?php the_field('cphone', 'option'); ?></a>
                        </li>
                        <li class="menu-item"><a
                                href="mailto:<?php the_field('cemail', 'option'); ?>"><?php the_field('cemail', 'option'); ?></a>
                        </li>
                    </ul>
                </div>
                <div class="auto cell show-for-tablet">

                    <?php
                    if (has_nav_menu('secondary_navigation')) :
                wp_nav_menu(['theme_location' => 'secondary_navigation', 'menu_class' => 'menu menu--topbar align-right', 'items_wrap' => '<ul class="%2$s">%3$s</ul>']);
                endif;
                ?>
                </div>
            </div>
        </div>
    </div>

    <div class="grid-container">
        <div class="grid-x grid-margin-x">
            <div class="auto cell">
                <div class="banner__branding">
                    <a class="brand" href="<?= esc_url(home_url('/')); ?>">
                        <!-- <img class="brand__logo" src="<?= get_stylesheet_directory_uri(); ?>/dist/images/lofo_hu_small.svg" alt="<?php bloginfo('name'); ?>"> -->
                        <img class="brand__fulllogo"
                            src="<?= get_stylesheet_directory_uri(); ?>/dist/images/orientdekor-logo.svg"
                            alt="<?php bloginfo('name'); ?> | <?php bloginfo('description'); ?>">
                    </a>
                </div>
                <nav class="banner__nav show-for-medium">
                    <?php
                    if (has_nav_menu('primary_navigation')) :
                wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'menu menu--main', 'items_wrap' => '<ul class="%2$s">%3$s</ul>']);
                endif;
                ?>
                </nav>
            </div>
            <div class="cell shrink show-for-tablet banner__ctacell">
                <div class="banner__cta">
                    <p class="show-for-large">Design Your Own Tiles</p>
                    <a href="#" class="btn">Start Simulator</a>
                </div>
            </div>
            <div class="shrink cell hide-for-tablet">
                <button class="menutoggler" type="button" data-toggle="mobilemodal"></button>
            </div>
        </div>
    </div>
</header>
<?php
 if ( is_woocommerce() ) {
    do_action( 'marrakesh_after_banner');
}
?>