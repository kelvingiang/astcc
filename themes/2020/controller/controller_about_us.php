<?php

class Admin_Controller_About_Us {

    public function __construct() {
        add_action('admin_menu', array($this, 'AddToMenu'));
    }

    public function AddToMenu() {
        // THEM 1 NHOM MENU MOI VAO TRONG ADMIN MENU
        $page_title = __('關於我們'); // TIEU DE CUA TRANG 
        $menu_title = __('關於我們');  // TEN HIEN TRONG MENU
// CHON QUYEN TRUY CAP manage_categories DE role ADMINNITRATOR VÀ EDITOR DEU THAY DUOC
        $capability = 'manage_categories'; // QUYEN TRUY CAP DE THAY MENU NAY
        $menu_slug = 'page_about_us'; // TEN slug TEN DUY NHAT KO DC TRUNG VOI TRANG KHAC GAN TREN THANH DIA CHI OF MENU
// THAM SO THU 5 GOI DEN HAM HIEN THI GIAO DIEN TRONG MENU
        $icon = PART_ICON . 'admin-icon.png';  // THAM SO THU 6 LA LINK DEN ICON DAI DIEN
        $position = 3; // VI TRI HIEN THI TRONG MENU

        add_menu_page($page_title, $menu_title, $capability, $menu_slug, array($this, 'dispatchActive'), $icon, $position);
    }

    // Phan dieu huong 
    public function dispatchActive() {
        $action = getParams('action');
        switch ($action) {
            default :
                $this->displayPage();
                break;
        }
    }

    public function createUrl() {
        echo $url = 'admin.php?page=' . getParams('page');
        if (mb_strlen(getParams('s'))) {
            $url .= '&s=' . getParams('s');
        }
        return $url;
    }

//---------------------------------------------------------------------------------------------
// Cmt CAC CHUC NANG THEM XOA SUA VA HIEN THI
//---------------------------------------------------------------------------------------------
// CAC DISPLAY PAGE
    public function displayPage() {
// LOC DU LIEU KHI action = -1 CO NGHIA LA DANG LOI DU LIEU (CHO 2 TRUONG HOP search va filter)
        if (getParams('action') == -1) {
            $url = $this->createUrl();
            wp_redirect($url);
        }
        if (isPost()) {
            require_once(DIR_MODEL . 'model_about_us.php');
            $model = new Admin_Model_About_Us();
            $model->Save($_POST);
        }
        require_once ( DIR_VIEW . 'about_us_view.php');
    }

}
