<!-- Slider main container -->
<div class="swiper mySwiper">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper">
        <?php
        $args = array(
            'post_type' => 'slide', 
            'posts_per_page' => -1,
            'orderby' => 'menu_order', // Cho phép sắp xếp slide từ admin
            'order' => 'ASC'
        );
        $loop = new WP_Query($args);
        if ($loop->have_posts()):
            while ($loop->have_posts()):
                $loop->the_post();
        ?>
        <!-- Slides -->
        <div class="swiper-slide">
            <?php if (has_post_thumbnail()): ?>
                <?php the_post_thumbnail('full'); ?>
            <?php endif; ?>
            <div class="swiper-slide-caption">
                <?php the_title(); ?>
            </div>
        </div>
        <?php
            endwhile;
        endif;
        wp_reset_postdata();
        ?>
    </div>
    <!-- Nút điều hướng -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>

<!-- Khởi tạo Swiper -->
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    var swiper = new Swiper(".mySwiper", {
        loop: true, // Lặp lại slider
        autoplay: {
            delay: 10000, // 30 giây
            disableOnInteraction: true, // Dừng autoplay khi người dùng tương tác
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
});
</script>