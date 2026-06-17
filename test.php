<?php
require 'wp-load.php';
$q = new WP_Query(array('post_type'=>'post', 'category_name'=>'news', 'meta_key'=>'_show_order', 'posts_per_page'=>-1));
echo "count: " . $q->post_count;
