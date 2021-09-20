<?php
/**
 * Template Name: Narrow Page With No Sidebar
 */
?>
<?php use Roots\Sage\Titles; ?>
<?php while (have_posts()) : the_post(); ?>
<div class="masthead">
    <div class="grid-container">
        <div class="grid-x grid-margin-x align-center">
            <div class="cell tablet-10 large-9 xlarge-7">
                <h1 class="page__title"><?= Titles\title(); ?></h1>
            </div>
        </div>
    </div>
    <figure class="masthead__bg">
        <?php
        if ( !( $mastheadbg = get_field('masthead-bg') ) )  {
            $mastheadbg = get_field('mhbg', 'option');
        };
            echo wp_get_attachment_image( $mastheadbg['ID'], 'xlarge' );
         ?>
    </figure>
</div>
<?php do_action( 'marrakesh_after_masthead'); ?>
<div class="grid-container ps ps--narrow">
    <div class="grid-x grid-margin-x align-center">
        <div class="cell tablet-10 large-9 xlarge-7">
            <?php if (has_excerpt()) : ?>
            <div class="lead"><?php the_excerpt(); ?></div>
            <?php endif; ?>
            <?php the_content(); ?>
            <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
        </div>
    </div>
</div>
<?php endwhile; ?>
