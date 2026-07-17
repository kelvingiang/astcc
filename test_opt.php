<?php
require 'wp-load.php';
$stats = [
    get_option('about_us_year'),
    get_option('about_us_country'),
    get_option('about_us_board')
];
var_dump($stats);

ob_start();
include 'wp-content/themes/2026/template/template-home-statistics.php';
$content = ob_get_clean();
echo "\n\nHTML OUTPUT:\n";
preg_match_all('/<h3 data-target="([^"]+)">/', $content, $matches);
print_r($matches[1]);
