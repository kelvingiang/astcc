<?php
/*
  Template Name:  Vote Result
 */

if (isset($_GET['kid'])) {
    VoteExportToExcel($_GET['kid']);
}
?>
<?php
// lay phan header
get_header();
?>
<style>

</style>
<body id="main_bg">
    <div class=" container-fluid ">
        <div class="row">
            <div class="col-lg-12">
                <!--<label class="vote-title-text">亞洲台灣商會聯合總會 - 投票系統</label>-->
            </div>
            <div class="col-lg-12" style="text-align: right">
                <!--                    <label class="btn btn-large btn-default" onclick="FunctionExportExcel(1)">總會長結果導出</label>
                                    <label class="btn btn-large btn-default" onclick="FunctionExportExcel(2)">監事長結果導出</label>-->
            </div>
            <?php
            $hueizhangList = getVoteResult(1);
            $jianshizhangList = getVoteResult(2);
            ?>
            <div class="col-lg-6">
                <div class="col-lg-12 title-space">總會長投票結果</div>
                <div class="list_horizontal">
                    <div class="list_col">
                        <div style=" font-weight: bold; color: white;
                             text-align: center; font-size: 20px; padding: 5px; background-color:  #f06801"
                             ><?php echo $hueizhangList[0]['name'] ?></div>
                        <div style=" text-align: center; height: 250px;   border-bottom: 1px dotted #dedbd9;"> <img   src="<?php echo get_vote_img($hueizhangList[0]['img']) ?>" /></div>
                        <div class="vote_text"><label>同意　</label>: <label id="hueizhangAgree"></label></div>
                        <div class="vote_text"><label>不同意</label>: <label id="hueizhangAnti"></label></div>
                        <div class="vote_text"><label>總票數  </label>: <label id="hueizhangTotal"></label></div>
                    </div>
                </div>
                <div></div>
            </div>

            <div class="col-lg-6">
                <div class="col-lg-12 title-space">監事長投票結果</div>
                <div class="list_horizontal">
                    <div class="list_col">
                        <div style=" font-weight: bold; color: white;
                             text-align: center; font-size: 20px; padding: 5px; background-color:  #f06801"
                             ><?php echo $jianshizhangList[0]['name'] ?></div>
                        <div style=" text-align: center; height: 250px;   border-bottom: 1px dotted #dedbd9;"> <img   src="<?php echo get_vote_img($jianshizhangList[0]['img']) ?>" /></div>
                        <div class="vote_text"><label>同意　 </label>: <label id="jianshiAgree"></label></div>
                        <div class="vote_text"><label>不同意 </label>: <label id="jianshiAnti"></label> </div>
                        <div class="vote_text"><label>總票數  </label>:<label id="jianshiTotal"></label> </div>
                    </div>
                </div>
                <div></div>
            </div>

            <!--//=================================================================-->               
            <?php
            $zangsiList = getVoteResult(3);
//                $zangsi_vote_total = voteTotal(2);
            ?>
            <div class="col-lg-12 title-space" style="margin-top: 70px" ></div>
            <div class="col-lg-12">
                <ul id='my_list' class="list_style">
                    <li id="list_title" style=" font-weight: bold; font-size: 20px;">
                        <div ><label>商會</label></div>
                        <div><label>照片</label></div>
                        <!--<div><label>有投票權人數</label></div>-->
                        <div>
                            <table style=" color: white; text-align: center; width: 100%">
                                <tr style=" border-bottom: 1px solid #fff">
                                    <td colspan="3" style=" font-size: 16px; padding-bottom: 10px">總會長</td>
                                </tr>
                                <tr style=" margin-top: 10px">
                                    <td style=" width: 35%; padding-top: 10px; font-size: 12px; border-right: 1px solid #fff">
                                        有投票權人數
                                    </td>
                                    <td style=" width: 35%; padding-top: 10px; font-size: 12px; border-right: 1px solid #fff">
                                        同意票數
                                    </td>
                                    <td style=" width: 30%; padding-top: 10px;font-size: 12px" >不同意票數</td>
                                </tr>
                            </table>
                        </div>
                        <div>  <table style=" color: white; text-align: center; width: 100%">
                                <tr style=" border-bottom: 1px solid #fff">
                                    <td colspan="3" style=" font-size: 16px; padding-bottom: 10px">監事長</td>
                                </tr>
                                <tr style=" margin-top: 10px">
                                    <td style=" width: 35%; padding-top: 10px; font-size: 12px; border-right: 1px solid #fff">
                                        有投票權人數
                                    </td>
                                    <td style=" width: 35%; padding-top: 10px; font-size: 12px; border-right: 1px solid #fff">
                                        同意票數
                                    </td>
                                    <td style=" width: 30%; padding-top: 10px;font-size: 12px" >不同意票數</td>
                                </tr>
                            </table>
                        </div>
                        <!-- <div><label>廢票</label></div> -->
                        <!--<div><label>總票數</label></div>-->
                    </li>
                    <?php
                    foreach ($zangsiList as $val) {
                        $hueizhangAgree = $hueizhangAgree + $val['vote_hueizhang_agree'];
                        $hueizhangAnti = $hueizhangAnti + $val['vote_hueizhang_anti'];
                        $jianshiAgree = $jianshiAgree + $val['vote_jianshi_agree'];
                        $jianshiAnti = $jianshiAnti + $val['vote_jianshi_anti'];
                        ?>
                        <li>
                            <div style="font-weight: bold"><?php echo $val['name'] ?></div>
                            <div> <img  style=" width: 80%; border: 1px solid #6d6f72; border-radius: 5px; margin: 5px"  src="<?php echo get_vote_img($val['img']) ?>" /></div>
                            <!--<div><?php /* echo $val['vote_permission'] */ ?></div>-->
                            <div>
                                <div style="width: 35%">
                                    <?php echo $val['vote_hueizhang_permission'] ?>
                                </div>
                                <div style="width: 35%; background-color: #c9c7c7; color: #333; height: 100%">
                                    <?php /*echo $val['vote_hueizhang_agree']*/ ?>
                                </div>
                                <div style="width: 30%;background-color: #bab6b6; color: #333; height: 100%">
                                    <?php /* echo $val['vote_hueizhang_anti']*/ ?>
                                </div>  
                            </div>
                            <div>
                                <div style="width: 35%">
                                    <?php echo $val['vote_jianshi_permission'] ?>
                                </div>
                                <div style="width: 35%; background-color: #c9c7c7; color: #333; height: 100%">
                                    <?php /*/echo $val['vote_jianshi_agree'] */?>
                                </div>
                                <div style="width: 30%; background-color: #bab6b6; color: #333; height: 100%">
                                    <?php /*echo $val['vote_jianshi_anti'] */?>
                                </div>  
                            </div>
                           <!-- <div><?php /* echo $val['vote_fail'] */ ?></div> -->
                             <!--<div style="font-weight: bold"><?php /* echo $val['vote_total']  */ ?></div>-->
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <div></div>
            </div>
        </div>
    </div>
    <style>
        .top-style{
            position:fixed;
            top:0px;
        }


    </style>
</body>

<script>

    function FunctionExportExcel(id) {
        var url = '<?php echo Chang_Url(); ?>';
        window.location = url + "/vote-result?kid=" + id;
    }
    jQuery(window).on('scroll', function () {
        var scrollTop = jQuery(window).scrollTop(),
                elementOffset = jQuery('#list_title').offset().top,
                listOffset = jQuery('#my_list').offset().top,
                distance = (elementOffset - scrollTop),
                disMyList = (listOffset - scrollTop);
        if (distance <= 0) {
            jQuery('#list_title').addClass('top-style');
            jQuery('#list_title').width(jQuery('#my_list').width());
        }
        if (disMyList >= 30) {
            jQuery('#list_title').removeClass('top-style');
        }
    });
    jQuery(document).ready(function () {
        var hueizhang_agree = <?php echo $hueizhangAgree ?>;
        var hueizhang_anti = <?php echo $hueizhangAnti ?>;
        var jianshi_agree = <?php echo $jianshiAgree ?>;
        var jianshi_anti = <?php echo $jianshiAnti ?>

        jQuery('#hueizhangAgree').html(hueizhang_agree);
        jQuery('#hueizhangAnti').html(hueizhang_anti);
        jQuery('#hueizhangTotal').html(hueizhang_agree + hueizhang_anti);
        jQuery('#jianshiAgree').html(jianshi_agree);
        jQuery('#jianshiAnti').html(jianshi_anti);
        jQuery('#jianshiTotal').html(jianshi_agree + jianshi_anti);

    });
</script>
<?php
// lay phan footer
get_footer();
