<?php get_header(); ?>

<!-- 2026-07-29: Thêm <main> semantic HTML5 để chuẩn SEO -->
<main id="primary" class="site-main" role="main">

    <div class="home-statistics" style="margin: 0.5rem 2rem;">
        <?php get_template_part('template/template', 'home-statistics'); ?>
    </div>
    <div class="home-supervisor">
        <?php get_template_part('template/template', 'home-supervisor'); ?>
    </div>
    <div class="home-event">
        <?php get_template_part('template/template', 'home-event'); ?>
    </div>
    <div id="home-slider-section">
        <?php get_template_part('template/template', 'home-slider'); ?>
    </div>
    <div class="home-maps">
        <?php get_template_part('template/template', 'home-maps'); ?>
    </div>

</main><!-- #primary -->

<?php get_footer();
