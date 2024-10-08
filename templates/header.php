<?php
    global $whislistmenuitem;
?>
<header class="banner">
    <div class="banner__toprow">
        <div class="grid-container">
            <div class="grid-x grid-margin-x">
                <div class="shrink cell">
                    <ul class="menu menu--topbar align-right">
                        <li class="menu-item show-for-medium">
                            <a href="<?php the_permalink(get_field('pageforcontact', 'option')) ?>">
                            <?= __('Bemutatóterem: 1088 Budapest, Bródy Sándor u. 34.', 'marrakesh'); ?>
                            </a>
                        </li>
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
                            wp_nav_menu([
                                'theme_location' => 'secondary_navigation',
                                'menu_class' => 'menu menu--topbar align-right',
                                'items_wrap' => '<ul class="%2$s">%3$s</ul>'
                            ]);
                        endif;
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="banner__main">
        <div class="grid-container">
            <div class="grid-x grid-margin-x align-middle">
                <div class="auto cell">
                    <div class="banner__branding">
                        <a class="brand <?= get_locale(); ?>" href="<?= esc_url(home_url('/')); ?>">
                            <?php switch( get_locale() ) {
                            case 'en_US' : ?>
                            <img class="brand__fulllogo" src="<?= get_stylesheet_directory_uri(); ?>/dist/images/logo-en.svg" alt="<?php bloginfo('name'); ?> | <?php bloginfo('description'); ?>">
                            <?php break; ?>
                            <?php case 'de_AT' : ?>
                            <img class="brand__fulllogo" src="<?= get_stylesheet_directory_uri(); ?>/dist/images/logo-de.svg" alt="<?php bloginfo('name'); ?> | <?php bloginfo('description'); ?>">
                            <?php break; ?>
                            <?php case 'sk_SK' : ?>
                            <img class="brand__fulllogo" src="<?= get_stylesheet_directory_uri(); ?>/dist/images/orientdecor.svg" alt="<?php bloginfo('name'); ?> | <?php bloginfo('description'); ?>">
                            <?php break; default: ?>
                            <img class="brand__fulllogo" src="<?= get_stylesheet_directory_uri(); ?>/dist/images/logo.svg" alt="<?php bloginfo('name'); ?> | <?php bloginfo('description'); ?>">
                            <?php } ?>
                        </a>
                    </div>
                    <nav class="banner__nav show-for-medium">
                        <?php get_template_part('templates/mainmenu'); ?>
                        <?php
                            // if (has_nav_menu('primary_navigation')) {
                            //     wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'menu menu--main', 'items_wrap' => '<ul class="%2$s">%3$s</ul>']);
                            // }
                        ?>
                    </nav>
                </div>
                <div class="cell shrink">
                    <div class="banner__actions">
                        <a class="banner__actions__search js_searchstarter" href="#">
                            <?= svginsert('search', 'icon'); ?>
                        </a>
                        <?php if ( defined( 'YITH_WCWL' ) ) : ?>
                            <a class="banner__actions__wishlist" href="<?= YITH_WCWL()->get_wishlist_url(); ?>">
                                <?= svginsert('heart-outline', 'icon'); ?>
                                <span class="badge"><?= YITH_WCWL()->count_all_products(); ?></span>
                            </a>
                        <?php endif; ?>
                        <a class="banner__actions__cart" href="<?= get_permalink( wc_get_page_id( 'cart' ) ) ?>">
                            <?= svginsert('cart', 'icon'); ?>
                            <?= marrakesh_cartcount(); ?>
                        </a>

                    </div>
                </div>
                <div class="shrink cell hide-for-medium">
                    <button class="menutoggler" type="button" data-toggle="mobilemodal"></button>
                </div>
            </div>
        </div>
    </div>
    <?php get_template_part('templates/megasearch'); ?>
</header>

<?php
    if (!is_archive()) {
        do_action( 'marrakesh_after_banner');
    }
?>
