<div class="reveal mobilemodal" id="mobilemodal" data-reveal data-animation-in="scale-in-down fast"
    data-animation-out="scale-out-up fast">

    <div class="mobilemodal__inner">
        <nav class="mobilemodal__mainnav">
            <a class="mobilemodal__brand <?= get_locale(); ?>" href="<?= esc_url(home_url('/')); ?>">
                <?php switch( get_locale() ) {
                        case 'sk_SK' : ?>
                <img src="<?= get_stylesheet_directory_uri(); ?>/dist/images/orientdecor.svg"
                    alt="<?php bloginfo('name'); ?> | <?php bloginfo('description'); ?>">
                <?php break; default: ?>
                <img src="<?= get_stylesheet_directory_uri(); ?>/dist/images/logo.svg"
                    alt="<?php bloginfo('name'); ?> | <?php bloginfo('description'); ?>">
                <?php } ?>
            </a>
            <?php
                if (has_nav_menu('primary_navigation')) :
                wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'menu accordion-menu menu--mobilemain', 'items_wrap' => '<ul class="%2$s" data-accordion-menu>%3$s</ul>']);
                endif;
            ?>
        </nav>
        <!-- <a href="#" target="_blank" class="mobilemodal__designer button alert small hollow">Tervezőprogram</a> -->
    </div>
    <nav class="mobilemodal__secondarynav">
        <?php
                if (has_nav_menu('secondary_navigation')) :
                wp_nav_menu(['theme_location' => 'secondary_navigation', 'menu_class' => 'menu menu--mobilesecondary align-center ahorizontal', 'items_wrap' => '<ul class="%2$s">%3$s</ul>']);
                endif;
            ?>
        <button class="mobilemodal__close" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </nav>

</div>