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
        $this->_ip = $_SERVER['REMOTE_ADDR'];
        $this->table_visitor = $wpdb->prefix . 'stats_visitor';
        $this->table_site    = $wpdb->prefix . 'stats_site';
    }

    public function web_visitor()
    {
        global $wpdb;

        // ✅ 3. 更新或插入該訪客記錄
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
            $wpdb->query("UPDATE {$this->table_site} SET total_views = total_views + 1 WHERE ID = 1");
        }

        //  // ✅ 1. 檢查此 IP 是否在 5 分鐘內已來訪
        $check = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT ID FROM {$this->table_visitor} 
                 WHERE ip_address = %s 
                 AND last_active >= DATE_SUB(%s, INTERVAL 5 MINUTE)",
                $this->_ip,
                $this->_now
            )
        );

        // ✅ 2. 若沒有出現過，總瀏覽次數 +1
        if (!$check) {
            $wpdb->query("UPDATE {$this->table_site} SET total_views = total_views + 1 WHERE ID = 1");
        }

        // ✅ 4. 清除 5 分鐘內未活動的紀錄（已離線）
        // $wpdb->query("DELETE FROM {$this->table_visitor} WHERE last_active < (NOW() - INTERVAL 5 MINUTE)");
        $sql = "DELETE FROM {$this->table_visitor} WHERE last_active < DATE_SUB('{$this->_now}', INTERVAL 5 MINUTE)";
        $wpdb->query($sql);
    }

    public function get_visitor_stats()
    {
        global $wpdb;
        // ✅ 5. 統計目前在線人數
        $online_users = $wpdb->get_var("SELECT COUNT(*) FROM {$this->table_visitor}");

        // ✅ 6. 取得總瀏覽次數
        $total_views = $wpdb->get_var("SELECT total_views FROM {$this->table_site} WHERE ID = 1");

        // ✅ 7. 回傳結果
        return [
            'online_users' => intval($online_users),
            'total_views'  => intval($total_views),
        ];
    }
}
