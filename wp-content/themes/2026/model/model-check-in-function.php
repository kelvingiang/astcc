<?php
// chen cai thu vien upload img
use PHPImageWorkshop\ImageWorkshop;

class Model_Check_In_Function
{
    private $_table_guests;
    private $_table_check_in;
    private $tbl_event;
    private $_error = [];

    public function __construct($args = array())
    {
        global $wpdb;
        $this->_table_guests = $wpdb->prefix . 'guests';
        $this->_table_check_in = $wpdb->prefix . 'guests_check_in';
        $this->tbl_event = $wpdb->prefix . 'guests_check_in_event';
        // $this->_error = [];
    }

    public function getEventActive()
    {
        global $wpdb;
        $sql = "SELECT ID FROM $this->tbl_event WHERE status = 1";
        $row = $wpdb->get_row($sql, ARRAY_A);
        return $row;
    }

    public function get_item($arrData = array(), $option = array())
    {
        global $wpdb;
        $id = absint($arrData['id']);
        $sql = "SELECT * FROM $this->_table_guests WHERE ID = $id";
        $row = $wpdb->get_row($sql, ARRAY_A);
        return $row;
    }

    public function trashItem($arrData = array(), $option = array())
    {
        global $wpdb;
        // KIEM TRA PHAN  CÓ PHAN DANG CHUOI HAY KHONG
        if (!is_array($arrData['id'])) {
            $data = array('status' => 0);
            $where = array('id' => absint($arrData['id']));
            $wpdb->update($this->_table_guests, $data, $where);
        } else {
            $arrData['id'] = array_map('absint', $arrData['id']);
            $ids = join(',', $arrData['id']);
            $sql = "UPDATE $this->_table_guests SET `status` =  '0'   WHERE ID IN ($ids)";
            $wpdb->query($sql);
        }
    }

    public function restoreItem($arrData = array(), $option = array())
    {
        global $wpdb;

        // KIEM TRA PHAN DELETE CÓ PHAN DANG CHUOI HAY KHONG
        if (!is_array($arrData['id'])) {
            $data = array('status' => 1);
            $where = array('id' => absint($arrData['id']));
            $wpdb->update($this->_table_guests, $data, $where);
        } else {
            $arrData['id'] = array_map('absint', $arrData['id']);
            $ids = join(',', $arrData['id']);
            $sql = "UPDATE $this->_table_guests SET `status` =  '1'   WHERE ID IN ($ids)";
            $wpdb->query($sql);
        }
    }

    public function checkin($arrData = array(), $option = array())
    {
        global $wpdb;
        $eventActive = $this->getEventActive();
        if ($arrData['check'] == 0) {
            $data = array(
                'guests_id' => $arrData['id'],
                'event_id' => $eventActive['ID'],
                'time' => date('H:i:s'),
                'date' => date('m-d-Y'),
            );
            $wpdb->insert($this->_table_check_in, $data);
        } elseif ($arrData['check'] == 1) {
            // XOA GUESTS CHECK IN
            $where = array('guests_id' => absint($arrData['id']), 'event_id' => $eventActive['ID']);
            $wpdb->delete($this->_table_check_in, $where);
        }
    }

    public function deleteItem($arrData = array(), $option = array())
    {
        global $wpdb;
        $this->deleteImg($arrData['id']);

        if (!is_array($arrData['id'])) {
            $where = array('ID' => absint($arrData['id']));
            $wpdb->delete($this->_table_guests, $where);
        } else {
            $arrData['id'] = array_map('absint', $arrData['id']);
            $ids = join(',', $arrData['id']);
            $sql = "DELETE FROM $this->_table_guests  WHERE ID IN ($ids)";
            $wpdb->query($sql);
        }
    }

    private function deleteImg($arrID)
    {
        global $wpdb;
        if (!is_array($arrID)) {
            $sql = "SELECT * FROM $this->_table_guests WHERE ID =" . $arrID;
            $row = $wpdb->get_row($sql, ARRAY_A);
            //            XOA HINH TRONG FOLDER
            unlink(DIR_IMAGES_GUESTS . $row['img']);
            unlink(DIR_IMAGES_BARCODE . $row['barcode'] . '.png');
        } else {
            foreach ($arrID as $key) {
                $sql = "SELECT * FROM $this->_table_guests WHERE ID =" . $key;
                $row = $wpdb->get_row($sql, ARRAY_A);
                // XOA HINH CUA GUESTS
                unlink(DIR_IMAGES_GUESTS . $row['img']);
                unlink(DIR_IMAGES_BARCODE . $row['barcode'] . '.png');
            }
        }
    }

    public function saveItem($arrData = array(), $cus_name = '')
    {
        global $wpdb;

        $selCountry    = $arrData['sel_country'] ?? '';
        $hiddenCountry = $arrData['hidden_country'] ?? '';
        $hiddenBarcode = $arrData['hidden_barcode'] ?? '';

        if (empty($hiddenBarcode)) {

            $t = time();
            $cc = substr($t, -9);
            $barcode = $selCountry . $cc;

            create_QRCode($barcode, $arrData['txt_fullname'] ?? '', 0);
        } else {

            if ($selCountry !== $hiddenCountry) {

                $t = time();
                $cc = substr($t, -9);
                // $barcode = $selCountry . $cc;
                $barcode = setQRCode($selCountry);
                create_QRCode($barcode, $arrData['txt_fullname'] ?? '', 0);

                $file = DIR_IMAGES_QRCODE . $hiddenBarcode . '.png';

                if (is_file($file)) {
                    @unlink($file);
                }
            } else {
                $barcode = $hiddenBarcode;
            }
        }

  

        if (empty($this->_error)) {
            $data_update = array(
                'full_name' => $arrData['txt_fullname'] ?? '',
                'barcode'   => $barcode,
                'country'   => $arrData['sel_country'] ?? '',
                'position'  => $arrData['txt_position'] ?? '',
                'email'     => $arrData['txt_email'] ?? '',
                'phone'     => $arrData['txt_phone'] ?? '',
                'img'       => $cus_name,
                'note'      => $arrData['txt_note'] ?? '',
            );

            $dataInsert = array_merge($data_update, [
                'check_in'    => '0',
                'create_date' => date('d-m-Y'),
                'status'      => '1',
            ]);

            if (!empty($arrData['hidden_ID'])) {
                $where = array('ID' => absint($arrData['hidden_ID']));
                $wpdb->update($this->_table_guests, $data_update, $where);
            } else {
                $wpdb->insert($this->_table_guests, $dataInsert);
            }
        }
    }

    // public function uploadImg($arrData, $barcode)
    // {

    public function uploadImg($arrData, $barcode)
    {
        $cus_name = $arrData['hidden_img']; // 預設用舊圖

        if (!empty($_FILES['guests_img']['name'])) {
            $file_name = $_FILES['guests_img']['name'];
            $file_size = $_FILES['guests_img']['size'];
            $file_tmp  = $_FILES['guests_img']['tmp_name'];
            $file_error = $_FILES['guests_img']['error']; // 取得 PHP 內建錯誤代碼

            $file_trim = explode('.', $file_name);
            $trim_type = strtolower(end($file_trim));

            if (!empty($arrData['hidden_barcode'])) {
                $cus_name = $arrData['hidden_barcode'] . '.' . $trim_type;
            } else {
                $cus_name = $barcode . '.' . $trim_type;
            }

            // 檔案格式限制
            $extensions = ["jpeg", "jpg", "png", "bmp"];
            if (!in_array($trim_type, $extensions)) {
                $this->_error[] = "上傳照片檔案是 JPEG , PNG , BMP.";
            }

            // 檔案大小限制
            if ($file_size > 2097152) {
                $this->_error[] = '上傳檔案容量不可大於 2 MB';
            }

            // 沒錯誤才上傳
            if (empty($this->_error)) {
                if (is_file(DIR_IMAGES_GUESTS . $arrData['hidden_img'])) {
                    unlink(DIR_IMAGES_GUESTS . $arrData['hidden_img']);
                }

                $destination = DIR_IMAGES_GUESTS . $cus_name;

                // 嘗試移動檔案，並捕捉結果
                if (move_uploaded_file($file_tmp, $destination)) {
                    // 成功
                } else {
                    // 失敗時，印出詳細的抓漏資訊
                    echo "<h3>❌ 上傳失敗，請看以下分析：</h3>";
                    echo "1. PHP 接收檔案錯誤代碼 (0代表正常)： <b>" . $file_error . "</b><br>";
                    echo "2. 暫存檔位置 (如果為空代表沒傳到伺服器)： <b>" . $file_tmp . "</b><br>";
                    echo "3. 目標路徑： <b>" . $destination . "</b><br>";
                    echo "4. 系統判定目標資料夾是否存在： <b>" . (is_dir(DIR_IMAGES_GUESTS) ? '<span style="color:green">是</span>' : '<span style="color:red">否</span>') . "</b><br>";
                    echo "5. 系統判定資料夾是否可寫入： <b>" . (is_writable(DIR_IMAGES_GUESTS) ? '<span style="color:green">是</span>' : '<span style="color:red">否 (權限問題)</span>') . "</b><br>";
                    die("<br>請將以上訊息截圖或貼給我看！"); // 暫停程式
                }
            }
        }
        return $cus_name;
    }



    // $cus_name = $arrData['hidden_img']; // 預設用舊圖

    // if (!empty($_FILES['guests_img']['name'])) {
    //     $file_name = $_FILES['guests_img']['name'];
    //     $file_size = $_FILES['guests_img']['size'];
    //     $file_tmp  = $_FILES['guests_img']['tmp_name'];

    //     $file_trim = explode('.', $file_name);
    //     $trim_type = strtolower(end($file_trim));

    //     if (!empty($arrData['hidden_barcode'])) {
    //         $cus_name = $arrData['hidden_barcode'] . '.' . $trim_type;
    //     } else {
    //         $cus_name = $barcode . '.' . $trim_type;
    //     }

    //     // 檔案格式限制
    //     $extensions = ["jpeg", "jpg", "png", "bmp"];
    //     if (!in_array($trim_type, $extensions)) {
    //         $this->_error[] = "上傳照片檔案是 JPEG , PNG , BMP.";
    //         // $this->_error[] = "1";
    //     }

    //     // 檔案大小限制
    //     if ($file_size > 2097152) {
    //         $this->_error[] = '上傳檔案容量不可大於 2 MB';
    //         // $this->_error[] = '2';
    //     }

    //     // 沒錯誤才上傳
    //     if (empty($this->_error)) {
    //         if (is_file(DIR_IMAGES_GUESTS . $arrData['hidden_img'])) {
    //             unlink(DIR_IMAGES_GUESTS . $arrData['hidden_img']);
    //         }
    //         move_uploaded_file($file_tmp, DIR_IMAGES_GUESTS . $cus_name);
    //     }else{
    //         die('上傳圖片失敗，請檢查圖片格式或容量0000000');
    //     }
    // }
    // return $cus_name;
    // }
    //TAO QRCODE


    public function getError()
    {
        $ss = $this->_error;
        return $ss;
    }
}
