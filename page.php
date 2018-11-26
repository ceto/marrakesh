<?php use Roots\Sage\Titles; ?>
<?php while (have_posts()) : the_post(); ?>
    <div class="ps ps--black ps--narrow">
        <div class="grid-container">
            <div class="grid-x grid-margin-x align-right">
                <div class="cell tablet-9 xxlarge-10">
                    <h1 class="page__title"><?= Titles\title(); ?></h1>
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid-container">
        <div class="grid-x grid-margin-x">
            <div class="cell tablet-9 xlarge-10 tablet-order-2">
                <div class="ps ps--narrow">
                    <?php if (has_excerpt()) : ?>
                            <div class="lead"><?php the_excerpt(); ?></div>
                    <?php endif; ?>
                    <?php the_content(); ?>
                    <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
                </div>
            </div>
            <div class="cell tablet-3 xlarge-2 tablet-order-1">
                <div class="ps ps--narrow">
                    <aside class="sidebar sidebar--page">
                        <?php dynamic_sidebar('sidebar-page'); ?>
                    </aside>
                </div>
            </div>
        </div>
    </div>
<?php endwhile; ?>
