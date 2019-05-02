<?php use Roots\Sage\Titles; ?>
<?php while (have_posts()) : the_post(); ?>
<div class="ps ps--black ps--narrow">
    <div class="grid-container">
        <div class="grid-x grid-margin-x align-right">
            <div class="cell large-9 xxlarge-9">
                <?php if ($localnav = get_field('localnav')) :  ?>
                <?php
                        $themenu = wp_get_nav_menu_object($localnav);
                        $menuitems = wp_get_nav_menu_items($localnav);
                    ?>
                <select class="taxchooser" name="taxchooser" id="taxchooser"
                    onChange="window.location.href=this.value;">
                    <option value="#" disabled><?= $themenu->name; ?>&hellip;</option>
                    <?php foreach( $menuitems as $item ): ?>
                    <option value="<?= $item->url ?>" <?= ($item->url==get_permalink())?'selected':'';  ?>>
                        <?= $item->title ?></option>
                    <?php endforeach; ?>
                </select>
                <a class="js-taxchooserstart"><?= $themenu->name; ?> &#9662;</a>
                <?php endif; ?>
                <h1 class="page__title"><?= Titles\title(); ?></h1>
            </div>
        </div>
    </div>
</div>

<div class="grid-container">
    <div class="grid-x grid-margin-x">
        <div class="cell tablet-9 xlarge-7 xxlarge-6 tablet-order-2">
            <div class="ps ps--narrow">
                <?php if (has_excerpt()) : ?>
                <div class="lead"><?php the_excerpt(); ?></div>
                <?php endif; ?>
                <?php the_content(); ?>
                <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
            </div>
        </div>
        <div class="cell tablet-3 xxlarge-3 tablet-order-1">
            <div class="ps ps--narrow">
                <aside class="sidebar sidebar--page">
                    <?php dynamic_sidebar('sidebar-page'); ?>
                </aside>
            </div>
        </div>
    </div>
</div>
<?php endwhile; ?>