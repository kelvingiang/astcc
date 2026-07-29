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
	// 2026-07-29: Self-host Swiper (custom build: Core + Navigation + Autoplay only)
	// Giảm từ ~43 KiB (CDN full bundle) xuống ~22 KiB sau gzip.
	// Rebuild khi cần: npm run build:swiper
	wp_enqueue_style('swiper-css', get_template_directory_uri() . '/js/swiper.min.css', array(), filemtime(get_template_directory() . '/js/swiper.min.css'));

	// --- Third-party Libraries (loaded in footer) ---
	wp_enqueue_script('swiper-js', get_template_directory_uri() . '/js/swiper.custom.min.js', array(), filemtime(get_template_directory() . '/js/swiper.custom.min.js'), true);

	// --- Main Theme Scripts (loaded in footer) ---
	wp_enqueue_script('theme-main-js', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true);


	// --- Conditional Scripts (loaded on all pages except 'check-in') ---
	if (!is_page('check-in')) {
		// 2026-07-29: Dùng custom.min.js (đã minify) để tối ưu tốc độ tải trang.
		// filemtime() tự động bust cache khi file được build lại.
		wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/custom.min.js', array('jquery'), filemtime(get_template_directory() . '/js/custom.min.js'), true);
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
