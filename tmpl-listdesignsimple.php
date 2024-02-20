<?php
/**
 * Template Name: Design Lister (Original)
 */
?>
<?php use Roots\Sage\Titles; ?>
<?php global $sitepress; ?>
<?php
    // var_dump($currentterm);
    $allstyles = get_terms( 'pa_style', array() );
?>
<?php while (have_posts()) : the_post(); ?>
<div class="masthead">
    <div class="grid-container">
        <div class="grid-x grid-margin-x align-right">
            <div class="cell tablet-9">
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
            if ( !( $mastheadbg = get_field('masthead-bg') ) )  {
                $mastheadbg = get_field('mhbg', 'option');
            };
            echo wp_get_attachment_image( $mastheadbg['ID'], 'xlarge' );
        ?>
    </figure>
</div>
<?php //var_dump($origstyletermid); ?>

<div class="grid-container">
    <div class="grid-x grid-margin-x">
        <div class="cell tablet-9 tablet-order-2">
            <div class="ps ps--narrow">
                <ul class="refcatcardgrid">
                    <?php foreach ( $allstyles as $child ) : ?>
                    <li>
                        <?php $origstyleid = apply_filters( 'wpml_object_id', $child->term_id, 'pa_style', TRUE, $sitepress->get_default_language() ); ?>
                        <div class="refcatcard">
                            <a class="refcatcard__fulllink"
                                href="<?= get_term_link($origstyleid, 'pa_style'); ?>">
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
        <div class="cell tablet-3 tablet-order-1">
            <div class="ps ps--narrow">
                <aside class="sidebar sidebar--page">
                    <?php dynamic_sidebar('sidebar-page'); ?>
                </aside>
            </div>
        </div>
    </div>
</div>
<?php endwhile; ?>
