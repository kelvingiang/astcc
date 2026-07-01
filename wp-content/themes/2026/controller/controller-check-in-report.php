<?php

class Controller_Check_In_Report {

    public function __construct() {
        add_action('admin_menu', array($this, 'AddSubMenu'));
    }

    // PHAN TAO MENU CON TRONG MENU CHA CUNG LA POST TYPE
    public function AddSubMenu() {
        $parent_slug = 'tw_checkin';
        $page_title = __('Check In Report');
        $menu_title = __('Check In Report');
        $capability = 'manage_categories';
        $menu_slug = 'checkinreport';
        $icon = PART_ICON . '/staff-icon.png';  // THAM SO THU 6 LA LINK DEN ICON DAI DIEN
        $position = 18;
        add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, array($this, 'dispatchActive'), $icon, $position);
    }

    public function dispatchActive() {
//        echo __METHOD__;
        $action = getParams('action');
        switch ($action) {
            default :
                $this->displayPage();
                break;
        }
    }

    public function displayPage() {
        require_once ( DIR_VIEW . 'view-check-in-report.php');
    }


    
    

}
