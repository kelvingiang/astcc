<?php

class Admin_metabox {

    private $_metabox_name = 'metabox_options';
    private $_metabox_options = array();

    public function __construct() {
        $defaultoption = array(
            'metabox_country' => TRUE,
            'metabox_home' => false,
            'metabox_order' => TRUE,
            'metabox_seo' => TRUE,
            'metabox_website' => TRUE,
            'metabox_special' => TRUE,
            'metabox_countries' => TRUE,
            'metabox_commerce' => TRUE,
            'metabox_president' => FALSE,
            'metabox_job_title' => TRUE
        );
        $this->_metabox_options = get_option($this->_metabox_name, $defaultoption);
        $this->Country();
        $this->home();
        $this->order();
        $this->seo();
        $this->website();
        $this->SpecialShow();
        $this->Countries();
        $this->Commerce();
        $this->President();
        $this->job_title();
    }

    public function job_title() {
        if ($this->_metabox_options['metabox_job_title'] == true) {
            require_once (DIR_METABOX . 'job_title.php');
            new Admin_Metabox_Job_Title();
        }
    }

    public function country() {
        if ($this->_metabox_options['metabox_country'] == true) {
            require_once (DIR_METABOX . 'country.php');
            new Admin_Metabox_Country();
        }
    }

    public function home() {
        if ($this->_metabox_options['metabox_home'] == true) {
            require_once (DIR_METABOX . 'home.php');
            new Admin_Metabox_Home();
        }
    }

    public function order() {
        if ($this->_metabox_options['metabox_order'] == true) {
            require_once (DIR_METABOX . 'order.php');
            new Admin_Metabox_Order();
        }
    }

    public function seo() {
        if ($this->_metabox_options['metabox_seo'] == true) {
            require_once(DIR_METABOX . 'seo.php');
            new Admin_Metabox_Seo();
        }
    }

    public function website() {
        if ($this->_metabox_options['metabox_website'] == true) {
            require_once (DIR_METABOX . 'website.php');
            new Admin_Metabox_website();
        }
    }

    public function SpecialShow() {
        if ($this->_metabox_options['metabox_special'] == true) {
            require_once (DIR_METABOX . 'special.php');
            new Admin_Metabox_Special();
        }
    }

    public function Countries() {
        if ($this->_metabox_options['metabox_countries'] == true) {
            require_once (DIR_METABOX . 'countries.php');
            new Admin_Metabox_Countries();
        }
    }

    public function Commerce() {
        if ($this->_metabox_options['metabox_commerce'] == true) {
            require_once (DIR_METABOX . 'commerce.php');
            new Admin_Metabox_Commerce();
        }
    }

    public function President() {
        if ($this->_metabox_options['metabox_president'] == true) {
            require_once (DIR_METABOX . 'president.php');
            new Admin_Metabox_President();
        }
    }

}
