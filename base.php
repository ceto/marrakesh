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
    <?php if ( is_post_type_archive('reference')) : ?>
        <script type='text/javascript'>
            function writeCanonical() {
                let urlParam = window.location.hash;
                var hashparts=urlParam.split('=');
                //console.log(hashparts);
                if (hashparts.length>1) {
                    var link = document.querySelector('link[rel=canonical]'); // get the link element
                    var ogurl = document.querySelector('meta[property="og:url"]');
                    if (hashparts['1']!=='*') {
                        link.setAttribute('href', '//' + location.host + '/references/' + hashparts['1']+'/');
                        ogurl.setAttribute('content', '//' + location.host + '/references/' + hashparts['1']+'/');
                    } else {
                        link.setAttribute('href', '//' + location.host + location.pathname );
                        ogurl.setAttribute('content', '//' + location.host + location.pathname );
                    }
                }
            };
            window.addEventListener("hashchange", writeCanonical(), false );
        </script>
        <?php endif; ?>
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
    <?php get_template_part('templates/svg','icons'); ?>
    <?php wp_footer(); ?>
  </body>
</html>
