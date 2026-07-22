<?php
// [18/06/2026] Fix Security: Chặn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

class Controller_Main
{
    private $_controller_name = 'tw_controller_options';
    private $_controller_options = array();

    public function __construct()
    {
        $default_option = array(
            'link_friend_controller' => true,
            'about_us_controller' => true,
            'slider_controller' => true,
            'chamber_controller' => true,
            'branch_controller' => true,
            'supervisor_controller' => true,
            'schedule_controller' => true,
            //=======================================================
            'checkin_controller' => false,
            'checkin_report_controller' => false,
            'checkin_event_controller' => false,
            'checkin_setting_controller' => false,
            
            'commerce_controller' => false,
            'conference_controller' => false,
            'industry_controller' => false,
            'countries_controller' => false,
            'link_business_controller' => false,
            'advertising_controller' => false,
            'president_controller' => false,
            'member_controller' => false,
            'vote_controller' => false,
        );

        $this->_controller_options = get_option($this->_controller_name, $default_option);

        // [18/06/2026] Tối ưu DRY: Gom nhóm danh sách controller vào mảng để khởi tạo tự động. 
        // Xóa bỏ hàng chục hàm kiểm tra lặp lại (ví dụ about_us_page, advertising_post...).
        $controllers = array(
            'about_us_controller'       => array('controller-about-us.php', 'Controller_About_Us'),
            'advertising_controller'    => array('controller-advertising.php', 'Controller_Advertising'),
            'conference_controller'     => array('controller-conference.php', 'Controller_Conference'),
            'slider_controller'         => array('controller-slider.php', 'Controller_Slider'),
            'chamber_controller'        => array('controller-chamber.php', 'Controller_Chamber'),
            'branch_controller'         => array('controller-branch.php', 'Controller_Branch'),
            'link_business_controller'  => array('controller-link-business.php', 'Controller_Link_Business'),
            'link_friend_controller'    => array('controller-link-friend.php', 'Controller_Link_Friend'),
            'supervisor_controller'     => array('controller-supervisor.php', 'Controller_Supervisor'),
            'schedule_controller'       => array('controller-schedule.php', 'Controller_Schedule'),
            'checkin_controller'        => array('controller-check-in.php', 'Controller_Check_In'),
            'checkin_report_controller' => array('controller-check-in-report.php', 'Controller_Check_In_Report'),
            'checkin_event_controller'  => array('controller-check-in-event.php', 'Controller_Check_In_Event'), // Fix Bug: Đã được bổ sung gọi (trước đó quên gọi)
            'countries_controller'      => array('controller-countries.php', 'Controller_Countries'),
            'commerce_controller'       => array('controller-commerce.php', 'Controller_Commerce'),
            'president_controller'      => array('controller-president.php', 'Controller_President'),

            'vote_controller'           => array('controller-vote.php', 'Controller_Vote'),
            'industry_controller'       => array('controller-industry.php', 'Controller_Industry'),
        );

        foreach ($controllers as $key => $info) {
            if (!empty($this->_controller_options[$key])) {
                require_once(DIR_CONTROLLER . $info[0]);
                new $info[1]();
            }
        }

        $login = wp_get_current_user();
        if (isset($login->ID) && $login->ID == 1) {
            if (!empty($this->_controller_options['checkin_setting_controller'])) {
                require_once(DIR_CONTROLLER . 'controller-check-in-setting.php');
                new Controller_Check_In_Setting();
            }
        }

        // FUNCTION NAY GIAI QUYET CHUYEN TRANG BI LOI (Cannot modify header)
        add_action('admin_init', array($this, 'do_output_buffer'));
    }

    public function do_output_buffer()
    {
        ob_start();
    }
}
