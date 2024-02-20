<?php
/**
 * Template Name: Design Lister Page
 */
?>
<?php use Roots\Sage\Titles; ?>
<?php global $sitepress; ?>
<?php
    $currentterm = get_term_by('slug', $_REQUEST['pa_style'],'pa_style');
    $origstyletermid = apply_filters( 'wpml_object_id', $currentterm->term_id, 'pa_style', TRUE, $sitepress->get_default_language() );

    // var_dump($currentterm);
    $allstyles = get_terms( 'pa_style', array() );
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
            if ( !( $mastheadbg = get_field('masthead-bg', 'pa_style_'.$origstyletermid) ) )  {
                $mastheadbg = get_field('mhbg', 'option');
            };
            echo wp_get_attachment_image( $mastheadbg['ID'], 'xlarge' );
         ?>
    </figure>
</div>
<?php //var_dump($origstyletermid); ?>

<?php if(!$currentterm) : ?>
<div class="grid-container">
    <div class="grid-x grid-margin-x align-center">
        <div class="cell xlarge-10">
            <div class="ps ps--narrow">
                <ul class="refcatcardgrid">
                    <?php foreach ( $allstyles as $child ) : ?>
                    <li>
                        <?php $origstyleid = apply_filters( 'wpml_object_id', $child->term_id, 'pa_style', TRUE, $sitepress->get_default_language() ); ?>
                        <div class="refcatcard">
                            <a class="refcatcard__fulllink"
                                href="<?php the_permalink(); ?>?pa_style=<?= $child->slug; ?>">
                                <?php if ($designthumb = get_field('cover', 'pa_style' . '_' . $origstyleid) ) : ?>
                                <?= wp_get_attachment_image( $designthumb['id'], 'large', false, array('class'=>'refcatcard__thumb', 'alt'=>$child->name) ); ?>
                                <?php else : ?>
                                <img class="refcatcard__img"
                                    src="//placehold.it/768x768/cecece/333333/?text=<?= $child->name;?>"
                                    class="refcatcard__thumb" alt="<?= $child->name;?>">
                                <?php endif; ?>
                                <h3 class="refcatcard__name">
                                <?= $child->name; ?>
                                <?php //printf( __( '%s minták', 'marrakesh' ), $child->name); ?>
                                <?= svginsert('gallery', 'icon'); ?>
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
                                    <?= svginsert('caret-left', 'icon'); ?>  <?= __('Vissza a stílus választóhoz','marrakesh') ?>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="touchhint">
    <?= svginsert('swipehorizontal', 'icon'); ?>
    <span><?= __('Swipe for details', 'marrakesh'); ?></span>
</div>
<?php
    $designterms = get_terms( array(
        'taxonomy' => 'pa_design',
        // 'hide_empty' => false,
    ));
?>
<div class="grid-container">
    <div class="grid-x grid-margin-x align-center">
        <div class="cell xlarge-10">
            <div class="ps ps--narrow ps--notop">
                <ul class="tmplcardgrid">
                    <?php foreach ( $designterms as $child ) : ?>
                    <?php $origchildid = apply_filters('wpml_object_id', $child->term_id, $child->taxonomy, TRUE, $sitepress->get_default_language() ); ?>
                    <?php if ( in_array( $origstyletermid, get_field('style', 'pa_design_'.$origchildid) ) ) : ?>
                    <li>
                        <div class="tmplcard">
                            <a class="tmplcard__fulllink" href="<?php echo get_term_link( $child->term_id); ?>">
                                <?php if ($designthumb = get_field('covera', 'pa_design_'.$origchildid) ) : ?>
                                <?= wp_get_attachment_image( $designthumb['id'], 'large', false, array('class'=>'tmplcard__thumb', 'alt'=>$child->name) ); ?>
                                <?php else : ?>
                                <img src="//placehold.it/768x768/cecece/333333/?text=<?= $child->name;?>"
                                    class="tmplcard__thumb" alt="<?= $child->name;?>">
                                <?php endif; ?>
                                <?php if ($coverb = get_field('coverb', 'pa_design_'.$origchildid)) : ?>
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
