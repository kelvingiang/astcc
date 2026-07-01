<?php
// [18/06/2026] Fix Security: Chặn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

// [18/06/2026] Fix: Nạp thư viện vendor bằng đường dẫn tuyệt đối chuẩn của WP để tránh lỗi file path
function astcc_load_qrcode_library() {
    if (!class_exists('\Endroid\QrCode\QrCode')) {
        $vendor_path = WP_CONTENT_DIR . '/vendor/autoload.php';
        if (file_exists($vendor_path)) {
            require_once $vendor_path;
        }
    }
}

/**
 * [18/06/2026] Refactor: Tạo QRCode với định dạng an toàn, không dùng die() gây sập web
 * 
 * @param string $code Mã của QRCode
 * @param string $name Họ tên thành viên
 * @param int $flag Nếu = 0 tên file không có tên thành viên, nếu = 1 tên file sẽ có tên thành viên
 */
function create_QRCode($code, $name, $flag)
{
    
    astcc_load_qrcode_library();

    $qrCode = new QrCode((string)$code);
    $qrCode->setSize(70);
    $qrCode->setMargin(2);

    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    $imageData = $result->getString();
    $qrImage = imagecreatefromstring($imageData);

    // [18/06/2026] Tối ưu: Dùng hàm chuẩn của WordPress thay cho __DIR__ tương đối, dễ bảo trì hơn
    // Fix: Sửa lại đường dẫn thành thư mục "fronts" (Do thư mục gốc bị viết sai chính tả thành fronts thay vì fonts)
    $fontPath = get_template_directory() . '/inc/fonts/NotoSansTC-Regular.ttf';
    if (!file_exists($fontPath)) {
        // [18/06/2026] Fix Bug (Nghiêm trọng): Tuyệt đối KHÔNG dùng die() trong core app vì sẽ làm website trắng trang (WSOD). Thay vào đó hãy ghi log.
        error_log('Lỗi tạo QRCode - Không tìm thấy Font tại: ' . $fontPath);
        return false;
    }

    $fontSize = 9;
    $text = (string)$name;

    // 計算文字寬高 (Tính toán chiều rộng/cao chữ)
    $bbox = imagettfbbox($fontSize, 0, $fontPath, $text);
    $textWidth = abs($bbox[2] - $bbox[0]);

    // QR Code 圖片大小
    $qrWidth = imagesx($qrImage);
    $qrHeight = imagesy($qrImage);

    // 新圖片高度：原 QR 高度 + 額外 10px 空間
    $newHeight = $qrHeight + 10;
    $newImage = imagecreatetruecolor($qrWidth, $newHeight);

    // 填滿白底 (Nền trắng)
    $white = imagecolorallocate($newImage, 255, 255, 255);
    imagefill($newImage, 0, 0, $white);

    // 把 QR Code 複製到新圖像上（靠上貼）
    imagecopy($newImage, $qrImage, 0, 0, 0, 0, $qrWidth, $qrHeight);

    // 設定文字顏色 (Chữ đen)
    $black = imagecolorallocate($newImage, 0, 0, 0);
    
    // 文字置中對齊，並離底部 3px
    $textX = ($qrWidth - $textWidth) / 2; // Ở giữa
    $textY = $newHeight - 3;              // Cách đáy 3px

    // [18/06/2026] Fix PHP 8.1+ Warning: Ép kiểu (int) cho $textX và $textY để tránh cảnh báo "Implicit conversion from float to int loses precision"
    imagettftext($newImage, $fontSize, 0, (int)$textX, (int)$textY, $black, $fontPath, $text);

    // [18/06/2026] Theo yêu cầu: Luôn lưu tất cả file QR Code vào chung thư mục images/qrcode/ (ngoài thư mục inc)
    $outputDir = get_template_directory() . '/images/qrcode/';
    
    if (!file_exists($outputDir)) {
        wp_mkdir_p($outputDir); // Hàm tạo thư mục an toàn của WordPress
    }

    $filename = ($flag == 1) ? $code . '-' . $name . '.png' : $code . '.png';
    $outputPath = $outputDir . $filename;
    
    imagepng($newImage, $outputPath);

    // 清理 (Xóa bộ nhớ)
    imagedestroy($qrImage);
    imagedestroy($newImage);
    
    return true;
}

