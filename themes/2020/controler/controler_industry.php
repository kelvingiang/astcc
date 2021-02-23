<?php

require_once (DIR_MODEL . 'model_kind.php');

class Admin_Controler_Industry {

    private $model;

    public function __construct() {
        add_action('admin_menu', array($this, 'AddSubMenu'));
    }

    // PHAN TAO MENU CON TRONG MENU CHA CUNG LA POST TYPE
    public function AddSubMenu() {
        $parent_slug = 'page_about_us';
        $page_title = '行業分類';
        $menu_title = '行業分類';
        $capability = 'manage_categories';
        $menu_slug = 'industry_member';
        add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, array($this, 'dispatchActive'));
    }

    public function dispatchActive() {

        $this->model = new Admin_Model_kind();

        $action = getParams('action');
        switch ($action) {
            case 'add' :
                $this->addAction();
                break;
            case 'del':
                $this->deleteAction();
                break;
            default :
                $this->displayPage();
                break;
        }
    }

    public function displayPage() {
        require_once ( DIR_VIEW . 'industry-view.php');
    }

    public function addAction() {
        if (empty($_POST['hid-id'])) {
            $this->model->save($_POST,  array('action' => 'add' , 'kind' => 'a'));
        } else {
            $this->model->save($_POST, array('action' => 'edit' , 'kind' => 'a'));
        }
        toBack(1);
    }

    public function deleteAction() {
        $this->model->deleteItem(getParams('id'));
        toBack(1);
    }

}
