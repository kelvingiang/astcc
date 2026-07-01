<?php

class Controller_Check_In_Setting
{

    private $_model;
    public function __construct()
    {
        add_action('admin_menu', array($this, 'AddSubMenu'));

        require_once(DIR_MODEL . 'model-check-in-setting.php');
        $this->_model = new Model_Check_In_Setting();
    }

    // PHAN TAO MENU CON TRONG MENU CHA CUNG LA POST TYPE
    public function AddSubMenu()
    {
        $parent_slug = 'tw_checkin';
        $page_title = __('Check In Setting');
        $menu_title = __('Check In Setting');
        $capability = 'manage_categories';
        $menu_slug = 'checkinsetting';
        $icon = PART_ICON . '/staff-icon.png';  // THAM SO THU 6 LA LINK DEN ICON DAI DIEN
        $position = 18;
        add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, array($this, 'dispatchActive'), $icon, $position);
    }

    public function dispatchActive()
    {
        //        echo __METHOD__;
        $action = getParams('action');
        switch ($action) {
            case 'waiting':
                $this->waitingAction();
                break;
            case 'export_member':
                $this->ExportGuestsAction();
                break;
            case 'export_register_member':
                $this->ExportRegistryAction();
                break;
            case 'import_member':
                $this->ImportGuestsAction();
                break;
            case 'create_qrcode':
                $this->createQRCodeAction();
                break;
            default:
                $this->displayPage();
                break;
        }
    }

    public function displayPage()
    {
        require_once(DIR_VIEW . 'view-check-in-setting.php');
    }

    public function waitingAction()
    {
        if (isPost()) {
            update_option('waiting_text', $_POST['txt_wait']);
            update_option('time_zone', $_POST['sel_timezone']);
            toBack(1);
        }
        require_once(DIR_VIEW . 'view-check-in-waiting.php');
    }

    public function ExportGuestsAction()
    {
        $this->_model->ExportGuests();
    }

    public function ExportRegistryAction()
    {
        $this->_model->ExportRegistry();
    }

    // Import Group Function 
    public function ImportGuestsAction()
    {
        if (isPost()) {
            $errors = array();
            $file_name = $_FILES['myfile']['name'];
            $file_size = $_FILES['myfile']['size'];
            $file_tmp = $_FILES['myfile']['tmp_name'];
            $file_type = $_FILES['myfile']['type'];

            $file_trim = ((explode('.', $_FILES['myfile']['name'])));
            $trim_name = strtolower($file_trim[0]);
            $trim_type = strtolower($file_trim[1]);
            //$name = $_SESSION['login'];
            // $cus_name = 'avatar-'.$name . '.' . $trim_type;  //tao name moi cho file tranh trung va mat file

            $extensions = array("xls", "xlsx");
            if (in_array($trim_type, $extensions) === false) {
                $errors[] = "extension not allowed, please choose a excel file.";
            }
            // if ($file_size > 20097152) {
            //     $errors[] = 'File size must be excately 20 MB';
            // }
            if (empty($errors)) {
                // $path = WP_CONTENT_DIR . DS . 'themes' . DS . '2020' . DS . 'file' . DS;
                move_uploaded_file($file_tmp, (DIR_FILE . $file_name));

                $excelList = DIR_FILE . $file_name;

                $this->_model->ImportMember($excelList);
                toBack(1);
            }
        }
        require_once(DIR_VIEW . 'view-member-import.php');
    }

    public function CreateQRCodeAction()
    {
        $this->_model->BatchCreateQRCode();
        toBack(1);
    }


}
