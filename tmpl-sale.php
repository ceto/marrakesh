<?php
/**
 * Template Name: Sale Products List
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
        <div class="cell tablet-9 tablet-order-2">
            <div class="ps ps--narrow">
                <div class="bodycopy">
                    <?php if (has_excerpt()) : ?>
                    <div class="lead"><?php the_excerpt(); ?></div>
                    <?php endif; ?>
                    <?php the_content(); ?>
                </div>

                <section>
                    <?php $thesalequery = new WP_Query(array(
                        'post_status' => 'publish',
                        'post_type' => array('product'),
                        'posts_per_page' => -1,
                        'meta_query'     => array(
                            'relation' => 'OR',
                            array( // Simple products type
                                'key'           => '_sale_price',
                                'value'         => 0,
                                'compare'       => '>',
                                'type'          => 'numeric'
                            ),
                            array( // Variable products type
                                'key'           => '_min_variation_sale_price',
                                'value'         => 0,
                                'compare'       => '>',
                                'type'          => 'numeric'
                            )
                        )
                    ));
                    $products = $thesalequery->get_posts();
                    ?>
                    <?php if ($products) :?>
                    <ul class="prodgrid prodgrid--narrow">
                        <?php foreach ( $products as $related_product ) : ?>
                        <?php
                            $post_object = get_post( $related_product );
                            setup_postdata( $GLOBALS['post'] =& $post_object );
                            wc_get_template_part( 'content', 'product' );
                        ?>
                        <?php endforeach; wp_reset_postdata(); ?>
                    </ul>
                    <?php endif; ?>

                </section>

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