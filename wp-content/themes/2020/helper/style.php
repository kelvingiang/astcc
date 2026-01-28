<?php

/* nhung fiel css */

function suite_style()
{
    /* phan chen scc */
    wp_register_style('main-style', get_template_directory_uri() . '/style.css', 'all');
    wp_enqueue_style('main-style');

    wp_register_style('bootstrap', get_template_directory_uri() . '/style/bootstrap.min4.0.css', 'all');
    wp_enqueue_style('bootstrap');

    wp_register_style('bootstrap-grid', get_template_directory_uri() . '/style/bootstrap-grid.min4.0.css', 'all');
    wp_enqueue_style('bootstrap-grid');

    wp_register_style('bootstrap-reboot', get_template_directory_uri() . '/style/bootstrap-reboot.min4.0.css', 'all');
    wp_enqueue_style('bootstrap-reboot');

    wp_register_style('font-awesome', get_template_directory_uri() . '/style/font-awesome.min.css', 'all');
    wp_enqueue_style('font-awesome');

    wp_register_style('my-style', get_template_directory_uri() . '/style/my.css', 'all');
    wp_enqueue_style('my-style');

    // reset lai mot so tinh nang cua boortrap
    wp_register_style('reset-style', get_template_directory_uri() . '/style/reset.css', 'all');
    wp_enqueue_style('reset-style');

    wp_register_style('scss-style', get_template_directory_uri() . '/style/main.css', 'all');
    wp_enqueue_style('scss-style');

    if (!is_page('check-in')) {
        wp_register_style('superfish-style', get_template_directory_uri() . '/style/superfish.css', 'all');
        wp_enqueue_style('superfish-style');

        wp_register_style('jquery-ui', get_template_directory_uri() . '/style/jquery-ui.min.css', 'all');
        wp_enqueue_style('jquery-ui');

        // srtye cua silder
        wp_register_style('skitter-styles', get_template_directory_uri() . '/style/skitter.styles.css', 'all');
        wp_enqueue_style('skitter-styles');

        // style cho responesive
        wp_register_style('respon-style', get_template_directory_uri() . '/style/respon-style.css', 'all');
        wp_enqueue_style('respon-style');

        // moi them cho 29/04 
        wp_register_style('fancybox-style', get_template_directory_uri() . '/style/fancybox.css', 'all');
        wp_enqueue_style('fancybox-style');

        /* phan chen js */

        wp_register_script('jquery-ui', get_template_directory_uri() . '/js/jquery-ui.min.js', array('jquery'));
        wp_enqueue_script('jquery-ui');

        wp_register_script('jquery-skitter', get_template_directory_uri() . '/js/jquery.skitter.min.js', array('jquery'));
        wp_enqueue_script('jquery-skitter');

        wp_register_script('custom-script', get_template_directory_uri() . '/js/custom.js', array('jquery'));
        wp_enqueue_script('custom-script');

        wp_register_script('ajax-script', get_template_directory_uri() . '/js/checkajax.js', array('jquery'));
        wp_enqueue_script('ajax-script');

        wp_register_script('bootstrap-script', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'));
        wp_enqueue_script('bootstrap-script');

        wp_register_script('bootstrap-bundle', get_template_directory_uri() . '/js/bootstrap.bundle.min.js', array('jquery'));
        wp_enqueue_script('bootstrap-bundle');

        wp_register_script('jquery-animate', get_template_directory_uri() . '/js/jquery.animate-colors-min.js', array('jquery'));
        wp_enqueue_script('jquery-animate');

        wp_register_script('jquery-easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array('jquery'));
        wp_enqueue_script('jquery-easing');

        wp_register_script('superfish-script', get_template_directory_uri() . '/js/superfish.js', array('jquery'));
        wp_enqueue_script('superfish-script');

        wp_register_script('jquery-flexisel', get_template_directory_uri() . '/js/jquery.flexisel.js', array('jquery'));
        wp_enqueue_script('jquery-flexisel');

        wp_register_script('jquery-jcarousellite', get_template_directory_uri() . '/js/jquery.jcarousellite-1.0.1.js', array('jquery'));
        wp_enqueue_script('jquery-jcarousellite');

        //    moi them cho 29/04 
        wp_register_script('jquery-fancybox', get_template_directory_uri() . '/js/jquery.fancybox.pack.js', array('jquery'));
        wp_enqueue_script('jquery-fancybox');

        wp_register_script('jquery-mCustomScrollbar', get_template_directory_uri() . '/js/jquery.mCustomScrollbar.js', array('jquery'));
        wp_enqueue_script('jquery-mCustomScrollbar');
    }
    //    
}

add_action('wp_enqueue_scripts', 'suite_style');

//===== phan admin =======================================
/* add css */
function admin_style()
{
    /* style */
    wp_register_style('product-style', get_template_directory_uri() . '/style/admin/admin-style.css', FALSE, '1.0.0');
    wp_enqueue_style('product-style');

    wp_register_style('jquery-ui', get_template_directory_uri() . '/style/jquery-ui.min.css', 'all');
    wp_enqueue_style('jquery-ui');

    wp_register_script('jquery-ui', get_template_directory_uri() . '/js/jquery-ui.min.js', array('jquery'));
    wp_enqueue_script('jquery-ui');

    wp_register_script('tap-script', get_template_directory_uri() . '/js/admin/tap.js', array('jquery'));
    wp_enqueue_script('tap-script');

    wp_register_script('custom-script', get_template_directory_uri() . '/js/admin/custom.js', array('jquery'));
    wp_enqueue_script('custom-script');

    wp_register_script('jquery-cookie', get_template_directory_uri() . '/js/admin/jquery.cookie.js', array('jquery'));
    wp_enqueue_script('jquery-cookie');

    wp_register_script('jquery-json', get_template_directory_uri() . '/js/admin/jquery.json.js', array('jquery'));
    wp_enqueue_script('jquery-json');
}

add_action('admin_enqueue_scripts', 'admin_style');
