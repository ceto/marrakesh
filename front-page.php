<?php use Roots\Sage\Titles; ?>
<?php global $woocommerce; ?>
<?php while (have_posts()) : the_post(); ?>

<?php if( have_rows('hero') ): ?>
<?php while( have_rows('hero') ): the_row(); ?>
<aside class="hero">
    <figure class="hero__fig">
        <?php if ( !($bgimage = get_sub_field('bgimage')) ) {
            $bgimage = get_field('mhbg', 'option');
        } ?>
        <?= wp_get_attachment_image( $bgimage[ID], 'full' ) ?>
    </figure>
    <div class="hero__content grid-container">
        <p class="hero__precapt"><?php the_sub_field('precapt'); ?></p>
        <h3 class="hero__caption"><?php the_sub_field('caption'); ?></h3>
        <p class="hero__postcapt"><?php the_sub_field('postcapt'); ?></p>
        <a href="<?php the_sub_field('ctatarget'); ?>" class="hero__action"><?php the_sub_field('ctatext'); ?></a>
    </div>
</aside>
<?php endwhile; ?>
<?php endif; ?>


<?php if( have_rows('promotions') ): ?>
<div class="ps">
    <div class="grid-container">
        <div class="grid-x grid-margin-x grid-margin-y medium-up-2 large-up-3">
            <?php while( have_rows('promotions') ): the_row(); ?>
            <div class="cell">
                <div class="squarepromo">
                    <figure class="squarepromo__thumb">
                        <a href="<?php the_sub_field('btntarget'); ?>">
                            <?php
                            if ( !( $image = get_sub_field('image') ) )  {
                                $image = get_field('mhbg', 'option');
                            };
                                echo wp_get_attachment_image( $image['ID'], 'medium_large' );
                            ?>
                        </a>
                    </figure>
                    <div class="squarepromo__content">
                        <h3 class="squarepromo__caption">
                            <a href="<?php the_sub_field('btntarget'); ?>">
                                <?php the_sub_field('title'); ?>
                            </a>
                        </h3>
                        <?php the_sub_field('text'); ?>
                        <a href="<?php the_sub_field('btntarget'); ?>"
                            class="squarepromo__readmore button small"><?php the_sub_field('btntext'); ?></a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php
    $args = array(
        'post_type' => array('reference'),
        'order'               => 'ASC',
        'orderby'             => 'menu_order',
        'posts_per_page'         => 10,
        'meta_query' => array(
            array(
                'key' => 'featured',
                'value'    => 1,
                'compare'    => '=',
            ),
        ),
    );
    $the_featrefs = new WP_Query( $args );
?>
<div class="ps ps--bordered ps--xlight">
    <div id="homerefs" class="agrid-container homerefs">
        <div class="grid-x grid-margin-x text-center">
            <div class="cell">
                <h2><?php _e('Kézműves cementlapok bevetésen', 'marrakesh');?></h2>
                <p class="lead">
                    <?php _e('Számos belső enteriőr ékessége az általunk gyártott cementlap.', 'marrakesh');?>
                </p>
                <br>
            </div>
        </div>
        <section id="referenceswipe" class="referenceswipe" itemscope itemtype="http://schema.org/ImageGallery">

            <?php while ($the_featrefs->have_posts()) : $the_featrefs->the_post(); ?>
            <?php setup_postdata( $post ); ?>
            <div <?php reffilter_class('referenceswipe__item'); ?>>
                <?php get_template_part('templates/referencecard-fixheight'); ?></div>
            <?php endwhile; ?>
        </section>
        <?php wp_reset_postdata(); ?>
        <div class="grid-x grid-margin-x text-center">
            <div class="cell">
                <br><br>
                <a href="<?php the_permalink(get_field('pageforgallery', 'option')) ?>"
                    class="button small"><?php _e('Tovább a tematikus galériákhoz', 'marrakesh'); ?></a>
            </div>
        </div>

    </div>
</div>
<?php get_template_part( 'templates/photoswipedom'); ?>


<div class="ps aps--bordered">
    <div class="grid-container">
        <div class="grid-x grid-margin-x">
            <div class="cell text-center">
                <h2><?php _e('A kínálatunkból', 'marrakesh');?>&hellip;</h2>
                <ul id="featprodtabs" class="tabs tabs--singleproduct" data-active-collapse="true" data-tabs>
                    <li class="tabs-title is-active">
                        <a href="#fpinstockpanel">
                            <?php esc_html_e( 'Raktárról azonnal', 'marrakesh' ) ?>
                        </a>
                    </li>
                    <li class="tabs-title">
                        <a href="#fpfeatpanel" aria-selected="true">
                            <?php esc_html_e( 'Kiemelt lapok', 'marrakesh' ); ?>
                        </a>
                    </li>
                    <!-- <li class="tabs-title">
                        <a href="#fpsalepanel">
                            <?php esc_html_e( 'Akciós', 'marrakesh' ); ?>
                        </a>
                    </li> -->
                </ul>
            </div>
        </div>
    </div>
    <?php
        $wargs = array(
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '',
            'after_title'   => ''
        );
    ?>
    <div class="tabs-content" data-tabs-content="featprodtabs">
        <div class="tabs-panel is-active" id="fpinstockpanel">
            <?php
                the_widget( 'WC_Widget_Products', array(
                    'title' => '',
                    'number' => 10,
                    'show' => '',
                    'orderby' => 'date',
                    'order' => 'DESC'

                ), $wargs );
                wp_cache_flush();
            ?>
            <br><br>
            <p class="text-center">
                <a href="<?= get_permalink( woocommerce_get_page_id( 'shop' ) ); ?>?filter_availability=in_stock"
                    class="button small">Ugrás a
                    raktárkészletre</a>
            </p>

        </div>
        <div class="tabs-panel" id="fpfeatpanel">
            <?php
                the_widget( 'WC_Widget_Products', array(
                    'title' => '',
                    'number' => 12,
                    'show' => '',
                    'orderby' => 'rand',
                    'order' => 'ASC'

                ), $wargs );
                wp_cache_flush();
            ?>
            <br><br>
            <p class="text-center">
                <a href="<?= get_permalink( woocommerce_get_page_id( 'shop' ) ); ?>" class="button small">További lapok
                    böngészése</a>

        </div>
        <!-- <div class="tabs-panel" id="fpsalepanel">
            <?php /*
                the_widget( 'WC_Widget_Products', array(
                        'title' => '',
                        'number' => '15',
                        'show' => 'onsale'
                    ), $wargs );
                    wp_cache_flush();
                    */
                ?>
        </div> -->
    </div>
</div>


<section class="widepromo">
    <div class="grid-container">
        <div class="grid-x grid-margin-x grid-margin-y align-middle align-justify">
            <div class="cell tablet-8 large-6 xlarge-5">
                <h3 class="widepromo__title"><?php the_field('widepromotitle', 'option') ?></h3>
                <div class="widepromo__text">
                    <?php the_field('widepromotext', 'option') ?>
                </div>
            </div>
            <div class="cell tablet-4 large-6 xlarge-7 tablet-text-right">
                <a href="<?php the_field('widepromotarget', 'option')?>" class="button accent">
                    <?php the_field('widepromocta', 'option') ?>
                </a>
            </div>
        </div>
    </div>
    <figure class="widepromo__bg">
        <?php
        if ( $widepromobg = get_field('widepromobg', 'option') )  {
            echo wp_get_attachment_image( $widepromobg['ID'], 'xlarge' );
        };
        ?>
    </figure>

</section>


<div class="ps ps--xlight ps--bordered">
    <div class="grid-container">
        <div class="grid-x grid-margin-x align-middle align-justify">
            <div class="cell tablet-6 large-5">
                <h2>Élőben még szebb. Látogass el bemutatótermünkbe!</h2>
                <div class="lead">
                    <p>Ugorj be hozzánk egy kávéra a Bródy 34-be. Testközelből megtapasztalhatod a
                        cementlapok izgalmas világát. Továbbá nagyon sok hasznos információval segítünk a
                        választásban.</p>
                </div>
                <a href="<?php the_permalink(get_field('pageforcontact', 'option')) ?>"
                    class="button small">Bemutatóterem és nyitvatartás</a>
            </div>
            <div class="cell tablet-6 large-6">
                <a href="<?php the_permalink(get_field('pageforcontact', 'option')) ?>">
                    <img src="<?= get_stylesheet_directory_uri() ?>/dist/images/bemutatoterem_resized.jpg"
                        alt="Bemutatóterem a Bródyban">
                </a>
            </div>
        </div>
    </div>
</div>

<?php endwhile; ?>