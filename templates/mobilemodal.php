<?php
    $pcats = array(
        '39' => 'Cementlap',
        '40' => 'Terrazzo',
        '421' => 'Falicsempe',
        '710' => 'Kerámia padlólap'
    );
?>
<div class="reveal mobilemodal" id="mobilemodal" data-reveal data-animation-in="scale-in-down fast"
    data-animation-out="scale-out-up fast">

    <div class="mobilemodal__inner">
        <nav class="mobilemodal__mainnav">
            <a class="mobilemodal__brand <?= get_locale(); ?>" href="<?= esc_url(home_url('/')); ?>">
                <?php switch( get_locale() ) {
                case 'en_US' : ?>
                    <img src="<?= get_stylesheet_directory_uri(); ?>/dist/images/logo-en.svg" alt="<?php bloginfo('name'); ?> | <?php bloginfo('description'); ?>">
                <?php break; ?>
                <?php case 'de_DE' : ?>
                    <img src="<?= get_stylesheet_directory_uri(); ?>/dist/images/logo-de.svg" alt="<?php bloginfo('name'); ?> | <?php bloginfo('description'); ?>">
                <?php break; ?>
                <?php case 'sk_SK' : ?>
                <img src="<?= get_stylesheet_directory_uri(); ?>/dist/images/orientdecor.svg" alt="<?php bloginfo('name'); ?> | <?php bloginfo('description'); ?>">
                <?php break; default: ?>
                <img src="<?= get_stylesheet_directory_uri(); ?>/dist/images/logo.svg" alt="<?php bloginfo('name'); ?> | <?php bloginfo('description'); ?>">
                <?php } ?>
            </a>

            <ul class="menu accordion-menu menu--mobilemain" data-accordion-menu>
                <?php foreach ($pcats as $pcatid => $pcatname) :?>
                <li class="menu-item menu-item-has-children menu-pcat-<?= $pcatid ?>">
                    <a href="<?= get_term_link($pcatid); ?>"><?= $pcatname; ?></a>
                    <ul class="sub-menu">
                        <li><a href="<?= add_query_arg(array('browse'=>'1','filter_availability'=>'in_stock'), get_term_link( $pcatid )); ?>"><?php _e('Készletről azonnal', 'marrakesh'); ?></a></li>
                        <li><a href="<?= add_query_arg(array('browse'=>'1','filter_cs'=>'1'), get_term_link( $pcatid )); ?>"><?php _e('Hamarosan érkezik', 'marrakesh'); ?></a></li>
                        <li><a href="<?= add_query_arg(array('browse'=>'1','filter_onsale'=>'1'), get_term_link( $pcatid )); ?>"><?php _e('Akciós termékek', 'marrakesh'); ?></a></li>
                        <?php
                            //$dtype = get_term_meta( intval($pcatid), 'display_type' );
                            //if ( $dtype[ 0 ] === 'subcategories' ) : ?>
                            <li><a href="<?= get_term_link($pcatid); ?>"><?php _e('Kollekciók', 'marrakesh'); ?></a></li>
                        <?php //endif; ?>
                        <?php if ( true || ($dtype[ 0 ] === 'subcategories') ) : ?>
                            <li><a class="button hollow tiny" href="<?= add_query_arg(array('browse'=>'1'), get_term_link( $pcatid )); ?>"><?php _e('Mutasd mindet', 'marrakesh'); ?></a></li>
                        <?php else: ?>
                            <li><a class="button hollow tiny" href="<?= get_term_link( $pcatid ); ?>"><?php _e('Mutasd mindet', 'marrakesh'); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endforeach; ?>
            </ul>






        </nav>

    </div>
    <nav class="mobilemodal__secondarynav">
        <?php
                if (has_nav_menu('secondary_navigation')) :
                wp_nav_menu([
                    'theme_location' => 'secondary_navigation',
                    'menu_class' => 'menu menu--mobilesecondary align-center ahorizontal',
                    'items_wrap' => '<ul class="%2$s">%3$s</ul>']);
                endif;
            ?>
        <button class="mobilemodal__close" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </nav>

</div>
