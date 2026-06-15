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

<footer id="footer">
    <div class="footer-container">
        <div class="footer-top">
            <div class="footer-col footer-about">
                <h3 class="footer-heading"><?php echo get_option('chamber_name') ?></h3>
                <p>Chúng tôi là tổ chức uy tín, kết nối và hỗ trợ cộng đồng doanh nghiệp Đài Loan tại châu Á, thúc đẩy sự phát triển bền vững và thịnh vượng chung.</p>
            </div>
            <div class="footer-col footer-contact">
                <h3 class="footer-heading">Thông tin liên hệ</h3>
                <ul>
                    <li><i class="fa fa-map-marker" aria-hidden="true"></i> <span>Địa chỉ: <?php echo get_option('contact_us_address') ?></span></li>
                    <li><i class="fa fa-phone" aria-hidden="true"></i> <span>Điện thoại: <?php echo get_option('contact_us_phone') ?></span></li>
                    <li><i class="fa fa-envelope" aria-hidden="true"></i> <span>Email: <a href="mailto:<?php echo get_option('contact_us_email') ?>"><?php echo get_option('contact_us_email') ?></a></span></li>
                </ul>
            </div>
            <div class="footer-col footer-stats">
                <h3 class="footer-heading">Thống kê truy cập</h3>
                <ul>
                    <li><i class="fa fa-users" aria-hidden="true"></i> <span>Đang online: <?php echo $web_visit['online_users'] ?></span></li>
                    <li><i class="fa fa-eye" aria-hidden="true"></i> <span>Tổng lượt xem: <?php echo $web_visit['total_views'] ; ?></span></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Copyright &copy; <?php echo date('Y'); ?> <?php echo get_option('chamber_name') ?>. All Rights Reserved.
                <br>
                Designed by Digiwin Software (Vietnam) Co., Ltd.
            </p>
        </div>
    </div>
</footer>



<?php wp_footer(); ?>

<?php
// require_once DIR_CLASS . 'my-popup.php';
