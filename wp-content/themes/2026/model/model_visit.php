<?php

class Model_Web_Visit
{
    private $_ip;
    private $_now;
    public $table_visitor;
    public $table_site;

    public function __construct()
    {
        global $wpdb;
        $now = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
        $this->_now = $now->format('Y-m-d H:i:s'); // Server time
        // $this->_now = current_time('mysql', 0); // Server time
        
        // [Modified: 15/06/2026] Thêm fallback IP mặc định phòng khi chạy trên CLI/Cron không có REMOTE_ADDR
        $this->_ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $this->table_visitor = $wpdb->prefix . 'stats_visitor';
        $this->table_site    = $wpdb->prefix . 'stats_site';
    }

    public function web_visitor()
    {
        global $wpdb;

        // [Modified: 15/06/2026] Di chuyển bước kiểm tra lượt truy cập lên trước để sửa lỗi logic đè thời gian hoạt động.
        // ✅ 1. Check if this IP has visited within the last 5 minutes
        $check = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT ID FROM {$this->table_visitor} 
                 WHERE ip_address = %s 
                 AND last_active >= DATE_SUB(%s, INTERVAL 5 MINUTE)",
                $this->_ip,
                $this->_now
            )
        );

        // [Modified: 15/06/2026] Tự động khởi tạo hàng dữ liệu mặc định ID = 1 nếu chưa tồn tại
        // ✅ 2. If not active in the last 5 minutes, increment total views
        if (!$check) {
            $site_exists = $wpdb->get_var("SELECT ID FROM {$this->table_site} WHERE ID = 1");
            if (!$site_exists) {
                $wpdb->insert(
                    $this->table_site,
                    ['ID' => 1, 'total_views' => 1],
                    ['%d', '%d']
                );
            } else {
                $wpdb->query("UPDATE {$this->table_site} SET total_views = total_views + 1 WHERE ID = 1");
            }
        }

        // ✅ 3. Update or insert this visitor's record
        $exists = $wpdb->get_var(
            $wpdb->prepare("SELECT ID FROM {$this->table_visitor} WHERE ip_address = %s", $this->_ip)
        );

        if ($exists) {
            $wpdb->update(
                $this->table_visitor,
                ['last_active' => $this->_now],
                ['ip_address' => $this->_ip],
                ['%s'],
                ['%s']
            );
        } else {
            $wpdb->insert(
                $this->table_visitor,
                ['ip_address' => $this->_ip, 'last_active' => $this->_now],
                ['%s', '%s']
            );
        }

        // ✅ 4. Delete inactive records (older than 5 minutes)
        $sql = "DELETE FROM {$this->table_visitor} WHERE last_active < DATE_SUB('{$this->_now}', INTERVAL 5 MINUTE)";
        $wpdb->query($sql);
    }

    public function get_visitor_stats()
    {
        global $wpdb;
        // ✅ 5. Get online users count
        $online_users = $wpdb->get_var("SELECT COUNT(*) FROM {$this->table_visitor}");

        // ✅ 6. Get total views count
        $total_views = $wpdb->get_var("SELECT total_views FROM {$this->table_site} WHERE ID = 1");
        
        // [Modified: 15/06/2026] Fallback giá trị 0 nếu không tìm thấy dữ liệu lượt xem
        if ($total_views === null) {
            $total_views = 0;
        }

        // ✅ 7. Return stats
        return [
            'online_users' => intval($online_users),
            'total_views'  => intval($total_views),
        ];
    }
}
