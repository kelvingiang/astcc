<?php
require 'wp-load.php';
global $wpdb;
$res = $wpdb->get_results("SELECT option_name, option_value FROM {$wpdb->options} WHERE option_value LIKE '%1411%'");
print_r($res);
