<?php while (have_posts()) : the_post(); ?>
<article <?php post_class(); ?>>
    <div class="grid-container">
        <header>
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php get_template_part('templates/entry-meta'); ?>
        </header>
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
        <?php if ( $gallery = get_field('gallery') ): ?>
        <div class="psgallery thumbswipe thumbswipe--nopadding thumbswipe--medium">
            <?php if ( has_post_thumbnail() ) :?>
            <figure class="thumbswipe__item psgallery__item" itemprop="associatedMedia" itemscope
                itemtype="http://schema.org/ImageObject">
                <a href="<?php $targimg = wp_get_attachment_image_src(get_post_thumbnail_id(),'full'); echo $targimg[0];?>"
                    data-size="<?= $targimg['1'].'x'.$targimg['2']; ?>">
                    <?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'medium' ); ?>
                </a>
            </figure>
            <?php endif; ?>
            <?php foreach( $gallery as $image ): ?>
            <figure class="thumbswipe__item psgallery__item" itemprop="associatedMedia" itemscope
                itemtype="http://schema.org/ImageObject">
                <a href="<?php $targimg = wp_get_attachment_image_src($image,'full'); echo $targimg[0];?>"
                    data-size="<?= $targimg['1'].'x'.$targimg['2']; ?>">
                    <?php echo wp_get_attachment_image( $image, 'medium' ); ?>
                </a>
            </figure>
            <?php endforeach; ?>
        </div>
        <?php get_template_part('templates/photoswipedom'); ?>
        <?php endif; ?>
        <footer>
            <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
        </footer>
        <?php //comments_template('/templates/comments.php'); ?>
    </div>
</article>
<?php endwhile; ?>
