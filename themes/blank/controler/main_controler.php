<?php

class Admin_Main_controler {

    private $_controler_name = 'tw_controler_options';
    private $_controler_options = array();

    public function __construct() {
        $defaultoption = array(
            'industry_controler' =>TRUE,
            'link_business_controler' => TRUE,
            'link_friend_controler' => TRUE,
            'conference_controler' => TRUE,
            'about_us_controler' => TRUE,
            'slider_controler' => TRUE,
            'chamber_controler' => TRUE,
            'branch_controler' => TRUE,
            'advertising_controler' => TRUE,
            'supervisor_controler' => TRUE,
            'schedule_controler' => TRUE, // lich trinh
            'checkin_controler' => TRUE,
            'checkin_report_controler' => TRUE,
            'checkin_setting_controler' => TRUE,
            'countries_controler' => FALSE, // phan hoi cac nuoc
            'commerce_controler' => FALSE, // tong hoi cac nuoc
            'president_controler' => FALSE,
            'member_controler' => FALSE,
            'vote_controler' => TRUE
        );
        $login = wp_get_current_user();

        $this->_controler_options = get_option($this->_controler_name, $defaultoption);
        $this->Conference_post();
        $this->About_us_page();
        $this->slider_post();
        $this->chamber_post();
        $this->branch_post();
        $this->businessLink_post();
        $this->friendLink_post();
        $this->advertising_post();
        $this->supervisor_post();
        $this->schedule_page();
        $this->check_in_page();
        $this->check_in_report_page();
        $this->countries_post();
        $this->commerce_post();
        $this->president_post();
        $this->member_page();
        $this->Vote_page();
        $this->Industry_option();

        if ($login->ID == 1) {
            $this->check_in_setting_page();
        }
        add_action('admin_init', array($this, 'do_output_buffer'));
    }

    // FUNCTION NAY GIAI VIET CHUYEN TRANG BI LOI 
    public function do_output_buffer() {
        ob_start();
    }
    
    public function Industry_option(){
        if($this->_controler_options['industry_controler'] == true){
            require_once (CONTROLER_DIR .'industry_controler.php');
            new Admin_Industry_Controler();
        }
    }
    
    
    public function Conference_post() {
        if ($this->_controler_options['conference_controler'] == true) {
            require_once (CONTROLER_DIR . 'conference_controler.php');
            new Admin_Conference_Controler();
        }
    }

    public function Vote_page() {
        if ($this->_controler_options['vote_controler'] == true) {
            require_once (CONTROLER_DIR . 'vote_controler.php');
           new Admin_Vote_Controler();
        }
    }

    public function About_us_page() {
        if ($this->_controler_options['about_us_controler'] == true) {
            require_once(CONTROLER_DIR . 'about_us_controler.php');
            new Admin_About_Us_Controler();
        }
    }

    public function slider_post() {
        if ($this->_controler_options['slider_controler'] == true) {
            require_once(CONTROLER_DIR . 'slider_controler.php');
            new Admin_Slider_controler();
        }
    }

    public function branch_post() {
        if ($this->_controler_options['branch_controler'] == true) {
            require_once (CONTROLER_DIR . 'branch_controler.php');
            new Admin_Branch_Controler();
        }
    }

    public function chamber_post() {
        if ($this->_controler_options['chamber_controler'] == true) {
            require_once(CONTROLER_DIR . 'chamber_controler.php');
            new Admin_Chamber_Controler();
        }
    }

    public function businessLink_post() {
        if ($this->_controler_options['link_business_controler'] == true) {
            require_once(CONTROLER_DIR . 'link_business_controler.php');
            new Admin_Link_business_controler();
        }
    }

    public function friendLink_post() {
        if ($this->_controler_options['link_friend_controler'] == true) {
            require_once(CONTROLER_DIR . 'link_friend_controler.php');
            new Admin_Link_Friend_controler();
        }
    }

    public function advertising_post() {
        if ($this->_controler_options['advertising_controler'] == true) {
            require_once (CONTROLER_DIR . 'advertising_controler.php');
            new Admin_Advertising_Controler();
        }
    }

    public function supervisor_post() {
        if ($this->_controler_options['supervisor_controler'] == true) {
            require_once (CONTROLER_DIR . 'supervisor_controler.php');
            new Admin_Supervisor_Controler();
        }
    }

    public function schedule_page() {
        if ($this->_controler_options['schedule_controler'] == true) {
            require_once(CONTROLER_DIR . 'schedule_controler.php');
            new Admin_Schedule_Controler();
        }
    }

    public function check_in_page() {
        if ($this->_controler_options['checkin_controler'] == TRUE) {
            require_once(CONTROLER_DIR . 'check_in_controler.php');
            new Admin_Check_In_Controler();
        }
    }

    public function check_in_report_page() {
        if ($this->_controler_options['checkin_report_controler'] == TRUE) {
            require_once(CONTROLER_DIR . 'check_in_report_controler.php');
            new Admin_Check_In_Report_Controler();
        }
    }

    public function check_in_setting_page() {
        if ($this->_controler_options['checkin_setting_controler'] == TRUE) {
            require_once(CONTROLER_DIR . 'check_in_setting_controler.php');
            new Admin_Check_In_Setting_Controler();
        }
    }

    public function countries_post() {

        if ($this->_controler_options['countries_controler'] == true) {
            require_once (CONTROLER_DIR . 'countries_controler.php');
            new Admin_Countries_Controler();
        }
    }

    public function commerce_post() {
        if ($this->_controler_options['commerce_controler'] == true) {
            require_once (CONTROLER_DIR . 'commerce_controler.php');
            new Admin_Commerce_Controler();
        }
    }

    public function president_post() {
        if ($this->_controler_options['president_controler'] == true) {
            require_once (CONTROLER_DIR . 'president_controler.php');
            new Admin_President_Controler();
        }
    }

    public function member_page() {
        if ($this->_controler_options['member_controler'] == true) {
            require_once (CONTROLER_DIR . 'member_controler.php');
            new Admin_Member_Controler();
        }
    }

}
