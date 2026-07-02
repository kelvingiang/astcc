<?php
/* * **************************phan cua theme******************************** */
// KHAI BAO HANG SO 
define('THEME_URL', get_stylesheet_directory());  // hang lay path thu muc theme
define('DS', DIRECTORY_SEPARATOR);  // phan nay thay doi dau / theo he dieu hanh khac nhau giua window va linx
define('CORE', THEME_URL . '/core'); // hang path thu muc core == thu muc chua cac function it thay doi 

define('DIR_CONTROLLER', THEME_URL . DS . 'controller' . DS);
define('DIR_MODEL', THEME_URL . DS . 'model' . DS);
define('DIR_VIEW', THEME_URL . DS . 'view' . DS);
define('DIR_METABOX', THEME_URL . DS . 'metabox' . DS);

define('DIR_VALIDATE', THEME_URL . DS . 'validates');


define('DIR_IMAGES_BARCODE', THEME_URL . DS . 'images' . DS . 'barcode' . DS);

define('DIR_IMAGES_QRCODE', THEME_URL . DS . 'images' . DS . 'qrcode' . DS);
define('DIR_IMAGES_GUESTS', THEME_URL . DS . 'images' . DS . 'guests' . DS);

define('DIR_IMAGES_VOTE', THEME_URL . DS . 'images' . DS . 'vote' . DS);


define('DIR_IMPORT', THEME_URL . DS . 'import' . DS);




// PART TRUC TIEP
// [15/06/2026] Khắc phục lỗi logic: Sử dụng dấu '/' thay vì 'DS' (DIRECTORY_SEPARATOR) cho đường dẫn URL để tránh lỗi hiển thị trên Windows
define('THEME_PART', get_template_directory_uri() . '/');
define('PART_ICON', THEME_PART . 'images/icon/');

define('PART_IMAGES', THEME_PART . 'images/');




