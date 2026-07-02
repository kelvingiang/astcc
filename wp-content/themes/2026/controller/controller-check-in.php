<?php
// [18/06/2026] Fix Security: Chặn truy cập trực tiếp vào file
if (!defined('ABSPATH')) {
    exit;
}

class Controller_Check_In {

    // [18/06/2026] Refactor: Tạo property chứa model để tái sử dụng, tránh lặp lại require_once nhiều lần. (DRY)
    private $model;

    public function __construct() {
        add_action('admin_menu', array($this, 'AddToMenu'));
    }

    private function getModel() {
        if ($this->model === null) {
            require_once(DIR_MODEL . 'model-check-in-function.php');
            $this->model = new Model_Check_In_Function();
        }
        return $this->model;
    }

    public function AddToMenu() {
        $page_title = '報到系統'; 
        $menu_title = '報到系統 ';  
        $capability = 'manage_categories'; 
        $menu_slug  = 'tw_checkin'; 
        $icon       = PART_ICON . '/staff-icon.png';  
        $position   = 17; 

        add_menu_page($page_title, $menu_title, $capability, $menu_slug, array($this, 'dispatchActive'), $icon, $position);
    }

    public function dispatchActive() {
        $action = getParams('action');
        switch ($action) {
            case 'add':
                $this->addAction();
                break;
            case 'edit':
                $this->editAction();
                break;
            case 'delete':
                $this->deleteAction();
                break;
            case 'trash':
                $this->trashAction();
                break;
            case 'uncheckin':
                $this->uncheckinAction();
                break;
            case 'restore':
                $this->restoreAction();
                break;
            default :
                $this->displayPage();
                break;
        }
    }

    public function createUrl() {
        // [18/06/2026] Fix Bug: Xóa bỏ lệnh `echo` gây lỗi in thừa URL ra màn hình và có thể cản trở wp_redirect (Cannot modify header information).
        $url = 'admin.php?page=' . getParams('page');

        if (getParams('filter_country') != '0' && getParams('filter_country') != ' ') {
            $url .= '&filter_country=' . getParams('filter_country');
        }

        if (mb_strlen(getParams('s'))) {
            $url .= '&s=' . getParams('s');
        }

        return $url;
    }

    public function displayPage() {
        if (getParams('action') == -1) {
            $url = $this->createUrl();
            wp_redirect($url);
            exit; // [18/06/2026] Fix Security: Bắt buộc gọi exit sau wp_redirect để ngắt luồng thực thi
        }
        require_once(DIR_VIEW . 'view-check-in.php');
    }

    public function addAction() {
        if (isPost()) {
            $model = $this->getModel();
            $model->saveItem($_POST);

            // [18/06/2026] Fix Bug: Định nghĩa biến $arrParams trước khi sử dụng để tránh lỗi Undefined variable
            $arrParams = getParams();
            $paged = isset($arrParams['paged']) ? max(1, $arrParams['paged']) : 1;
            $url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
            
            // Xử lý gửi lỗi validate/upload (nếu có) thông qua URL params
            $errors = $model->getError();
            if (!empty($errors)) {
                $url .= '&e=' . urlencode(json_encode($errors));
            }

            wp_redirect($url);
            exit; // [18/06/2026] Fix Security: Luôn exit sau khi wp_redirect
        }
        require_once(DIR_VIEW . 'from-check-in.php');
    }

    public function editAction() {
        $model = $this->getModel();

        if (isPost()) {
            $model->saveItem($_POST);
            
            // [18/06/2026] Tối ưu UX/Luồng: Bổ sung redirect sau khi submit cập nhật để tránh việc bị resubmit dữ liệu (Form Resubmission) khi user vô tình nhấn F5.
            $arrParams = getParams();
            $paged = isset($arrParams['paged']) ? max(1, $arrParams['paged']) : 1;
            $id = isset($_POST['hidden_ID']) ? $_POST['hidden_ID'] : '';
            $url = 'admin.php?page=' . $_REQUEST['page'] . '&action=edit&id=' . $id . '&paged=' . $paged . '&msg=1';
            
            $errors = $model->getError();
            if (!empty($errors)) {
                $url .= '&e=' . urlencode(json_encode($errors));
            }
            
            wp_redirect($url);
            exit;
        } else {
            $data = $model->get_item(getParams());  
        }
        require_once(DIR_VIEW . 'from-check-in.php');
    }

    public function uncheckinAction() {
        $arrParams = getParams();
        $model = $this->getModel();

        if (isset($arrParams['check']) && $arrParams['check'] == 0 && !is_array(isset($arrParams['id']) ? $arrParams['id'] : null)) {
            $model->checkin($arrParams);
        } else {
            $model->uncheckinItem($arrParams);
        }

        $paged = isset($arrParams['paged']) ? max(1, $arrParams['paged']) : 1;
        $url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
        wp_redirect($url);
        exit; // [18/06/2026] Fix Security: Luôn exit sau khi wp_redirect
    }

    public function deleteAction() {
        $arrParam = getParams();
        $model = $this->getModel();
        $model->deleteItem($arrParam);

        $paged = isset($arrParam['paged']) ? max(1, $arrParam['paged']) : 1;
        $url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
        wp_redirect($url);
        exit; // [18/06/2026] Fix Security: Luôn exit sau khi wp_redirect
    }

    public function restoreAction() {
        $arrParams = getParams();
        $model = $this->getModel();
        $model->restoreItem($arrParams);

        $paged = isset($arrParams['paged']) ? max(1, $arrParams['paged']) : 1;
        $url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
        wp_redirect($url);
        exit; // [18/06/2026] Fix Security: Luôn exit sau khi wp_redirect
    }

    public function trashAction() {
        $arrParams = getParams();
        $model = $this->getModel();
        $model->trashItem($arrParams);

        $paged = isset($arrParams['paged']) ? max(1, $arrParams['paged']) : 1;
        $url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
        wp_redirect($url);
        exit; // [18/06/2026] Fix Security: Luôn exit sau khi wp_redirect
    }

}

