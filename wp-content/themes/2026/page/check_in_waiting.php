<?php
//Template Name: Check In Waiting
get_header();
?>
<div class="my_container">
    <div id="loggo">
        <img src="<?php echo get_image('astcc-logo.png') ?>" class="logo-img" alt="ctcvn_logo" title="ctcvn_logo" />
        <label class="title-cn">亞 洲 台 灣 商 會 聯 合 總 會 </label>
        <label class="title-en">ASIA TAIWANESE CHAMBERS OF COMMERCE</label>
        <label class="title-meeting"> <?php echo get_option('Title_text'); ?> </label>
    </div>
    <div style="text-align: center; height:250px; margin-top:10%">
        <label ID="waiting_txt"><?php echo get_option('Waiting_text'); ?></label>
    </div>
</div>

<style>
    #waiting_txt {
        font-size: 50px;
        font-weight: bold;
        letter-spacing: 10px;
        -webkit-animation-name: example;
        /* Safari 4.0 - 8.0 */
        -webkit-animation-duration: 10s;
        /* Safari 4.0 - 8.0 */
        -webkit-animation-iteration-count: infinite;
        /* Safari 4.0 - 8.0 */
        animation-name: example;
        animation-duration: 10s;
        animation-iteration-count: infinite;

    }


    /* Safari 4.0 - 8.0 */
    @-webkit-keyframes example {
        0% {
            color: #333;
            font-size: 60px
        }

        20% {
            color: #333;
            font-size: 60px
        }

        40% {
            color: #FC9105;
            font-size: 72px
        }

        41% {
            color: #FC9105;
            font-size: 70px
        }

        42% {
            color: #FC9105;
            font-size: 71px
        }

        50% {
            color: #FC9105;
            font-size: 70px
        }

        70% {
            color: #FC9105;
            font-size: 70px
        }

        100% {
            color: #333;
            font-size: 60px;
        }
    }

    /* Standard syntax */
    @keyframes example {
        0% {
            color: #333;
            font-size: 60px
        }

        20% {
            color: #333;
            font-size: 60px
        }

        40% {
            color: #FC9105;
            font-size: 72px
        }

        41% {
            color: #FC9105;
            font-size: 70px
        }

        42% {
            color: #FC9105;
            font-size: 71px
        }

        50% {
            color: #FC9105;
            font-size: 70px
        }

        70% {
            color: #FC9105;
            font-size: 70px
        }

        100% {
            color: #333;
            font-size: 60px;
        }
    }
</style>