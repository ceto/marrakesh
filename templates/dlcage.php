<?php if ( have_rows('downloads') ): ?>
<div class="dlbox">
    <h3 class="dlbox__title"><?php _e('Letölthető anyag(ok)', 'marrakesh'); ?></h3>
    <ul class="dlcage">
        <?php while( have_rows('downloads') ): the_row();
                    $file = get_sub_field('attachment');
                ?>
        <li class="dlcage__item">
            <span class="dlcage__item__title"><a href="<?= $file['url']; ?>"><?= $file['title']; ?></a></span>
            <span class="dlcage__item__fileinfo">
                <span class="dlcage__item__extension"><?= pathinfo($file['filename'], PATHINFO_EXTENSION); ?></span>,
                <span class="dlcage__item__size"><?= size_format(filesize(get_attached_file($file['ID']))) ?></span>
            </span>
            <a class="dlcage__item__action" download href="<?= $file['url']; ?>"><?php _e('Letöltés', 'marrakesh'); ?>&nbsp;<?= svginsert('download', 'icon'); ?></a>
        </li>
        <?php endwhile; ?>
    </ul>
</div>
<?php endif; ?>
