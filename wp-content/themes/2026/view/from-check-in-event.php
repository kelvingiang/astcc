<?php
require_once(DIR_MODEL . 'model-check-in-event-function.php');
$model = new Model_Check_In_Event_Function();
$id = $title = null;

if ($paramId = getParams('id')) {
    $data = $model->getItem($paramId);
    if (!empty($data)) {
        $id = $data['ID'] ?? null;
        $title = $data['title'] ?? null;
    }
}
?>

<form action="" method="post" enctype="multipart/form-data" id="f-guests" name="f-guests">
    <div style="height: 50px;">
        <input type="hidden" name="hidden_ID" value="<?php echo $id; ?>" />
    </div>
    <div class="col">
        <div class="cell-title">
            <label> 報到標題 </label>
        </div>
        <div class="cell-text">
            <input type="text" name="txt_title" class='my-input' value='<?php echo $title; ?>' />
        </div>
    </div>

    <div class="row-one-column" style="padding-top: 20px; text-align: right">
        <div class="cell-title "><label class="label-admin"></label></div>
        <div class="cell-text">
            <input name="submit" id="submit" class="button button-primary" value="發 表" type="submit" style="margin-right: 50px">
        </div>
    </div>
</form>