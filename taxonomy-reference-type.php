<?php use Roots\Sage\Titles; ?>

<?php
    $heroratio=33.333333;
    $category = get_queried_object();
?>

<div class="masthead">
    <div class="grid-container">
        <div class="grid-x grid-margin-x align-center text-center">
            <div class="cell large-9">
                <h1 class="page__title"><?= __('Galéria','marrakesh') ?>: <?= $category->name; ?></h1>
                <!-- <div class="lead">
                    <?php echo apply_filters( 'content', get_the_archive_description('Lorem')); ?>
                </div> -->
            </div>
        </div>
    </div>
    <figure class="masthead__bg">
        <?php
        if ( !( $mastheadbg = get_field('masthead-bg',$category) ) )  {
            $mastheadbg = get_field('mhbg', 'option');
        };
            echo wp_get_attachment_image( $mastheadbg['ID'], 'xlarge' );
         ?>
    </figure>
</div>
<?php
    $refcats = get_terms( array(
        'taxonomy' => 'reference-type',
        //'hide_empty' => false,
    ) );
?>

<div id="thestickynav" class="localnav sticky-container" data-sticky-container>
    <div class="sticky localnav__top" data-sticky data-stick-to="top" data-top-anchor="refiwrap" data-margin-top="0"
        data-margin-bottom="0" data-sticky-on="small">
        <div class="grid-container">
            <div class="grid-x grid-margin-x">
                <div class="auto cell">
                    <nav class="portfolionav">
                        <ul class="menu amenu--portfolio ajs-activate-filter menu--local align-center">
                            <li class="menu-all">
                                <a href="<?php the_permalink(get_field('pageforgallery', 'option')) ?>">
                                    <?= svginsert('caret-left', 'icon'); ?> <?= __('Vissza a galériákhoz','marrakesh') ?>
                                </a>
                            </li>
                            <?php foreach( $refcats as $refcat ): ?>
                            <!-- <li><a href="<?= get_term_link( $refcat->term_id) ?>"><?= $refcat->name ?></a></li> -->
                            <?php endforeach; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="refiwrap" class="grid-container refiwrap">
    <div class="grid-x grid-margin-x">
        <div class="cell">
            <section id="referencegrid" class="referencegrid" itemscope itemtype="http://schema.org/ImageGallery">
                <?php $piter=0; ?>
                <?php while (have_posts()) : the_post(); ?>
                <div <?php reffilter_class('referencegrid__item'); ?>>
                    <?php get_template_part('templates/referencecard'); ?></div>
                <?php endwhile; ?>
            </section>
            <!-- <nav id="referencegrid__next" class="masonrynext ps text-center">
                <?php next_posts_link( __('See More','brick'), 0 ); ?>
            </nav> -->
        </div>
    </div>
</div>

<?php get_template_part( 'templates/photoswipedom'); ?>
