<div style="clear: both; height: 30px"></div>
</div>

</div> <!-- end coontaineer -->
<?php
require_once(DIR_CLASS . 'online-counter.php');
$online = new Class_Online_counter;
?>
<?php if (!is_page('check-in')) { ?>
    <div id="back-top-wrapper">
        <a id="back-top">
            <img src="<?php echo get_image('up.png'); ?>"> </img>
        </a>
    </div>
    <?php wp_footer(); ?>
    <div id="footer">
        <div class="footer-content">
            <?php
            // THONG TIN REWRITE
            //                  echo '<pre>';
            //                 print_r($wp_rewrite);
            //                 echo '</pre>';
            // CAC THAM SO TREN THANH URL DE GET_QUERY_VAR LAY DC
            //                 echo '<pre>';
            //                 print_r($wp);
            //                 echo '</pre>';
            ?>

            <div class="copy-right">

                <div style=" text-align: right ">

                    <ul style="display: inline; color: white">
                        <li>
                            <label>在線人數　： <?php echo $online->online(); ?> </label>
                        </li>
                        <li>
                            <label>瀏覽人數　： <?php echo $online->total(); ?> </label>
                        </li>
                    </ul>
                </div>

                <div style=" text-align: left">
                    <?php global $mapsx, $mapsy, $hospitalname; ?>
                    Copyright &copy; - 2015 Design byDigiwin Software (Vietnam) Co., Ltd.
                </div>

            </div>
        </div>
    </div>
    <div id="mobi-footer">
        <div class="copy-right">

            <div style=" text-align: right ">

                <ul style="display: inline; color: white">
                    <li>
                        <label>在線人數： <?php echo $online->online(); ?> </label>
                    </li>
                    <li>
                        <label>瀏覽人數： <?php echo $online->total(); ?> </label>
                    </li>
                </ul>
            </div>

            <div style=" text-align: left">
                <?php global $mapsx, $mapsy, $hospitalname; ?>
                Copyright &copy; - 2015 Design by Digiwin Software (Vietnam) Co., Ltd.
            </div>

        </div>
    </div>
<?php } ?>
<?php
require_once DIR_CLASS . 'my-popup.php';
