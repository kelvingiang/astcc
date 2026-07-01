<?php

class Controller_Check_In_Event
{
    private $_model;
    public function __construct()
    {
        add_action('admin_menu', array($this, 'AddSubMenu'));

        require_once(DIR_MODEL . 'model-check-in-event-function.php');
        $this->_model = new Model_Check_In_Event_Function();
    }

    // PHAN TAO MENU CON TRONG MENU CHA CUNG LA POST TYPE
    public function AddSubMenu()
    {
        $parent_slug = 'tw_checkin';
        $page_title = __('報到活動');
        $menu_title = __('報到活動');
        $capability = 'manage_categories';
        $menu_slug = 'checkin_event';
        $icon = PART_ICON . '/staff-icon.png';  // THAM SO THU 6 LA LINK DEN ICON DAI DIEN
        $position = 18;
        add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, array($this, 'dispatchActive'), $icon, $position);
    }

    public function dispatchActive()
    {
        //        echo __METHOD__;
        $action = getParams('action');
        switch ($action) {
            case 'add':
            case 'edit':
                $this->addAction();
                break;
            case 'active':
                $this->activeAction();
                break;
            case 'view':
                $this->viewDetailAction();
                break;
            case 'export':
                $this->exportCheckInAction();
                break;
            case 'reset':
                $this->resetCheckInAction();
                break;
            case 'trash':
            case 'restore':
                $this->trashAction();
                break;
            case 'delete':
                $this->deleteAction();
                break;
            default:
                $this->displayPage();
                break;
        }
    }

    public function displayPage()
    {
        require_once(DIR_VIEW . 'view-check-in-event.php');
    }

    public function viewDetailAction()
    {
        require_once(DIR_VIEW . 'view-check-in-event-detail.php');
    }

    public function exportCheckInAction()
    {
        $this->_model->exportCheckIn(getParams('id'));
        toBack(1);
    }

    public function activeAction()
    {
        $this->_model->activeItem(getParams());
        toBack(1);
    }

    public function trashAction()
    {
        $this->_model->trashItem(getParams());
        toBack(1);
    }

    public function deleteAction()
    {
        $this->_model->deleteItem(getParams());
        toBack(1);
    }

    public function addAction()
    {
        if (isPost()) {
            $this->_model->saveItem($_POST, getParams('action'));
            toBack(1);
        }
        require_once(DIR_VIEW . 'from-check-in-event.php');
    }

    public function resetCheckInAction()
    {
        $this->_model->resetItem(getParams());
        toBack(1);
    }
}
