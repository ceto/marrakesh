<?php use Roots\Sage\Titles; ?>
<?php while (have_posts()) : the_post(); ?>
    <aside class="hero">
        <figure class="hero__fig">
            <?php if ( get_field('heroimg') ) :?>
                    <?php $image =  get_field('heroimg'); s?>
                    <?= wp_get_attachment_image( $image[ID], 'full' ) ?>
                <?php else: ?>
                    <img class="hero__img" src="https://source.unsplash.com/1600x900/?interior,tiles,marrakesh,arab" alt="<?php the_title(); ?>">
                <?php endif; ?>
        </figure>

            <div class="hero__content">
                <p class="hero__precapt">Lorem ipsum dolor sit amet</p>
                <h3 class="hero__caption">Handmade Cement Tiles</h3>
                <p class="hero__postcapt">Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Donec sed odio dui.</p>
                <a href="<?= get_permalink( woocommerce_get_page_id( 'shop' ) ) ?>" class="hero__action">Browse Collection</a> <a href="<?= get_post_type_archive_link('reference') ?>" class="hero__action hollow">Get Inspiration</a>
            </div>

    </aside>
    
    <div class="grid-container">
        <div class="grid-x grid-margin-x">
            <div class="cell large-auto large-order-2">
                <div class="ps ps--narrow">
                    <?php if (has_excerpt()) : ?>
                            <div class="lead"><?php the_excerpt(); ?></div>
                    <?php endif; ?>
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
<?php endwhile; ?>
