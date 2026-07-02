<?php

class metabox_Main {

    private $_metabox_name = 'metabox_options';
    private $_metabox_options = array();

    // Map option keys to file names and class names
    private $_metabox_map = array(
        'metabox_country'   => array('file' => 'meta-country.php',   'class' => 'Metabox_Country'),
        'metabox_home'      => array('file' => 'meta-home.php',      'class' => 'Metabox_Home'),
        'metabox_order'     => array('file' => 'meta-order.php',     'class' => 'Metabox_Order'),
        'metabox_seo'       => array('file' => 'meta-seo.php',       'class' => 'Metabox_Seo'),
        'metabox_website'   => array('file' => 'meta-website.php',   'class' => 'Metabox_website'),
        'metabox_special'   => array('file' => 'meta-special.php',   'class' => 'Metabox_Special'),
        'metabox_countries' => array('file' => 'meta-countries.php', 'class' => 'Metabox_Countries'),
        'metabox_commerce'  => array('file' => 'meta-commerce.php',  'class' => 'Metabox_Commerce'),
        'metabox_president' => array('file' => 'meta-president.php', 'class' => 'Metabox_President'),
        'metabox_job_title' => array('file' => 'meta-job-title.php', 'class' => 'Metabox_Job_Title')
    );

    public function __construct() {
        $default_options = array(
            'metabox_country'   => true,
            'metabox_home'      => false,
            'metabox_order'     => true,
            'metabox_seo'       => true,
            'metabox_website'   => true,
            'metabox_special'   => true,
            'metabox_countries' => true,
            'metabox_commerce'  => true,
            'metabox_president' => false,
            'metabox_job_title' => true
        );
        $this->_metabox_options = get_option($this->_metabox_name, $default_options);
        
        $this->load_metaboxes();
    }

    private function load_metaboxes() {
        foreach ($this->_metabox_map as $key => $data) {
            if (!empty($this->_metabox_options[$key])) {
                require_once(DIR_METABOX . $data['file']);
                if (class_exists($data['class'])) {
                    new $data['class']();
                }
            }
        }
    }
}
