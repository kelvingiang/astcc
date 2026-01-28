<?php if (!is_page('check-in')) { ?>
    <?php
    if (is_page('recruit') || is_page('article')) {
        if (!isset($_SESSION['login'])) {
            wp_redirect(home_url());
        }
    }
    ?>
    <!--DOI TRONG PHAN CHECK-IN-->
    <div class="my-waiting">
        <img src="<?php echo get_image('loading_pr2.gif') ?>" style=" width: 150px" />
    </div>
    <div id="header">
        <div id="logo">
            <a href="<?php echo home_url() ?>">
                <img src="<?php echo get_image('astcc-logo.png') ?>" class="logo-img" alt="ctcvn_logo" title="ctcvn_logo" />
            </a>

            <div>
                <label>亞 洲 台 灣 商 會 聯 合 總 會 </label><br>
                <label>ASIA TAIWANESE CHAMBERS OF COMMERCE</label>
            </div>
        </div>
        <div id="login">
            <!--<h1> <i class="fa fa-sign-in" aria-hidden="true"></i>會員登入</h1>-->
        </div>
    </div>

    <div id="menu"><?php suite_menu('primary-menu') ?></div>



    <div>
        <?php get_template_part('template/template', 'mobile-menu'); ?>
    </div>
<?php } ?>