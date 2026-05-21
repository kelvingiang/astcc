<?php

class Admin_Model_Kind {

    private $table;

    public function __construct($args = array()) {
        global $wpdb;
        $this->table = $wpdb->prefix . 'kind';
    }

//---------------------------------------------------------------------------------------------
// Cmt  CAC CHUC ADD EDIT DELETE 
//---------------------------------------------------------------------------------------------
// SAVE DATA DEN DATABASE
    public function save($arrData = array(), $option = array()) {
        global $wpdb;
// kIEM ADD NEW OR UPDATE
        $data = array(
            'name' => $arrData['txt-name'],
            'order' => $arrData['txt-order'],
        );

        if ($option['action'] == 'add') {
            $data += ['kind' => $option['kind']];
            $wpdb->insert($this->table, $data);
        } else if ($option['action'] == 'edit') {
            $where = array('ID' => $arrData['hid-id']);  // CHUYEN THEM DK DE UPDATE 
            $wpdb->update($this->table, $data, $where);
        }
    }

// LAY DU LIEU CAN CHINH SUA
    public function get_item($arrData = array(), $option = array()) {
        global $wpdb;
// THONG SO id DUA CHUYEN TREN url DE LAY DONG DU LIEU CAN CHINH SUA
        $id = absint($arrData);  // ham absint  chuyen ky tu sang kieu so
        $sql = "SELECT * FROM $this->table WHERE ID = $id";
        $row = $wpdb->get_row($sql, ARRAY_A);  // LAY DONG DU LIEU TRA VE KIEU array
        return $row;
    }

    //  LAY TAT CA CAC DU LIEU
    public function getAll($options = array()) {
        global $wpdb;
        $sql = "SELECT * FROM $this->table  WHERE `kind` = 'a'  ORDER BY `order` DESC";
        $row = $wpdb->get_results($sql, ARRAY_A);  // LAY DONG DU LIEU TRA VE KIEU array
        return $row;
    }

    public function getMemberIndustry() {
        global $wpdb;
        $table = $wpdb->prefix . 'member';
        $sql = "SELECT industry_id FROM $table WHERE industry_id != '0' ";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }

// XOA DATA
    public function deleteItem($arrData = array(), $options = array()) {
        global $wpdb;
// KIEM TRA PHAN DELETE CÓ PHAN DANG CHUOI HAY KHONG
        $where = array('ID' => $arrData);
        $wpdb->delete($this->table, $where);
    }

}
