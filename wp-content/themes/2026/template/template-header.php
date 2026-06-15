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
        <div id="header-wrap">
            <a href="<?php echo home_url() ?>">
                <img src="<?php echo get_image('astcc-logo.png') ?>"
                    class="logo-img"
                    alt="ctcvn_logo"
                    title="ctcvn_logo" />
            </a>

            <div class="header-text">
                <h1>亞洲台灣商會聯合總會</h1>
                <h2>ASIA TAIWANESE CHAMBERS OF COMMERCE</h2>
            </div>
        </div>

        <div id="menu-main"><?php suite_menu('primary-menu') ?></div>

        <div id="menu-second">
            <a href="<?php echo home_url() ?>">
                <img src="<?php echo get_image('astcc-logo.png') ?>"
                    class="logo-img"
                    alt="ctcvn_logo"
                    title="ctcvn_logo" />
            </a>
            <?php suite_menu('primary-menu') ?>

        </div>


        <div>
            <?php get_template_part('template/template', 'mobile-menu'); ?>
        </div>
    </div>
<?php } ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Lấy các phần tử cần thiết
    const menuMain = document.getElementById("menu-main");
    const menuSecond = document.getElementById("menu-second");

    // Nếu không tồn tại 1 trong 2 menu trên trang thì dừng lại để tránh lỗi
    if (!menuMain || !menuSecond) return;

    // Tính toán tọa độ dưới cùng của menu-main
    // Bằng cách lấy khoảng cách từ top + chiều cao của chính nó
    const triggerPoint = menuMain.offsetTop + menuMain.offsetHeight;

    // Lắng nghe sự kiện cuộn chuột
    window.addEventListener("scroll", function() {
        // Lấy vị trí cuộn hiện tại
        let scrollPosition = window.scrollY || document.documentElement.scrollTop;

        // Nếu cuộn qua khỏi menu-main
        if (scrollPosition > triggerPoint) {
            menuSecond.classList.add("is-sticky");
        } else {
            // Nếu cuộn ngược lên lại đầu trang
            menuSecond.classList.remove("is-sticky");
        }
    });
});
</script>