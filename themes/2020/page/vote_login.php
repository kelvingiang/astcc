<?php
/*
  Template Name:  Vote Login
 */
if (isPost()) {
    $returnValue = voteLogin($_POST['txt-name'], $_POST['txt-pass']);
}

?>
<html id="main">
    <head>
        <title>ctcvn vote system</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php wp_head(); ?>
        <style>
            #main{
                margin-top: 0px !important;
            }

            #main_bg{
                background-color: #FFF;
                background-image: url('');
                padding: 0px;
                font-size: calc(1em + 1vh);
                color: #666;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100%;
            }

            .vote-error{
                color: red;
                font-style:  italic;
                font-size: 12px;
                font-weight: normal;
            }

            .my-container .row div{
                margin-bottom: 5px;
            }

            label{
                font-size: 18px;
                letter-spacing: 1px;
            }
            /* Extra small devices (phones, 600px and down) */
            @media only screen and (max-width: 600px) {
                 .vote-title-text{
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 10vh;
                    font-size: 1.3em;
                    color:  #002a80;
                }
            }

            /* Small devices (portrait tablets and large phones, 600px and up) */
            @media only screen and (min-width: 600px) {
                .vote-title-text{
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 10vh;
                    font-size: 1.3em;
                    color:  #002a80;
                }
            }

            /* Medium devices (landscape tablets, 768px and up) */
            @media only screen and (min-width: 768px) {
                .my-container{
                    border: 0px dotted #ccc;
                    border-radius: 5px;

                    height: 30vh;
                    width: 50vw;

                    display: block;
                    overflow: visible;
                }

                .vote-title-text{
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 10vh;
                    font-size: 1.3em;
                    color:  #002a80;
                }
            }

            /* Large devices (laptops/desktops, 992px and up) */
            @media only screen and (min-width: 992px) {
                .my-container{
                    border: 1px dotted #ccc;
                    border-radius: 5px;

                    height: 40vh;
                    width: 60vw;

                    display: block;
                    overflow: visible;
                }

                .vote-title-text{
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 17vh;
                    font-size: 1.5em;
                    color:  #002a80;
                }
            }

            /* Extra large devices (large laptops and desktops, 1200px and up) */
            @media only screen and (min-width: 1200px) {
                .vote-title-text{
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 10vh;
                    font-size: 1em;
                    color:  #002a80;
                }
            }

            @media only screen and (min-width: 1365px) {
                .my-container{
                    border: 3px dotted #ccc;
                    border-radius: 5px;

                    height: 40vh;
                    width: 50vw;

                    display: block;
                    overflow: visible;
                }

                .vote-title-text{
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 15vh;
                    font-size: 1.8em;
                    color:  #002a80;
                }

            }

        </style>
    </head>

    <body id="main_bg">
        <div class="container-fluid my-container">
            <form name="f_vote_login" id="f_vote_login" method="post" action="">
                <div class="row">
                    <div class="col-lg-12">
                        <label class="vote-title-text">亞洲台灣商會聯合總會 - 投票系統</label>
                    </div>
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-md-12 col-xs-12"> <label> 帳號 </label></div>
                            <div class="col-lg-7 col-md-6 col-md-12 col-xs-12" ><input type="text" name="txt-name" id="txt-name" class=" form-control" /></div>
                            <div class="col-lg-3 col-md-4 col-md-12 col-xs-12"> <label name="user-error" id="user-error" class="vote-error"></label></div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-md-12 col-xs-12"><label> 密碼 </label></div>
                            <div class="col-lg-7 col-md-6 col-md-12 col-xs-12"><input type="password" name="txt-pass" id="txt-pass" class="form-control"/></div>
                            <div class="col-lg-3 col-md-4 col-md-12 col-xs-12"><label name="pass-error" id="pass-error" class="vote-error">&nbsp; </label></div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-5"><label class="vote-error"><?php echo $returnValue ?></label></div>
                            <div class="col-lg-2">
                                <input type="button" name="btn-submit" id="btn-submit" value=" 登 入 " class="btn btn-primary btn-large"  style=" float: right"/>
                            </div>
                            <div class="col-lg-3"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </body>
    <script>
        jQuery(document).ready(function () {
            jQuery("#btn-submit").on("click", function () {
                var error = '';
                if (jQuery('#txt-name').val() === '') {
                    error = 'name is null';
                    jQuery('#user-error').text('請輸入您的帳號!');
                } else {
                    error + '';
                    jQuery('#user-error').text('');
                }

                if (jQuery('#txt-pass').val() === '') {
                    error = 'pass is null';
                    jQuery('#pass-error').text('請輸入您的密碼!');
                } else {
                    error + '';
                    jQuery('#pass-error').text('');
                }
                console.log(error);
                if (error === '') {
                    jQuery("#f_vote_login").submit();
                }
            });
        });
    </script>
</html>

