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

    <div id="mobi-footer">
        <div class="footer-content">
            <div class="content-contact">
                <div><?php echo get_option('chamber_name') ?></div>
                <div>地址 : <?php echo get_option('contact_us_address') ?></div>
                <div>電話 : <?php echo get_option('contact_us_phone') ?></div>
                <div>Email : <?php echo get_option('contact_us_email') ?></div>
            </div>
            <div class="content-count">
                <div class="online-count">
                    <div>在線人數　： <?php echo $online->online(); ?> </div>
                    <div>瀏覽人數　： <?php echo $online->total(); ?> </div>
                </div>

                <div class="copy-right">
                    <?php global $mapsx, $mapsy, $hospitalname; ?>
                    Copyright &copy; - 2015 Design byDigiwin Software (Vietnam) Co., Ltd.
                </div>
            </div>

        </div>
    </div>
    <div id="footer">
        <div class="footer-content">
            <div class="content-contact">
                <div><?php echo get_option('chamber_name') ?></div>
                <div>地址 : <?php echo get_option('contact_us_address') ?></div>
                <div>電話 : <?php echo get_option('contact_us_phone') ?></div>
                <div>Email : <?php echo get_option('contact_us_email') ?></div>
            </div>
            <div class="content-count">
                <div class="online-count">
                    <div>在線人數　： <?php echo $online->online(); ?> </div>
                    <div>瀏覽人數　： <?php echo $online->total(); ?> </div>
                </div>

                <div class="copy-right">
                    <?php global $mapsx, $mapsy, $hospitalname; ?>
                    Copyright &copy; - 2015 Design byDigiwin Software (Vietnam) Co., Ltd.
                </div>
            </div>

        </div>
    </div>

<?php } ?>
<?php wp_footer(); ?>

<?php
require_once DIR_CLASS . 'my-popup.php';

// THONG TIN REWRITE
//                  echo '<pre>';
//                 print_r($wp_rewrite);
//                 echo '</pre>';
// CAC THAM SO TREN THANH URL DE GET_QUERY_VAR LAY DC
//                 echo '<pre>';
//                 print_r($wp);
//                 echo '</pre>';
