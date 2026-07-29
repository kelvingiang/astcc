<?php

date_default_timezone_set(get_option('time_zone'));



function toBack($msg)
{
    $url = 'admin.php?page=' . $_REQUEST['page'] . '&msg=' . $msg;
    wp_redirect($url);
}


function Chang_Url()
{
    // [15/06/2026] Khắc phục chất lượng mã nguồn: Trả về home_url('/') động thay vì hardcode tên miền
    return home_url('/');
}

// STRAT VOTE THE FUNCTION
//==== FUNCTIONS  IS FOR VOTE ============================================



function OptionVoteTotal()
{
    update_option('_vote_total', 2);
    return get_option('_vote_total');
}

//function voteTotal($kid) {
//    global $wpdb;
//    $table = $wpdb->prefix . 'vote';
//    $sql = "SELECT  sum(vote_total) as 'total' FROM $table WHERE `kid` = $kid";
//    $row = $wpdb->get_row($sql, ARRAY_A);
//    return $row;
//}

function getVoteFinalResult()
{
    global $wpdb;
    $table = $wpdb->prefix . 'vote';
    $sql = "SELECT * FROM $table WHERE `position` != '0' AND `status` = 1 ORDER BY `position` DESC";
    $row = $wpdb->get_results($sql, ARRAY_A);
    return $row;
}

function getVoteResult($kid)
{
    global $wpdb;
    $table = $wpdb->prefix . 'vote';
    // [15/06/2026] Khắc phục SQL Injection: Ép kiểu $kid về int
    $kid = (int)$kid;
    $sql = "SELECT * FROM $table WHERE `kid` = $kid AND `status` = 1 ORDER BY `vote_total` DESC";
    $row = $wpdb->get_results($sql, ARRAY_A);
    return $row;
}

function getVoteListByKid($kid)
{
    global $wpdb;
    $table = $wpdb->prefix . 'vote';
    // [15/06/2026] Khắc phục SQL Injection: Ép kiểu $kid về int
    $kid = (int)$kid;
    $sql = "SELECT * FROM $table WHERE `kid` = $kid AND `status` = 1";
    $row = $wpdb->get_results($sql, ARRAY_A);
    return $row;
}

function voteLogin($user, $pass)
{
    global $wpdb;
    $table = $wpdb->prefix . 'guests';
    // [15/06/2026] Khắc phục SQL Injection: Sử dụng prepared statements
    $sql = $wpdb->prepare(
        "SELECT ID, full_name, barcode FROM $table WHERE `full_name` = %s AND `barcode` = %s AND `status` = 1 AND `check_in` = 0",
        $user,
        $pass
    );
    $row = $wpdb->get_row($sql, ARRAY_A);
    if (!empty($row)) {
        $_SESSION['voteLogin'] = $row;
        wp_redirect(home_url('vote'));
    } else {
        return "登入失敗-請檢查帳號或密碼";
    }
}

function updateVoteCount($id)
{
    global $wpdb;
    //PLUS VOTE COUNT
    $table = $wpdb->prefix . 'vote';
    // [15/06/2026] Khắc phục SQL Injection: Ép kiểu $id về int
    $id = (int)$id;
    $updateSql = "UPDATE $table SET vote_total=vote_total + 1 WHERE ID=$id";
    $wpdb->query($updateSql);
}

function userVoteSuccess()
{
    global $wpdb;
    // SET USER VOTED
    $table = $wpdb->prefix . 'guests';
    // [15/06/2026] Khắc phục SQL Injection: Ép kiểu ID về int và kiểm tra sự tồn tại
    $user_id = isset($_SESSION['voteLogin']['ID']) ? (int)$_SESSION['voteLogin']['ID'] : 0;
    $updateSql = "UPDATE $table SET check_in = 1 WHERE ID = $user_id";
    $wpdb->query($updateSql);

    unset($_SESSION['voteLogin']);
}

// END


function get_barcode_img($barcode = '')
{
    return get_template_directory_uri() . '/images/barcode/' . $barcode . '.png';
}

function get_qrcode_img($barcode = '')
{
    return get_template_directory_uri() . '/images/qrcode/' . $barcode . '.png';
}

function get_guests_img($img = '')
{
    return get_template_directory_uri() . '/images/guests/' . $img;
}

function get_vote_img($img = '')
{
    return get_template_directory_uri() . '/images/vote/' . $img;
}

function get_member_img($img = '')
{
    return get_template_directory_uri() . '/images/member/' . $img;
}

function getParams($name = null)
{
    if ($name == null || empty($name)) {
        return $_REQUEST; // TRA VE GIA TRI REQUEST
    } else {
        // TRUONG HOP name DC CHUYEN VAO 
        // KIEM TRA name CO TON TAI TRA VE name NGUOI ''
        $val = (isset($_REQUEST[$name])) ? $_REQUEST[$name] : ' ';
        return $val;
    }
}

// KIEM TRA DU LIEU CO CHINH XAC VA LOI KHONG
function getValidate($filename = '', $dir = '')
{
    $obj = new stdClass();
    $file = DIR_VALIDATE . $dir . DS . $filename . '.php';
    if (file_exists($file)) {
        require_once $file;
        $validateName = 'Admin_' . $filename . '_Validate';
        $obj = new $validateName();
    }
    return $obj;
}

function kid_name($id)
{
    //$arr = array('1' => '理事', '2' => '監事');
    if ($id == 1) {
        $val = "總會長";
    } elseif ($id == 2) {
        $val = '監事長';
    } elseif ($id == 3) {
        $val = "各總會";
    }
    return $val;
}

// KIEM DU LIEU CHUYEN QUA BANG PHUONG POST HAY GET
function isPost()
{
    $flag = ($_SERVER['REQUEST_METHOD'] == 'POST') ? TRUE : FALSE;
    return $flag;
}

/* ---start ------------------------------change language-----------------------19/05/15-------- */
global $language;
$language = 'zh_TW';

//   if (!is_admin()) {
function change_translate_text($translated)
{
    global $language;
    $file = dirname(dirname(dirname(dirname(__FILE__)))) . "/languages/{$language}/data.php";
    include_once $file;
    $data = getTranslate();
    if (isset($data[$translated])) {
        return $data[$translated];
    }
    return $translated;
}

add_filter('gettext', 'change_translate_text', 20);

// SEND EMAIL
function registrySendMail($mailTo, $name, $password)
{
    $subject = '亞洲台灣商會聯合總會-會員註冊';
    $message = '<h2>' . $name . ': 您好 ! </h2> <br>';
    $message .= '<h3> 歡迎您成為"亞洲台灣商會聯合總會"網頁的會員 </h3>';
    $message .= '<p> 登入密碼    :' . $password . ' </p>';
    $message .= '<p> 您可以使用自己的姓名或email 來登入 </p>';
    $message .= '<a href ="http://astcc24.net" target="_blank"> 越南台灣商會聯合總會網頁</a><br>';
    $message .= '<a href ="http://astcc24.net" target="_blank"> astcc24.net</a><br>';
    $message .= '謝謝';
    wp_mail($mailTo, $subject, $message);
}

//===================================================================================


function get_lib($name = '')
{
    return get_template_directory() . '/lib/' . $name;
}

function get_core($name = '')
{
    return get_template_directory() . '/core/' . $name;
}

/* * ********************
 * GET SRC OF IMAGES
 * ******************* */

/* === get url ==============  */

function get_image($name = '')
{
    return get_template_directory_uri() . '/images/' . $name;
}

function get_icon($name = '')
{
    return get_template_directory_uri() . '/images/icon/' . $name;
}

function get_lib_uri($name = '')
{
    return get_template_directory_uri() . '/lib/' . $name;
}



// ==== get path ============
// path de upload file den thu muc mong muon
//DS la ham so se thay doi dau / theo he thong  

function upload_guests()
{
    // [15/06/2026] Khắc phục lỗi logic: Sử dụng get_stylesheet_directory() động thay vì hardcode 'blank'
    return get_stylesheet_directory() . DS . 'images' . DS . 'guests' . DS;
}

function upload_avatar()
{
    // [15/06/2026] Khắc phục lỗi logic: Sử dụng get_stylesheet_directory() động thay vì hardcode 'blank'
    return get_stylesheet_directory() . DS . 'images' . DS . 'avata' . DS;
}

function upload_article()
{
    // [15/06/2026] Khắc phục lỗi logic: Sử dụng get_stylesheet_directory() động thay vì hardcode 'blank'
    return get_stylesheet_directory() . DS . 'images' . DS . 'article' . DS;
}

function get_guests($name)
{
    // [15/06/2026] Khắc phục lỗi logic: Sử dụng get_stylesheet_directory() động thay vì hardcode 'blank'
    return get_stylesheet_directory() . DS . 'images' . DS . 'guests' . DS . $name;
}

function get_avata($name)
{
    // [15/06/2026] Khắc phục lỗi logic: Sử dụng get_stylesheet_directory() động thay vì hardcode 'blank'
    return get_stylesheet_directory() . DS . 'images' . DS . 'avata' . DS . $name;
}

function dir_php_class($dir = '')
{
    // [15/06/2026] Khắc phục lỗi logic: Sử dụng get_stylesheet_directory() động thay vì hardcode 'blank'
    return get_stylesheet_directory() . DS . 'lib' . DS . 'class' . DS . $dir;
}

function import_file()
{
    // [15/06/2026] Khắc phục lỗi logic: Định nghĩa hàm import_file() bị thiếu để phục vụ import Excel
    return get_stylesheet_directory() . DS . 'file' . DS;
}

class Common
{

    public static $_langDefault = 'vi_VI';
    public static $_langSite = 'language';
    public static $_wpeditor = array(
        'wpautop' => false,
        'editor_height' => '250px'
    );
}

function custom_redirect($location)
{

    global $post_type;
    $location = admin_url('edit.php?post_type=' . $post_type);

    return $location;
}

// an thanh bardang nhap cua admin
add_filter('show_admin_bar', '__return_false');
/* ================================================================ */

function get_page_permalink($name)
{
    if (!empty($name)) {
        $dataPage = get_page_by_title($name);
        $id = $dataPage->ID;
        return get_page_link($id);
    }
    return false;
}

//====== functions  ===================================================
// kiem tra doi tuong da ton tai chu
// $filed = ten filed trong database
// $value = gia tri tim kiem trong $field
// $error_mess = noi dung cau thong bao tra ve
function checkExists($field, $value, $error_mess)
{
    $strField = $field;
    $strValue = $value;

    global $wpdb;
    $table = $wpdb->prefix . 'guests';
    
    // [15/06/2026] Khắc phục SQL Injection: Sử dụng whitelist cho tên cột và prepared statements cho giá trị
    $allowed_fields = array('email', 'full_name', 'barcode', 'phone');
    if (!in_array($strField, $allowed_fields)) {
        return;
    }

    $sql = $wpdb->prepare("SELECT * FROM $table WHERE $strField = %s", $strValue);
    $row = $wpdb->get_row($sql, ARRAY_A);
    
    if (empty($row)) {
        return;
    }
    
    if (isset($_SESSION['email']) && $row['email'] == $_SESSION['email']) {
        //  break;
    } else if (!empty($row['email'])) {
        $return['error'] = 'exists';
        $return['mess'] = $error_mess;
        return $return;
    }
}

// kiem tra string
// $element = doi tuong input can kiem tra
// $min = so ky tu nho nhat
// $max = so ky tu lon nhat
function checkstr($element, $min = 2, $max = 5000)
{
    $length = strlen($element);
    if (empty($length)) {
        return __('

      plaese require this', 'suite');
    } elseif ($length < $min) {
        return __('min', 'suite') . $min . __('characters', 'suite');
    } elseif ($length > $max) {
        return __('max', 'suite') . $max . __('characters', 'suite');
    }
    //   return true;
}

// kiem tra email
function checkemail($element)
{
    if ($element == '

    ') {
        return __('plaese require this', 'suite');
    } else if (!filter_var($element, FILTER_VALIDATE_EMAIL)) {
        return __(' this email exists', 'suite');
    }
}

// kiem tra captcha
function checkcaptcha($elenment)
{
    if ($elenment == '') {
        return __('Requied', 'suite');
    } elseif ($elenment !== $_SESSION['captcha']) {
        return __('Capcha Not Matching', 'suite');
    }
}

// 1===DOI TEN POST MAC DINH CUA WP===============================================
function revcon_change_post_label()
{
    global $menu;
    global $submenu;
    $menu[5][0] = __('Astcc News');
    $submenu['edit.php'][5][0] = __('Astcc News');
    $submenu['edit.php'][10][0] = __('Add New');
    $submenu['edit.php'][16][0] = __('Tags');
}

add_action('admin_menu', 'revcon_change_post_label');

function revcon_change_post_object()
{
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = __('Astcc News');
    $labels->singular_name = __('new');
    $labels->add_new = __('Add New');
    $labels->add_new_item = __('Add New');
    $labels->edit_item = __('Edit');
    $labels->new_item = 'News';
    $labels->view_item = 'View News';
    $labels->search_items = 'Search News';
    $labels->not_found = 'No News found';
    $labels->not_found_in_trash = 'No News found in Trash';
    $labels->all_items = 'All News';
    $labels->menu_name = 'News';
    $labels->name_admin_bar = 'News';
}

add_action('init', 'revcon_change_post_object');

// 2==== THAY DOI COT TRONG POST MAC DINH============================================

function set_custom_edit_columns($columns)
{
    // $date_label = _x('Create Date', 'suite');
    unset($columns['author']);
    //            unset($columns['categories']);
    unset($columns['tags']);
    unset($columns['comments']);
    unset($columns['date']);
    $columns['content'] = __('Content', 'your_text_domain');
    //$columns['publisher'] = __('Publisher', 'your_text_domain');
    // $columns['order'] = __('次序', 'your_text_domain');
    // $columns['home'] = __('首頁', 'your_text_domain');

    $columns['date'] = __('Create Date', 'suite');
    return $columns;
}

add_filter('manage_posts_columns', 'set_custom_edit_columns');

// 3==== LAY CONTENT TRONG COT ============================================
function my_sub_more($data)
{
    $str = explode(' <!--more-->', $data);
    return $str[0];
}

function Custom_post_RenderCols($columns)
{
    global $post;
    switch ($columns) {
        case 'content':
            echo '<span>' . my_sub_more(get_the_content()) . '</span>';
            break;
        case 'order':
            echo '<span>' . get_post_meta($post->ID, '_show_order', TRUE) . '</span>';
            break;
        case 'home':
            $ss = get_post_meta($post->ID, "_metabox_home", TRUE) == 'on' ? 'check-icon' : '';
            echo "<div class=" . $ss . "> </div>";
            break;
        default:
            break;
    }
}

add_action('manage_posts_custom_column', 'Custom_Post_RenderCols');


//==== tao menu ============================================
/* them menu co phan khai bao thay doi ngon ngu o phan __  thong qua textdomain */
register_nav_menu('primary-menu', __('Primary name', 'suite')); // goi menu de show
register_nav_menu('mobile-menu', __('Mobile name', 'suite')); // goi menu de show



if (!function_exists('suite_menu')) {

    function suite_menu($slug)
    {
        $menu = array(
            'theme_location' => $slug, // chon menu dc thiet lap truoc
            'container' => 'nav', // tap html chua menu nay
            'container_class' => $slug, // class cua mennu
            'items_wrap' => '<nav class=' . $slug . '><ul id="%1$s" class="%2$s">%3$s</ul></nav>'
        );
        wp_nav_menu($menu);
    }
}

if (!function_exists('mobile_menu')) {

    function mobile_menu($slug)
    {
        $menu = array(
            'theme_location' => $slug, // chon menu dc thiet lap truoc
            'container' => 'nav', // tap html chua menu nay
            'container_class' => $slug, // class cua mennu
            'items_wrap' => '<nav class=' . $slug . '><ul id="%1$s" class="%2$s">%3$s</ul></nav>'
        );
        wp_nav_menu($menu);
    }
}
// DOI LOGO MAC DINH CUA WORDPRESS
function custom_login_logo()
{
    // [15/06/2026] Khắc phục lỗi logic: Sử dụng get_stylesheet_directory_uri() động thay vì hardcode 'blank'
    echo '<style type="text/css">
h1 a { background-image:url(' . get_stylesheet_directory_uri() . '/images/logo.png) !important; 
         background-size: 100px !important;
          width : 250px !important;
          height : 100px !important;
}
</style>';
}

add_action('login_head', 'custom_login_logo');



// Thêm vào cuối tệp functions.php của theme 2026

function astcc_enqueue_news_script() {
    // Chỉ tải script này trên trang sử dụng template 'page/news.php', 'page/news-young.php', 'page/news-other.php'
    if ( is_page_template('page/news.php') || is_page_template('page/news-conference.php') || is_page_template('page/news-young.php') || is_page_template('page/news-other.php') || is_page_template('page/other.php') || is_page_template('page/conference.php') ) {
        wp_enqueue_script(
            'infinite-scroll',
            get_template_directory_uri() . '/js/infinite-scroll.js',
            array('jquery'),
            '1.0',
            true
        );

        $category_slug = 'news';
        $post_type = 'post';
        $initial_posts = 5;

        if ( is_page_template('page/news-young.php') ) {
            $category_slug = 'young';
        } elseif ( is_page_template('page/news-other.php') ) {
            $category_slug = 'member';
        } elseif ( is_page_template('page/other.php') ) {
            $category_slug = 'other';
            $post_type = 'conference';
            $initial_posts = 2; // other.php ban đầu load 2 bài
        } elseif ( is_page_template('page/conference.php') ) {
            $category_slug = '';
            $post_type = 'conference';
            $initial_posts = 5;
        }

        // Tối ưu hóa: Lấy trực tiếp số lượng bài viết từ object
        if ($post_type === 'conference') {
            if (!empty($category_slug)) {
                $term = get_term_by('slug', $category_slug, 'conference_cate');
                $total_posts = $term ? $term->count : 0;
            } else {
                $total_posts = wp_count_posts('conference')->publish;
            }
        } else {
            $cat_obj = get_category_by_slug($category_slug);
            $total_posts = $cat_obj ? $cat_obj->count : 0;
        }

        // Truyền biến tới JavaScript
        wp_localize_script(
            'infinite-scroll',
            'news_load_params',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('load_more_posts_nonce'),
                'total_posts' => $total_posts,
                'initial_posts' => $initial_posts, // Số bài viết tải ban đầu
                'posts_per_page' => 2,   // Số bài viết tải mỗi lần cuộn
                'category_slug' => $category_slug,
                'post_type' => $post_type
            )
        );
    }
}
add_action('wp_enqueue_scripts', 'astcc_enqueue_news_script');

// Enqueue infinite scroll script for single post pages
function astcc_enqueue_single_post_script() {
    if ( is_single() ) {
        wp_enqueue_script(
            'infinite-scroll-single',
            get_template_directory_uri() . '/js/infinite-scroll-single.js',
            array('jquery'),
            '1.0',
            true
        );

        $post_id = get_the_ID();
        $post_type = get_post_type($post_id);
        
        $category_slug = '';
        $total_posts = 0;

        if ($post_type === 'conference') {
            $terms = get_the_terms($post_id, 'conference_cate');
            if (!empty($terms) && !is_wp_error($terms)) {
                $category_slug = $terms[0]->slug;
                $total_posts = max(0, $terms[0]->count - 1);
            } else {
                $total_posts = max(0, wp_count_posts('conference')->publish - 1);
            }
        } else {
            $cate = get_the_category();
            if (!empty($cate)) {
                $category_slug = $cate[0]->slug;
                $cat_obj = get_category_by_slug($category_slug);
                $total_posts = $cat_obj ? max(0, $cat_obj->count - 1) : 0;
            }
        }

        wp_localize_script(
            'infinite-scroll-single',
            'related_load_params',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('load_more_related_nonce'),
                'total_posts' => $total_posts,
                'initial_posts' => 5,
                'posts_per_page' => 2,
                'category_slug' => $category_slug,
                'post_type' => $post_type,
                'exclude_post_id' => $post_id
            )
        );
    }
}
add_action('wp_enqueue_scripts', 'astcc_enqueue_single_post_script');

// 2026-07-17
// 允許 WordPress 媒體庫上傳 WebP 格式檔案
function enable_webp_upload( $mimes ) {
    $mimes['webp'] = 'image/webp';
    return $mimes;
}
add_filter( 'upload_mimes', 'enable_webp_upload' );

// 2026-07-17
// 確保 WebP 圖片在 WordPress 媒體庫中可以正常顯示預覽圖
function display_webp_in_media_library( $result, $path ) {
    if ( $result === false ) {
        $displayable_image_types = array( IMAGETYPE_WEBP );
        $info = @getimagesize( $path );

        if ( empty( $info ) ) {
            $result = false;
        } elseif ( ! in_array( $info[2], $displayable_image_types ) ) {
            $result = false;
        } else {
            $result = true;
        }
    }
    return $result;
}
add_filter( 'file_is_displayable_image', 'display_webp_in_media_library', 10, 2 );

// Ngày: 22/07/2026
// Chức năng: Rút gọn định dạng hiển thị trong cột Ngày tháng (Date) của danh sách bài viết trong admin thành dạng ngắn nhất (VD: 2024/10/16)
function astcc_shorten_post_date_column( $t_time, $post, $column_name, $mode ) {
    if ( 'date' === $column_name ) {
        // Ghi đè định dạng dài dòng mặc định bằng định dạng ngắn gọn Y/m/d
        $t_time = get_the_time( 'Y/m/d', $post );
    }
    return $t_time;
}
add_filter( 'post_date_column_time', 'astcc_shorten_post_date_column', 10, 4 );

// Date: 2026-07-22
// Function: Vô hiệu hóa internal sitemap cache của Rank Math để đảm bảo Googlebot luôn nhận dữ liệu live, tránh lỗi HTTP 404 ẩn
add_filter( 'rank_math/sitemap/enable_caching', '__return_false');


// 2026-07-28
// Chức năng: Ngăn chặn tải script Analytics của Rank Math trên các trang không phải là Post/Page 
// để tối ưu hiệu suất admin và tránh lỗi 404 REST API (post/undefined).
add_action( 'admin_enqueue_scripts', function() {
    // Lấy thông tin màn hình hiện tại trong WP Admin
    $screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
    
    // Nếu không nằm trong màn hình chỉnh sửa post/page thông thường, hủy tải script
    if ( $screen && ! in_array( $screen->base, array( 'post', 'edit' ), true ) ) {
        // Hủy đăng ký các script gọi API không cần thiết của Rank Math
        wp_dequeue_script( 'rank-math-analyzer' );
        wp_dequeue_script( 'rank-math-analytic' );
    }
}, 999 );
