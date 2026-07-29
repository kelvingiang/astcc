<?php get_header(); ?>

<!-- 2026-07-29: Thêm <main> semantic HTML5 để chuẩn SEO -->
<!-- [02/07/2026] Cập nhật giao diện trang 404 để hiển thị thân thiện và đẹp mắt hơn khi người dùng truy cập link hỏng -->
<main id="primary" class="site-main" role="main">
<div class="astcc-page-container single-full-width">
    <div class="sing-content" style="text-align: center; padding: 80px 15px;">
        <article id="post-404">
            <h1 style="font-size: 8rem; color: #0056b3; margin-bottom: 10px; line-height: 1; font-weight: bold;">404</h1>
            <h2 style="font-size: 2rem; margin-bottom: 20px; color: #333;">
                <?php _e( '抱歉，您尋找的頁面不存在！', 'html5blank' ); ?>
            </h2>
            <p style="margin-bottom: 40px; color: #6c757d; font-size: 1.1rem; max-width: 600px; margin-left: auto; margin-right: auto;">
                <?php _e( '連結可能已失效或頁面已被移除。請返回首頁繼續瀏覽其他內容。', 'html5blank' ); ?>
            </p>
            <a href="<?php echo home_url(); ?>" style="display: inline-block; padding: 12px 30px; background: #0056b3; color: #fff; text-decoration: none; border-radius: 50px; font-weight: 600; font-size: 1.1rem; transition: background 0.3s ease;">
                <?php _e( '返回首頁', 'html5blank' ); ?>
            </a>
        </article>
    </div>
</div>
</main><!-- #primary -->

<?php get_footer(); ?>
