<?php
/**
 * Template Name: Design Lister Page
 */
?>
<?php use Roots\Sage\Titles; ?>



<?php
    $currentterm = get_term_by('slug', $_REQUEST['pa_style'],'pa_style');
    // var_dump($currentterm);

    $allstyles = get_terms( 'pa_style', array() );
    // var_dump($allstyles);


    $child_terms = get_terms( 'pa_design', array(
        /*'child_of' => $parent_term->term_id */
    ) );

?>
<?php while (have_posts()) : the_post(); ?>
<div class="masthead">
    <div class="grid-container">
        <div class="grid-x grid-margin-x align-center">
            <div class="cell xlarge-10 text-center">
                <?php if (FALSE && ($localnav = get_field('localnav') )) :  ?>
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
                <h1 class="page__title"><?php  echo Titles\title(); echo $currentterm?': '.$currentterm->name:''; ?>
                </h1>
            </div>
        </div>
    </div>
    <figure class="masthead__bg">
        <?php
            if ( !( $mastheadbg = get_field('masthead-bg',$currentterm) ) )  {
                $mastheadbg = get_field('mhbg', 'option');
            };
            echo wp_get_attachment_image( $mastheadbg['ID'], 'xlarge' );
         ?>
    </figure>
</div>
<?php if(!$currentterm) : ?>
<div class="grid-container">
    <div class="grid-x grid-margin-x align-center">
        <div class="cell xlarge-10">
            <div class="ps ps--narrow">
                <ul class="refcatcardgrid">
                    <?php foreach ( $allstyles as $child ) : ?>
                    <li>
                        <div class="refcatcard">
                            <a class="refcatcard__fulllink"
                                href="<?php the_permalink(); ?>?pa_style=<?= $child->slug; ?>">
                                <?php if ($designthumb = get_field('cover', $child) ) : ?>
                                <?= wp_get_attachment_image( $designthumb['id'], 'large', false, array('class'=>'refcatcard__thumb', 'alt'=>$child->name) ); ?>
                                <?php else : ?>
                                <img class="refcatcard__img"
                                    src="//placehold.it/768x768/cecece/333333/?text=<?= $child->name;?>"
                                    class="refcatcard__thumb" alt="<?= $child->name;?>">
                                <?php endif; ?>
                                <h3 class="refcatcard__name">
                                <?php printf( __( '%s minták', 'marrakesh' ), $child->name); ?>
                                <svg class="icon"><use xlink:href="#icon-gallery"></use></svg>
                                </h3>
                            </a>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div id="thestickynav" class="localnav sticky-container" data-sticky-container>
    <div class="sticky localnav__top" data-sticky data-stick-to="top" data-margin-top="0" data-margin-bottom="0"
        data-sticky-on="small">
        <div class="grid-container">
            <div class="grid-x grid-margin-x">
                <div class="cell">
                    <nav class="portfolionav">
                        <ul class="menu amenu--portfolio menu--local align-center">
                            <li class="menu-all">
                                <a href="<?php the_permalink() ?>">
                                    <svg class="icon">
                                        <use xlink:href="#icon-caret-left"></use>
                                    </svg> <?= __('Vissza a stílus választóhoz','marrakesh') ?>
                                </a>
                            </li>
                            <?php foreach( $allstyles as $refcat ): ?>
                            <!-- <li><a
                                    href="<?php the_permalink(); ?>?pa_style=<?= $refcat->slug; ?>"><?= $refcat->name ?></a>
                            </li> -->
                            <?php endforeach; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="grid-container">
    <div class="grid-x grid-margin-x align-center">
        <div class="cell xlarge-10">
            <div class="ps ps--narrow ps--notop">
                <!-- <?php if (has_excerpt()) : ?>
                <div class="lead"><?php the_excerpt(); ?></div>
                <?php endif; ?>
                <?php the_content(); ?> -->
                <ul class="tmplcardgrid">
                    <?php foreach ( $child_terms as $child ) : ?>
                    <?php if ( get_field('style', $child) && in_array( $currentterm->term_id, get_field('style', $child) ) ) : ?>
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
                    <?php endif; ?>
                    <?php endforeach;  ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>
<?php endwhile; ?>
