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
    <div id="silder"><?php get_template_part('template/template', 'silder'); ?></div>
    </div>

    <div class="container-fluid">

        <div style=" clear: both"></div>
        <div id="header" class="row" style="padding-bottom: 20px;">

            <!--ham nay dc viet trong file function -->
            <!--  ADD PHAN SILDER -->

            <!--  ham get menu dc viet trong file function -->

            <div class="col-md-12">
                <div class="mobile-menu-title"><img src="<?php echo get_image('mobile_menu_icon.png') ?>" style="width: 20px; margin: 5px" />
                    <label style="margin-left: 20px; color: #FFF; font-weight:  bold;  font-size: 15px"> 項 目 </label>
                </div>
                <?php suite_menu('mobile-menu') ?>
            </div>
        </div>

        </hr>

    <?php
    //                if (is_page()) {
    //                    get_template_part('template', 'advertising');
    //                }
}
