<?php
$action = $_GET['action'];
$id = $_GET['id'];
$title = $action == 'add' ? '新增候選' : '修改-更新';
if ($action == "add") {
    $voterHueizhangPermission = 0;
    $voteHueizhangAgree = 0;
    $voteHueizhangAnti = 0;
    $voterJianshiPermission = 0;
    $voteJianshiAgress = 0;
    $voteJianshiAnti = 0;
    $voteFail = 0;
} else {
    include_once DIR_CONTROLER . 'vote_controler.php';
    $controler = new Admin_Vote_Controler();
    $item = $controler->getItem($id);
    $voteHueizhangPermission = $item['vote_hueizhang_permission'];
    $voteHueizhangAgree = $item['vote_hueizhang_agree'];
    $voteHueizhangAnti = $item['vote_hueizhang_anti'];
    $voteJiansshiPermission = $item['vote_jianshi_permission'];
    $voteJianshiAgree = $item['vote_jianshi_agree'];
    $voteJianshiAnti = $item['vote_jianshi_anti'];
    $voteFail = $item['vote_fail'];
}
?>
<style>
    .err{
        color: red;
        font-size: 12px;
        font-style:italic;
    }
</style>
<div style="padding-top: 20px">
    <div style=" margin:  0 30px;" ><h2 style="color:  #0364c5;  letter-spacing: 5px"><?php echo $title ?></h2></div>
    <form action="" method="post" enctype="multipart/form-data" id="f-vote" name="f-vote" >
        <input type="hidden" id="hid_id" name="hid_id" value="<?php echo $item['ID'] ?>">
        <input type="hidden" id="hid_img" name="hid_img" value="<?php echo $item['img'] ?>">
        <div class="content" style=" margin-bottom: 70px ">
            <div class="cell-one "><label class="label-admin" > <?php _e('Picture') ?> </label></div>    
            <div class="cell-two">
                <?php
                if (empty($item['img'])) {
                    $vote_img = 'no-image.jpg';
                } else {
                    $vote_img = $item['img'];
                }
                ?>
                <div id="show-img" style="background-image: url('<?php echo get_vote_img($vote_img); ?>')"></div>  
                <input type="file" id="vote_img" name="vote_img" accept=".png, .jpg, .jpeg, .bmp"/>
            </div>
        </div>
</div>

<div class="content">
    <div class="cell-one "><label class="label-admin">候選類別</label></div>    
    <div class="cell-two">
        <select id="sel_kid" name="sel_kid">
            <option value="0">選類別</option>
            <option value="1"  <?php echo $item['kid'] == 1 ? 'selected' : '' ?> >總會長</option>
            <option value="2"  <?php echo $item['kid'] == 2 ? 'selected' : '' ?> >監事長</option>
            <option value="3"  <?php echo $item['kid'] == 3 ? 'selected' : '' ?> >各國總會</option>
        </select>
        <label id="err_kid" class="err"></label>
    </div>
</div>

<div class="content">
    <div class="cell-one "><label class="label-admin">職位</label></div>    
    <div class="cell-two">
        <select id="sel_position" name="sel_position">
            <option value="0">選擇職位</option>
            <option value="1"  <?php echo $item['position'] == 1 ? 'selected' : '' ?> >總會長</option>
            <option value="2"  <?php echo $item['position'] == 2 ? 'selected' : '' ?> >監事長</option>
        </select>
        <label id="err_position" class="err"></label>
    </div>
</div>

<div class="content">
    <div class="cell-one "><label class="label-admin" >姓名</label></div>    
    <div class="cell-two">
        <label id="err_name" class="err"></label>
        <input type="text" id="txt_name" name="txt_name" value="<?php echo $item['name'] ?>" />
    </div>
</div>
<div class="content">
    <div class="cell-one "><label class="label-admin">公司名稱</label></div>    
    <div class="cell-two"><input type="text" id="txt_company" name="txt_company" value="<?php echo $item['company'] ?>"  /></div>
</div>
<hr>
<div class="content">
    <div class="cell-one "><label class="label-admin">總會長有投票權人數</label></div>    
    <div class="cell-two"><input type="text" id="txt_hueizhang_permission" name="txt_hueizhang_permission" value="<?php echo $voteHueizhangPermission; ?>"  class=" type-number " /></div>
</div>

<div class="content">
    <div class="cell-one "><label class="label-admin">總會長同意票數</label></div>    
    <div class="cell-two"><input type="text" id="txt_hueizhang_agree" name="txt_hueizhang_agree" value="<?php echo $voteHueizhangAgree; ?>"  class=" type-number " /></div>
</div>

<div class="content">
    <div class="cell-one "><label class="label-admin" style=" color: #999" >總會長不同意票數</label></div>    
    <div class="cell-two"><input type="text" id="txt_hueizhang_anti" name="txt_hueizhang_anti" value="<?php echo $voteHueizhangAnti; ?>"  class=" type-number " /></div>
</div>
<hr>
<div class="content">
    <div class="cell-one "><label class="label-admin">監事長有投票權人數</label></div>    
    <div class="cell-two"><input type="text" id="txt_jianshi_permission" name="txt_jianshi_permission" value="<?php echo $voteJiansshiPermission; ?>"  class=" type-number " /></div>
</div>
<div class="content">
    <div class="cell-one "><label class="label-admin">監事長同意票數</label></div>    
    <div class="cell-two"><input type="text" id="txt_jianshi_agree" name="txt_jianshi_agree" value="<?php echo $voteJianshiAgree; ?>"  class=" type-number " /></div>
</div>

<div class="content">
    <div class="cell-one "><label class="label-admin" style=" color: #999">監事長不同意票數</label></div>    
    <div class="cell-two"><input type="text" id="txt_jianshi_anti" name="txt_jianshi_anti" value="<?php echo $voteJianshiAnti; ?>"  class=" type-number " /></div>
</div>
<!--
<div class="content">
    <div class="cell-one "><label class="label-admin">廢票數</label></div>    
    <div class="cell-two"><input type="text" id="txt_fail" name="txt_fail" value="<?php echo $voteFail; ?>" class=" type-number " /></div>
</div>
-->
<div class="content">
    <div class="cell-one "><label class="label-admin">總票數</label></div>    
    <div class="cell-two"><input type="text" id="txt_vote" name="txt_vote"  value="<?php echo $item['vote_total'] ?>"  /></div>
</div>

<div class="content" style="padding-top: 20px; margin-left: 23%">
    <div class="cell-one "><label class="label-admin"></label></div>   
    <div class="cell-submit ">
        <button type="button" id="submitBtn" class="button button-primary"> 發 佈</button>
    </div>
</div>
</form>
</div>
<script type="text/javascript">



    jQuery(document).ready(function () {
//        jQuery("#txt_agree").keyup(function () {
//            vote_total();
//        });
//
//        jQuery("#txt_anti").keyup(function () {
//            vote_total();
//        });
//        jQuery("#txt_fail").keyup(function () {
//            vote_total();
//        });

        jQuery('#submitBtn').on("click", function () {
            var err = [];
            jQuery('#err_kid').html('');
            jQuery('#err_name').html('');

            if (jQuery("#sel_kid").val() === "0") {
                err[1] = "請選上候選者職稱";
            }

            if (jQuery("#txt_name").val() === '') {
                err[2] = '姓名不能為空';
            }

            if (err.length > 0) {
                jQuery('#err_kid').html(err[1]);
                jQuery('#err_name').html(err[2]);
                // err.splice();
            } else {
                jQuery('#f-vote').submit();
            }
        });
    });



    // show hinh anh truoc khi up len
    jQuery(function () {
        jQuery("#vote_img").on("change", function ()
        {
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader)
                return; // no file selected, or no FileReader support

            if (/^image/.test(files[0].type)) { // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function () { // set image data as background of div
                    jQuery("#show-img").css("background-image", "url(" + this.result + ")");
                };
                console.log(result);
            }
        });
    }
    );

//    function vote_total() {
//        var agree = parseInt(jQuery("#txt_agree").val(), 10);
//        var anti = parseInt(jQuery("#txt_anti").val(), 10);
//        // var fail = parseInt(jQuery("#txt_fail").val(), 10);
//        var total = agree + anti;
//
//        jQuery("#txt_vote").val(total);
//    }

</script>
