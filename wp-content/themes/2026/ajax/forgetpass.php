<?php

// include WordPress
define('WP_USE_THEMES', false);
require('../../../../wp-load.php');

$email = $_POST['g-email']; // email
$passport = $_POST['g-passport']; // ten 
global $wpdb;
$table = $wpdb->prefix . "guests";
// [15/06/2026] Khắc phục SQL Injection: Sử dụng $wpdb->prepare
$sqlName = $wpdb->prepare("SELECT * FROM $table WHERE full_name = %s", $passport);
$sqlEmail = $wpdb->prepare("SELECT * FROM $table WHERE email = %s", $email);
$sql = $wpdb->prepare("SELECT * FROM  $table WHERE email = %s AND full_name = %s", $email, $passport);


$resultName = $wpdb->get_row($sqlName, ARRAY_A);
if (empty($resultName)) {
    $errPassport = '姓名不正確';
} else {
    $errPassport = '';
}

$resultEmail = $wpdb->get_row($sqlEmail, ARRAY_A);
if (empty($resultEmail)) {
    $errEmail = '電郵信箱不正確!';
} else {
    $errEmail = '';
}


$objForget = $wpdb->get_row($sql, ARRAY_A);
if (!empty($objForget)) {
   // $getMeta = get_post_meta($objForget->ID);
    $newPass = myramdom(); // tao password moi
    $newmd5 = md5($newPass); // tao password moi
    //UPDATE LAI PASSWORD
    $data = array('password' => $newmd5);
    $where = array('ID' => $objForget['ID']);
    $wpdb->update($table, $data, $where);
    
    
    //  update_post_meta($objEmail->ID,'m_password', $newmd5);
    // SEND PASSWORD MOI CHO USER
    $to = $email;
    $subject = '亞洲台灣商會 - 取得新密碼 ';
    $message = '<h4>' . $objForget['full_name'] . ' 您好 ! </h4>';
    $message .= '<p> 您的亞洲台灣商會聯合總會網站的新密碼是 ' . $newPass . '</p>';
// kieu data show trong mail
    // [15/06/2026] Khắc phục tương thích PHP 8: Thay thế create_function() bằng Closure
    add_filter('wp_mail_content_type', function() { return 'text/html'; });
    wp_mail($to, $subject, $message);
    $response = array(
        'status' => 'done',
        'message' => __('請檢查郵箱取得新密碼'),
        'md5' => $newmd5,
    );
} else {
    if ($errEmail == '') {
        $errEmail = '電郵信箱 và 姓名 không khớp';
        // [15/06/2026] Bảo mật: Không echo câu SQL truy vấn để tránh lộ cấu trúc DB
    }
    if ($errPassport == '') {
        $errPassport = '姓名 và 電郵信箱 không khớp';
        // [15/06/2026] Bảo mật: Không echo câu SQL truy vấn để tránh lộ cấu trúc DB
    }
    $response = array(
        'status' => 'error',
        'email' => $errEmail,
        'passport' => $errPassport,
    );
}

function myramdom() {
    $length = 8;
    $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    return $randomString;
}

echo json_encode($response);
?>
