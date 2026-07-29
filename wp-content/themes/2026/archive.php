<?php get_header(); ?>

	<!-- 2026-07-29: Thêm id="primary" class="site-main" cho chuẩn SEO semantic HTML5 -->
	<main id="primary" class="site-main" role="main">
		<!-- section -->
		<section>

			<h1><?php _e( 'Archives', 'html5blank' ); ?></h1>

			<?php get_template_part('loop'); ?>

			<?php get_template_part('pagination'); ?>

		</section>
		<!-- /section -->
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
