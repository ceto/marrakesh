<?php global $product_id, $cats, $datafromprod; ?>
<div class="singleproduct__details">
    <h3><?= __('Tudnivalók', 'marrakesh'); ?></h3>
    <?php if (!get_page_template_slug($product_id)) : ?>
        <?php if ($catdescr=term_description(end($cats))) : ?>
            <?= $catdescr; ?>
        <?php endif; ?>
    <?php endif; ?>
    <?php the_content(); ?>
    <?php
        if (get_field('showsimulator', $product_id)==true) {
            get_template_part('templates/simulatorcta');
        }
    ?>
    <?php

        $datapostobject = get_post( $datafromprod['_linfopage'] );
        setup_postdata( $GLOBALS['post'] =& $datapostobject );
        get_template_part('templates/accordioncage');
        get_template_part('templates/dlcage');
        wp_reset_postdata();
    ?>
    <p>
        <?= __('További információk és részletes termék ismertetők az','marrakesh'); ?> <a href="<?php the_permalink(get_field('pageforinfohelp', 'option')) ?>"><?= __('Info &amp; Segítség oldalon.','marrakesh'); ?></a>
    </p>


</div>
