<?php

class Admin_Controller_Main
{

    private $_controller_name = 'tw_controller_options';
    private $_controller_options = array();

    public function __construct()
    {
        $defaultoption = array(
            'industry_controller' => true,
            'link_business_controller' => true,
            'link_friend_controller' => true,
            'conference_controller' => true,
            'about_us_controller' => true,
            'slider_controller' => true,
            'chamber_controller' => true,
            'branch_controller' => true,
            'advertising_controller' => true,
            'supervisor_controller' => true,
            'schedule_controller' => true, // lich trinh
            'checkin_controller' => TRUE,
            'checkin_report_controller' => TRUE,
            'checkin_setting_controller' => TRUE,
            'countries_controller' =>true, // phan hoi cac nuoc
            'commerce_controller' => true, // tong hoi cac nuoc
            'president_controller' => false,
            'member_controller' => true,
            'vote_controller' => true
        );
        $login = wp_get_current_user();

        $this->_controller_options = get_option($this->_controller_name, $defaultoption);
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



    public function about_us_page()
    {
        if ($this->_controller_options['about_us_controller'] == true) {
            require_once(DIR_CONTROLLER . 'controller_about_us.php');
            new Admin_Controller_About_Us();
        }
    }

    public function advertising_post()
    {
        if ($this->_controller_options['advertising_controller'] == true) {
            require_once(DIR_CONTROLLER . 'controller_advertising.php');
            new Admin_Controller_Advertising();
        }
    }

    public function branch_post()
    {
        if ($this->_controller_options['branch_controller'] == true) {
            require_once(DIR_CONTROLLER . 'controller_branch.php');
            new Admin_Controller_Branch();
        }
    }

    public function chamber_post()
    {
        if ($this->_controller_options['chamber_controller'] == true) {
            require_once(DIR_CONTROLLER . 'controller_chamber.php');
            new Admin_Controller_Chamber();
        }
    }

    public function check_in_page()
    {
        if ($this->_controller_options['checkin_controller'] == TRUE) {
            require_once(DIR_CONTROLLER . 'controller_check_in.php');
            new Admin_Controller_Check_In();
        }
    }

    public function check_in_report_page()
    {
        if ($this->_controller_options['checkin_report_controller'] == TRUE) {
            require_once(DIR_CONTROLLER . 'controller_check_in_report.php');
            new Admin_Controller_Check_In_Report();
        }
    }

    public function check_in_setting_page()
    {
        if ($this->_controller_options['checkin_setting_controller'] == TRUE) {
            require_once(DIR_CONTROLLER . 'controller_check_in_setting.php');
            new Admin_Controller_Check_In_Setting();
        }
    }

    public function commerce_post()
    {
        if ($this->_controller_options['commerce_controller'] == true) {
            require_once(DIR_CONTROLLER . 'controller_commerce.php');
            new Admin_Controller_Commerce();
        }
    }

    public function conference_post()
    {
        if ($this->_controller_options['conference_controller'] == true) {
            require_once(DIR_CONTROLLER . 'controller_conference.php');
            new Admin_Controller_Conference();
        }
    }

    public function countries_post()
    {
        if ($this->_controller_options['countries_controller'] == true) {
            require_once(DIR_CONTROLLER . 'controller_countries.php');
            new Admin_Controller_Countries();
        }
    }

    public function Industry_option()
    {
        if ($this->_controller_options['industry_controller'] == true) {
            require_once(DIR_CONTROLLER . 'controller_industry.php');
            new Admin_Controller_Industry();
        }
    }

    public function businessLink_post()
    {
        if ($this->_controller_options['link_business_controller'] == true) {
            require_once(DIR_CONTROLLER . 'controller_link_business.php');
            new Admin_Controller_Link_Business();
        }
    }

    public function friendLink_post()
    {
        if ($this->_controller_options['link_friend_controller'] == true) {
            require_once(DIR_CONTROLLER . 'controller_link_friend.php');
            new Admin_Controller_Link_Friend();
        }
    }

    public function member_page()
    {
        if ($this->_controller_options['member_controller'] == true) {
            require_once(DIR_CONTROLLER . 'controller_member.php');
            new Admin_Controller_Member();
        }
    }

    public function president_post()
    {
        if ($this->_controller_options['president_controller'] == true) {
            require_once(DIR_CONTROLLER . 'controller_president.php');
            new Admin_Controller_President();
        }
    }

    public function schedule_page()
    {
        if ($this->_controller_options['schedule_controller'] == true) {
            require_once(DIR_CONTROLLER . 'controller_schedule.php');
            new Admin_Controller_Schedule();
        }
    }

    public function slider_post()
    {
        if ($this->_controller_options['slider_controller'] == true) {
            require_once(DIR_CONTROLLER . 'controller_slider.php');
            new Admin_Controller_Slider();
        }
    }

    public function supervisor_post()
    {
        if ($this->_controller_options['supervisor_controller'] == true) {
            require_once(DIR_CONTROLLER . 'controller_supervisor.php');
            new Admin_Controller_Supervisor();
        }
    }

    public function Vote_page()
    {
        if ($this->_controller_options['vote_controller'] == true) {
            require_once(DIR_CONTROLLER . 'controller_vote.php');
            new Admin_Controller_Vote();
        }
    }

    // FUNCTION NAY GIAI VIET CHUYEN TRANG BI LOI 
    public function do_output_buffer()
    {
        ob_start();
    }
}
