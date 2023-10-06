<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width">
    <link type="image/x-icon" href="/favicon.ico" rel="icon"> <!-- icon show on web title -->
    <link type="image/x-icon" href="/favicon.ico" rel="shortcut icon" />

    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <!-- B--- phan cho bootstrap -->
    <link href="//www.google-analytics.com" rel="dns-prefetch">

    <link href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" rel="shortcut icon">
    <link href="<?php echo get_template_directory_uri(); ?>/images/touch.png" rel="apple-touch-icon-precomposed">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="3CFT6aP41yw0zYmOmbqUHSdWgHrzXvuCl7phgyCHLLk" />
    <!-- E --- phan bootstrap ------------->
    <!--[if lt IE 9]>
        <script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/html5.js"></script>
        <![endif]-->
    <!-- them jquery tu google    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> -->
    <meta name="geo.region" content="VN" />
    <meta name="geo.position" content="10.725377;106.720064" />
    <meta name="ICBM" content="10.725377, 106.720064" />
    <?php // suite_seo(); 
    ?>
    <?php wp_head(); ?>


    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-89258261-1', 'auto');
        ga('send', 'pageview');
    </script>
</head>

<body <?php body_class(); ?>>
<?php get_template_part('template/template', 'header'); ?>