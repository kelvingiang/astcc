<?php
// Ngày: 22/07/2026
// Chức năng: Tải script jQuery UI Datepicker và CSS chuyên biệt cho trang Admin
function enqueue_admin_datepicker( $hook_suffix ) {
    // Tối ưu hiệu suất: Chỉ load ở các trang cụ thể (Ví dụ trang post.php hoặc post-new.php)
    // Bạn cần thay đổi hook name phù hợp với trang admin của bạn
    $allowed_pages = array( 'post.php', 'post-new.php', 'toplevel_page_tw_schedule' );
    
    if ( ! in_array( $hook_suffix, $allowed_pages ) ) {
        return;
    }

    // Load Datepicker module có sẵn từ WP Core
    wp_enqueue_script( 'jquery-ui-datepicker' );

    // Tải CSS cho jQuery UI từ CDN (Admin WP không tự động load style cho UI module)
    wp_enqueue_style( 
        'jquery-ui-style', 
        'https://code.jquery.com/ui/1.13.3/themes/smoothness/jquery-ui.min.css', 
        array(), 
        '1.13.3' 
    );
}
add_action( 'admin_enqueue_scripts', 'enqueue_admin_datepicker' );
