<?php
/**
 * Template Name: Full Width Page With No Sidebar
 */
?>
<?php use Roots\Sage\Titles; ?>
<?php while (have_posts()) : the_post(); ?>
<div class="masthead">
    <div class="grid-container">
        <div class="grid-x grid-margin-x">
            <div class="cell">
                <h1 class="page__title"><?= Titles\title(); ?></h1>
            </div>
        </div>
    </div>
    <figure class="masthead__bg">
        <img src="https://source.unsplash.com/1600x400/?interior,marrakesh,arab" alt="">
    </figure>
</div>

<div class="grid-container ps ps--narrow">
    <div class="grid-x grid-margin-x">
        <div class="cell">
            <?php if (has_excerpt()) : ?>
            <div class="lead"><?php the_excerpt(); ?></div>
            <?php endif; ?>
            <?php the_content(); ?>
            <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
        </div>
    </div>
</div>
<?php endwhile; ?>