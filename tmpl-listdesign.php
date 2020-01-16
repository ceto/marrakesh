<?php
/**
 * Template Name: Design Lister Page
 */
?>
<?php use Roots\Sage\Titles; ?>



<?php
  $allstylegroups = get_terms(array(
    'taxonomy' => 'pa_design',
    'hide_empty' => false,
  ));
//   var_dump($allstylegroups);
  $child_terms = get_terms( 'pa_design', array(/*'child_of' => $parent_term->term_id */) );
//var_dump($child_terms);

?>
<?php while (have_posts()) : the_post(); ?>
<div class="masthead">
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
                <?php if (has_excerpt()) : ?>
                <div class="lead"><?php the_excerpt(); ?></div>
                <?php endif; ?>
                <?php the_content(); ?>
                <ul class="tmplcardgrid">
                    <?php foreach ( $child_terms as $child ) : ?>
                    <li>
                        <div class="tmplcard">
                            <a class="tmplcard__fulllink" href="<?php echo get_term_link( $child->term_id); ?>">
                                <?php if ($designthumb = get_field('covera', $child) ) : ?>
                                <?= wp_get_attachment_image( $designthumb['id'], 'large', false, array('class'=>'tmplcard__thumb', 'alt'=>$child->name) ); ?>
                                <?php else : ?>
                                <img src="//placehold.it/768x768/cecece/333333/?text=<?= $child->name;?>"
                                    class="tmplcard__thumb" alt="<?= $child->name;?>">
                                <?php endif; ?>
                                <?php if (($coverb = get_field('coverb', $child)) || true) : ?>
                                <?= wp_get_attachment_image( $coverb['id'], 'large', false, array('class'=>'tmplcard__thumb variant', 'alt'=>$child->name) ); ?>
                                <?php endif; ?>
                                <h3 class="tmplcard__name"><?= $child->name;?></h3>
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