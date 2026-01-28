<?php

class Admin_Model_Excel {

    public function ExprotToExcel(array $data) {
        require_once DIR_CLASS . 'PHPExcel.php';
        $exExport = new PHPExcel();

        // TAO COT TITLE
        $exExport->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Tên')
                ->setCellValue('B1', 'Email')
                ->setCellValue('C1', 'hovaten')
                ->setCellValue('D1', 'dt');

        // TAO NOI DUNG CHEN TU DONG 2
        $i = 2;
        foreach ($data as $row) {
            $exExport->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $row['user'])
                    ->setCellValue('B' . $i, $row['email'])
                    ->setCellValue('C' . $i, $row['fullname'])
                    ->setCellValue('D' . $i, $row['phone']);
            $i++;
        }

        // TAO FILE EXCEL VA SAVE LAI THEO PATH
        $objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
        $full_path = HQ_DIR_EXPORT . date("Ymd") . '_data.xlsx'; //duong dan file

        $objWriter->save($full_path);

        // SEND MAIL ATTACHMENT FILE T
        $attachments = array($full_path);
        $headers = 'From: My Name <myname@example.com>' . "\r\n";
        wp_mail('giaminh0265@yahoo.com', 'subject', 'message', $headers, $attachments);

        //    SAU KHI SEND XONG CHUYEN VE TRANG SHOW
        $url = 'admin.php?page=' . $_REQUEST['page'] . '&msg=1';
        wp_redirect($url);
    }

    public function ImportFromExcel($filename) {
        global $wpdb;
        require_once DIR_CLASS . 'PHPExcel.php';
        //$filename = 'data.xlsx';
        // echo '<br>'. $filename;

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

        $table = $wpdb->prefix . 'staff';
        foreach ($arraydata as $item) {
            $data = array(
                'code' => $item[0],
                'name' => $item[1],
                'sex' => $item[2],
                'address' => $item[3],
                'phone' => $item[4],
                'email' => $item[5],
                'department' => $item[6],
                'birthday' => $item[7],
                'day' => $item[8],
                'month' => $item[9],
                'image' => 'no-image.jpg',
                'status' => $item[10],
                'arrival' => $item[11],
                'create-date' => date('Y-m-d')
            );
   
           $wpdb->insert($table, $data);
        }
    }

    public function SaveItem($arrData = array(), $option = array()) {
  
        if (isset($_FILES['myfile'])) {
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
            if ($file_size > 2097152) {
                $errors[] = 'File size must be excately 2 MB';
            }
            if (empty($errors)) {
                $path = import_file();
                move_uploaded_file($file_tmp, ( $path . $file_name));

                $excelList = $path . $file_name;
                $this->ImportFromExcel($excelList);
//                require_once DGW_DIR_MODEL . 'excel_model.php';
//                $import = new DGW_Excel_Model();
//                $import->ImportFromExcel($excelList);
            }
        }
    }

}

?>
