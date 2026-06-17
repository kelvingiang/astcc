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
                <p>我們是一個享有盛譽的組織，連結並支持亞洲的台灣企業社群，促進永續發展與共同繁榮。</p>
            </div>
            <div class="footer-col footer-contact">
                <h3 class="footer-heading">聯絡資訊</h3>
                <ul>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>地址：
                            <a href="<?php echo get_option('contact_us_maps_link') ?>" target="_blank "><?php echo get_option('contact_us_address') ?></a>
                        </span>
                    </li>
                    <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.63A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg> <span>電話：<?php echo get_option('contact_us_phone') ?></span></li>
                    <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <span>Email:
                            <?php echo get_option('contact_us_email') ?>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="footer-col footer-stats">
                <h3 class="footer-heading">瀏覽統計</h3>
                <ul class="footer-visit">
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span>線上人數：<?php echo number_format($web_visit['online_users'], 0, ',', '.'); ?></span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <span>總瀏覽量：<?php echo number_format($web_visit['total_views'], 0, ',', '.'); ?></span>
                    </li>
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
