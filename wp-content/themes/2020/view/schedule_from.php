<?php
$page = getParams('page');
$action = (getParams('action') != ' ') ? getParams('action') : 'add';
$msg = '';
//---------------------------------------------------------------------------------------------
// Cmt KIEM TRA NEU CO LOI THI DUA LOI VAO BIEN  $msg VAO SHOW $msg 
//---------------------------------------------------------------------------------------------
if (count($error) > 0) {
    $msg .= '<div class="error"><ul>';
    foreach ($error as $key => $value) {
        $msg .= '<li>' . $value . '</li>';
    }
    $msg .= '</ul></div>';
}

require_once(DIR_MODEL . 'model_schedule.php');
$model = new Admin_Model_Schedule();
$data = $model->get_item(getParams());
?>


<div class="wrap">
    <h2><?php echo $lbl ?></h2>
    <form action="" method="post" id="<?php $page ?>" name="<?php $page ?>">
        <input type="hidden" name="hid_id" id="hid_id" value="<?php echo getParams('id'); ?>" />
        <div class="row-one-column">
            <div class="cell-title">活動標題</div>
            <div class="cell-text">
                <input type="text" class="my-input" name="txt-title" id="txt-title" value="<?php echo $data['title'] ?>" />
            </div>
        </div>
        <div class="row-three-column">
            <div class="col">
                <div class="cell-title">活動開始日期</div>
                <div class="cell-text">
                    <input type="text" class="my-input datepicker" name="txt-start-date" id="txt-start-date" placeholder="dd/mm/yyyy" value="<?php echo $data["date"] ?>" />
                </div>
            </div>
            <div class="col">
                <div class="cell-title">星期</div>
                <div class="cell-text">
                    <input type="text" class="my-input dayOfWeek" name="txt-start-week" id="txt-start-week" placeholder="" value="<?php echo $data["weekdays"] ?>" />
                </div>
            </div>

            <div class="col">
                <div class="cell-title">時間</div>
                <div class="cell-text">
                    <input type="text" class="my-input type-time type-number" name="txt-start-time" id="txt-start-time" placeholder="00:00" maxlength="5" value="<?php echo $data["time"] ?>" />
                </div>
            </div>
        </div>

        <div class="row-three-column">
            <div class="col">
                <div class="cell-title">活動結束日期</div>
                <div class="cell-text">
                    <input type="text" class="my-input datepicker" name="txt-finish-date" id="txt-finish-date" placeholder="dd/mm/yyyy" value="<?php echo $data["finish_date"] ?>" />
                </div>
            </div>
            <div class="col">
                <div class="cell-title">星期</div>
                <div class="cell-text">
                    <input type="text" class="my-input dayOfWeek" name="txt-finish-week" id="txt-finish-week" placeholder="" value="<?php echo $data["finish_week"] ?>" />
                </div>
            </div>

            <div class="col">
                <div class="cell-title">時間</div>
                <div class="cell-text">
                    <input type="text" class="my-input type-time type-number" name="txt-finish-time" id="txt-finish-time" placeholder="00:00"  maxlength="5" value="<?php echo $data["finish_time"] ?>"/>
                </div>
            </div>
        </div>

        <div class="row-one-column">
            <div class="cell-title">活動地點</div>
            <div class="cell-text">
                <input type="text" class="my-input" name="txt-place" id="txt-place" value="<?php echo $data['place'] ?>" />
            </div>
        </div>


        <div class="row-one-column">
            <div class="cell-title">備註</div>
            <div class="cell-text">
                <textarea class="my-input" name="txt-note" id="txt-note" style="height: 100px;"><?php echo $data['note'] ?></textarea>
            </div>
        </div>

        <div class="btn-add-space">
            <input name="submit" id="submit" class="button button-primary" value="發 表" type="submit">
        </div>
    </form>
</div>

<!--DOAN SCRIPT HIEN THI NGAY VA THU TRONG TUAN-->
<script type="text/javascript">
    jQuery(function() {
        jQuery('.datepicker').datepicker({
            dateFormat: 'dd/mm/yy',
            showAnim: 'show',
            onSelect: function(dateText) {
                let parentDiv = jQuery(this).closest('.row-three-column');
                var seldate = jQuery(this).datepicker('getDate');
                seldate = seldate.toDateString();
                seldate = seldate.split(' ');
                var weekday = new Array();
                weekday['Mon'] = "星期一";
                weekday['Tue'] = "星期二";
                weekday['Wed'] = "星期三";
                weekday['Thu'] = "星期四";
                weekday['Fri'] = "星期五";
                weekday['Sat'] = "星期六";
                weekday['Sun'] = "星期天";
                var dayOfWeek = weekday[seldate[0]];
                parentDiv.find('.dayOfWeek').val(dayOfWeek); //.attr('readonly', true)
            },
            onClose: closeDatePicker_datepicker_1
        });
    });

    function closeDatePicker_datepicker_1() {
        var tElm = jQuery('.datepicker');
        if (typeof datepicker_1_Spry !== null && typeof datepicker_1_Spry !== "undefined" && test_Spry.validate) {
            datepicker_1_Spry.validate();
        }
        tElm.blur();
    }
</script>
