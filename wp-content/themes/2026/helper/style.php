<?php

/**
 * Enqueue theme styles and scripts.
 *
 * @package 2026
 */
function suite_style()
{
	// --- Main Theme Styles ---
	// Main stylesheet
	wp_enqueue_style('main-style', get_template_directory_uri() . '/style.css', array(), null, 'all');
	// Compiled SCSS
	wp_enqueue_style('scss-style', get_template_directory_uri() . '/style/main.min.css', array(), filemtime(get_template_directory() . '/style/main.min.css'), 'all');

	// --- Third-party Libraries ---
	// SwiperJS for sliders
	wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper/swiper-bundle.min.css');
	// JAVASCRIPT

	// --- Third-party Libraries (loaded in footer) ---
	// SwiperJS for sliders
	wp_enqueue_script('swiper-js', 'https://unpkg.com/swiper/swiper-bundle.min.js', array(), null, true);

	// --- Main Theme Scripts (loaded in footer) ---
	wp_enqueue_script('theme-main-js', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true);


	// --- Conditional Scripts (loaded on all pages except 'check-in') ---
	if (!is_page('check-in')) {
		wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/custom.js', array('jquery'), null, true);
	}
}

add_action('wp_enqueue_scripts', 'suite_style');

//======================================================================
// ADMIN STYLES & SCRIPTS
//======================================================================
function admin_style()
{
	/* style */
	wp_enqueue_style('admin-custom-style', get_template_directory_uri() . '/style/admin/admin-style.min.css', array(), '1.0.0');
	
	/* script */
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-tabs');
	// Ngày: 22/07/2026
	// Chức năng: Đăng ký thêm datepicker và selectmenu của WP Core để sửa lỗi "is not a function" trong tap.js và custom.js
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_script('jquery-ui-selectmenu');

	wp_enqueue_script('admin-tap-script', get_template_directory_uri() . '/js/admin/tap.js', array('jquery', 'jquery-ui-tabs', 'jquery-ui-datepicker'), null, true);
	wp_enqueue_script('admin-custom-script', get_template_directory_uri() . '/js/admin/custom.js', array('jquery', 'jquery-ui-selectmenu'), null, true);
	wp_enqueue_script('jquery-cookie', get_template_directory_uri() . '/js/admin/jquery.cookie.js', array('jquery'), null, true);
	wp_enqueue_script('jquery-json', get_template_directory_uri() . '/js/admin/jquery.json.js', array('jquery'), null, true);

}

add_action('admin_enqueue_scripts', 'admin_style');
