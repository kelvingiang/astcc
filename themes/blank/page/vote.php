<?php
/*
  Template Name:  Vote
 */
if (!isset($_SESSION['voteLogin'])) {
    wp_redirect(home_url('vote-login'));
}
 $url_chang =  "Chang_U";
?>
<!DOCTYPE html>
<html id="main">
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php wp_head(); ?>
        <style>
            #main{
                margin-top: 0px !important;
            }/*
            */
            #main_bg{
                background-color: #FFF;
                background-image: url('');
                padding: 0px;
                font-size: calc(1em + 1vh);
                color: #666;
            }

            h2{
                letter-spacing: 2px;
                color:  #f97a05;
                font-size: 3vh;
                font-weight: bold;
            }

            .vote-title-text{
                height: 80px;
                font-size: 28px;
                color:  #ea6c05;
                font-weight: bold;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .vote-title-bg-sub{
                height: 40px;
                width: 100%;

                background-color: #ea6c05;
                display: block;
            }
            .vote-title-text-sub{
                font-size: 20px;
                color:  white;
                letter-spacing: 2px;
                line-height: 40px;
                margin-left: 10px;
            }

            .list_vote .list_vote_row:nth-child(even){
                background-color:#faf9f9;
            }

            .list_vote_row{
                display: flex;
                border-bottom: 1px solid #ccc;
            }

            .list_vote_row div{
                width: 20%;
                display: flex;
                justify-content:  center;
                align-items:  center;
                padding: 10px 0px;
            }
            .list_vote_row div:first-child{
                width: 5%;
            }
            
            .list_vote_row div:last-child{
                width: 30%;
                justify-content:  flex-start;
            }
            .list_vote_row img {
                width: 100px;
                max-height: 150px;
            }

        </style>
    </head>
    <?php
    $lishiList = getVoteListByKid(1);
    $zianshiList = getVoteListByKid(2);
    ?>

    <body id="main_bg">
        <div class=" container-fluid">
            <form name="vote-f" id="vote-f" action="<?php echo home_url('vote-submit') ?>" method="post">
                <div class="row">
                    <div class=" col-lg-12">
                        <label class="vote-title-text" >亞洲台灣商會聯合總會 - 投票系統</label>
                    </div> 
                    <div class="col-lg-12" >
                        <div class="vote-title-bg-sub"> 
                            <label class="vote-title-text-sub">總會長候選名單</label>
                        </div>
                        <div class="col-lg-12 list_vote">
                            <?php
                            foreach ($lishiList as $item) {
                                ?>
                                <div class="list_vote_row">
                                    <div>
                                        <input type="checkbox" class="lishi" name="<?php echo $item['ID'] ?>" id="<?php echo $item['ID'] ?>"> 
                                    </div>
                                    <div>
                                        <?php echo $item['name'] ?>
                                    </div>
                                    <div>
                                        <img src="<?php echo WB_URL_IMAGES_VOTE . $item['img'] ?>"/>
                                    </div>
                                    <div>
                                        <?php echo $item['company'] ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>            
                    <div class="col-lg-12" style=" height: 30px"></div>
                    <div class="col-lg-12">
                        <div class="vote-title-bg-sub"> 
                            <label class="vote-title-text-sub">監事長候選名單</label>
                        </div>
                        <div class="col-lg-12 list_vote">
                            <?php
                            foreach ($zianshiList as $item) {
                                ?>
                                <div class="list_vote_row">
                                    <div >
                                        <input type="checkbox" class="zianshi" name="<?php echo $item['ID'] ?>" id="<?php echo $item['ID'] ?>"> 
                                    </div>
                                    <div>
                                        <?php echo $item['name'] ?>
                                    </div>
                                    <div>
                                        <img src="<?php echo WB_URL_IMAGES_VOTE . $item['img'] ?>"/>
                                    </div>
                                    <div>
                                        <?php echo $item['company'] ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-lg-12" style=" height: 100px; text-align: right; padding-right: 50px; padding-top: 20px">
                        <button type="button" name="btn-submit" id="btn-submit" class="btn btn-primary btn-large" style=" font-size: 20px; font-weight: bold"> 投 票 </button>
                    </div>
                </div>
            </form>
            <div id="dialog" title="提醒注意">
                <p>This is an animated dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the 'x' icon.</p>
            </div>
        </div>
   
    </div>
</body>
</html>
<style>
    #dialog{
        background-color: red;
        color: #FFF;
        font-weight: bold;
    }
</style>



<script>
    jQuery(document).ready(function () {
 
        jQuery('[type="checkbox"]').each(function () { //iterate all listed checkbox items
            this.checked = status; //change ".checkbox" checked status
        });
  

  

        var liShiCount = 0;
        var zianShiCount = 0;

        jQuery('input.lishi[type="checkbox"]').click(function () {
            if (jQuery(this).is(":checked")) {
                liShiCount++;
                if (liShiCount > 2) {
                    jQuery("#dialog").dialog("open");
                    jQuery("#dialog p").text("您勾選總會長票數已超過十九位");
                    jQuery(this).attr("checked", false);
                    liShiCount--;
                }
            } else if (jQuery(this).is(":not(:checked)")) {
                liShiCount--;
                console.log(liShiCount);
            }
        });

        jQuery('input.zianshi[type="checkbox"]').click(function () {
            if (jQuery(this).is(":checked")) {
                zianShiCount++;
                if (zianShiCount > 3) {
                    jQuery("#dialog").dialog("open");
                    jQuery("#dialog p").text("您勾選監事長票數已超過十二位 ");
                    jQuery(this).attr("checked", false);
                    zianShiCount--;
                }
                console.log("+" + zianShiCount);
            } else if (jQuery(this).is(":not(:checked)")) {
                zianShiCount--;
                console.log("-" + zianShiCount);
            }
        });

        jQuery("#btn-submit").on("click", function () {
            jQuery("#vote-f").submit();
        });

        jQuery(function () {
            jQuery("#dialog").dialog({
                autoOpen: false,
                resizable: false,
                modal: true,
                show: {
                    effect: "blind",
                    duration: 1000
                },
                hide: {
                    effect: "explode",
                    duration: 1000
                }
            });

        });

    });


</script>

