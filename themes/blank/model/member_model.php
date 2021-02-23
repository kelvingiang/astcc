<?php

// KIEM TRA  WP_List_Table CO TON TAI CHUA NEU CHUA SE INCLUSE VAO
if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php ';
}

class Admin_QR_Member_Model extends WP_List_Table {

    private $_pre_page = 30;
    private $_sql;
    private $_stt = 1;

    public function __construct($args = array()) {
        $args = array(
            'plural' => 'ID', // GIA TRI NAY TUONG UNG VOI key TRONG table
            'singular' => 'ID', // GIA TRI NAY TUONG UNG VOI key TRONG table
            'ajax' => FALSE,
            'screen' => null,
        );
        parent::__construct($args);
    }

// HAM NAY BAT BUOT PHAI CO QUAN TRONG DE SHOW LIST RA
//  CAC THONG SO VA DU LIEU CAN  CUNG CAP DE HIEN THI GIRDVIEW
    public function prepare_items() {
        $columns = $this->get_columns();  // NHUNG GI CAN HIEN THI TREN BANG 
        $hidden = $this->get_hidden_columns(); // NHUNG COT TA SE AN DI
        $sorttable = $this->get_sortable_columns(); // CAC COT DC SAP XEP TANG HOAC GIAM DAN

        $this->_column_headers = array($columns, $hidden, $sorttable); //DUA 3 GIA TRI TREN VAO DAY DE SHOW DU LIEU
        $this->items = $this->table_data(); // LAY DU LIEU TU DATABASE

        $total_items = $this->total_items(); // TONG SO DONG DA LIEU
        $per_page = $this->_pre_page; // SO TRANG 
        $total_pages = ceil($total_items / $per_page); // TONG SO TRANG
// PHAN TRANG
        $args = array(
            'total_items' => $total_items,
            'per_page' => $per_page,
            'total_pages' => $total_pages
        );
        $this->set_pagination_args($args);
    }

//---------------------------------------------------------------------------------------------
// Cmt NHOM NHAT DINH  PHAI CO CHO LIST NAY
//---------------------------------------------------------------------------------------------
// LAY CAC COT TUONG UNG TRONG DATABASE DAN VAO CAC COT TREN LUOI
    public function get_columns() {
        $arr = array(
            'cb' => '<input type="checkbox" />',
            //   'id'            => 'ID',
            'img' => '照片',
            'fullname' => '姓名',
            'branch' => '分會',
            'position' => '職稱',
            'barcode' => '條碼',
            'phone' => '電話',
            'email' => 'email',
            'checkin' => '報到',
                // 'note' => '備註'
        );
        return $arr;
    }

// KHIA BAO CAC COT BI AN DI TREN GRIDVIEW
    public function get_hidden_columns() {
        return array('');
    }

// COLUMN SAP XEP THU TANG HOAC GIAM DAN
    public function get_sortable_columns() {
        return array(
            'checkin' => array('check_in', true),
            'position' => array('position', true),
            'country' => array('country', true),
            'id' => array('id', true),
        );
    }

//---------------------------------------------------------------------------------------------
// Cmt NHOM GET DATA TU DATABASE
//---------------------------------------------------------------------------------------------
// GET DATA TRONG DATABASE 
    private function table_data() {
        $data = array();
        global $wpdb;
// LAY GIA TRI SAP XEP DU LIEU TREN COT
        $orderby = (getParams('orderby') == ' ') ? 'id' : $_GET['orderby'];
        $order = (getParams('order') == ' ') ? 'DESC' : $_GET['order'];
        $tblTest = $wpdb->prefix . 'member';
        $sql = 'SELECT m.* FROM ' . $tblTest . ' AS m ';
        $whereArr = array();  // TAO MANG WHERE

        if (getParams('customvar') == 'trash') {
            $whereArr[] = "(status = 0)";
        } else {
            $whereArr[] = "(status = 1)";
        }

        if (getParams('filter_branch') != ' ') {
            $country = getParams('filter_branch');
            $whereArr[] = "(m.country = $country)";
        }

        if (getParams('s') != ' ') {
            $s = esc_sql(getParams('s'));
            $whereArr[] = "(m.full_name  LIKE '%$s%')";
        }

// CHUYEN CAC GIA TRI where KET VOI NHAU BOI and
        if (count($whereArr) > 0) {
            $sql .= " WHERE " . join(" AND ", $whereArr);
        }

// orderby
        $sql .= 'ORDER BY m.' . esc_sql($orderby) . ' ' . esc_sql($order);

        $this->_sql = $sql;


//LAY GIA TRI PHAN TRANG PAGEING
        $paged = max(1, @$_REQUEST['paged']);
        $offset = ($paged - 1) * $this->_pre_page;

        $sql .= ' LIMIT  ' . $this->_pre_page . ' OFFSET ' . $offset;

// LAY KET QUA  THONG QUA CAU sql
        $data = $wpdb->get_results($sql, ARRAY_A);

        return $data;
    }

// TINH TONG SO DONG DU LIEU  DE AP DUNG CHO VIEC PHAN TRANG
    public function total_items() {
        global $wpdb;
        return $wpdb->query($this->_sql);
    }

// SO TONG ITEM DUNG DE PHAN TRANG
    public function total_list() {
        global $wpdb;
        $tblOrdert = $wpdb->prefix . 'member';
        return $wpdb->get_var("SELECT COUNT(*) FROM $tblOrdert");
    }

// SO TONG ITEM TRONG TRASH(SO RAC)
    public function total_trash() {
        global $wpdb;
        $tblOrdert = $wpdb->prefix . 'member';
        return $wpdb->get_var("SELECT COUNT(*) FROM $tblOrdert WHERE status = 0");
    }

// SO TONG ITEM HIEN HANH
    public function total_publish() {
        global $wpdb;
        $tblOrdert = $wpdb->prefix . 'member';
        return $wpdb->get_var("SELECT COUNT(*) FROM $tblOrdert WHERE status = 1");
    }

//---------------------------------------------------------------------------------------------
// Cmt NHOM CAC SELECT BOX O DAU CUA LIST
//---------------------------------------------------------------------------------------------
//
    // PHAN SHOW THONG KE SO ITEM O DAU LIST (tong so item, so item hien hanh, so item trong trash)
    function get_views() {
        $views = array();
        $current = (!empty($_REQUEST['customvar']) ? $_REQUEST['customvar'] : 'all');

//All link
        $class = ($current == 'all' ? ' class="current"' : '');
        $all_url = remove_query_arg('customvar');
        $views['all'] = "<strong>" . __('All') . " (" . $this->total_list() . ")</strong>";

//Foo link
        $foo_url = add_query_arg('customvar', 'published');
        $class = ($current == 'foo' ? ' class="current"' : '');
        $views['foo'] = "<a href='{$foo_url}' {$class} > " . __('Published') . " (" . $this->total_publish() . ")</a>";

//Bar link
        $bar_url = add_query_arg('customvar', 'trash');
        $class = ($current == 'bar' ? ' class="current"' : '');
        $views['bar'] = "<a href='{$bar_url}' {$class} >" . __('Trash') . "(" . $this->total_trash() . ")</a>";

        return $views;
    }

//
// CAC ITEM TRONG SELECT BOX CHUC NANG 'UNG DUNG'
    public function get_bulk_actions() {
        if ($_GET['customvar'] == 'trash') {
            $actions = array(
                'restore' => '還原',
                'delete' => '永久刪除'
            );
        } else {
            $actions = array(
                'trash' => '回收桶',
                'uncheckin' => '取消報到'
            );
        }
        return $actions;
    }

// CAC ITEM TRONG SECLETBOX TRONG PHAN FILTER
    public function extra_tablenav($which) {
        if ($which == 'top') {
            $htmlObj = new MyHtml();

            $filterVal = @$_REQUEST['filter_branch'];
            $dd = array('0' => __('Select Brach'));
            $country = $dd + get_guests_country();
            $options['data'] = $country;

            $slbFilter = $htmlObj->selectbox('filter_branch', $filterVal, array(), $options);
            $attr = array('id' => 'filter_action', 'class' => 'button');
            $btnFilter = $htmlObj->button('filter_action', __('Filter'), $attr);

            echo '<div class="alignleft action bulkactions">' . $slbFilter . $btnFilter . '</div>';
        }
    }

//---------------------------------------------------------------------------------------------
// Cmt NHOM THIET LAP GIA TRI CHO CAC CLOUMN
//---------------------------------------------------------------------------------------------
//
// TAO CAC CHECK BOS O DAU DONG TRONG 
    public function column_cb($item) {
        $singular = $this->_args['singular'];
        $html = '<input type="checkbox" name="' . $singular . '[]" value="' . $item['ID'] . '-' . $item['barcode'] . '"/>';
        return $html;
    }

// THEM CAC PHAN CHINH SUA NHANH TAI COLUMN NAY
//DAT TEN column_TEN COLUMN CAN TAO CAC CHINH SUA NHANH
    public function column_fullname($item) {
        $page = getParams('page');
        $name = 'security_code';
//        $linkDelete = add_query_arg(array('action' => 'delete', 'id' => $item['id']));
//        $action = 'delete_id' . $item['id'];
//        $linkDelete = wp_nonce_url($linkDelete, $action, $name);

        if ($_GET['customvar'] == 'trash') {
            $actions = array(
                'restore' => '<a href=" ?page=' . $page . '&action=restore&id=' . $item['ID'] . ' " >還原 </a>',
                'delete' => '<a href=" ?page=' . $page . '&action=delete&id=' . $item['ID'] . '&barcode=' . $item['barcode'] . ' " >永久刪除 </a>',
                    // 'view' => '<a href ="#">View</a>'
            );
        } else {
            $actions = array(
                'edit' => '<a href=" ?page=' . $page . '&action=edit&id=' . $item['ID'] . ' " > 編輯 </a>',
                'trash' => '<a href=" ?page=' . $page . '&action=trash&id=' . $item['ID'] . ' " > 回收桶 </a>',
                    // 'view' => '<a href ="#">View</a>'
            );
        }
        $html = '<strong> <a href="?page=' . $page . '&action=edit&id=' . $item['ID'] . ' ">' . $item['full_name'] . '</a> </strong>' . $this->row_actions($actions);
        return $html;
    }

    public function column_checkin($item) {
        $page = getParams('page');
        if ($item['check_in'] == 1) {
// $action = 'inactive';
            $src = get_icon('active32x32.png');
        } else {
// $action = 'active';
            $src = get_icon('inactive32x32.png');
        }

// TAO SECURITY CODE
        $paged = max(1, @$_REQUEST['paged']);
        $name = 'security_code';
        $linkStatus = add_query_arg(array('action' => 'uncheckin', 'barcode' => $item['barcode'], 'id' => $item['ID'], 'paged' => $paged, 'check' => $item['check_in']));
        $action = $action . '_id_' . $item['id'];
        $linkStatus = wp_nonce_url($linkStatus, $action, $name);
        if (getParams('customvar') != 'trash') {
            $html = '<img alt="" src=" ' . $src . ' " />';
            $html = '<a href ="' . $linkStatus . ' ">' . $html . '</a>';
        } else {
            $html = '<img alt="" src=" ' . $src . ' " />';
            $html = '<a href ="#">' . $html . '</a>';
        }
        return $html;
    }

// LAY GIA TRI MA THONG QUA QUA HAM get_country SHOW TEN RA
    public function column_branch($item) {
        echo get_country($item['country']);
    }

    public function column_img($item) {
        if (!empty($item['img'])) {
            echo '<img style="width:100px" src=" ' . get_template_directory_uri() . '/images/member/' . $item["img"] . ' " />';
        }
    }

    public function column_barcode($item) {
        echo $item['barcode'];
    }

//CAC COLUMN MAC DINH KHI LOAD TRANG SE SHOW LEN 
    public function column_default($item, $column_name) {
        return $item[$column_name];
    }

//CAC FUNCTION XU LY DATA  

    public function get_item($arrData = array(), $option = array()) {
        global $wpdb;
        $id = absint($arrData['id']);
        $table = $wpdb->prefix . 'member';
        $sql = "SELECT * FROM $table WHERE ID = $id";
        $row = $wpdb->get_row($sql, ARRAY_A);
        return $row;
    }

    public function trashItem($arrData = array(), $option = array()) {
        global $wpdb;

        $table = $wpdb->prefix . 'member';
// KIEM TRA PHAN  CÓ PHAN DANG CHUOI HAY KHONG
        if (!is_array($arrData['id'])) {
            $data = array('status' => 0);
            $where = array('id' => absint($arrData['id']));
            $wpdb->update($table, $data, $where);
        } else {
            $arrData['id'] = array_map('absint', $arrData['id']);
            $ids = join(',', $arrData['id']);
            $sql = "UPDATE $table SET `status` =  '0'   WHERE ID IN ($ids)";
            $wpdb->query($sql);
        }
    }

    public function restoreItem($arrData = array(), $option = array()) {
        global $wpdb;

        $table = $wpdb->prefix . 'member';
// KIEM TRA PHAN DELETE CÓ PHAN DANG CHUOI HAY KHONG
        if (!is_array($arrData['id'])) {
            $data = array('status' => 1);
            $where = array('id' => absint($arrData['id']));
            $wpdb->update($table, $data, $where);
        } else {
            $arrData['id'] = array_map('absint', $arrData['id']);
            $ids = join(',', $arrData['id']);
            $sql = "UPDATE $table SET `status` =  '1'   WHERE ID IN ($ids)";
            $wpdb->query($sql);
        }
    }

    public function uncheckinItem($arrData = array(), $option = array()) {
        global $wpdb;
        $table = $wpdb->prefix . 'member';
        $table2 = $wpdb->prefix . 'member_check_in';
        $table3 = $wpdb->prefix . 'guests_check_in';
        // UNCHECK IN
        if (!is_array($arrData['id'])) {
            $data = array('check_in' => 0);
            $where = array('ID' => absint($arrData['id']));
            $wpdb->update($table, $data, $where);
            // XOA MEMBER CHECK IN
            $where2 = array('member_id' => absint($arrData['id']));
            $wpdb->delete($table2, $where2);
            // XOA GUESTS CHECK IN
            $where3 = array('barcode' => $arrData['barcode']);
            $wpdb->delete($table3, $where3);
        } else {
            foreach ($arrData['id'] as $val) {
                $ss = explode("-", $val);
                $barcodeList .= ',' . $ss['1'];
                $ids .= ',' . $ss['0'];
            }
            $ids = substr($ids, 1);
            $barcodeList = substr($barcodeList, 1);
            $sql = "UPDATE $table SET `check_in` = '0'  WHERE ID IN ($ids)";
            $wpdb->query($sql);
            // XOA GUESTS CHECK IN
            $sql2 = "DELETE FROM $table2 WHERE member_id IN ($ids)";
            $wpdb->query($sql2);
            // XOA GUESTS CHECK IN
            $sql3 = "DELETE FROM $table3 WHERE barcode IN ($barcodeList)";
            $wpdb->query($sql3);
        }
    }

    public function checkin($arrData = array(), $option = array()) {
        global $wpdb;
        $table = $wpdb->prefix . 'member';
        $table3 = $wpdb->prefix . 'guests_check_in';
        // CHECK IN
        if ($arrData['check'] == 0) {
            $data = array('check_in' => '1');
            $where = array('ID' => $arrData['id']);
            $wpdb->update($table, $data, $where);
            
            $data3 = array(
                'guests_id' => $arrData['id'],
                'barcode' => $arrData['barcode'],
                'time' => date('H:i:s'),
                'date' => date('m-d-Y'),
                'kind' => 'm',
              );
            $wpdb->insert($table3, $data3);
        }
    }

    public function deleteItem($arrData = array(), $option = array()) {
        global $wpdb;
        $table = $wpdb->prefix . 'member';
        $this->deleteImg($arrData['id']);
        if (!is_array($arrData['id'])) {
            $where = array('ID' => absint($arrData['id']));
            $wpdb->delete($table, $where);
        } else {
            $arrData['id'] = array_map('absint', $arrData['id']);
            $ids = join(',', $arrData['id']);
            $sql = "DELETE FROM $table WHERE ID IN ($ids)";
            $wpdb->query($sql);
        }
    }

    private function deleteImg($arrID) {
        global $wpdb;
        $table = $wpdb->prefix . 'member';
        if (!is_array($arrID)) {
            $sql = "SELECT * FROM $table WHERE ID =" . $arrID;
            $row = $wpdb->get_row($sql, ARRAY_A);
//            XOA HINH TRONG FOLDER
            unlink(WB_DIR_MEMBER . $row['img']);
            unlink(WB_DIR_IMAGES_QRCODE . $row['barcode'] . '.png');
        } else {
            foreach ($arrID as $key) {
                $sql = "SELECT * FROM $table WHERE ID =" . $key;
                $row = $wpdb->get_row($sql, ARRAY_A);
                // XOA HINH CUA GUESTS
                unlink(WB_DIR_MEMBER . $row['img']);
                unlink(WB_DIR_IMAGES_QRCODE . $row['barcode'] . '.png');
            }
        }
    }

    public function saveItem($arrData = array(), $option = array()) {
        global $wpdb;
        $table = $wpdb->prefix . 'member';
        if (isset($arrData['hidden_barcode']) and empty($arrData['hidden_barcode'])) {
           // $barcode = $this->createQRcode($arrData['sel_branch']);
        } else {
          //  if ($arrData['sel_branch'] != $arrData['hidden_branch']) {
               // $barcode = $this->createQRcode($arrData['sel_branch']);
                // delete the old barcode picture 
              //  if (is_file(WB_DIR_IMAGES_QRCODE . $arrData['hidden_barcode'] . '.png')) {
                   // unlink(WB_DIR_IMAGES_QRCODE . $arrData['hidden_barcode'] . '.png');
               // }
            //} else {
          $barcode = $arrData['hidden_barcode'];
           // }
        }

        if (!empty($_FILES['guests_img']['name'])) {
            $errors = array();
            $file_name = $_FILES['guests_img']['name'];
            $file_size = $_FILES['guests_img']['size'];
            $file_tmp = $_FILES['guests_img']['tmp_name'];
            $file_type = $_FILES['guests_img']['type'];

            $file_trim = ((explode('.', $_FILES['guests_img']['name'])));
            $trim_name = strtolower($file_trim[0]);
            $trim_type = strtolower($file_trim[1]);

            // $name = 'hinh';
            if (!empty($arrData['hidden_barcode'])) {
                $cus_name = $arrData['hidden_barcode'] . '.' . $trim_type;  //tao name moi cho file tranh trung va mat file
            } else {
                $cus_name = $barcode . '.' . $trim_type;
            }
            $extensions = array("jpeg", "jpg", "png", "bmp");
            if (in_array($trim_type, $extensions) === false) {
                $errors[] = "上傳照片檔案是 JPEG, PNG, BMP.";
            }
            if ($file_size > 2097152) {
                $errors[] = '上傳檔案容量不可大於 2 MB';
            }
            $path = WP_CONTENT_DIR . DS . 'themes' . DS . 'suite' . DS . 'images' . DS . 'member' . DS; // get function path upload img dc khai bao tai file hepler

            if (empty($errors) == true) {
                //=== upload hinh ==============================
                // delete the old barcode picture 
                if (is_file(WB_DIR_IMAGES_MEMBER . $arrData['hidden_img'])) {
                    unlink(WB_DIR_IMAGES_MEMBER . $arrData['hidden_img']);
                }
                move_uploaded_file($file_tmp, ( $path . $cus_name));
            } else {
                return $errors;
            }
        } else {
            $cus_name = $arrData['hidden_img'];
        }

        $data1 = array(
            'full_name' => $arrData['txt_name'],
            'barcode' => $barcode,
            'country' => $arrData['sel_country'],
            'position' => $arrData['txt_position'],
            'email' => $arrData['txt_email'],
            'phone' => $arrData['txt_phone'],
            'img' => $cus_name,
            'note' => $arrData['txt_note'],
        );

        $data2 = array(
            'barcode' => $barcode,
            'full_name' => $arrData['txt_name'],
            'country' => $arrData['sel_country'],
            'position' => $arrData['txt_position'],
            'email' => $arrData['txt_email'],
            'phone' => $arrData['txt_phone'],
            'img' => $cus_name,
            'note' => $arrData['txt_note'],
            'create_date' => date('d-m-Y'),
        );


        if (!empty($arrData['hidden_ID'])) {
            $where = array('ID' => absint($arrData['hidden_ID']));
            $wpdb->update($table, $data1, $where);
        } else {
            $wpdb->insert($table, $data2);
        }
    }

    public function createbarcode($aa) {
        // TAO BARCODE
        //  $aa = $arrData['sel_country'];
        $t = time();
        $cc = substr($t, -8);
        $bar = $aa . $cc;
        require_once ( WB_DIR_BARCODE . 'BarcodeGenerator.php');
        require_once (WB_DIR_BARCODE . 'BarcodeGeneratorPNG.php');
        $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
        file_put_contents(WB_DIR_IMAGES_BARCODE . $bar . '.png', $generatorPNG->getBarcode($bar, $generatorPNG::TYPE_CODE_128, 2, 30));
        return $bar;
    }

    public function createQRcode($code) {
        // TAO BARCODE
        // $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
        require_once ( WB_DIR_QRCODE . 'qrlib.php');
        //   if (!file_exists($PNG_TEMP_DIR))
        //   mkdir($PNG_TEMP_DIR);

        $t = time();
        $cc = substr($t, -8);
        $bar = $code . $cc;
//     $pattern = " ";
//     $replacement = "-";
//    $name = str_replace($pattern, $replacement, $subject);

        $filename = WB_DIR_IMAGES_QRCODE . $bar . '.png';
        $errorCorrectionLevel = "L";
        $matrixPointSize = 10;
        QRcode::png($bar, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
        return $bar;
    }

}
