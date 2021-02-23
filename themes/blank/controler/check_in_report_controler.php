<?php

class Admin_Check_In_Report_Controler {

    public function __construct() {
        add_action('admin_menu', array($this, 'CheckInReportAdminMenu'));
    }

    // PHAN TAO MENU CON TRONG MENU CHA CUNG LA POST TYPE
    public function CheckInReportAdminMenu() {
        $parent_slug = 'tw_checkin';
        $page_title = __('Check In Report');
        $menu_title = __('Check In Report');
        $capability = 'manage_categories';
        $menu_slug = 'checkinreport';
        $icon = ICON_DIR . '/staff-icon.png';  // THAM SO THU 6 LA LINK DEN ICON DAI DIEN
        $position = 18;
        add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, array($this, 'dispatchActive'), $icon, $position);
    }

    public function dispatchActive() {
//        echo __METHOD__;
        $action = getParams('action');
        switch ($action) {
            case 'export':
                $this->exportAction();
                break;
            case 'barcode':
                $this->barcodeAction();
                break;
            case 'waiting':
                $this->waitingAction();
                break;
       
            default :
                $this->displayPage();
                break;
        }
    }

    public function displayPage() {
        require_once ( VIEW_DIR . 'check_in_report_view.php');
    }

    public function exportAction() {
        require_once (MODEL_DIR . 'check_in_setting_model.php');
        $model = new Admin_Check_In_Setting_model();
        $model->ExCheckInToExcel();
    }

    public function barcodeAction() {
        require_once (MODEL_DIR . 'check_in_report_model.php');
        $model = new Admin_Check_In_Report_model();
        $model->ExportBarcode();
    }

    public function waitingAction() {
        if (isPost()) {
            update_option("waiting_text", $_POST['txt_wait']);
            update_option("title_text", $_POST['txt_title']);
            update_option('time_zone', $_POST['sel_timezone']);

            $paged = max(1, $arrParams['paged']);
            $url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
            wp_redirect($url);
        }
        require_once (VIEW_DIR . 'check_in_waiting_view.php');
    }
    
    

}
