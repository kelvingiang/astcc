<?php

class Admin_Controler_Main {

    private $_controler_name = 'tw_controler_options';
    private $_controler_options = array();

    public function __construct() {
        $defaultoption = array(
            'industry_controler' => TRUE,
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
        $this->about_us_page();
        $this->advertising_post();
        $this->conference_post();
        $this->slider_post();
        $this->chamber_post();
        $this->branch_post();
        $this->businessLink_post();
        $this->friendLink_post();
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

    public function about_us_page() {
        if ($this->_controler_options['about_us_controler'] == true) {
            require_once(DIR_CONTROLER . 'controler_about_us.php');
            new Admin_Controler_About_Us();
        }
    }

    public function advertising_post() {
        if ($this->_controler_options['advertising_controler'] == true) {
            require_once (DIR_CONTROLER . 'controler_advertising.php');
            new Admin_Controler_Advertising();
        }
    }

    public function branch_post() {
        if ($this->_controler_options['branch_controler'] == true) {
            require_once (DIR_CONTROLER . 'controler_branch.php');
            new Admin_Controler_Branch();
        }
    }

    public function chamber_post() {
        if ($this->_controler_options['chamber_controler'] == true) {
            require_once(DIR_CONTROLER . 'controler_chamber.php');
            new Admin_Controler_Chamber();
        }
    }

    public function check_in_page() {
        if ($this->_controler_options['checkin_controler'] == TRUE) {
            require_once(DIR_CONTROLER . 'controler_check_in.php');
            new Admin_Controler_Check_In();
        }
    }

    public function check_in_report_page() {
        if ($this->_controler_options['checkin_report_controler'] == TRUE) {
            require_once(DIR_CONTROLER . 'controler_check_in_report.php');
            new Admin_Controler_Check_In_Report();
        }
    }

    public function check_in_setting_page() {
        if ($this->_controler_options['checkin_setting_controler'] == TRUE) {
            require_once(DIR_CONTROLER . 'controler_check_in_setting.php');
            new Admin_Controler_Check_In_Setting();
        }
    }

    public function commerce_post() {
        if ($this->_controler_options['commerce_controler'] == true) {
            require_once (DIR_CONTROLER . 'controler_commerce.php');
            new Admin_Controler_Commerce();
        }
    }

    public function conference_post() {
        if ($this->_controler_options['conference_controler'] == true) {
            require_once (DIR_CONTROLER . 'controler_conference.php');
            new Admin_Controler_Conference();
        }
    }

    public function countries_post() {
        if ($this->_controler_options['countries_controler'] == true) {
            require_once (DIR_CONTROLER . 'controler_countries.php');
            new Admin_Controler_Countries();
        }
    }

    public function Industry_option() {
        if ($this->_controler_options['industry_controler'] == true) {
            require_once (DIR_CONTROLER . 'controler_industry.php');
            new Admin_Controler_Industry();
        }
    }

    public function businessLink_post() {
        if ($this->_controler_options['link_business_controler'] == true) {
            require_once(DIR_CONTROLER . 'controler_link_business.php');
            new Admin_Controler_Link_Business();
        }
    }

    public function friendLink_post() {
        if ($this->_controler_options['link_friend_controler'] == true) {
            require_once(DIR_CONTROLER . 'controler_link_friend.php');
            new Admin_Controler_Link_Friend();
        }
    }

    public function member_page() {
        if ($this->_controler_options['member_controler'] == true) {
            require_once (DIR_CONTROLER . 'controler_member.php');
            new Admin_Controler_Member();
        }
    }

    public function president_post() {
        if ($this->_controler_options['president_controler'] == true) {
            require_once (DIR_CONTROLER . 'controler_president.php');
            new Admin_Controler_President();
        }
    }

    public function schedule_page() {
        if ($this->_controler_options['schedule_controler'] == true) {
            require_once(DIR_CONTROLER . 'controler_schedule.php');
            new Admin_Controler_Schedule();
        }
    }

    public function slider_post() {
        if ($this->_controler_options['slider_controler'] == true) {
            require_once(DIR_CONTROLER . 'controler_slider.php');
            new Admin_Controler_Slider();
        }
    }

    public function supervisor_post() {
        if ($this->_controler_options['supervisor_controler'] == true) {
            require_once (DIR_CONTROLER . 'controler_supervisor.php');
            new Admin_Controler_Supervisor();
        }
    }

    public function Vote_page() {
        if ($this->_controler_options['vote_controler'] == true) {
            require_once (DIR_CONTROLER . 'controler_vote.php');
            new Admin_Controler_Vote();
        }
    }

}
