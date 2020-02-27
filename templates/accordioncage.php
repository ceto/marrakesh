<?php if ( have_rows('accordion') ): ?>
<ul class="accordion" data-accordion data-allow-all-closed="true">
    <?php while( have_rows('accordion') ): the_row(); ?>
    <li class="accordion-item" data-accordion-item>
        <a href="#<?= sanitize_title(get_sub_field('title')); ?>" class="accordion-title"><?php the_sub_field('title'); ?></a>
        <div id="<?= sanitize_title(get_sub_field('title')); ?>" class="accordion-content" data-tab-content>
            <div class="bodycopy small">
                <?php the_sub_field('content'); ?>
            </div>
        </div>
    </li>
    <?php endwhile; ?>
</ul>
<?php endif; ?>
