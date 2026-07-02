<?php
require_once('wp-load.php');
require_once(get_template_directory() . '/inc/code/function-qrcode.php');
$res = create_QRCode('TESTQR123', 'John Doe', 0);
var_dump($res);
