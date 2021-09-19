<?php get_template_part('templates/page', 'header'); ?>
<div class="ps ps--xlight">
    <div class="grid-container">
        <div class="alert alert-warning">
            <p class="lead"><?php _e('Bocsánat, a keresett oldal nem található.', 'marrakesh'); ?></p>
            <p>
                <a href="<?= esc_url(home_url('/')); ?>" class="button"><?php _e('Újrakezdem a főoldalról.', 'marrakesh'); ?></a>
                vagy
                <a href="<?= get_permalink( wc_get_page_id( 'shop' ) ) ?>" class="button accent"><?php _e('Ugrom a termékekre', 'marrakesh'); ?></a>

            </p>
        </div>
    </div>
</div>

