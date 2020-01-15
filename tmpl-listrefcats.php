<?php
/**
 * Template Name: Reference Category Lister Page
 */
?>
<?php use Roots\Sage\Titles; ?>



<?php
  $allstylegroups = get_terms(array(
    'taxonomy' => 'reference-type',
    'hide_empty' => false,
  ));
//   var_dump($allstylegroups);
  $child_terms = get_terms( 'reference-type', array(/*'child_of' => $parent_term->term_id */) );
//var_dump($child_terms);

?>
<?php while (have_posts()) : the_post(); ?>
<div class="masthead">
    <div class="grid-container">
        <div class="grid-x grid-margin-x align-center">
            <div class="cell large-9 xxlarge-9 text-center">
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
    <div class="grid-x grid-margin-x">
        <div class="cell">
            <div class="ps ps--narrow">
                <!-- <?php if (has_excerpt()) : ?>
                <div class="lead"><?php the_excerpt(); ?></div>
                <?php endif; ?>
                <?php the_content(); ?> -->
                <section class="grid-x grid-margin-x grid-margin-y small-up-2 large-up-3">
                    <?php foreach ( $child_terms as $child ) : ?>
                    <div class="cell">
                        <div class="refcatcard">
                            <a class="refcatcard__fulllink" href="<?php echo get_term_link( $child->term_id); ?>">
                                <?php if ($designthumb = get_field('thumbnail', $child) ) : ?>
                                <?= wp_get_attachment_image( $designthumb['id'], 'large', false, array('class'=>'refcatcard__thumb', 'alt'=>$child->name) ); ?>
                                <?php else : ?>
                                <img class="refcatcard__img"
                                    src="//placehold.it/768x768/cecece/333333/?text=<?= $child->name;?>"
                                    class="refcatcard__thumb" alt="<?= $child->name;?>">
                                <?php endif; ?>
                                <h3 class="refcatcard__name"><?= $child->name;?></h3>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </section>
            </div>
        </div>
    </div>
</div>
<?php endwhile; ?>
