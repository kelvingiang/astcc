<?php
// [18/06/2026] Fix Security: Chặn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\IOFactory;

// [18/06/2026] Fix: Nạp thư viện vendor bằng đường dẫn tuyệt đối chuẩn của WP (tránh lỗi require_once do sai cấp thư mục __DIR__)
function astcc_load_phpspreadsheet() {
    if (!class_exists('\PhpOffice\PhpSpreadsheet\Spreadsheet')) {
        $vendor_path = WP_CONTENT_DIR . '/vendor/autoload.php';
        if (file_exists($vendor_path)) {
            require_once $vendor_path;
        }
    }
}

// [18/06/2026] Refactor: Hàm dùng chung để set style cho header của Excel (Tối ưu chuẩn DRY)
function astcc_apply_excel_header_style($sheet, $last_col)
{
    $header_range = 'A1:' . $last_col . '1';
    
    $sheet->getRowDimension('1')->setRowHeight(30);
    $sheet->getStyle($header_range)->getFont()->setBold(true);
    $sheet->getStyle($header_range)->getFill()->setFillType(Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FF999999');
    $sheet->getStyle($header_range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)
        ->setColor(new Color("FF333333"));
    $sheet->getStyle($header_range)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle($header_range)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
}

// [18/06/2026] Refactor: Hàm dùng chung để xuất file và dọn dẹp bộ nhớ đệm (Tối ưu chuẩn DRY)
function astcc_output_excel_file($spreadsheet, $filename)
{
    $writer = new Xlsx($spreadsheet);

    if (ob_get_length()) {
        ob_end_clean();
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
}


function export_excel_check_in($data)
{
    astcc_load_phpspreadsheet();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('CHECK IN');

    $headers = ['A1' => '姓名', 'B1' => '分會', 'C1' => '職稱', 'D1' => '電話', 'E1' => 'E-mail', 'F1' => '時間', 'G1' => '日期'];
    foreach ($headers as $cell => $text) {
        $sheet->setCellValue($cell, $text);
    }

    $sheet->getColumnDimension('A')->setWidth(15);
    $sheet->getColumnDimension('B')->setWidth(20);
    $sheet->getColumnDimension('C')->setWidth(20);
    $sheet->getColumnDimension('D')->setWidth(20);
    $sheet->getColumnDimension('E')->setWidth(30);
    $sheet->getColumnDimension('F')->setAutoSize(true);
    $sheet->getColumnDimension('G')->setAutoSize(true);

    astcc_apply_excel_header_style($sheet, 'G');

    if (!empty($data) && is_array($data)) {
        $i = 2;
        foreach ($data as $val) {
            // [18/06/2026] Fix Bug: Sử dụng ?? '' để tránh lỗi Warning: Undefined array key
            $sheet->setCellValue('A' . $i, $val['full_name'] ?? '');
            $sheet->setCellValue('B' . $i, get_country($val['country'] ?? ''));
            $sheet->setCellValue('C' . $i, $val['position'] ?? '');
            $sheet->setCellValue('D' . $i, $val['phone'] ?? '');
            $sheet->setCellValue('E' . $i, $val['email'] ?? '');
            $sheet->setCellValue('F' . $i, $val['time'] ?? '');
            $sheet->setCellValue('G' . $i, $val['date'] ?? '');
            $i++;
        }
    }

    astcc_output_excel_file($spreadsheet, 'astcc_check_in_' . wp_date('dmYHis') . '.xlsx');
}

function export_excel_member($data)
{
    astcc_load_phpspreadsheet();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('member');

    $headers = ['A1' => '姓名', 'B1' => '國家', 'C1' => '職稱', 'D1' => '電話', 'E1' => 'E-mail', 'F1' => '條碼', 'G1' => '照片'];
    foreach ($headers as $cell => $text) {
        $sheet->setCellValue($cell, $text);
    }

    $sheet->getColumnDimension('A')->setWidth(15);
    $sheet->getColumnDimension('B')->setWidth(20);
    $sheet->getColumnDimension('C')->setWidth(20);
    $sheet->getColumnDimension('D')->setWidth(20);
    $sheet->getColumnDimension('E')->setWidth(50);
    $sheet->getColumnDimension('F')->setAutoSize(true);
    $sheet->getColumnDimension('G')->setAutoSize(true);

    astcc_apply_excel_header_style($sheet, 'G');
    $sheet->getStyle('F:F')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);

    if (!empty($data) && is_array($data)) {
        $i = 2;
        foreach ($data as $val) {
            $sheet->setCellValue('A' . $i, $val['full_name'] ?? '');
            $sheet->setCellValue('B' . $i, get_country($val['country'] ?? ''));
            $sheet->setCellValue('C' . $i, $val['position'] ?? '');
            $sheet->setCellValue('D' . $i, $val['phone'] ?? '');
            $sheet->setCellValue('E' . $i, $val['email'] ?? '');
            $sheet->setCellValueExplicit('F' . $i, $val['barcode'] ?? '', DataType::TYPE_STRING);
            $sheet->setCellValue('G' . $i, $val['img'] ?? '');
            $i++;
        }
    }

    astcc_output_excel_file($spreadsheet, 'astcc_member_' . wp_date('dmYHis') . '.xlsx');
}

function import_excel_guests($filePart)
{
    astcc_load_phpspreadsheet();
    $spreadsheet = IOFactory::load($filePart);
    $sheet = $spreadsheet->getActiveSheet();
    return $sheet->toArray();
}

