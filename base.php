<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

?>

<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>

    <!--[if IE]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->
    <?php
      do_action('get_header');
      get_template_part('templates/header');
    ?>
    <div class="document" role="document">
        <main class="main" role="main">
          <?php include Wrapper\template_path(); ?>
        </main><!-- /.main -->
    </div><!-- /.document -->
    <?php
      do_action('get_footer');
      get_template_part('templates/footer');
      get_template_part('templates/mobilemodal');
    ?>
    <div style="height: 0; width: 0; position: absolute; visibility: hidden; overflow: hidden;">
    <?php echo file_get_contents( get_stylesheet_directory().'/dist/images/svg-icons.svg'); ?>
    </div>
    <?php wp_footer(); ?>
  </body>
</html>
