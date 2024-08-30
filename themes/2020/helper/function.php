<?php

date_default_timezone_set(get_option('time_zone'));



function toBack($msg)
{
    $url = 'admin.php?page=' . $_REQUEST['page'] . '&msg=' . $msg;
    wp_redirect($url);
}

function get_country($countryCode)
{
    switch ($countryCode) {
        case '081':
            $country = '日本';
            break;
        case '062':
            $country = '印尼';
            break;
        case '091':
            $country = '印度';
            break;
        case '673':
            $country = '汶萊';
            break;
        case '880':
            $country = '孟加拉';
            break;
        case '855':
            $country = '柬埔寨';
            break;
        case '852':
            $country = '香港';
            break;
        case '856':
            $country = '寮國';
            break;
        case '060':
            $country = '馬來西亞';
            break;
        case '063':
            $country = '菲律賓';
            break;
        case '084':
            $country = '越南';
            break;
        case '065':
            $country = '新加坡';
            break;
        case '066':
            $country = '泰國';
            break;
        case '095':
            $country = '緬甸';
            break;
        case '853':
            $country = '澳門';
            break;
        case '001':
            $country = '關島';
            break;
        case '670':
            $country = '東帝汶';
        case '082':
            $country = '韓國';
            break;
        case '966':
            $country = '阿拉伯';
            break;
    }
    return $country;
}

function get_guests_country()
{
    $countryArr = array(
        '00' => '選擇國家',
        '081' => '日本', '082' => '韓國',
        '062' => '印尼', '091' => '印度',
        '673' => '汶萊', '880' => '孟加拉',
        '855' => '柬埔寨', '852' => '香港',
        '856' => '寮國', '060' => '馬來西亞',
        '063' => '菲律賓', '084' => '越南',
        '065' => '新加坡', '066' => '泰國',
        '095' => '緬甸', '853' => '澳門',
        '001' => '關島', '670' => '東帝汶', '966' => '阿拉伯'
    );
    return $countryArr;
}


function Chang_Url()
{
    if ($_SERVER['HTTP_HOST'] === 'localhost') {
        $url = 'http://localhost/astcc/';
    } else {
        $url = 'http://astcc24.net/';
    }
    return $url;
}

// STRAT VOTE THE FUNCTION
//==== FUNCTIONS  IS FOR VOTE ============================================

function VoteExportToExcel($kid)
{
    require_once DIR_CLASS . 'PHPExcel.php';
    $exExport = new PHPExcel();

    // TAO COT TITLE
    $exExport->setActiveSheetIndex(0);
    $sheet = $exExport->getActiveSheet()->setTitle("check in");
    $sheet->setCellValue('A1', '姓名');
    $sheet->setCellValue('B1', '公司名稱');
    $sheet->setCellValue('C1', '票數');

    // set kich thuoc cot  
    $sheet->getColumnDimension('A')->setWidth(10);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setWidth(15);

    // set chieu cao cua dong
    $sheet->getRowDimension('1')->setRowHeight(30);
    // set to dam chu
    $sheet->getStyle('A')->getFont()->setBold(TRUE);
    $sheet->getStyle('A1:C1')->getFont()->setBold(TRUE);
    // set nen backgroup cho dong
    $sheet->getStyle('A1:C1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('0008bdf8');
    // set chu canh giua
    $sheet->getStyle('A1:C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A1:C1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


    // TAO NOI DUNG CHEN TU DONG 2
    $i = 2;
    $list = getVoteResult($kid);

    foreach ($list as $row) {
        $exExport->setActiveSheetIndex(0)
            ->setCellValueExplicit('A' . $i, $row['name'])
            ->setCellValue('B' . $i, $row['company'])
            ->setCellValueExplicit('C' . $i, $row['vote_total'], PHPExcel_Cell_DataType::TYPE_STRING);
        $i++;
        // phan set border 
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        //cho tat ca 
        $sheet->getStyle('A1:' . 'C' . ($i - 1))->applyFromArray($styleArray);
    }

    // TAO FILE EXCEL VA SAVE LAI THEO PATH
    //$objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
    //$full_path = DIR_EXPORT . date("YmdHis") . '_report.xlsx'; //duong dan file
    //$objWriter->save($full_path);
    // TAO FILE EXCEL VA DOWN TRUC TIEP XUONG CLINET
    $kidID = $kid == 1 ? "lishi" : 'jianshi';
    $filename = $kidID . '_vote_' . date("ymdHis") . '.xlsx';
    $objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename=$filename");
    header('Cache-Control: max-age=0');
    ob_end_clean();
    //        ob_start();
    $objWriter->save('php://output');
}

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
    $sql = "SELECT * FROM $table WHERE `kid` = $kid AND `status` = 1 ORDER BY `vote_total` DESC";
    $row = $wpdb->get_results($sql, ARRAY_A);
    return $row;
}

function getVoteListByKid($kid)
{
    global $wpdb;
    $table = $wpdb->prefix . 'vote';
    $sql = "SELECT * FROM $table WHERE `kid` = $kid AND `status` = 1";
    $row = $wpdb->get_results($sql, ARRAY_A);
    return $row;
}

function voteLogin($user, $pass)
{
    global $wpdb;
    $table = $wpdb->prefix . 'guests';
    $sql = "SELECT ID, full_name, barcode FROM $table WHERE `full_name` = '$user' AND `barcode` = '$pass' AND `status` = 1 AND `check_in` = 0";
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
    $updateSql = "UPDATE $table SET vote_total=vote_total + 1 WHERE ID=$id";
    $wpdb->query($updateSql);
}

function userVoteSuccess()
{
    global $wpdb;
    // SET USER VOTED
    $table = $wpdb->prefix . 'guests';
    $updateSql = "UPDATE $table SET check_in = 1 WHERE ID = " . $_SESSION['voteLogin']['ID'];
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
    return get_template_directory_uri() . '/icon/' . $name;
}

function get_lib_uri($name = '')
{
    return get_template_directory_uri() . '/lib/' . $name;
}

function get_workshop_uri($name = '')
{
    return get_template_directory_uri() . '/lib/PHPImageWorkshop/' . $name;
}

// ==== get path ============
// path de upload file den thu muc mong muon
//DS la ham so se thay doi dau / theo he thong  

function upload_guests()
{
    return WP_CONTENT_DIR . DS . 'themes' . DS . 'blank' . DS . 'images' . DS . 'guests' . DS;
}

function upload_avatar()
{
    return WP_CONTENT_DIR . DS . 'themes' . DS . 'blank' . DS . 'images' . DS . 'avata' . DS;
}

function upload_article()
{
    return WP_CONTENT_DIR . DS . 'themes' . DS . 'blank' . DS . 'images' . DS . 'article' . DS;
}

function get_guests($name)
{
    return WP_CONTENT_DIR . DS . 'themes' . DS . 'blank' . DS . 'images' . DS . 'guests' . DS . $name;
}

function get_avata($name)
{
    return WP_CONTENT_DIR . DS . 'themes' . DS . 'blank' . DS . 'images' . DS . 'avata' . DS . $name;
}

function dir_php_class($dir = '')
{
    return WP_CONTENT_DIR . DS . 'themes' . DS . 'blank' . DS . 'lib' . DS . 'class' . DS . $dir;
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
    $sql = "SELECT * FROM $table WHERE  $strField = '" . $strValue . "'";
    $row = $wpdb->get_row($sql, ARRAY_A);
    if ($row['email'] == $_SESSION['email']) {
        //  break;
    } else if (count($row['email']) > 0) {
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
    $columns['order'] = __('次序', 'your_text_domain');
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
            'items_wrap' => '<nav class=' . $slug . '><ul id="%1$s" class="%2$s sf-menu">%3$s</ul></nav>'
        );
        wp_nav_menu($menu);
    }
}

// DOI LOGO MAC DINH CUA WORDPRESS
function custom_login_logo()
{
    echo '<style type="text/css">
h1 a { background-image:url(' . WP_CONTENT_URL . '/themes/blank/images/logo.png) !important; 
         background-size: 100px !important;
          width : 250px !important;
          height : 100px !important;
}
</style>';
}

add_action('login_head', 'custom_login_logo');
