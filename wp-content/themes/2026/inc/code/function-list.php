<?php

// 1. Nguồn dữ liệu duy nhất (Chỉ cần thêm/sửa quốc gia ở đây)
function get_guests_country()
{
    return array(
        '00'  => '選擇國家',
        '081' => '日本',
        '082' => '韓國',
        '062' => '印尼',
        '091' => '印度',
        '673' => '汶萊',
        '880' => '孟加拉',
        '855' => '柬埔寨',
        '852' => '香港',
        '856' => '寮國',
        '060' => '馬來西亞',
        '063' => '菲律賓',
        '084' => '越南',
        '065' => '新加坡',
        '066' => '泰國',
        '095' => '緬甸',
        '853' => '澳門',
        '001' => '關島',
        '670' => '東帝汶',
        '966' => '阿拉伯',
        '002' => '觀察會員國帛琉'
    );
}

// 2. Lấy tên quốc gia dựa trên mã (Tối ưu lại)
function get_country($countryCode)
{
    $countries = get_guests_country();
    // Bỏ qua giá trị mặc định '00'
    unset($countries['00']);
    return isset($countries[$countryCode]) ? $countries[$countryCode] : '';
}

// 3. Lấy mã dựa trên tên quốc gia (Tối ưu lại)
function set_country($countryName)
{
    $countries = get_guests_country();
    unset($countries['00']);
    
    // Tìm mã code dựa theo tên
    $code = array_search($countryName, $countries);
    return $code !== false ? (string)$code : '';
}

function download_list()
{
    $arr = array(
        array('file' => "32niengiam.pdf", 'name' => "第32屆亞洲台灣商會聯合總會年刊"),

        array('file' => "31niengiam.pdf", 'name' => "第31屆亞洲台灣商會聯合總會年刊"),

        array('file' => "20241223-1.pdf", 'name' => "第32屆經貿投資特刊"),

        array('file' => "20241223-2-cn.pdf", 'name' => "臺商經貿投資白皮書 -馬來西亞篇 (中文)"),

        array('file' => "20241223-2-en.pdf", 'name' => "臺商經貿投資白皮書 -馬來西亞篇 (英文)"),

        array('file' => "22hueikan.pdf", 'name' => "第廿二屆理監事聯席會議特刊"),

        array('file' => "24hueikan.pdf", 'name' => "第廿四屆理監事聯席會議特刊"),

        array('file' => "27nainkan.pdf", 'name' => "第廿七屆理監事聯席會議特刊"),

        array('file' => "28hueikan.pdf", 'name' => "第廿八屆理監事聯席會議特刊"),

        array('file' => "29hueikan.pdf", 'name' => "第二九屆理監事聯席會議特刊"),

        array('file' => "30jiniantekan.pdf", 'name' => "第三十屆理監事聯席會議特刊"),

        array('file' => "thailanf-2022.pdf", 'name' => "臺商經貿投資白皮書─泰國篇"),

        array('file' => "2022-10-report.pdf", 'name' => "第30屆功能委員會"),

        array('file' => "2022-09.pdf", 'name' => "東協經貿委員會月報"),

        array('file' => "lishsuphandau.pdf", 'name' => "亞洲商會創奮鬥史"),

        array('file' => "28niengiam-1.pdf", 'name' => "第廿八屆年刊（一）"),

        array('file' => "28niengiam-2.pdf", 'name' => "第廿八屆年刊（二）"),

        array('file' => "28niengiam-3.pdf", 'name' => "第廿八屆年刊（三）"),

    );

    return $arr;
}
