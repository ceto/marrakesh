<?php use Roots\Sage\Titles; ?>
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
                            <?php the_post_thumbnail('medium_large'); ?>
                        </a>
                    </figure>
                    <div class="squarepromo__content">
                        <h3 class="squarepromo__caption">
                            <a href="<?php the_sub_field('btntarget'); ?>">
                                <?php the_sub_field('title'); ?>
                            </a>
                        </h3>
                        <?php the_sub_field('text'); ?>
                        <a href="<?php the_sub_field('btntarget'); ?>" class="squarepromo__readmore button small"><?php the_sub_field('btntext'); ?></a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
<?php endif; ?>


<div class="ps ps--xlight ps--bordered">
    <div class="grid-container">
        <div class="grid-x grid-margin-x align-center text-center">
            <div class="cell tablet-8 large-6">
                <h3>Some featured information goes here</h3>
                <div class="lead">
                    <p>Lorem ipsum dolor doloribus archi sit amet. doloribus architecto repudiandae consectetur dolore,
                        corporis amet abidu cement eius totam magnam minima nobis suscipit delectus</p>
                    <a href="#" class="button">Click to see details</a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- <div class="ps aps--xlight ps--bordered">
    <div class="grid-container">
        <div class="grid-x grid-margin-x">
            <div class="cell tablet-8 large-6">
                <h2>Lorem ipsum dolor sit amet.</h2>
                <div class="lead">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex facere voluptas fuga voluptatem
                        fugiat aspernatur cupiditate doloribus architecto repudiandae consectetur dolore, corporis amet
                        eius totam magnam minima nobis suscipit delectus!</p>
                </div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim excepturi error explicabo
                    nesciunt, magni aut sint animi quia reprehenderit iure libero illum similique ipsam,
                    praesentium veniam deleniti optio facilis eius.</p>
                <a href="#" class="button small">Learn more</a>
            </div>
            <div class="cell tablet-4 large-6">
                <img src="https://source.unsplash.com/1200x600/?tiles,marrakesh,arab" alt="">
            </div>
        </div>
    </div>
</div> -->

<div class="ps aps--bordered">
    <div class="grid-container">
        <div class="grid-x grid-margin-x">
            <div class="cell text-center">
                <h2><?php _e('Products Recommended', 'marrakesh');?></h2>
                <ul id="featprodtabs" class="tabs tabs--singleproduct" data-active-collapse="true" data-deep-link="true"
                    data-update-history="true" data-deep-link-smudge="true" data-deep-link-smudge-delay="500" data-tabs>
                    <li class="tabs-title is-active">
                        <a href="#fpfeatpanel" aria-selected="true">
                            <?php esc_html_e( 'Featured Tiles', 'marrakesh' ); ?>
                        </a>
                    </li>
                    <li class="tabs-title">
                        <a href="#fpinstockpanel">
                            <?php esc_html_e( 'In Stock', 'marrakesh' ) ?>
                        </a>
                    </li>
                    <li class="tabs-title">
                        <a href="#fpsalepanel">
                            <?php esc_html_e( 'Sale', 'marrakesh' ); ?>
                        </a>
                    </li>
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
        <div class="tabs-panel is-active" id="fpfeatpanel">
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
        </div>
        <div class="tabs-panel" id="fpinstockpanel">
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
        </div>
        <div class="tabs-panel" id="fpsalepanel">
            <?php
                the_widget( 'WC_Widget_Products', array(
                        'title' => '',
                        'number' => '15',
                        'show' => 'onsale'
                    ), $wargs );
                ?>
        </div>
    </div>
</div>

<!-- <div class="grid-container">
    <div class="grid-x grid-margin-x">
        <div class="cell large-auto large-order-2">
            <div class="ps ps--narrow">
                <?php if (has_excerpt()) : ?>
                <div class="lead"><?php the_excerpt(); ?></div>
                <?php endif; ?>
                <div class="lead">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur sit eaque architecto
                        molestiae rem dolor quis temporibus sequi atque odio possimus dolores, consequatur a
                        nesciunt
                        maxime. Earum illum excepturi optio.</p>
                </div>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Optio, vel tempore unde omnis nemo
                    ullam,
                    illum, quos eius voluptatem quidem rem. Maxime excepturi aliquid eum voluptatibus harum!
                    Repudiandae, nisi eaque?</p>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iusto voluptates, error ipsum quis
                    nostrum
                    culpa odio. Corrupti quasi magni officiis consequatur ipsam magnam odit, nesciunt quidem minima
                    tempore iste expedita?</p>
                <?php the_content(); ?>
                <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
            </div>
        </div>
        <div class="cell large-3 large-order-1">
            <div class="ps ps--narrow">
                <aside class="sidebar sidebar--page">
                    <?php dynamic_sidebar('sidebar-page'); ?>
                </aside>
            </div>
        </div>
    </div>
</div> -->
<?php
    $args = array(
        'post_type' => array('reference'),
        'order'               => 'ASC',
        'orderby'             => 'menu_order',
        'posts_per_page'         => 10,
        // 'tax_query' => array(
        //     array(
        //         'taxonomy' => 'department',
        //         'field'    => 'term_id',
        //         'terms'    => $department->term_id,
        //     ),
        // ),
    );
    $the_featrefs = new WP_Query( $args );
?>
<div class="ps ps--bordered ps--xlight">
    <div id="homerefs" class="agrid-container homerefs">
        <div class="grid-x grid-margin-x text-center">
            <div class="cell">
                <h2><?php _e('Cement Tiles in Action', 'marrakesh');?></h2>
                <p class="lead">See our engaging reference</p>
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
                <a href="<?= get_post_type_archive_link( 'reference' ); ?>" class="button">Show all references</a>
            </div>
        </div>

    </div>
</div>
<?php get_template_part( 'templates/photoswipedom'); ?>

<?php endwhile; ?>
