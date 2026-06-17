<?php

// include WordPress
define('WP_USE_THEMES', false);
require('../../../../wp-load.php');

// tiep gía tri chuyen qua tu post 
//$user = $_SESSION['login'];
$o_pass = md5($_POST['o_pass']);
$n_pass = md5($_POST['n_pass']);
$user_id = isset($_SESSION['login']) ? (int)$_SESSION['login'] : 0;

// dieu kien get data tu metabox == where
global $wpdb;
$table = $wpdb->prefix . 'guests';

// [15/06/2026] Khắc phục SQL Injection & Lỗi logic: Kiểm tra mật khẩu cũ khớp với đúng ID đang đăng nhập
$sql = $wpdb->prepare("SELECT * FROM $table WHERE ID = %d AND password = %s", $user_id, $o_pass);
$row = $wpdb->get_row($sql, ARRAY_A);

if ($user_id === 0 || empty($row)) {
    $response = array(
        'status' => 'error',
        'oldPass' => '密碼不正確',
        'message' => ' '
    );

    /*
      $getMeta = get_post_meta($objMember->ID); // lay gia tri tu metabox
      $_SESSION['login'] = $getMeta['m_user'][0]; //  lay user trong metabox ra de tao gia tri cho session
      $response = array(
      'status' => 'done',
      'message' => ''
      );
     * 
     */
} else {

    // sau khi lay va lay dong du lieu
    $where = array('ID' => $user_id);
    $data =array('password' => $n_pass );
    $wpdb->update($table, $data, $where);
    $response = array(
        'status' => 'done',
        'oldPass' => '',
        'message' => '密碼已更新 !'
    );
}

echo json_encode($response);
?>
