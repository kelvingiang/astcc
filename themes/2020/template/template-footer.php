</div>

</div> <!-- end coontaineer -->
<?php
require_once(DIR_MODEL . 'model_visit.php');
$model = new Model_Web_Visit;
$model->web_visitor();
$web_visit = $model->get_visitor_stats();
?>

<div id="back-top-wrapper">
    <a id="back-top">
        <img src="<?php echo get_image('up.png'); ?>"> </img>
    </a>
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
                <div>在線人數　： <?php echo $web_visit['online_users'] ?> </div>
                <div>瀏覽人數　： <?php echo $web_visit['total_views'] ; ?> </div>
            </div>

            <div class="copy-right">
                <?php global $mapsx, $mapsy, $hospitalname; ?>
                Copyright &copy; - 2015 Design byDigiwin Software (Vietnam) Co., Ltd.
            </div>
        </div>

    </div>
</div>



<?php wp_footer(); ?>

<?php
// require_once DIR_CLASS . 'my-popup.php';
