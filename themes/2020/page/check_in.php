<?php
//Template Name: Check In
get_header();
?>
<div class="my_container">
    <div id="loggo">
        <div>
            <img src="<?php echo get_image('astcc-logo.png') ?>" class="logo-img" alt="ctcvn_logo" title="ctcvn_logo" />
        </div>
        <div>
            <label class="title-cn">亞 洲 台 灣 商 會 聯 合 總 會 </label>
            <label class="title-en">ASIA TAIWANESE CHAMBERS OF COMMERCE</label>
            <label class="title-meeting"> <?php echo get_option('Title_text'); ?> </label>
        </div>
    </div>

    <div id='check-in-content'>
        <div class="check-in-form">
            <form name="check-form" id="check-form" method="post" action="">
                <input type="text" id="txt-barcode" name="txt-barcode" placeholder="輸入條碼" required title="Username should only contain lowercase letters. e.g. john" style="width: 70%;  height: 33px" />
                <button type="submit" id="btn-submit" name="btn-submit" class="btn-submit-barcode">
                    <?php _e('Submit'); ?>
                </button>
            </form>
            <div class="digiwin">
                <img src="<?php echo get_image('digiwin_logo.png'); ?>" /> </br>
                <label class="text-digiwin">鼎 捷 軟 件 維 護 製 作</label>
            </div>
        </div>

        <div class="check-in-value">
            <div class="check-in-value-header">
                <div>
                    <label class="text-welcome"> 歡 迎 光 臨 </label>
                    <div id="last-check-in"></div>
                </div>

            </div>


            <div id="barcode-error">條 碼 不 正 確 !</div>
            <div id="accout-unactive"> 您 的 帳 號 還 未 啓 用 ! </div>
            <div id="guest-main">
                <div>
                    <div id="guest-pictrue"></div>
                </div>
                <div>
                    <div class="guest-info guest-name">
                        <label id="guest_name">&nbsp; </label>
                    </div>

                    <div class="guest-info">
                        <label>職 稱 : </label>
                        <label id="guest_position">&nbsp; </label>
                    </div>

                    <div class="guest-info">
                        <label>國 家 : </label>
                        <label id="guest_country">&nbsp; </label>
                    </div>

                    <div class="guest-info">
                        <label>E-mail : </label>
                        <label id="guest_email">&nbsp; </label>
                    </div>

                    <div class="guest-info">
                        <label>電 話 :</label>
                        <label id="guest_phone">&nbsp; </label>
                    </div>
                    <div class="guest-info">
                        <label>備 註 :</label>
                        <label id="guest_note">&nbsp; </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#txt-barcode").focus();

        jQuery('#check-form').submit(function(e) {
            //     console.log(objInfo);
            var barcode = jQuery('#txt-barcode').val();
            jQuery('.my-waiting').css('display', 'block');


            jQuery.ajax({
                url: '<?php echo get_template_directory_uri() . '/ajax/updata-checkin.php' ?>', // lay doi tuong chuyen sang dang array
                type: 'post',
                //                data: $(this).serialize(),
                data: {
                    id: barcode
                },
                dataType: 'json',
                success: function(data) { // set ket qua tra ve  data tra ve co thanh phan status va message
                    jQuery("#txt-barcode").val('');
                    if (data.status === 'done') {
                        //window.location.reload();  
                        jQuery('#guest-main, #last-check-in, #accout-unactive').css('display', 'flex');
                        jQuery('#barcode-error, #accout-unactive').css('display', 'none');
                        jQuery('#last-check-in').css('display', 'block');
                        jQuery('#last-check-in').children().remove();
                        if (data.info.TotalTimes !== null) {
                            jQuery('#last-check-in').append("<h5>登入次數 : " + data.info.TotalTimes + " 次  </h5>");
                            jQuery('#last-check-in').append("<h5>上次登入 : " + data.info.LastCheckIn + "</h5>");
                        }
                        jQuery('#guest_name').text(data.info.FullName);
                        jQuery('#guest_position').text(data.info.Position);
                        jQuery('#guest_country').text(data.info.Country);
                        jQuery('#guest_email').text(data.info.Email);
                        jQuery('#guest_phone').text(data.info.Phone);
                        jQuery('#guest_note').text(data.info.Note);
                        jQuery('#guest-pic').remove();
                        jQuery('#guest-pictrue').append(data.info.Img);

                        window.setTimeout(function() {
                            jQuery('.my-waiting').css('display', 'none');
                        }, 100);

                        //   alert(data.info.FullName);
                    } else if (data.status === 'error') {
                        jQuery('#guest-main, #last-check-in, #accout-unactive').css('display', 'none');
                        jQuery('#barcode-error').css('display', 'block');
                        window.setTimeout(function() {
                            jQuery('.my-waiting').css('display', 'none');
                        }, 100);
                    } else if (data.status === 'unactive') {
                        jQuery('#guest-main, #last-check-in, #barcode-error').css('display', 'none');
                        jQuery('#accout-unactive').css('display', 'block');
                        window.setTimeout(function() {
                            jQuery('.my-waiting').css('display', 'none');
                        }, 100);
                    }
                },
                error: function(xhr) {
                    console.log(xhr.reponseText);
                    //console.log(data.status);
                }
            });
            e.preventDefault();
        });
    });
</script>