<?php
    $pcats = array(
        '39' => 'Cementlap',
        '40' => 'Terazzo',
        '421' => 'Falicsmepe',
        '710' => 'Kerámia padlólap',
        '828' => 'Márvány'
    );
?>
<ul id="menu-main-menu" class="mainmenu">
    <?php foreach ($pcats as $pcatid => $pcatname) :?>
    <li class="menu-item menu-item-has-children menu-pcat-<?= $pcatid ?>">
        <a href="<?= get_term_link($pcatid); ?>"><?= $pcatname; ?></a>
        <nav class="mega">
            <div class="mega__menu">
                <h3><?= $pcatname; ?></h3>
                <ul class="sub-menu">
                    <li><a href="<?= add_query_arg(array('browse'=>'1','filter_availability'=>'in_stock'), get_term_link( $pcatid )); ?>"><?php _e('Készletről azonnal', 'marrakesh'); ?></a></li>
                    <li><a href="<?= add_query_arg(array('browse'=>'1','filter_cs'=>'1'), get_term_link( $pcatid )); ?>"><?php _e('Hamarosan érkezik', 'marrakesh'); ?></a></li>
                    <li><a href="<?= get_term_link($pcatid); ?>"><?php _e('Kollekciók', 'marrakesh'); ?></a></li>
                    <li><a href="<?= add_query_arg(array('browse'=>'1'), get_term_link( $pcatid )); ?>"><?php _e('Mutasd mindet', 'marrakesh'); ?></a></li>
                </ul>
            </div>
            <div class="mega__content wide">
                <ul class="grid-x grid-margin-x small-up-2 medium-up-3 large-up-4">
                    <?php $terms = marrakesh_get_atts_for_product_category($pcatid, $attr="style"); ?>
                    <?php if ($terms) : ?>
                    <section class="cell widget">
                        <h3 class="widget__title"><?= __('Stílus', 'marrakesh'); ?></h3>
                        <ul class="menu vertical">
                            <?php foreach ($terms as $term) : ?>
                                <li><a href="<?= add_query_arg(array('browse'=>'1','filter_style'=>$term->slug), get_term_link( $pcatid )); ?>"><?= $term->name; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </section>
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
                    <?php $terms = marrakesh_get_atts_for_product_category($pcatid, $attr="suit"); ?>
                    <?php if ($terms) : ?>
                    <section class="cell widget">
                        <h3 class="widget__title"><?= __('Alkalmazás', 'marrakesh'); ?></h3>
                        <ul class="menu vertical">
                            <?php foreach ($terms as $term) : ?>
                                <li><a href="<?= add_query_arg(array('browse'=>'1','filter_suit'=>$term->slug), get_term_link( $pcatid )); ?>"><?= $term->name; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </section>
                    <?php endif; ?>
                    <?php $terms = marrakesh_get_atts_for_product_category($pcatid, $attr="felulet"); ?>
                    <?php if ($terms) : ?>
                    <section class="cell widget">
                        <h3 class="widget__title"><?= __('Felület', 'marrakesh'); ?></h3>
                        <ul class="menu vertical">
                            <?php foreach ($terms as $term) : ?>
                                <li><a href="<?= add_query_arg(array('browse'=>'1','filter_felulet'=>$term->slug), get_term_link( $pcatid )); ?>"><?= $term->name; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </section>
                    <?php endif; ?>
                    <?php $terms = marrakesh_get_atts_for_product_category($pcatid, $attr="pattern"); ?>
                    <?php if ($terms) : ?>
                    <section class="cell widget">
                        <h3 class="widget__title"><?= __('Mintázat', 'marrakesh'); ?></h3>
                        <ul class="menu vertical">
                            <?php foreach ($terms as $term) : ?>
                                <li><a href="<?= add_query_arg(array('browse'=>'1','filter_pattern'=>$term->slug), get_term_link( $pcatid )); ?>"><?= $term->name; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </section>
                    <?php endif; ?>
                </ul>


            </div>
        </nav>
    </li>
    <?php endforeach; ?>
</ul>
