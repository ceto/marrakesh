<?php
    global $piter;
?>
<article <?php post_class('referencecard referencecard--fixheight'); ?>>
    <header class="referencecard__header">
        <?php
            $ratio=56.25;
            $psattr='data-size="1600x900';
            if (has_post_thumbnail()) {
                $featimage['ID'] = get_post_thumbnail_id();
                $titi=wp_get_attachment_image_src( $featimage['ID'], 'medium_large');
                $ratio = $titi[2] / $titi[1] * 100;
                $targimage = wp_get_attachment_image_src( $featimage['ID'], 'xlarge' );
                $psattr = 'data-imagetarget="'.$targimage[0].'" data-size="'.$targimage['1'].'x'.$targimage['2'].'"';
            }

            if( $video=get_field('video') ) {
                $psattr .= ' data-type="video"';
                $psattr .= " data-video='". brick_the_vimeoembed( $video, 'pl-'.sanitize_title( get_the_title() ) ) . "'";
            }

        ?>
        <figure class="referencecard__figure" style="/* padding-bottom: <?= $ratio ?>%*/" itemscope
            itemtype="http://schema.org/ImageObject">

            <?php
            $layout = get_field('layout');

            switch ($layout) {
                case 'download':
                   $attachment = get_field('attachment');
                   $psattr .= ' data-type="download"';
                   $psattr .= ' data-attachment="'.$attachment['url'].'"';

                   echo '<a target="_blank" href="'.$attachment['url'].'" '.$psattr.'>';
                break;

                case 'reference':
                    $url = get_field('url');
                    $psattr .= ' data-type="reference"';
                    $psattr .= ' data-url="'.$url.'"';

                    echo '<a target="_blank" href="'.$url.'" '.$psattr.'>';
                break;

                default:
                    # code...
                    echo '<a href="'.get_the_permalink().'" '.$psattr.'>';
                break;
            }

        ?>



            <?php the_post_thumbnail('medium_large'); ?>
            <?php if( $video=get_field('video') ): ?>
            <?= svginsert('play-color', 'icon'); ?>
            <?php endif; ?>
            </a>
        </figure>
        <?php if ( get_field('layout') == 'download' ): ?>
        <p class="referencecard__label referencecard__label--fileinfo">
            <span
                class="referencecard__label__extension"><?= pathinfo($attachment['filename'], PATHINFO_EXTENSION); ?></span>
            | <span
                class="referencecard__label__size"><?= size_format(filesize(get_attached_file($attachment['ID']))) ?></span>
        </p>
        <h2 class="referencecard__title">
            <a target="_blank" href="<?= $attachment['url'] ?>"><?php the_title(); ?></a>
        </h2>
        <?php elseif ( get_field('layout') == 'reference' ) : ?>
        <p class="referencecard__label"><?= svginsert('external-link', 'icon'); ?></p>
        <h2 class="referencecard__title">
            <a target="_blank" href="<?= $url ?>"><?php the_title(); ?></a>
        </h2>
        <?php else :?>
        <h2 class="referencecard__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php endif; ?>
        <?php if ( $quickinfo=get_post_meta( get_the_id(), 'quickinfo', true ) ) :?>
        <p class="referencecard__quickinfo"><?= $quickinfo ?></p>
        <?php endif; ?>
    </header>
</article>
