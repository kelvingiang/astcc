<?php

// include WordPress
define('WP_USE_THEMES', false);
require('../../../../wp-load.php');

// tiep gía tri chuyen qua tu post 
$user = $_POST['l_user'];
$pass = md5($_POST['l_pass']);

global $wpdb;
$table = $wpdb->prefix . 'guests';
// [15/06/2026] Khắc phục SQL Injection: Sử dụng $wpdb->prepare
$sql = $wpdb->prepare(
    "SELECT * FROM $table WHERE password = %s AND status = 1 AND ( full_name = %s OR email = %s )",
    $pass,
    $user,
    $user
);
$row = $wpdb->get_row($sql, ARRAY_A);

if (!empty($row)) {
    $_SESSION['login'] = $row['ID'];    //  lay user trong metabox ra de tao gia tri cho session
    $response = array(
        'status' => 'done',
        'message' => ' ',
    );
} else {
    $response = array(
        'status' => 'error',
        'message' => __('登入帳號(姓名)或密碼不正確!'),
        'pass' => $pass
    );
}

echo json_encode($response);
?>
