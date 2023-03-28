<?php
//global $wp;
$current_url = home_url( add_query_arg( array(), $wp->request ) );
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link
        href='https://fonts.googleapis.com/css?family=Alegreya+Sans:100,300,400,700,900,400italic&display=swap&subset=latin-ext'
        rel='stylesheet' type='text/css'>
    <link rel="icon" type="image/png" href="<?= get_stylesheet_directory_uri(); ?>/dist/images/favicon/favicon.png">
    <link rel="apple-touch-icon" href="<?= get_stylesheet_directory_uri(); ?>/dist/images/favicon/apple-touch-icon.png">

    <link rel="canonical" href="<?= $current_url; ?>">
    <meta property="og:url" content="<?= $current_url; ?>" />
    <?php wp_head(); ?>
    <?php if ( !current_user_can( 'manage_options' ) && (ENV=='production')) : ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-N5DS238');</script>
    <!-- End Google Tag Manager -->
    <?php endif; ?>
</head>
