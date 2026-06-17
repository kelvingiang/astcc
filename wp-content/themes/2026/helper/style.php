<?php

/**
 * Enqueue theme styles and scripts.
 *
 * @package 2026
 */
function suite_style()
{
	//======================================================================
	// STYLESHEETS (CSS)
	//======================================================================

	// --- Main Theme Styles ---
	// Main stylesheet
	wp_enqueue_style('main-style', get_template_directory_uri() . '/style.css', array(), null, 'all');
	// Custom styles
	wp_enqueue_style('my-style', get_template_directory_uri() . '/style/my.css', array(), filemtime(get_template_directory() . '/style/my.css'), 'all');
	// Compiled SCSS
	wp_enqueue_style('scss-style', get_template_directory_uri() . '/style/main.css', array(), filemtime(get_template_directory() . '/style/main.css'), 'all');

	// --- Third-party Libraries ---
	// SwiperJS for sliders
	wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper/swiper-bundle.min.css');
	

	// --- Conditional Styles (loaded on all pages except 'check-in') ---
	if (!is_page('check-in')) {
		// Superfish menu
		wp_enqueue_style('superfish-style', get_template_directory_uri() . '/style/superfish.css', array(), null, 'all');
		// jQuery UI
		//wp_enqueue_style('jquery-ui', get_template_directory_uri() . '/style/jquery-ui.min.css', array(), null, 'all');
		
	}

	//======================================================================
	// JAVASCRIPT
	//======================================================================

	// --- Third-party Libraries (loaded in footer) ---
	// SwiperJS for sliders
	wp_enqueue_script('swiper-js', 'https://unpkg.com/swiper/swiper-bundle.min.js', array(), null, true);

	// --- Main Theme Scripts (loaded in footer) ---
	wp_enqueue_script('theme-main-js', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true);
	// [15/06/2026] Loại bỏ nhúng 'infinite-scroll-js' toàn cục tại đây để tránh lỗi ReferenceError do thiếu 'news_load_params' trên các trang khác

	// --- Conditional Scripts (loaded on all pages except 'check-in') ---
	if (!is_page('check-in')) {
		// jQuery UI
		wp_enqueue_script('jquery-ui', get_template_directory_uri() . '/js/jquery-ui.min.js', array('jquery'), null, true);
		// Custom theme scripts
		wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/custom.js', array('jquery'), null, true);
		// Superfish menu
		wp_enqueue_script('superfish-script', get_template_directory_uri() . '/js/superfish.js', array('jquery'), null, true);
	
	}
}

add_action('wp_enqueue_scripts', 'suite_style');

//======================================================================
// ADMIN STYLES & SCRIPTS
//======================================================================
function admin_style()
{
	/* style */
	wp_enqueue_style('admin-custom-style', get_template_directory_uri() . '/style/admin/admin-style.css', array(), '1.0.0');
	wp_enqueue_style('jquery-ui-style', get_template_directory_uri() . '/style/jquery-ui.min.css', array(), null, 'all');

	/* script */
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-tabs');

	wp_enqueue_script('admin-tap-script', get_template_directory_uri() . '/js/admin/tap.js', array('jquery', 'jquery-ui-tabs'), null, true);
	wp_enqueue_script('admin-custom-script', get_template_directory_uri() . '/js/admin/custom.js', array('jquery'), null, true);
	wp_enqueue_script('jquery-cookie', get_template_directory_uri() . '/js/admin/jquery.cookie.js', array('jquery'), null, true);
	wp_enqueue_script('jquery-json', get_template_directory_uri() . '/js/admin/jquery.json.js', array('jquery'), null, true);
	wp_enqueue_script('admin-jquery-ui-script', get_template_directory_uri() . '/js/jquery-ui.min.js', array('jquery'), null, true);
}

add_action('admin_enqueue_scripts', 'admin_style');
