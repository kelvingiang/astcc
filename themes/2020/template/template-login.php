<div class="blue-group">
                <div class="blue-title">
                    <h3 class="blue-title-text"> 會員登入 </h3>
                </div> 
<div class="login-space group-space" style=" border-radius: 0 0 5px 5px ">
    <form id="f-login" name="f-login" method="post" action="">
        <div class="form-style">
            <div class="form-text">帳號</div>
            <div>
                <input type="text" id="txt-user" name="txt-user" class="form-control" />
            </div>
        </div>
        <div class="form-style">
            <div class="form-text">密碼</div>
            <div>
                <input type="password" id="txt-pass" name="txt-pass" class="form-control"/>
                <a href="http://tttba.org/"></a>
            </div>
        </div>
        <div style="text-align: center; line-height: 60px">
            <input type="submit" name="btn-submit" id="btn-submit" value="登入" class="btn my-btn" />
            <input type="button"id="btn-changed-password" value="忘記密碼" class="btn my-btn" />
            <!--<a  href="<?php echo URL_FILE . 'member-register.pdf' ?>" download="member_register" class="btn my-btn" style=" color: white"><i class="fa fa-download" aria-hidden="true"></i> 會員申請表</a>-->
        </div>
    </form>
</div>


<div id="chang-password-place">
    <div class="chang-password-area">
        <div class="chang-password-title">
            <div class="title-text"><label>忘記密碼</label></div>
            <div class="close-x"><i class="fa fa-window-close" aria-hidden="true"></i></div>
        </div>
        <div class="chang-password-content">
            <div>
                <label style=" margin-bottom: 5px; font-weight: bold">會員電郵 <i id="email-error" style="color: red; font-size: 15px"></i></label>
                <input type="text" id="txt-email" name="txt-email" class=" form-control"/></div>
            <div style=" text-align: right; ">
                <input type="submit" class="btn my-btn" id="btn-chang" name="btn-chang" value="發送"  disabled="true" />
            </div>
        </div>
    </div>
</div>

<?php
if (isPost()) {
    global $wpdb;
// THONG SO id DUA CHUYEN TREN url DE LAY DONG DU LIEU CAN CHINH SUA
    $table = $wpdb->prefix . 'member';
    $pass = md5($_POST['txt-pass']);
    $sql = "SELECT company_cn, contact_cn, password, ID, contact_email, serial FROM $table WHERE trash = 0 AND contact_email = '" . $_POST['txt-user'] . "' AND password = '$pass'";
    $row = $wpdb->get_row($sql, ARRAY_A);


    if (!empty($row)) {
        $_SESSION['member'] = $row;
        wp_redirect(home_url('member'));
        /* wp_redirect("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); */ /* GIU LAI TRANG HIEN TAI */
    }
}
?>

<style>
    .login-space{
        background-color: #ccc;
        padding: 5px;
        width: 100%;
    }
    .form-style{
        margin: 10px 2px;
    }
    .form-text {
        margin: 5px 10px;
        letter-spacing: 2px;
        font-size: 1.5rem;
        font-weight: bold;
    }

    #chang-password-place{
        background-color: rgba(170, 165, 165, 0.9);
        width: 100vw;
        height: 100vh;    
        position:fixed;
        top: 0px;
        left: 0px;
        z-index: 100;
        display: none;


    }

    .chang-password-area{
        background-color: #fff;
        width: 50%;
        height: 300px;
        margin-top: 10%;
        margin-left: 25%;
        opacity: 1;
        border-radius: 5px;
        z-index: 110;

    }

    .chang-password-title{
        background-color:  #730000;
        height: 50px;
        border-radius: 5px 5px  0 0 ;
        color: white;

    }

    .chang-password-title label{
        font-weight: bold;
        letter-spacing: 2px;
        margin-top: 15px;
        margin-left: 15px;
    }

    .title-text{
        float: left;
    }
    .close-x{
        float: right;
        margin-right: 15px;
        margin-top: 15px;
        cursor:  pointer;
        font-size: 20px;
    }

    .chang-password-content{
        width: 90%;
        margin: 0 20px;
        margin-top: 50px;
    }

    .chang-password-content div{
        margin-bottom: 20px;

    }


</style>
<script>
    jQuery(document).ready(function () {
        jQuery('#btn-changed-password').click(function () {
            jQuery('#chang-password-place').fadeIn(1000);
            jQuery("body").css("overflow", "hidden");
            jQuery('#txt-email').val('');
        });

        jQuery('.close-x').click(function () {
            jQuery('#chang-password-place').fadeOut(500);
            jQuery("body").css("overflow", "scroll");
        });

        // CHUYEN  KIEM TRA EMAIL HOI VIEN DA DANG KY  BANG AJAX
        jQuery('#txt-email').focusout(function () {
            customerEmail = jQuery('#txt-email').val();

            jQuery.ajax({
                url: '<?php echo get_template_directory_uri() . '/ajax/check-email.php' ?>', // lay doi tuong chuyen sang dang array
                type: 'post', //                data: $(this).serialize(),
                data: {email: customerEmail},
                dataType: 'json',
                success: function (data) {  // set ket qua tra ve  data tra ve co thanh phan status va message
                    if (data.status === 'done') {
                        jQuery("#email-error").html('');
                        jQuery("#btn-chang").prop("disabled", false);

                    } else if (data.status === 'error') {
                        jQuery("#email-error").html('電郵不存在');
                        jQuery("#btn-chang").prop("disabled", true);

                    }
                }

            });
        });

        jQuery('#btn-chang').click(function () {
            customerEmail = jQuery('#txt-email').val();

            jQuery.ajax({
                url: '<?php echo get_template_directory_uri() . '/ajax/send-email-get-password.php' ?>', // lay doi tuong chuyen sang dang array
                type: 'post', //                data: $(this).serialize(),
                data: {email: customerEmail},
                dataType: 'json',
                success: function (data) {  // set ket qua tra ve  data tra ve co thanh phan status va message
                    if (data.send === 'good') {
                        jQuery('.chang-password-content').empty();
                        jQuery('.chang-password-content').append("<h2 style='letter-spacing: 2px; color: #730000; font-weight: bold'>新密碼已成功寄到您的郵箱</h2>");
                        setTimeout(() => {
                            jQuery('#chang-password-place').fadeOut(500);
                            jQuery("body").css("overflow", "scroll");
                            window.location.reload();
                        }, 3000);
                    } else if (data.send === 'error') {
                        console.log('loi');
                    }
                }

            });
        });


    });
</script>


