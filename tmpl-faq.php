<?php
/**
 * Template Name: Help/FAQ Template
 */
?>
<?php use Roots\Sage\Titles; ?>
<?php while (have_posts()) : the_post(); ?>
<div class="masthead">
    <div class="grid-container">
        <div class="grid-x grid-margin-x aalign-center">
            <div class="cell large-10 xlarge-8 xxlarge-7">
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

<div class="grid-container ps ps--narrow">
    <div class="grid-x grid-margin-x aalign-center">
        <div class="cell large-10 xlarge-8 xxlarge-7">
            <?php if (has_excerpt()) : ?>
            <div class="lead"><?php the_excerpt(); ?></div>
            <br>
            <?php endif; ?>
            <?php if (have_rows('toc')) :  ?>
            <?php
                $wargs = array(
                    'before_widget' => '<section class="cell widget widget--sidebar %1$s">',
                    'after_widget'  => '</section>',
                    'before_title'  => '<h3 class="widget__title">',
                    'after_title'   => '</h3>'
                );
            ?>
            <div class="grid-x grid-margin-x grid-padding-y medium-up-2 tablet-up-3">
                <?php while( have_rows('toc') ) : the_row(); ?>
                <div class="cell">
                    <?php
                            $currmenu = get_sub_field('menu');
                            $themenu = wp_get_nav_menu_object($currmenu);

                            the_widget( 'WP_Nav_Menu_Widget', array(
                                'title' => get_sub_field('title')?get_sub_field('title'):$themenu->name,
                                'nav_menu' => $currmenu
                            ), $wargs );
                        ?>
                </div>
                <?php endwhile; ?>
            </div>
            <?php endif; ?>
            <hr>
            <?php the_content(); ?>

        </div>
    </div>
</div>
<?php endwhile; ?>