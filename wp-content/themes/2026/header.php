<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <!-- [15/06/2026] Khắc phục chất lượng mã nguồn: Loại bỏ thẻ title cứng để sử dụng add_theme_support('title-tag') và hợp nhất viewport -->
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- 2026-07-29: Preload font Outfit Latin (self-hosted) để trình duyệt tải song song với HTML.
         Tránh việc phải chờ CSS parse xong mới phát hiện font → giảm LCP ~200-300ms.
         crossorigin bắt buộc vì font được tải bằng anonymous CORS request. -->
    <link rel="preload"
          href="<?php echo esc_url( get_template_directory_uri() ); ?>/style/fonts/outfit-latin.woff2"
          as="font"
          type="font/woff2"
          crossorigin>

    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <link href="//www.google-analytics.com" rel="dns-prefetch">

    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico?v=2" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico?v=2" type="image/x-icon">

    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/touch.png?v=2">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
   
    <meta name="google-site-verification" content="Y-oXHA_6B0gaudFE2Mghki7C-mDqtdEPCewvobHM_lU" />
 
    <meta name="geo.region" content="VN" />
    <meta name="geo.position" content="10.725377;106.720064" />
    <meta name="ICBM" content="10.725377, 106.720064" />
    <?php // suite_seo(); 
    ?>


    <?php wp_head(); ?>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-Z3304RSFQ8"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-Z3304RSFQ8');
    </script>

</head>

<body <?php body_class(); ?>>
    <?php get_template_part('template/template', 'header'); ?>