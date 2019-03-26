<?php use Roots\Sage\Titles; ?>
<?php while (have_posts()) : the_post(); ?>
<div class="agrid-container">
    <aside class="hero">
        <figure class="hero__fig">
            <?php if ( get_field('heroimg') ) :?>
            <?php $image =  get_field('heroimg'); s?>
            <?= wp_get_attachment_image( $image[ID], 'full' ) ?>
            <?php else: ?>

            <img class="hero__img"
                src="https://riad-dbe0.kxcdn.com/wp-content/uploads/2019/01/home-banner-jan-2019-1.jpg"
                alt="<?php the_title(); ?>">

            <!-- <img class="hero__img" src="https://source.unsplash.com/1600x900/?interior,tiles,marrakesh,arab"
            alt="<?php the_title(); ?>"> -->
            <?php endif; ?>
        </figure>

        <div class="hero__content grid-container">
            <p class="hero__precapt">Lorem ipsum dolor sit amet</p>
            <h3 class="hero__caption">Handmade Cement Tiles</h3>
            <p class="hero__postcapt">Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut
                fermentum
                massa justo sit amet risus. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
            <a href="<?= get_permalink( woocommerce_get_page_id( 'shop' ) ) ?>" class="hero__action">Browse
                Collection</a>
            <a href="<?= get_post_type_archive_link('reference') ?>" class="hero__action hollow">Get Inspiration</a>
        </div>

    </aside>
</div>
<div class="ps">
    <div class="grid-container">
        <div class="grid-x grid-margin-x medium-up-2 large-up-3">
            <div class="cell">
                <h3>Lorem ipsum dolor sit.</h3>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis animi aliquam, inventore pariatur
                    odit
                    dolores quae at molestiae, commodi, sint amet provident illum expedita aperiam quasi molestias
                    ducimus
                    veniam tenetur?</p>
                <a href="#" class="button small">Learn more</a>
            </div>
            <div class="cell">
                <h3>Isum dolor sit.</h3>
                <p>
                    Amet consectetur adipisicing elit. Omnis animi aliquam, inventore pariatur
                    odit
                    dolores quae at molestiae, commodi, sint amet provident illum expedita aperiam quasi molestias
                    ducimus
                    veniam tenetur?</p>
                <a href="#" class="button small">Browse in-stock tiles</a>
            </div>
            <div class="cell">
                <h3>Lorem ipsum dolor sit amet.</h3>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis animi aliquam, inventore pariatur
                    odit
                    dolores quae at molestiae, commodi, sint amet provident illum expedita aperiam quasi molestias
                    ducimus
                    veniam tenetur?</p>
                <a href="#" class="button small">Go to collection</a>
            </div>
        </div>
    </div>
</div>
<div class="ps ps--narrow ps--xlight ps--bordered">
    <div class="grid-container">
        <div class="grid-x grid-margin-x">
            <div class="cell">
                <h3><?php _e('Featured Products', 'marrakesh');?></h3>
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

<div class="grid-container">
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
</div>
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
<div class="ps aps--bordered aps--xlight">
    <div id="homerefs" class="agrid-container homerefs">
        <div class="agrid-x agrid-margin-x">
            <div class="acell">
                <section id="referenceswipe" class="referenceswipe" itemscope itemtype="http://schema.org/ImageGallery">

                    <?php while ($the_featrefs->have_posts()) : $the_featrefs->the_post(); ?>
                    <?php setup_postdata( $post ); ?>
                    <div <?php reffilter_class('referenceswipe__item'); ?>>
                        <?php get_template_part('templates/referencecard-fixheight'); ?></div>
                    <?php endwhile; ?>
                </section>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    </div>
</div>
<?php get_template_part( 'templates/photoswipedom'); ?>

<?php endwhile; ?>