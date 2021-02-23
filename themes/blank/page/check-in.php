<?php
//Template Name: Check In
get_header();
?>
<div class="my_container" style="padding-bottom: 30px" >
    <div class="row">
        <div id="loggo" style=" margin-bottom: 10px" class="col-xl-12 col-lg-12">
            <a style=" float: left"  href="<?php echo home_url() ?>" >
                <img src="<?php echo get_image('astcc-logo.png') ?>"  class="logo-img"  alt="ctcvn_logo" title="ctcvn_logo"/>
            </a> 
            <div><h1 class="title-cn">亞 洲 台 灣 商 會 聯 合 總 會 </h1></div> 
            <div><h1 class="title-en">ASIA TAIWANESE CHAMBERS OF COMMERCE</h1></div>
  
            <h1 style="font-weight:  bold; color: #2D3094; letter-spacing: 3px; text-align: center; font-size: 35px; margin-bottom: 15px "> <?php echo get_option('Title_text'); ?> </h1>
        </div>
        <div class=" col-xl-3 col-lg-3 col-md-3">
            <form name="check-form" id="check-form" method="post" action="">
                <input type="text" id="txt-barcode" name="txt-barcode" placeholder="輸入條碼" required
                       title="Username should only contain lowercase letters. e.g. john"  style="width: 70%;  height: 33px"/>
                <input type="submit" id="btn-submit" name="btn-submitbarcode"  value="<?php _e('Submit'); ?>" class="btn btn-sm"/>
            </form>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
            <div class="row">
                <div class='col-lg-12' style=' margin-bottom: 20px; height: 120px; color: #666;  border-bottom: 2px #666 dotted; float: left' >
                    <div class="row">
                        <div class="col-lg-6">
                            <h2 style="font-weight:bold;  color: #FC9105" > 歡 迎 光 臨 </h2>
                            <div id="last-check-in">
                            </div>
                        </div>
                        <div class="col-lg-6" style="padding-top: 10px; float: right">
                            <img src="<?php echo get_image('digiwin_logo.png'); ?>"/> </br>
                            <label style="font-size: 25px; font-weight: bold; padding-left: 10px;color: #FC9105">鼎 捷 軟 件 維 護 製 作</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" id="barcode-error">條 碼 不 正 確 ! </div>
                <div class="col-lg-12" id="accout-unactive"> 您 的 帳 號 還 未 啓 用 ! </div>
                <div class="col-lg-12" id="guest-main">
                    <div class="row">
                        <div id="guest-pictrue" class="col-lg-5">

                        </div>

                        <div class="col-lg-7" style="padding-left: 50px; float:  left ; font-size: 15px"> 
                            <div class="guest-info guest-name">
                                <div><label>姓 名 : </label></div>
                                <div><label id="guest_name">&nbsp; </label></div>
                            </div>  
                            <div class="guest-info">
                                <div><label>職 稱  : </label></div>
                                <div><label id="guest_position">&nbsp; </label></div>
                            </div>  
                            <div class="guest-info">
                                <div><label>所 屬 商 會 :  </label></div>
                                <div><label id="guest_country">&nbsp; </label></div>
                            </div>
                            <div class="guest-info">
                                <div><label>E-mail : </label></div>
                                <div><label id="guest_email">&nbsp; </label></div>
                            </div>
                            <div class="guest-info">
                                <div><label>聯 絡 電 話 :</label></div>
                                <div><label id="guest_phone">&nbsp; </label></div>
                            </div>
                            <div class="guest-info">
                                <div><label>備 註 :</label></div>
                                <div><label id="guest_note">&nbsp; </label></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style  type="text/css">
    .my_container{
        background-color: #FFF !important;
        max-width:  100% !important;
        margin: 0 auto;
        min-height: 780px;
    }

    .my_container .row{
        width: 100%;
        margin: 0 auto;
    }

    .my_container .row #title-text, .my_container .row #loggo{
        background-color: #eeeeee;
        padding-top: 10px;

    }
    #title-text{
        margin-bottom: 20px;
        border-bottom: 2px solid #2D3094;
    }
    #guest-main{
        margin-left: 10px;
    }
    .guest-info{
        clear: both;
    }
    .guest-info div:first-child{
        min-width: 100px;
    }
    .guest-info div {
        float: left;
    }
    .guest-name{
        font-size: 20px; 
        font-weight: bold;
        color:#FC9105
    }
    #guest-pic{
        width: 350px;
        margin-left: 5px; 
        margin-top: 5px;
        border: 1px solid #999999;
        border-radius: 3px;
    }
    #last-check-in h5 {
        font-weight: bold
    }
    #barcode-error, #accout-unactive{
        display: none;
        font-size:  30px;
        font-weight: bold;
        color: red;
    }
</style>

<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery("#txt-barcode").focus();

        jQuery('#check-form').submit(function (e) {
            //     console.log(objInfo);
            var barcode = jQuery('#txt-barcode').val();
            jQuery('.my-waiting').css('display', 'block');


            jQuery.ajax({
                url: '<?php echo get_template_directory_uri() . '/ajax/updata-checkin.php' ?>', // lay doi tuong chuyen sang dang array
                type: 'post',
                //                data: $(this).serialize(),
                data: {id: barcode},
                dataType: 'json',
                success: function (data) {  // set ket qua tra ve  data tra ve co thanh phan status va message
                    jQuery("#txt-barcode").val('');
                    if (data.status === 'done') {
                        //window.location.reload();  
                        jQuery('#barcode-error, #accout-unactive').css('display', 'none');
                        jQuery('#guest-main, #last-check-in').css('display', 'block');
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

                        window.setTimeout(function () {
                            jQuery('.my-waiting').css('display', 'none');
                        }, 100);

                        //   alert(data.info.FullName);
                    } else if (data.status === 'error') {
                        jQuery('#guest-main, #last-check-in, #accout-unactive').css('display', 'none');
                        jQuery('#barcode-error').css('display', 'block');
                        window.setTimeout(function () {
                            jQuery('.my-waiting').css('display', 'none');
                        }, 100);
                    } else if (data.status === 'unactive') {
                        jQuery('#guest-main, #last-check-in, #barcode-error').css('display', 'none');
                        jQuery('#accout-unactive').css('display', 'block');
                        window.setTimeout(function () {
                            jQuery('.my-waiting').css('display', 'none');
                        }, 100);
                    }
                },
                error: function (xhr) {
                    console.log(xhr.reponseText);
                    //console.log(data.status);
                }
            });
            e.preventDefault();
        });
    });
</script>

