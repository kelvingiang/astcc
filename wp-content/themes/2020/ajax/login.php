<?php

// include WordPress
define('WP_USE_THEMES', false);
require('../../../../wp-load.php');

// tiep gía tri chuyen qua tu post 
$user = esc_attr($_POST['l_user']);
$pass = md5(esc_attr($_POST['l_pass']));

global $wpdb;
$table = $wpdb->prefix . 'guests';
$sql = "SELECT * FROM $table WHERE  password = '$pass' AND status = 1 AND ( full_name = '$user' OR email = '$user' )";
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
