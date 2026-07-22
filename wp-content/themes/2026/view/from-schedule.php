<?php
$page   = getParams('page');
$id     = getParams('id');
$action = (getParams('action') !== '' && getParams('action') !== null) ? getParams('action') : 'add';
$lbl = $lbl ?? (($action === 'add') ? '新增活動' : '編輯活動');
$msg    = '';
//---------------------------------------------------------------------------------------------
// Cmt KIEM TRA NEU CO LOI THI DUA LOI VAO BIEN  $msg VAO SHOW $msg
//---------------------------------------------------------------------------------------------
$error = array();

// TODO: đẩy lỗi validate (nếu có) vào $error tại đây, ví dụ:
// if (empty($_POST['txt-title'])) { $error[] = '請輸入活動標題'; }

if (count($error) > 0) {
    $msg .= '<div class="error"><ul>';
    foreach ($error as $value) {
        $msg .= '<li>' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '</li>';
    }
    $msg .= '</ul></div>';
}

$title = "";
$date = "";
$weekdays = "";
$time = "";
$finish_date = "";
$finish_weekdays = "";
$finish_time = "";
$place = "";
$note = "";


if (isset($id) && $id != '') {
    require_once(DIR_MODEL . 'model-schedule.php');
    $model = new Model_Schedule();
    $data  = $model->get_item($id);
    if (is_array($data)) {
        $title = $data['title'];
        $date = $data['date'];
        $weekdays = $data['weekdays'];
        $time = $data['time'];
        $finish_date = $data['finish_date'];
        $finish_weekdays = $data['finish_week'];
        $finish_time = $data['finish_time'];
        $place = $data['place'];
        $note = $data['note'];
    } else {
        $error[] = '找不到該筆活動資料';
    }
}
/**
 * Helper escape ngắn cho output attribute / text.
 * Nếu đang ở môi trường WordPress, có thể đổi thành esc_attr() / esc_textarea().
 */
function h($value)
{
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}
?>

<div class="wrap">
    <h2><?php echo h($lbl); ?></h2>

    <?php echo $msg; // hiển thị lỗi (nếu có) 
    ?>

    <form action="" method="post" id="<?php echo h($page); ?>" name="<?php echo h($page); ?>">
        <input type="hidden" name="hid_id" id="hid_id" value="<?php echo h($id); ?>" />

        <div class="row-one-column">
            <div class="cell-title">活動標題</div>
            <div class="cell-text">
                <input type="text" class="my-input" name="txt-title" id="txt-title"
                    value="<?php echo $title; ?>" required />
            </div>
        </div>

        <div class="row-three-column">
            <div class="col">
                <div class="cell-title">活動開始日期</div>
                <div class="cell-text">
                    <input type="text" class="my-input datepicker" name="txt-start-date" id="txt-start-date"
                        placeholder="dd/mm/yyyy" value="<?php echo $date; ?>" required />
                </div>
            </div>
            <div class="col">
                <div class="cell-title">星期</div>
                <div class="cell-text">
                    <input type="text" class="my-input dayOfWeek" name="txt-start-week" id="txt-start-week"
                        placeholder="" value="<?php echo $weekdays; ?>" readonly />
                </div>
            </div>
            <div class="col">
                <div class="cell-title">時間</div>
                <div class="cell-text">
                    <input type="text" class="my-input type-time type-number" name="txt-start-time" id="txt-start-time"
                        placeholder="00:00" maxlength="5" value="<?php echo $time; ?>" />
                </div>
            </div>
        </div>

        <div class="row-three-column">
            <div class="col">
                <div class="cell-title">活動結束日期</div>
                <div class="cell-text">
                    <input type="text" class="my-input datepicker" name="txt-finish-date" id="txt-finish-date"
                        placeholder="dd/mm/yyyy" value="<?php echo $finish_date; ?>" />
                </div>
            </div>
            <div class="col">
                <div class="cell-title">星期</div>
                <div class="cell-text">
                    <input type="text" class="my-input dayOfWeek" name="txt-finish-week" id="txt-finish-week"
                        placeholder="" value="<?php echo $finish_weekdays; ?>" readonly />
                </div>
            </div>
            <div class="col">
                <div class="cell-title">時間</div>
                <div class="cell-text">
                    <input type="text" class="my-input type-time type-number" name="txt-finish-time" id="txt-finish-time"
                        placeholder="00:00" maxlength="5" value="<?php echo $finish_time; ?>" />
                </div>
            </div>
        </div>

        <div class="row-one-column">
            <div class="cell-title">活動地點</div>
            <div class="cell-text">
                <input type="text" class="my-input" name="txt-place" id="txt-place"
                    value="<?php echo $place; ?>" />
            </div>
        </div>

        <div class="row-one-column">
            <div class="cell-title">備註</div>
            <div class="cell-text">
                <textarea class="my-input" name="txt-note" id="txt-note" style="height: 100px;"><?php echo $note; ?></textarea>
            </div>
        </div>

        <div class="btn-add-space">
            <input name="submit" id="submit" class="button button-primary" value="發 表" type="submit">
        </div>
    </form>
</div>

<!-- DOAN SCRIPT HIEN THI NGAY VA THU TRONG TUAN -->
<script type="text/javascript">
    jQuery(function($) {

        var weekdayMap = {
            'Mon': '星期一',
            'Tue': '星期二',
            'Wed': '星期三',
            'Thu': '星期四',
            'Fri': '星期五',
            'Sat': '星期六',
            'Sun': '星期天'
        };

        jQuery('.datepicker').datepicker({
            dateFormat: 'dd/mm/yy',
            showAnim: 'show',
            onSelect: function(dateText) {
                var $parentDiv = jQuery(this).closest('.row-three-column');
                var selDate = jQuery(this).datepicker('getDate');
                var dayShort = selDate.toDateString().split(' ')[0]; // 'Mon', 'Tue', ...
                var dayOfWeek = weekdayMap[dayShort] || '';

                $parentDiv.find('.dayOfWeek').val(dayOfWeek);
            },
            onClose: closeDatePicker_datepicker_1
        });

       
    });

    function closeDatePicker_datepicker_1() {
        var $elm = jQuery('.datepicker');

        if (typeof datepicker_1_Spry !== 'undefined' && datepicker_1_Spry && typeof datepicker_1_Spry.validate === 'function') {
            datepicker_1_Spry.validate();
        }

        $elm.blur();
    }
</script>