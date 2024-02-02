<?php
/**
 * Template Name: Icon Reference Page
 */
?>
<?php use Roots\Sage\Titles; ?>
<?php while (have_posts()) : the_post(); ?>
<?php get_template_part('templates/page-header'); ?>
<div class="pagewrap">
    <ul class="densegrid">
        <?php foreach (glob(get_stylesheet_directory().'/assets/iconcollection/*.svg') as $filename) :?>
            <li>
                <div class="ircard">
                    <a href="<?= get_stylesheet_directory_uri().'/assets/iconcollection/'.basename($filename); ?>" download><?php echo svginsert(basename($filename,'.svg'), 'ircard__icon'); ?></a>
                    <h6 class="ircard__name"><?= basename($filename,'.svg'); ?></h6>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endwhile; ?>
