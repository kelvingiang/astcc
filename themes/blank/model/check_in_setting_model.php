<?php

class Admin_Check_In_Setting_model {

    private $attenList;

    public function __construct() {
        $this->AttenDetail();
    }

//---------------------------------------------------------------------------------------------
// them moi de kiem tra check trong ca hai table member va guests
// lay barcode trong table check-in de lay data trong hai table
//---------------------------------------------------------------------------------------------

    public function AttendTime() {
        global $wpdb;
        $table = $wpdb->prefix . 'guests_check_in';
        $sql = "SELECT barcode, time, date  FROM $table GROUP BY guests_id ";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }

    public function AttenDetail() {
        global $wpdb;
        $table_guests = $wpdb->prefix . 'guests';
       // $table_member = $wpdb->prefix . 'member';
        //$barcode = $this->AttendTime();
        $guestsList = array();
       // $memberList = array();
   
        
        foreach ($this->AttendTime() as $val) {
//           if($val['kind'] == 'g'){
                 $sql = "SELECT full_name AS Name, country AS Country,  position AS Position, phone AS Phone, email AS Email, barcode AS Barcode  FROM $table_guests WHERE  barcode =" . $val['barcode'];
                 $row = $wpdb->get_results($sql, ARRAY_A);
                  array_push($row, array("Time" => $val['time'], "Date" => $val['date']));
                  $guestsList[] = $row;
//                }
//           if($val['kind'] == 'm'){
//                 $sql2 = "SELECT full_name AS Name, country AS Country,  position AS Position, phone AS Phone, email AS Email, barcode AS Barcode  FROM $table_member WHERE  barcode =" . $val['barcode'];
//                 $row2 = $wpdb->get_results($sql2, ARRAY_A);
//                  array_push($row2, array("Time" => $val['time'], "Date" => $val['date'], "Kind" => $val['kind']));
//                  $memberList[] = $row2;
//                }
        }
       
    
    
        // PHAN SAP XEP LAI THU TU THEO THOI GIAN CHECK IN
        uasort($guestsList, function($a, $b) {
            return $b[1]['Time'] - $a[1]['Time'];
        });
    
        $this->attenList = $guestsList;
        
       // return array_merge($guestsList,$memberList);
      
    }

    ////=================================================================  
    public function ReportView() {
        global $wpdb;
        $table = $wpdb->prefix . 'guests';
        $sql = "SELECT * FROM $table WHERE check_in = 1 AND status = 1";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }

    public function ReportjoinView() {
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
    public function ReportBranchView() {
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

    public function BarcodeInfo() {
        global $wpdb;
        $table = $wpdb->prefix . 'guests';
        $sql = "SELECT * FROM $table WHERE  status = 1";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }

    public function ReportDetailView($barcode) {
        global $wpdb;
        $table = $wpdb->prefix . 'guests_check_in';
        $sql = "SELECT * FROM $table WHERE barcode = $barcode";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }

    /// =============================================

    public function ExCheckInToExcel() {
        
//           echo '<pre>';
//        print_r($this->attenList);
//        echo '</pre>';
//        die();
        
        require_once CLASS_DIR . 'PHPExcel.php';
        $exExport = new PHPExcel();
        // TAO COT TITLE
        $exExport->setActiveSheetIndex(0);
        $sheet = $exExport->getActiveSheet()->setTitle("check in");
        $sheet->setCellValue('A1', '姓名');
        $sheet->setCellValue('B1', '分會');
        $sheet->setCellValue('C1', '職稱');
        $sheet->setCellValue('D1', '報到時間');
        $sheet->setCellValue('E1', '聯絡電話');
        $sheet->setCellValue('F1', 'EMAIL');
        $sheet->setCellValue('G1', '條碼');
        // set do rong cua cot
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setWidth(35);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        // set chieu cao cua dong
        $sheet->getRowDimension('1')->setRowHeight(30);
        // set to dam chu
        $sheet->getStyle('A')->getFont()->setBold(TRUE);
        $sheet->getStyle('A1:G1')->getFont()->setBold(TRUE);
        // set nen backgroup cho dong
        $sheet->getStyle('A1:G1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('0008bdf8');
        // set chu canh giua
        $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:G1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $i = 2;

        //---------------------------------------------------------------------------------------------
// PHAN LAY CHICK IN 2 TABLE GUESTS VA MEMBER NHU CHI LAY 1 DONG TRONG BANG CHECK IN
//---------------------------------------------------------------------------------------------
     
        
        foreach ($this->attenList as $row) {
             // DAY DU CHI TIET SO LAN CHECK IN 
//                           $arrgCheckIn = $this->ReportDetailView($row[0]['Barcode']);
//                           foreach ($arrgCheckIn as $item) {
//                               $checkInAll .= $item['time'] . '__' . $item['date'] . '  ';
//                           }

            $exExport->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $row[0]['Name'])
                    ->setCellValue('B' . $i, get_country($row[0]['Country']))
                    ->setCellValue('C' . $i, $row[0]['Position'])
//                    ->setCellValue('D' . $i, $checkInAll)
                    ->setCellValue('D' . $i, $row[1]['Time'] . '___' . $row[1]['Date'])
                    ->setCellValueExplicit('E' . $i, $row[0]['Phone'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValue('F' . $i, $row[0]['Email'])
                    ->setCellValue('G' . $i, $row[0]['Barcode'], PHPExcel_Cell_DataType::TYPE_STRING);
 
//            $checkInAll ="";
            if($row[1]['Kind']=="m"){
                //$objPHPExcel->setActiveSheetIndex(0)->getStyle( $cell )->getFont()->setSize( 10 );
                $exExport->setActiveSheetIndex(0)->getStyle("A$i:G$i")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00e9ebed');
            }        
            $i++;
        }
        // phan set border 
        $styleArray = array('borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        //cho tat ca 
          $sheet->getStyle('A1:'.'G'.($i-1))->applyFromArray($styleArray);     
        //   chi dong title
        //$sheet->getStyle('A1:' . 'G1')->applyFromArray($styleArray);

        // TAO FILE EXCEL VA SAVE LAI THEO PATH
        //$objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
        //$full_path = EXPORT_DIR . date("YmdHis") . '_report.xlsx'; //duong dan file
        //$objWriter->save($full_path);
// TAO FILE EXCEL VA DOWN TRUC TIEP XUONG CLINET
        $filename = 'astcc_checkin_' . date("ymdHis") . '.xlsx';
        $objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
        header("Content-Disposition: attachment;filename=$filename");
        header('Cache-Control: max-age=0');
        ob_end_clean();
//        ob_start();
        $objWriter->save('php://output');
    }

    public function ExportBarcode() {
        require_once CLASS_DIR . 'PHPExcel.php';
        $exExport = new PHPExcel();

        // TAO COT TITLE
        $exExport->setActiveSheetIndex(0)
                ->setCellValue('A1', '姓名')
                ->setCellValue('B1', '職稱')
                ->setCellValue('C1', '分會')
                ->setCellValue('D1', '條碼');

        // TAO NOI DUNG CHEN TU DONG 2
        $i = 2;
        $list = $this->BarcodeInfo();

        foreach ($list as $row) {
            $exExport->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $row['full_name'])
                    ->setCellValue('B' . $i, $row['position'])
                    ->setCellValue('C' . $i, get_country($row['country']))
                    ->setCellValueExplicit('D' . $i, $row['barcode'], PHPExcel_Cell_DataType::TYPE_STRING);
            $i++;
        }
        // TAO FILE EXCEL VA SAVE LAI THEO PATH
        //$objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
        //$full_path = EXPORT_DIR . date("YmdHis") . '_report.xlsx'; //duong dan file
        //$objWriter->save($full_path);
        //
// TAO FILE EXCEL VA DOWN TRUC TIEP XUONG CLINET
        $filename = date("YmdHis") . '_barcode.xlsx';
        $objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=$filename");
        header('Cache-Control: max-age=0');
        ob_end_clean();
//        ob_start();
        $objWriter->save('php://output');
    }

    public function ExportMemberPost() {
        require_once CLASS_DIR . 'PHPExcel.php';
        $exExport = new PHPExcel();

        // TAO COT TITLE
        $exExport->setActiveSheetIndex(0)
                ->setCellValue('A1', '姓名')
                ->setCellValue('B1', '公司')
                ->setCellValue('C1', '國家')
                ->setCellValue('D1', 'Email')
                ->setCellValue('E1', '電話');

        // TAO NOI DUNG CHEN TU DONG 2
        $i = 2;
        $arr = array(
            'post_type' => 'member',
            'posts_per_page' => -1,
            'orderby' => 'ID',
            'order' => 'ASC',
        );

        $my_query = new WP_Query($arr);
  
        if ($my_query->have_posts()) {
            while ($my_query->have_posts()) {
                $my_query->the_post();
//    echo get_the_ID();
// echo  get_post_meta(get_the_ID(),'m_fullname', TRUE);
//die();
                $exExport->setActiveSheetIndex(0)
                        ->setCellValue('A' . $i, get_post_meta(get_the_ID(), '_m_contact', TRUE))
                        ->setCellValue('B' . $i, get_post_meta(get_the_ID(), '_m_company', TRUE))
                        ->setCellValue('C' . $i, get_country(get_post_meta(get_the_ID(), '_m_country', True)))
                        ->setCellValue('D' . $i, get_post_meta(get_the_ID(), '_m_email', True))
                        ->setCellValueExplicit('E' . $i, get_post_meta(get_the_ID(), '_m_phone', True), PHPExcel_Cell_DataType::TYPE_STRING);
                $i++;
            }
            wp_reset_postdata();
            wp_reset_query();
        }
        // TAO FILE EXCEL VA SAVE LAI THEO PATH
        //$objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
        //$full_path = EXPORT_DIR . date("YmdHis") . '_report.xlsx'; //duong dan file
        //$objWriter->save($full_path);
// TAO FILE EXCEL VA DOWN TRUC TIEP XUONG CLINET
        $filename = date("YmdHis") . '_member.xlsx';
        $objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=$filename");
        header('Cache-Control: max-age=0');
        ob_end_clean();
//        ob_start();
        $objWriter->save('php://output');
    }
    
    public function ExportMemberTable() {
        require_once CLASS_DIR . 'PHPExcel.php';
        $exExport = new PHPExcel();

        // TAO COT TITLE
        $exExport->setActiveSheetIndex(0)
                ->setCellValue('A1', 'ID')
                ->setCellValue('B1', 'Full Name')
                ->setCellValue('C1', 'Country')
                ->setCellValue('D1', 'Position')
                ->setCellValue('E1', 'Email')
                ->setCellValue('F1', 'Phone')
                ->setCellValue('G1', 'Barcode')
                ->setCellValue('H1', 'Img')
                ->setCellValue('I1', 'Check In')
                ->setCellValue('J1', 'Create Date')
                ->setCellValue('K1', 'Stauts')
                ->setCellValue('L1', 'Note');

        // TAO NOI DUNG CHEN TU DONG 2
        global $wpdb;
        $table = $wpdb->prefix . 'member';
        $sql = "SELECT * FROM $table";
        $row = $wpdb->get_results($sql, ARRAY_A);
        if (!empty($row)) {
            $i = 2;
            foreach ($row as $val) {
                $exExport->setActiveSheetIndex(0)
                        ->setCellValueExplicit('A' . $i, $val['ID'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValue('B' . $i, $val['full_name'])
                        ->setCellValueExplicit('C' . $i, $val['country'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValue('D' . $i, $val['position'])
                        ->setCellValue('E' . $i, $val['email'])
                        ->setCellValueExplicit('F' . $i, $val['phone'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('G' . $i, $val['barcode'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValue('H' . $i, $val['img'])
                        ->setCellValue('I' . $i, $val['check_in'])
                        ->setCellValue('j' . $i, $val['create_date'])
                        ->setCellValue('K' . $i, $val['status'])
                        ->setCellValue('L' . $i, $val['note']);
                $i++;
            }
        }


        // TAO FILE EXCEL VA SAVE LAI THEO PATH
        //$objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
        //$full_path = EXPORT_DIR . date("YmdHis") . '_report.xlsx'; //duong dan file
        //$objWriter->save($full_path);
// TAO FILE EXCEL VA DOWN TRUC TIEP XUONG CLINET
        $filename = date("YmdHis") . '_memberlist.xlsx';
        $objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=$filename");
        header('Cache-Control: max-age=0');
        ob_end_clean();
//        ob_start();
        $objWriter->save('php://output');
    }

    public function ExportGuests() {
        require_once CLASS_DIR . 'PHPExcel.php';
        $exExport = new PHPExcel();

        // TAO COT TITLE
        $exExport->setActiveSheetIndex(0)
                ->setCellValue('A1', 'ID')
                ->setCellValue('B1', 'Full Name')
                ->setCellValue('C1', 'Country')
                ->setCellValue('D1', 'Position')
                ->setCellValue('E1', 'Email')
                ->setCellValue('F1', 'Phone')
                ->setCellValue('G1', 'Barcode')
                ->setCellValue('H1', 'Img')
                ->setCellValue('I1', 'Check In')
                ->setCellValue('J1', 'Create Date')
                ->setCellValue('K1', 'Stauts')
                ->setCellValue('L1', 'Note');

        // TAO NOI DUNG CHEN TU DONG 2
        global $wpdb;
        $table = $wpdb->prefix . 'guests';
        $sql = "SELECT * FROM $table";
        $row = $wpdb->get_results($sql, ARRAY_A);
        if (!empty($row)) {
            $i = 2;
            foreach ($row as $val) {
                $exExport->setActiveSheetIndex(0)
                        ->setCellValueExplicit('A' . $i, $val['ID'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValue('B' . $i, $val['full_name'])
                        ->setCellValueExplicit('C' . $i, get_country($val['country']), PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValue('D' . $i, $val['position'])
                        ->setCellValue('E' . $i, $val['email'])
                        ->setCellValueExplicit('F' . $i, $val['phone'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('G' . $i, $val['barcode'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValue('H' . $i, $val['img'])
                        ->setCellValue('I' . $i, $val['check_in'])
                        ->setCellValue('j' . $i, $val['create_date'])
                        ->setCellValue('K' . $i, $val['status'])
                        ->setCellValue('L' . $i, $val['note']);
                $i++;
            }
        }


        // TAO FILE EXCEL VA SAVE LAI THEO PATH
        //$objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
        //$full_path = EXPORT_DIR . date("YmdHis") . '_report.xlsx'; //duong dan file
        //$objWriter->save($full_path);
// TAO FILE EXCEL VA DOWN TRUC TIEP XUONG CLINET
        $filename = date("YmdHis") . '_guests.xlsx';
        $objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=$filename");
        header('Cache-Control: max-age=0');
        ob_end_clean();
//        ob_start();
        $objWriter->save('php://output');
    }

    public function BatchCreateQRCode() {
        global $wpdb;
        $table = $wpdb->prefix . 'guests';
        $sql = "SELECT full_name, barcode FROM $table";
        $row = $wpdb->get_results($sql, ARRAY_A);

        // XOA HET CAC FILE QRCODE .png CO TRONG FOLDER
        $files = glob(WB_DIR_IMAGES_QRCODE.'*.png'); //get all file names
        foreach($files as $file){
              if(is_file($file))
                   unlink($file); //delete file
        }
   
        // TAO TAT CA CAC FILE QRCODE MOI
        require_once ( WB_DIR_QRCODE . 'qrlib.php');
        foreach ($row as $item) {
            $filePath = WB_DIR_IMAGES_QRCODE . $item['barcode'] . '.png';
            $errorCorrectionLevel = "L";
            $matrixPointSize = 3;
            QRcode::png($item['barcode'], $filePath, $errorCorrectionLevel, $matrixPointSize, 2);

            // DOI TEN FILE THEO KIEU CHU HOA
            // $newName = iconv('UTF-8', 'BIG5', WB_DIR_IMAGES_BARCODE . $item['full_name'] . '-' . $item['barcode'] . '.png');
            // $oldName = iconv('UTF-8', 'BIG5', $filePath);
            // rename($oldName, $newName);
        }
    }

    public function ResetCheckIn() {
        global $wpdb;
        $table = $wpdb->prefix . 'guests';
        $table1 = $wpdb->prefix . 'member';
        $table2 = $wpdb->prefix . 'guests_check_in';
        //RESET ALL CHECK 
        $updateSql = "UPDATE $table SET check_in=0 WHERE 1=1";
        $wpdb->query($updateSql);

        $updateSql1 = "UPDATE $table1 SET check_in=0 WHERE 1=1";
        $wpdb->query($updateSql1);
        // XOA GUESTS CHECK IN
        $deleteSql = "DELETE FROM $table2";
        $wpdb->query($deleteSql);
        // TRA ID LAI MUT BAT DAU BAT DAU BANG 1
        $sql = "ALTER TABLE $table2 AUTO_INCREMENT = 1";
        $wpdb->query($sql);
    }

    public function SetQRCodeName() {
        global $wpdb;
   // xoa cac file cu
        $files = glob(rtrim(WB_DIR_IMAGES_QRCODE_NAME . '*.png')); //get all file names
        foreach ($files as $file) {
                unlink($file); //delete file
        }
       // rmdir( THEME_URL . DS . 'images' . DS . 'name_barcode');
   //  copy tat ca file trong thu muc barcode den thu muc name_barcode  
     //   $copyfiles = glob(trim(WB_DIR_IMAGES_QRCODE . '*.png')); //get all file names
    /*
        foreach ($copyfiles as $item) {
           // echo $item;
            if (is_file($item)) {
               $ff = explode(DS, $item);
               $lastItem = end($ff); // lay phan tu cuoi cung trong array
               $newfile = WB_DIR_IMAGES_QRCODE_NAME . $lastItem;
               copy($item, $newfile); // chuyen sang folden moi;
            }
        }
  */
 // doi ten them ten thanh vien vao ten file
        $table = $wpdb->prefix . 'guests';
        $sql = "SELECT full_name, barcode FROM $table WHERE status = 1";
        $rows = $wpdb->get_results($sql, ARRAY_A);
     
        foreach ($rows as $row) {
            $from = WB_DIR_IMAGES_QRCODE.$row['barcode'] .'.png';
            echo $from;
        
            $to   = WB_DIR_IMAGES_QRCODE_NAME .$row['barcode'].'.png';  
            echo $to;
            copy($from, $to); // chuyen sang folden moi;
            // DOI TEN FILE THEO KIEU CHU HOA
            $oldName = WB_DIR_IMAGES_QRCODE_NAME . $row['barcode'] . '.png';
            $newName = iconv('UTF-8', 'BIG5', WB_DIR_IMAGES_QRCODE_NAME . $row['full_name'] . '-' . $row['barcode'] . '.png');
            //$newName =  WB_DIR_IMAGES_QRCODE_NAME.$row['ID'] . '-' . $row['barcode'] . '.png';
            rename($oldName, $newName);
            
        }
    }

    public function ImportGuests($filename) {
        require_once CLASS_DIR . 'PHPExcel.php';
        $inputFileType = PHPExcel_IOFactory::identify($filename);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);

        $objReader->setReadDataOnly(true);

        /**  Load $inputFileName to a PHPExcel Object  * */
        $objPHPExcel = $objReader->load("$filename");

        $total_sheets = $objPHPExcel->getSheetCount();

        $allSheetName = $objPHPExcel->getSheetNames();
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        $arraydata = array();
        for ($row = 2; $row <= $highestRow; ++$row) {
            for ($col = 0; $col < $highestColumnIndex; ++$col) {
                $value = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                $arraydata[$row - 2][$col] = $value;
            }
        }
        global $wpdb;
        $table = $wpdb->prefix . 'guests';

        foreach ($arraydata as $item) {
            $note = $item[11] == null ? "" : $item[11];
            $img = $item[7] == null ? "" : $item[7];
            $phone = $item[5] == null ? "" : $item[5];
            $email = $item[4] == null ? "" : $item[4];
            $data = array(
                'full_name' => $item[1],
                'country' => $item[2],
                'position' => $item[3],
                'email' => $email,
                'phone' => $phone,
                'barcode' => $item[6],
                'img' => $img,
                'check_in' => $item[8],
                'create_date' => $item[9],
                'status' => $item[10],
                'note' => $note,
            );
            $wpdb->insert($table, $data);
            //     $format = array('%s','%s','%s','%s','%s','%s','%d','%s',NULL,'%s','%s',);
            //        $wpdb->insert($table,  $data, $format);
            // SHOW ERROR KHI INSERT DATA
            //  $wpdb->show_errors();
            // echo $wpdb->last_error;
//             echo '<pre>';
//             print_r(var_dump($wpdb));
//             echo '</pre>';
            // INSERT DATA THEO KIEU SQL
//           $sql = "INSERT INTO $table (barcode,full_name,country,position,email,phone,check_in,img,note,create_date,status) "
//                    . "VALUES ('$item[0]','$item[1]','$item[2]','$item[3]','$item[4]','$item[5]','$item[6]','$item[7]','$item[8]','$item[9]','$item[10]')";
//           $wpdb->query($sql);
        }
    }
    
    public function ImportMember($filename) {
        require_once CLASS_DIR . 'PHPExcel.php';
        $inputFileType = PHPExcel_IOFactory::identify($filename);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);

        $objReader->setReadDataOnly(true);

        /**  Load $inputFileName to a PHPExcel Object  * */
        $objPHPExcel = $objReader->load("$filename");

        $total_sheets = $objPHPExcel->getSheetCount();

        $allSheetName = $objPHPExcel->getSheetNames();
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        $arraydata = array();
        for ($row = 2; $row <= $highestRow; ++$row) {
            for ($col = 0; $col < $highestColumnIndex; ++$col) {
                $value = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                $arraydata[$row - 2][$col] = $value;
            }
        }
        global $wpdb;
        $table = $wpdb->prefix . 'member';
        foreach ($arraydata as $item) {
           
            $note = $item[11] == null ? "" : $item[11];
            $img = $item[7] == null ? "" : $item[7];
            $phone = $item[5] == null ? "" : $item[5];
            $email = $item[4] == null ? "" : $item[4];
            $createDate = $item[9] == null ? date('d-m-Y'):$item[9];
            $data = array(
                'barcode' => $item[6],
                'full_name' => $item[1],
                'country' => $item[2],
                'position' => $item[3],
                'phone' => $phone,
                'email' => $email,
                'img' => $img,
                'check_in' => $item[8],
                'status' => $item[10],
                'note' => $note,
                'create_date' => $createDate,
            );
            
           $wpdb->insert($table, $data);

        }
       // die();
    }

}