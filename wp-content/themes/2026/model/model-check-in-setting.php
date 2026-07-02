<?php

class Model_Check_In_Setting
{

    private $_attenList;
    private $_tb_guests;

    public function __construct()
    {
        global $wpdb;
        $this->AttenDetail();
        $this->_tb_guests = $wpdb->prefix . 'guests';
    }


    /// =============================================
    /// =============================================
    /// =============================================

    public function ExportGuests()
    {
        global $wpdb;
        $sql = "SELECT full_name, position, email, phone, country, barcode, img 
                FROM $this->_tb_guests WHERE 1 = 1 
                ORDER BY country  ASC";
        $data = $wpdb->get_results($sql, ARRAY_A);
        export_excel_member($data);
    }

    public function ExportRegistry()
    {
        global $wpdb;
        $sql = "SELECT full_name, position, email, phone, country, barcode, img 
                FROM $this->_tb_guests WHERE status = 1
                ORDER BY country ASC";
        $data = $wpdb->get_results($sql, ARRAY_A);
        export_excel_member($data);
    }

    public function ImportMember($filename)
    {
        $arrData = import_excel_guests($filename);
        global $wpdb;
        // cần đưa mới danh sách xóa hết cái cũ đưa cái mới hoàn toàn 
        // $wpdb->query("TRUNCATE TABLE $$this->_tb_guests");

        // bat dau insert tu dong thu 2
        foreach (array_slice($arrData, 1) as $item) {
            $countryCode = set_country($item[1]);
            $note = $item[10] == null ? "" : $item[5];
            // $img = $item[6] == null ? "" : $item[6];
            $phone = $item[3] == null ? "" : $item[3];
            $email = $item[4] == null ? "" : $item[4];
            $data = array(
                'full_name' => $item[0],
                'country' => $countryCode,
                'position' => $item[2],
                'email' => $email,
                'phone' => $phone,
                'barcode' => setQRCode($countryCode),
                // 'img' => $img,
                // 'check_in' => $item[8],
                'create_date' => date('d-m-Y'),
                'status' => 1,
                'note' => $note,
            );
            $wpdb->insert($this->_tb_guests, $data);
        }
    }



    // 08-2025 ======================================
    public function BatchCreateQRCode()
    {
        global $wpdb;

        $sql = "SELECT full_name, barcode FROM $this->_tb_guests WHERE 1 = 1";
        $row = $wpdb->get_results($sql, ARRAY_A);

        // XOA HET CAC FILE QRCODE .png CO TRONG FOLDER
        $files = glob(DIR_IMAGES_QRCODE . '*.png'); //get all file names
        foreach ($files as $file) {
            if (is_file($file))
                unlink($file); //delete file
        }
        // TAO TAT CA CAC FILE QRCODE MOI
        foreach ($row as $item) {
            create_QRCode($item['barcode'], $item['full_name'], 0);
        }
    }


    //---------------------------------------------------------------------------------------------
    // them moi de kiem tra check trong ca hai table member va guests
    // lay barcode trong table check-in de lay data trong hai table
    //---------------------------------------------------------------------------------------------

    public function AttendTime()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'guests_check_in';
        $sql = "SELECT barcode, time, date  FROM $table GROUP BY guests_id ";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }

    public function AttenDetail()
    {
        global $wpdb;
        $table_guests = $wpdb->prefix . 'guests';
        //$barcode = $this->AttendTime();
        $guestsList = array();

        foreach ($this->AttendTime() as $val) {
            //           if($val['kind'] == 'g'){
            $sql = "SELECT full_name AS Name, country AS Country,  position AS Position, phone AS Phone, email AS Email, barcode AS Barcode  FROM $table_guests WHERE  barcode =" . $val['barcode'];
            $row = $wpdb->get_results($sql, ARRAY_A);
            array_push($row, array("Time" => $val['time'], "Date" => $val['date']));
            $guestsList[] = $row;
        }



        // PHAN SAP XEP LAI THU TU THEO THOI GIAN CHECK IN
        uasort($guestsList, function ($a, $b) {
            return $b[1]['Time'] - $a[1]['Time'];
        });

        $this->_attenList = $guestsList;

        // return $guestsList;

    }

    ////=================================================================  
    public function ReportView()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'guests';
        $sql = "SELECT * FROM $table WHERE check_in = 1 AND status = 1";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }

    public function ReportjoinView()
    {
        global $wpdb;
        $table_guests = $wpdb->prefix . 'guests';
        $table_check = $wpdb->prefix . 'guests_check_in';
        $sql = "SELECT * FROM $table_guests AS A LEFT JOIN $table_check AS B ON A.ID = B.guests_id
                  WHERE A.status = 1 AND A.check_in =1
                  GROUP BY B.guests_id
                  ORDER BY B.time DESC";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }

    //^^ add new at 14/03/2018
    public function ReportBranchView()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'guests';

        $sql = "SELECT country AS code, Count(country) AS register, 
            (SELECT  Count(country) FROM $table WHERE check_in = 1 AND status = 1 AND country = code) AS arrived
             FROM $table WHERE status = 1 GROUP BY country ORDER BY arrived DESC ";
        $row = $wpdb->get_results($sql, ARRAY_A);

        $newBranchitem = array();
        $newBranch = array();
        foreach ($row as $val) {
            $newBranchitem['code'] = $val['code'];
            $newBranchitem['register'] = $val['register'];
            $newBranchitem['arrived'] = $val['arrived'];
            $newBranchitem['percent'] = round($val['arrived'] / $val['register'] * 100, 2);
            $newBranch[] = $newBranchitem;
        }
        return $newBranch;
    }

    public function BarcodeInfo()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'guests';
        $sql = "SELECT * FROM $table WHERE  status = 1";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }

    public function ReportDetailView($barcode)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'guests_check_in';
        $sql = "SELECT * FROM $table WHERE barcode = $barcode";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }
}
