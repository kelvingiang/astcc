



<div class="row">
    <div class="col-lg-12">
        <label class="vote-title-text">亞洲台灣商會聯合總會 - 第二十八屆選舉結果</label>
    </div>

    <?php
    $voteFinalList = getVoteFinalResult();
    // $vote_total = voteTotal(1);
    ?>
    <!--<div class="col-lg-12 title-space">選舉結果 </div>-->
    <div class="col-lg-12">
        <div class="list_horizontal">
            <?php
            $stt = 1;
            foreach ($voteFinalList as $val) {
                ?>
                <div class="list_col" style=" display: flex; width: 50%;  flex-direction: column;">
                    <div style=" height: 40px;
                         background-color:  #fc7500; 
                         font-weight: bold;
                         display: flex;                                    
                         justify-content: center;
                         align-items: center;
                         font-size: 18px;
                         color: white">

                        <?php echo $val['kid'] == 1 ? '總會長' : '監事長' ?>
                    </div>
                    <div style="height:360px">
                        <img style="width: 100%; max-height: 600px"  src="<?php echo get_vote_img( $stt.".jpg") ?>" /></div>
                    <div style="height: 30px; text-align: center; font-size: 17px; color:#fc7500;  font-weight: bold ">
                               <?php echo $val['name'] ?></div>
                </div>
                <?php
                $stt ++;
            }
            ?>
        </div>
        <div style="margin: 10px"><a style="float: right; letter-spacing: 4px" class="btn btn-large btn-primary" href="<?php echo home_url('vote-result') ?>" >投票詳細</a></div>
    </div>

    <!--//=================================================================-->   
    <div class="col-lg-12" style="height: 10px; background-color: #ccc; margin: 10px 0"></div>
</div>

<script>
    jQuery(document).ready(function () {

    });
</script>