<?php
/**
 * functions.php
 *
 * Ngày tạo  : 2026-07-29
 * Tác giả   : Theme Developer
 * Mục đích  : Khởi tạo toàn bộ tính năng, hook, filter cho theme WordPress.
 *
 * Cấu trúc:
 *  1. Require / Autoload
 *  2. Theme Setup & Support
 *  3. Scripts & Styles
 *  4. Navigation & Sidebar
 *  5. Content & Excerpt
 *  6. Cleanup & Optimization (wp_head)
 *  7. Actions & Filters Registration
 */

declare(strict_types=1);

/*=============================================================
 * 1. REQUIRE / AUTOLOAD
 *=============================================================*/

// 2026-07-29: Nạp module khởi tạo trung tâm (inc/init.php)
require_once get_template_directory() . '/inc/init.php';

// Khai báo thư mục helper và nạp các file phụ trợ
define('HELPER', get_stylesheet_directory() . '/helper');
require_once HELPER . '/style.php';
require_once HELPER . '/define.php';
require_once HELPER . '/function.php';
require_once HELPER . '/require.php';

/*=============================================================
 * 2. THEME SETUP & SUPPORT
 *=============================================================*/

// 2026-07-29: Khởi chạy Session qua hook 'init' (priority 1)
// để tránh lỗi "headers already sent" trên PHP 8+
add_action('init', function (): void {
    if (!session_id()) {
        session_start();
    }
}, 1);

// 2026-07-29: Đặt content_width mặc định nếu chưa được khai báo
if (!isset($content_width)) {
    $content_width = 900;
}

/**
 * Ngày tạo : 2026-07-29
 * Chức năng : Đăng ký các tính năng theme sau khi WP khởi tạo xong.
 *             Sử dụng hook 'after_setup_theme' theo khuyến nghị của WordPress.
 */
add_action('after_setup_theme', function (): void {

    // Cho phép menu navigation
    add_theme_support('menus');

    // Sinh tiêu đề trang động (thay thế hard-code <title>)
    add_theme_support('title-tag');

    // Hỗ trợ ảnh đại diện bài viết (post thumbnail)
    add_theme_support('post-thumbnails');
    add_image_size('large',       700, 0,   true); // Thumbnail lớn
    add_image_size('medium',      250, 0,   true); // Thumbnail trung bình
    add_image_size('small',       120, 0,   true); // Thumbnail nhỏ
    add_image_size('custom-size', 700, 200, true); // Kích thước tuỳ chỉnh

    // Bật RSS feed link tự động
    add_theme_support('automatic-feed-links');

    // Nạp bản dịch theme
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
});

/*=============================================================
 * 3. SCRIPTS & STYLES
 *=============================================================*/


/**
 * Ngày tạo : 2026-07-29
 * Chức năng : Xóa jquery-migrate để giảm tải JavaScript không cần thiết trên frontend.
 */
function remove_jquery_migrate(\WP_Scripts $scripts): void
{
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, ['jquery-migrate']);
        }
    }
}

/**
 * Ngày tạo : 2026-07-29
 * Chức năng : Enqueue script comment-reply chỉ khi cần (threaded comments).
 */
function enable_threaded_comments(): void
{
    if (!is_admin() && is_singular() && comments_open() && get_option('thread_comments') == 1) {
        wp_enqueue_script('comment-reply');
    }
}

/*=============================================================
 * 4. NAVIGATION & SIDEBAR
 *=============================================================*/

/**
 * Ngày tạo : 2026-07-29
 * Chức năng : Xóa wrapper <div> bao ngoài wp_nav_menu để HTML gọn hơn.
 *
 * @param  array $args Mảng tham số của wp_nav_menu.
 * @return array
 */
function my_wp_nav_menu_args(array $args): array
{
    $args['container'] = false;
    return $args;
}

/**
 * Ngày tạo : 2026-07-29
 * Chức năng : Xóa thuộc tính rel="category tag" không hợp lệ khỏi danh sách category.
 *
 * @param  string $thelist HTML danh sách category.
 * @return string
 */
function remove_category_rel_from_category_list(string $thelist): string
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

/**
 * Ngày tạo : 2026-07-29
 * Chức năng : Thêm slug của trang/bài vào body class để dễ CSS targeting.
 *
 * @param  array $classes Mảng class hiện tại.
 * @return array
 */
function add_slug_to_body_class(array $classes): array
{
    global $post;

    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page() || is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

/*=============================================================
 * 5. CONTENT & EXCERPT
 *=============================================================*/

/**
 * Ngày tạo : 2026-07-29
 * Chức năng : Render excerpt với độ dài và "read more" có thể tuỳ chỉnh.
 *
 * @param  string $length_callback Tên hàm callback trả về độ dài excerpt.
 * @param  string $more_callback   Tên hàm callback trả về chuỗi "more".
 */
function html5wp_excerpt(string $length_callback = '', string $more_callback = ''): void
{
    if ($length_callback && function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if ($more_callback && function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }

    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    echo '<p>' . wp_kses_post($output) . '</p>';
}

/**
 * Ngày tạo : 2026-07-29
 * Chức năng : Callback độ dài excerpt cho trang index (20 từ).
 *
 * @return int
 */
function html5wp_index(int $length): int
{
    return 20;
}

/**
 * Ngày tạo : 2026-07-29
 * Chức năng : Callback độ dài excerpt cho custom post type (40 từ).
 *
 * @return int
 */
function html5wp_custom_post(int $length): int
{
    return 40;
}

/**
 * Ngày tạo : 2026-07-29
 * Chức năng : Thay thế [...] cuối excerpt bằng link "View Article".
 *
 * @param  string $more Chuỗi mặc định của WP.
 * @return string
 */
function html5_blank_view_article(string $more): string
{
    global $post;
    return '... <a class="view-article" href="' . esc_url(get_permalink($post->ID)) . '">'
        . esc_html__('View Article', 'html5blank') . '</a>';
}

/**
 * Ngày tạo : 2026-07-29
 * Chức năng : Phân trang cho danh sách bài viết (không cần plugin).
 */
function html5wp_pagination(): void
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links([ // phpcs:ignore WordPress.Security.EscapeOutput
        'base'    => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format'  => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total'   => $wp_query->max_num_pages,
    ]);
}

/*=============================================================
 * 6. CLEANUP & OPTIMIZATION
 *=============================================================*/

/**
 * Ngày tạo : 2026-07-29
 * Chức năng : Ẩn Admin Bar trên frontend.
 *
 * @return false
 */
function remove_admin_bar(): bool
{
    return false;
}

/**
 * Ngày tạo : 2026-07-29
 * Chức năng : Xóa thuộc tính type="text/css" khỏi thẻ <link> stylesheet
 *             (không cần thiết từ HTML5).
 *
 * @param  string $tag HTML tag của stylesheet.
 * @return string
 */
function html5_style_remove(string $tag): string
{
    return preg_replace('~\s+type=["\'][^"\']+["\']~', '', $tag);
}

/**
 * Ngày tạo : 2026-07-29
 * Chức năng : Xóa width/height inline trên thumbnail để hình ảnh responsive linh hoạt.
 *
 * @param  string $html HTML của thumbnail.
 * @return string
 */
function remove_thumbnail_dimensions(string $html): string
{
    return preg_replace('/(width|height)="\d+"\s/', '', $html);
}

/**
 * Ngày tạo : 2026-07-29
 * Chức năng : Xóa inline style của widget Recent Comments khỏi wp_head.
 */
function my_remove_recent_comments_style(): void
{
    global $wp_widget_factory;
    remove_action('wp_head', [
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style',
    ]);
}

/*=============================================================
 * 7. ACTIONS & FILTERS REGISTRATION
 *=============================================================*/

// --- Scripts & Styles ---
// style.css được enqueue trong helper/style.php (handle: 'main-style') — không enqueue lại ở đây
add_action('wp_default_scripts',  'remove_jquery_migrate');      // Xóa jquery-migrate
add_action('get_header',          'enable_threaded_comments');   // Threaded comments script

// --- Widgets ---
add_action('widgets_init', 'my_remove_recent_comments_style');   // Xóa Recent Comments style

// --- Navigation ---
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args');           // Xóa wrapper <div> nav

// --- Body Class & Content ---
add_filter('body_class',          'add_slug_to_body_class');     // Slug vào body class
add_filter('the_category',        'remove_category_rel_from_category_list'); // Sửa rel attr
add_filter('the_excerpt',         'shortcode_unautop');           // Xóa <p> tự động trong excerpt
add_filter('the_excerpt',         'do_shortcode');               // Chạy shortcode trong excerpt
add_filter('excerpt_more',        'html5_blank_view_article');   // Nút "View Article"
add_filter('widget_text',         'do_shortcode');               // Shortcode trong widget
add_filter('widget_text',         'shortcode_unautop');          // Xóa <p> trong widget

// --- Thumbnail ---
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Xóa width/height thumbnail
add_filter('image_send_to_editor','remove_thumbnail_dimensions', 10); // Xóa width/height ảnh

// --- Cleanup ---
add_filter('show_admin_bar',      'remove_admin_bar');           // Ẩn Admin Bar
add_filter('style_loader_tag',    'html5_style_remove');         // Xóa type="text/css"
remove_filter('the_excerpt',      'wpautop');                    // Xóa <p> tự động trong excerpt

// --- wp_head Cleanup: Xóa các link metadata không cần thiết ---
remove_action('wp_head', 'feed_links_extra',                  3);
remove_action('wp_head', 'feed_links',                        2);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'parent_post_rel_link',              10, 0);
remove_action('wp_head', 'start_post_rel_link',               10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link',           10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head',   10, 0);
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head',              10, 0);

// --- Third-party Plugins ---
// 2026-07-28: Tắt cache sitemap Rank Math để tránh xung đột server
add_filter('rank_math/sitemap/enable_caching', '__return_false');