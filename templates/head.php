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

    <link rel="canonical" href="<?= $current_url; ?>">
    <meta property="og:url" content="<?= $current_url; ?>" />


    <?php wp_head(); ?>
</head>
