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
    <?php if ( !current_user_can( 'manage_options' ) ) : ?>
    <!-- Hotjar Tracking Code for https://marrakeshcementlap.hu -->
    <script>
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:1706309,hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
    </script>
    <!-- Global site tag (gtag.js) - Google Ads: 734728363 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-734728363"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'AW-734728363');
        gtag('config', 'UA-3523093-7');
    </script>
    <?php endif; ?>
</head>
