<?php

class Admin_metabox {

    private $_metabox_name = 'metabox_options';
    private $_metabox_options = array();

    public function __construct() {
        $defaultoption = array(
            'metabox_country' => TRUE,
            'metabox_home' => TRUE,
            'metabox_order' => TRUE,
            'metabox_seo' => TRUE,
            'metabox_website' => TRUE,
            'metabox_special' => TRUE,
            'metabox_countries' => TRUE,
            'metabox_commerce' => TRUE,
            'metabox_president' => FALSE,
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
    }

    public function country() {
        if ($this->_metabox_options['metabox_country'] == true) {
            require_once (METABOX_DIR . 'country.php');
            new Admin_Metabox_Country();
        }
    }

    public function home() {
        if ($this->_metabox_options['metabox_home'] == true) {
            require_once (METABOX_DIR . 'home.php');
            new Admin_Metabox_Home();
        }
    }

    public function order() {
        if ($this->_metabox_options['metabox_order'] == true) {
            require_once (METABOX_DIR . 'order.php');
            new Admin_Metabox_Order();
        }
    }

    public function seo() {
        if ($this->_metabox_options['metabox_seo'] == true) {
            require_once(METABOX_DIR . 'seo.php');
            new Admin_Metabox_Seo();
        }
    }

    public function website() {
        if ($this->_metabox_options['metabox_website'] == true) {
            require_once (METABOX_DIR . 'website.php');
            new Admin_Metabox_website();
        }
    }

    public function SpecialShow() {
        if ($this->_metabox_options['metabox_special'] == true) {
            require_once (METABOX_DIR . 'special.php');
            new Admin_Metabox_Special();
        }
    }

    public function Countries() {
        if ($this->_metabox_options['metabox_countries'] == true) {
            require_once (METABOX_DIR . 'countries.php');
            new Admin_Metabox_Countries();
        }
    }

    public function Commerce() {
        if ($this->_metabox_options['metabox_commerce'] == true) {
            require_once (METABOX_DIR . 'commerce.php');
            new Admin_Metabox_Commerce();
        }
    }

    public function President() {
        if ($this->_metabox_options['metabox_president'] == true) {
            require_once (METABOX_DIR . 'president.php');
            new Admin_Metabox_President();
        }
    }

}
