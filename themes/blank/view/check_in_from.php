<?php
if (!empty(getParams('id'))) {
    require_once (MODEL_DIR . 'check_in_model.php');
    $model = new Admin_Check_In_Model();
    $data = $model->get_item(getParams());
}
?>
<?php
require_once (MODEL_DIR . 'check_in_model.php');
$error = Admin_Check_In_Model::$_error;

if (!empty($error)) {
    ?>
    <div style=" background-color: #FFADAD; color: white; min-height: 50px; margin-left: -20px; margin-top: 10px; padding: 20px">
        <?php foreach ($error as $val) { ?>
            <label style=" font-weight: bold"> <?php echo $val ?></label>
        <?php } ?>
    </div>
<?php } ?>
<form action="" method="post" enctype="multipart/form-data" id="f-guests" name="f-guests" >
    <div class="content" style=" height: 230px; padding-top: 50px">
        <div class="cell-one "><label class="label-admin" > <?php _e('Picture') ?> </label></div>    
        <div class="cell-two">
            <?php
            if (empty($data['img'])) {
                $guest_img = 'no-image.jpg';
            } else {
                $guest_img = $data['img'];
            }
            ?>

            <div id="show-img" style=" background-image: url('<?php echo get_guests_img($guest_img); ?>');"></div>  
            <input type="file" id="guests_img" name="guests_img" accept=".png, .jpg, .jpeg, .bmp"/>
            
            <input type='hidden' id='hidden_barcode' name='hidden_barcode' value='<?php echo $data['barcode']; ?>'/>
            <input type='hidden' id='hidden_ID' name='hidden_ID' value='<?php echo $data['ID']; ?>'/>
            <input type='hidden' id='hidden_img' name='hidden_img' value='<?php echo $data['img']; ?>'/>
            <input type='hidden' id='hidden_country' name='hidden_country' value='<?php echo $data['country']; ?>'/>
            <input type='hidden' id='hidden_password' name='hidden_password' value='<?php echo $data['password']; ?>'/>
            <input type='hidden' id='hidden_appcode' name='hidden_appcode' value='<?php echo $data['app_code']; ?>'/>
        </div>
    </div>

    <?php if (getParams('action') != 'add') { ?>
        <div class="content" style=" height: 50px">
            <div class="cell-one "><label class="label-admin"> <?php _e('Barcode') ?> </label></div>    
            <div class="cell-two">
                <span><img id="img_barcode" name="img_barcode" src='<?php echo get_qrcode_img($data['barcode']); ?>' ></span> 
                <span style=" position: absolute; top:300px; padding-left: 10px">
                    <label> <?php echo $data['barcode']; ?></label><br/><br/>
                    <a href="<?php echo get_qrcode_img($data['barcode']) ?>" 
                       download="<?php echo $data['full_name'] . '-' . $data['barcode'] . '.png' ?>"
                       style="font-weight:  bold; text-decoration: none; color: blue"    
                       > 下載 QRCODE 檔案 </a>
                </span>     
            </div>
        </div>
    <?php } ?>
    
    <div class="content">
        <div class="cell-one "><label class="label-admin"> <?php _e('App Code') ?></label></div>    
        <div class="cell-two"><input type="text" id="txt_appcode" name="txt_appcode" <?php echo get_current_user_id() == 1 ? '' : 'readonly' ?> value ="<?php echo $data['app_code'] ?>" /></div>
    </div>

    <div class="content">
        <div class="cell-one "><label class="label-admin"> <?php _e('Full Name') ?></label></div>    
        <div class="cell-two"><input type="text" id="txt_fullname" name="txt_fullname"   required value ="<?php echo $data['full_name'] ?>" /></div>
    </div>
<!--    <div class="content">
        <div class="cell-one "><label class="label-admin"> <?php// _e('Password') ?> </label></div>    
        <div class="cell-two"><input type="password" id="txt_password" name="txt_password"   required value ="<?php //echo $data['password'] != '' ? $data['password'] : '0000' ?>" /></div>
    </div>-->
    <div class="content">
        <div class="cell-one "><label class="label-admin"><?php
                _e('Country');
                ?> </label></div>    
        <div class="cell-two">
            <select  id="sel_country" name="sel_country" >
                <?php foreach (get_guests_country() as $key => $val) { ?>
                    <option value='<?php echo $key ?>' <?php echo $data['country'] == $key ? 'selected' : '' ?>  > <?php echo $val ?> </option>
                <?php } ?>
            </select></div>
    </div>
    <div class="content">
        <div class="cell-one "><label class="label-admin"> <?php _e('Asia Position') ?> </label></div>    
        <div class="cell-two"><input type="text" id="txt_position" name="txt_position" value='<?php echo $data['position'] ?>' /></div>
    </div>
    <div class="content">
        <div class="cell-one "><label class="label-admin"> <?php _e('Email') ?> </label></div>    
        <div class="cell-two">
            <input type="text" id="txt_email" name="txt_email" class='email'  value='<?php echo $data['email'] ?>' />
            <label style=' font-weight: bold; color: red;padding-left: 10px' id='error-email'></label>
        </div>
    </div>
    <div class="content">
        <div class="cell-one "><label class="label-admin"> <?php _e('Phone') ?> </label></div>    
        <div class="cell-two"><input type="text" id="txt_phone" name="txt_phone" class='type-phone-more'  value='<?php echo $data['phone']; ?>' /></div>
    </div>
    <div class="content">
        <div class="cell-one "><label class="label-admin"> <?php _e('Note') ?> </label></div>    
        <div class="cell-two">
            <textarea id="txt_note" name="txt_note" cols="41" rows="6"><?php echo $data['note'] ?></textarea>
        </div>
    </div>
    <div class="content" style="padding-top: 20px; text-align: right">
        <div class="cell-one "><label class="label-admin"></label></div>   
        <div class="cell-two">
            <input name="submit" id="submit" class="button button-primary" value="發 表" type="submit" style="margin-right: 50px">
        </div>
    </div>
</form>
<script type="text/javascript">
    // show hinh anh truoc khi up len
    jQuery(function () {
        jQuery("#guests_img").on("change", function ()
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
    });

</script>
