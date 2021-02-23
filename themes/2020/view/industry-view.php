<?php
$page = getParams('page');
require_once ( DIR_MODEL . 'model_kind.php');
$model = new Admin_Model_Kind();
$item = $model->get_item(getParams('id'));

/* ========== start  lay tat ca id trong bang member ========= */
//$industry_id = $model->getMemberIndustry();
//$arr_id = getMemberIndustry($industry_id);
?>

<div style="width:100%; height: 50px">
    <h2>行業分類</h2>
</div>
<div style="width: 100%; display: flex">
    <div class="my-table" style=" width:50%; margin-top: 55px">

        <?php $url = 'admin.php?page=' . $page . '&action=add' ?>
        <form action="<?php echo $url ?>" method="post" id="f1" name="f1" >
            <input type="hidden" id='hid-id' name='hid-id' value="<?php echo $item['ID'] ?>"/>
            <div class="my-row">
                <div class="column-15">
                    <label>行業名稱</label>
                </div>
                <div class="column-75">
                    <input type="text" name="txt-name" id="txt-name" value="<?php echo $item['name'] ?>" />
                </div>
            </div>
            <div class="my-row">
                <div class="column-15">
                    <label>排列次序</label>
                </div>
                <div class="column-75">
                    <input type="text" name="txt-order" id="txt-order" class="type-number"  value="<?php echo $item['order'] ?>" />
                </div>
            </div>
            <div class="button-space">
                <input name="submit" id="submit" class="button button-primary" value="發 表" type="submit">
            </div>
        </form>
    </div>
    <div style="width:50%">
        <?php
        $data = $model->getAll();
        $stt = 1
        ?>
        <div style=" margin: 10px" >
            <a  href="<?php echo 'admin.php?page=' . $page ?>" class="button button-primary" >新 增</a>
        </div>
        <div class="data-list">
            <div class="row row-title">
                <div><label>排列次序</label></div>
                <div style=" border-left: 1px #dbdada solid"><label>行業名稱</label></div>
                <div style=" border-left: 1px #dbdada solid"></div>
            </div>
            <?php foreach ($data as $val) { ?>
                <div class="row">
                    <div><?php echo $val['order'] ?></div>
                    <div>
                        <a href="<?php echo 'admin.php?page=' . $page . '&action=edit&id=' . $val['ID'] ?>" style="font-size: 15px">
                            <?php echo $val['name'] ?>
                        </a>
                    </div>
                    <div>
                        <a onclick="myFunction('您確定刪除這行業?', '<?php echo $page ?>', 'del', <?php echo $val['ID'] ?>)" class="del-style" > <?php _e('Delete') ?></a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
