<?php
    $pcats = array(
        '39' => 'Cementlap',
        '40' => 'Terrazzo',
        '421' => 'Falicsempe',
        '710' => 'Kerámia padlólap'
    );
?>
<ul id="menu-main-menu" class="mainmenu">
    <?php foreach ($pcats as $pcatid => $pcatname) :?>
    <li class="menu-item menu-item-has-children menu-pcat-<?= $pcatid ?>">
        <a href="<?= get_term_link($pcatid); ?>"><?= $pcatname; ?></a>
        <nav class="mega">
            <div class="mega__menu">
                <h3 class="widget__title large"><?= $pcatname; ?></h3>
                <ul class="sub-menu">
                    <li><a href="<?= add_query_arg(array('browse'=>'1','filter_availability'=>'in_stock'), get_term_link( $pcatid )); ?>"><?php _e('Készletről azonnal', 'marrakesh'); ?></a></li>
                    <li><a href="<?= add_query_arg(array('browse'=>'1','filter_cs'=>'1'), get_term_link( $pcatid )); ?>"><?php _e('Hamarosan érkezik', 'marrakesh'); ?></a></li>
                    <li><a href="<?= add_query_arg(array('browse'=>'1','filter_onsale'=>'1'), get_term_link( $pcatid )); ?>"><?php _e('Akciós termékek', 'marrakesh'); ?></a></li>
                    <?php
                        $dtype = get_term_meta( intval($pcatid), 'display_type' );
                        if ( $dtype[ 0 ] === 'subcategories' ) : ?>
                        <li><a href="<?= get_term_link($pcatid); ?>"><?php _e('Kollekciók', 'marrakesh'); ?></a></li>
                    <?php endif; ?>
                </ul>
                <br>
                <?php
                    if ( $dtype[ 0 ] === 'subcategories' ) : ?>
                    <a class="button accent small" href="<?= add_query_arg(array('browse'=>'1'), get_term_link( $pcatid )); ?>"><?php _e('Mutasd mindet', 'marrakesh'); ?></a>
                <?php else: ?>
                <a class="button accent small" href="<?= get_term_link( $pcatid ); ?>"><?php _e('Mutasd mindet', 'marrakesh'); ?></a>
                <?php endif; ?>
            </div>
            <div class="mega__content wide">
                <div class="grid-x grid-margin-x small-up-2 medium-up-3 large-up-4">
                    <?php if ( ($termsa = marrakesh_get_atts_for_product_category($pcatid, $attr="style")) || ($termsb = marrakesh_get_atts_for_product_category($pcatid, $attr="suit")) ) : ?>
                    <div class="cell">
                        <?php if ($termsa) : ?>
                        <section class="widget">
                            <h3 class="widget__title"><?= __('Stílus', 'marrakesh'); ?></h3>
                            <ul class="menu vertical">
                                <?php foreach ($termsa as $term) : ?>
                                    <li><a href="<?= add_query_arg(array('browse'=>'1','filter_style'=>$term->slug), get_term_link( $pcatid )); ?>"><?= $term->name; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </section>
                        <?php endif; ?>
                        <?php $termsb = marrakesh_get_atts_for_product_category($pcatid, $attr="suit"); ?>
                        <?php if ($termsb) : ?>
                        <section class="widget">
                            <h3 class="widget__title"><?= __('Alkalmazás', 'marrakesh'); ?></h3>
                            <ul class="menu vertical">
                                <?php foreach ($termsb as $term) : ?>
                                    <li><a href="<?= add_query_arg(array('browse'=>'1','filter_suit'=>$term->slug), get_term_link( $pcatid )); ?>"><?= $term->name; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </section>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <?php $terms = marrakesh_get_atts_for_product_category($pcatid, $attr="color"); ?>
                    <?php if ($terms) : ?>
                    <section class="cell widget">
                        <h3 class="widget__title"><?= __('Színek', 'marrakesh'); ?></h3>
                        <ul class="menu vertical">
                            <?php foreach ($terms as $term) : ?>
                                <li><a href="<?= add_query_arg(array('browse'=>'1','filter_color'=>$term->slug), get_term_link( $pcatid )); ?>"><?= $term->name; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </section>
                    <?php endif; ?>
                    <?php /* $terms = marrakesh_get_atts_for_product_category($pcatid, $attr="meret"); ?>
                    <?php if ($terms) : ?>
                    <section class="cell widget">
                        <h3 class="widget__title"><?= __('Méret', 'marrakesh'); ?></h3>
                        <ul class="menu vertical">
                            <?php foreach ($terms as $term) : ?>
                                <li><a href="<?= add_query_arg(array('browse'=>'1','filter_meret'=>$term->slug), get_term_link( $pcatid )); ?>"><?= $term->name; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </section>
                    <?php endif; */?>
                    <?php if ( ($termsa = marrakesh_get_atts_for_product_category($pcatid, $attr="felulet")) || ($termsb = marrakesh_get_atts_for_product_category($pcatid, $attr="pattern")) ) : ?>
                    <div class="cell">
                        <?php if ($termsa) : ?>
                        <section class="widget">
                            <h3 class="widget__title"><?= __('Felület', 'marrakesh'); ?></h3>
                            <ul class="menu vertical">
                                <?php foreach ($termsa as $term) : ?>
                                    <li><a href="<?= add_query_arg(array('browse'=>'1','filter_felulet'=>$term->slug), get_term_link( $pcatid )); ?>"><?= $term->name; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </section>
                        <?php endif; ?>
                        <?php $termsb = marrakesh_get_atts_for_product_category($pcatid, $attr="pattern"); ?>
                        <?php if ($termsb) : ?>
                        <section class="widget">
                            <h3 class="widget__title"><?= __('Mintázat', 'marrakesh'); ?></h3>
                            <ul class="menu vertical">
                                <?php foreach ($termsb as $term) : ?>
                                    <li><a href="<?= add_query_arg(array('browse'=>'1','filter_pattern'=>$term->slug), get_term_link( $pcatid )); ?>"><?= $term->name; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </section>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <?php $terms = marrakesh_get_atts_for_product_category($pcatid, $attr="shape"); ?>
                    <?php if ($terms) : ?>
                    <section class="cell widget">
                        <h3 class="widget__title"><?= __('Forma', 'marrakesh'); ?></h3>
                        <ul class="menu vertical">
                            <?php foreach ($terms as $term) : ?>
                                <li><a href="<?= add_query_arg(array('browse'=>'1','filter_shape'=>$term->slug), get_term_link( $pcatid )); ?>"><?= $term->name; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </section>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </li>
    <?php endforeach; ?>
</ul>
