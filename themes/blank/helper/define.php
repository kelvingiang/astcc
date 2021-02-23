<?php
/* * **************************phan cua theme******************************** */
// KHAI BAO HANG SO 
define('THEME_URL', get_stylesheet_directory());  // hang lay path thu muc theme
define('DS', DIRECTORY_SEPARATOR);  // phan nay thay doi dau / theo he dieu hanh khac nhau giua window va linx
define('CORE', THEME_URL . '/core'); // hang path thu muc core == thu muc chua cac function it thay doi 


define('CONTROLER_DIR', THEME_URL . DS . 'controler' . DS);
define('COUNTER_DIR', THEME_URL . DS . 'counter' . DS);
define('MODEL_DIR', THEME_URL . DS . 'model' . DS);
define('VIEW_DIR', THEME_URL . DS . 'view' . DS);
define('METABOX_DIR', THEME_URL . DS . 'metabox' . DS);
define('VALIDATE_DIR', THEME_URL . DS . 'validates');
define('CLASS_DIR', THEME_URL . DS . 'class' . DS);
define('HTML_DIR', CLASS_DIR . 'html');
define('WB_DIR_BARCODE', CLASS_DIR . 'barcode' . DS);
define('WB_DIR_FILE', THEME_URL . DS .  'file' . DS);
define('WB_DIR_IMAGES', THEME_URL . DS . 'images' . DS);
define('WB_DIR_IMAGES_BARCODE', THEME_URL . DS . 'images' . DS . 'barcode' . DS);
define('WB_DIR_IMAGES_QRCODE_NAME', THEME_URL . DS . 'images' . DS . 'qrcode-name' . DS);
define('WB_DIR_IMAGES_QRCODE', THEME_URL . DS . 'images' . DS . 'qrcode' . DS);
define('WB_DIR_IMAGES_GUESTS', THEME_URL . DS . 'images' . DS . 'guests' . DS);
define('WB_DIR_IMAGES_MEMBER', THEME_URL . DS . 'images' . DS . 'member' . DS);
define('WB_DIR_IMAGES_VOTE', THEME_URL . DS . 'images' . DS . 'vote' . DS);
define('EXPORT_DIR', THEME_URL . DS . 'export' . DS);
define('WB_DIR_QRCODE', CLASS_DIR . 'qrcode' . DS);




// PART TRUC TIEP
//    return get_template_directory_uri() . '/images/qrcode/' . $barcode . '.png';

define('THEME_PART', get_template_directory_uri() . DS);
define('ICON_DIR', THEME_PART . '/icon/');
define('WB_URL_IMAGES_BARCODE', THEME_PART . 'barcode' . DS);
define('WB_URL_IMAGES_VOTE', THEME_PART . 'images/vote' . DS);
define('WB_URL_IMAGES_QRCODE', THEME_PART . 'images/qrcode' . DS);
define('WB_URL_IMAGES', THEME_PART . DS .  'img' . DS);
define('WB_URL_FILE', THEME_PART . DS .  'file' . DS);

