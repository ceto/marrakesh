<?php
/**
 * Template Name: Reference Category Lister Page
 */
?>
<?php use Roots\Sage\Titles; ?>



<?php

  $child_terms = get_terms( array(
        'taxonomy' => 'reference-type',
        'hide_empty' => false,
        'meta_query' => array(
            'position_clause' => array(
                'key' => 'order',
                'value' => 0,
                'compare' => '>='
            ),
            // 'relation' => 'AND',
        ),
        'orderby' => 'position_clause',
        'order' =>  'ASC'
    ));

?>
<?php while (have_posts()) : the_post(); ?>
<div class="masthead">
    <div class="grid-container">
        <div class="grid-x grid-margin-x align-center">
            <div class="cell xlarge-10 text-center">
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

<div class="grid-container">
    <div class="grid-x grid-margin-x align-center">
        <div class="cell xlarge-10">
            <div class="ps ps--narrow">
                <!-- <?php if (has_excerpt()) : ?>
                <div class="lead"><?php the_excerpt(); ?></div>
                <?php endif; ?>
                <?php the_content(); ?> -->
                <ul class="refcatcardgrid">
                    <?php foreach ( $child_terms as $child ) : ?>
                    <li>
                        <div class="refcatcard">
                            <a class="refcatcard__fulllink" href="<?php echo get_term_link( $child->term_id); ?>">
                                <?php if ($designthumb = get_field('cover', $child) ) : ?>
                                <?= wp_get_attachment_image( $designthumb['id'], 'large', false, array('class'=>'refcatcard__thumb', 'alt'=>$child->name) ); ?>
                                <?php else : ?>
                                <img class="refcatcard__img"
                                    src="//placehold.it/768x768/cecece/333333/?text=<?= $child->name;?>"
                                    class="refcatcard__thumb" alt="<?= $child->name;?>">
                                <?php endif; ?>
                                <h3 class="refcatcard__name"><?= $child->name;?></h3>
                            </a>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php endwhile; ?>
