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
define('DIR_COUNTER', THEME_URL . DS . 'counter' . DS);
define('DIR_VALIDATE', THEME_URL . DS . 'validates');
define('DIR_CLASS', THEME_URL . DS . 'class' . DS);
define('DIR_HTML', DIR_CLASS . 'html');
define('DIR_BARCODE', DIR_CLASS . 'barcode' . DS);
define('DIR_IMAGES', THEME_URL . DS . 'images' . DS);
define('DIR_IMAGES_BARCODE', THEME_URL . DS . 'images' . DS . 'barcode' . DS);
define('DIR_IMAGES_QRCODE_NAME', THEME_URL . DS . 'images' . DS . 'qrcode-name' . DS);
define('DIR_IMAGES_QRCODE', THEME_URL . DS . 'images' . DS . 'qrcode' . DS);
define('DIR_IMAGES_GUESTS', THEME_URL . DS . 'images' . DS . 'guests' . DS);
define('DIR_IMAGES_MEMBER', THEME_URL . DS . 'images' . DS . 'member' . DS);
define('DIR_IMAGES_VOTE', THEME_URL . DS . 'images' . DS . 'vote' . DS);
define('DIR_EXPORT', THEME_URL . DS . 'export' . DS);
define('DIR_QRCODE', DIR_CLASS . 'qrcode' . DS);



// PART TRUC TIEP
define('THEME_PART', get_template_directory_uri() . DS);
define('PART_ICON', THEME_PART . '/icon/');
define('PART_IMAGES_BARCODE', THEME_PART . 'barcode' . DS);
define('PART_IMAGES_VOTE', THEME_PART . 'images/vote' . DS);
define('PART_IMAGES_QRCODE', THEME_PART . 'images/qrcode' . DS);
define('PART_IMAGES', THEME_PART . 'images' . DS);
define('PART_FILE', THEME_PART . DS .  'file' . DS);

