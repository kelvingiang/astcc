<?php get_header(); ?>

<!-- 2026-07-29: Thêm <main> semantic HTML5 để chuẩn SEO -->
<main id="primary" class="site-main" role="main">
<div class="astcc-page-container single-full-width">
    <div class="sing-content">
        <?php if (have_posts()): while (have_posts()) : the_post(); ?>
                <?php $did = get_the_id(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class('single-post-article'); ?>>
                    <div class="head-title">
                        <h1 class="head"><?php the_title(); ?></h1>
                    </div>

                    <div class="post-meta">
                        <span class="meta-item date-meta">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <?php echo get_the_date(); ?>
                        </span>
                    </div>

                    <!-- post thumbnail -->
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
                            <img src="<?php the_post_thumbnail_url('large') ?>" alt="<?php the_title_attribute(); ?>" />
                        </div>
                    <?php endif; ?>

                    <div class="content-style">
                        <?php the_content(); ?>
                    </div>
                </article>
                <!-- /article -->
            <?php endwhile; ?>
        <?php endif; ?>

        <div class="single-article-list">
            <h3 class="related-title"><?php _e('相關文章', 'html5blank'); ?></h3>
            <div class="related-posts-grid">
                <?php
                $cate = get_the_category();
                if (!empty($cate)) {
                    $arr = array(
                        'post_type' => 'post',
                        'post_status' => 'publish',
                        'category_name' => $cate[0]->slug,
                        'posts_per_page' => 5,
                        'orderby' => 'ID',
                        'order' => 'DESC',
                        'post__not_in' => array($did),
                    );
                    $related_query = new WP_Query($arr);
                    if ($related_query->have_posts()):
                        while ($related_query->have_posts()):
                            $related_query->the_post();
                ?>
                            <div class="related-post-card">
                                <div class="related-post-date-block">
                                    <span class="related-date-day"><?php echo get_the_date('d'); ?></span>
                                    <span class="related-date-month"><?php echo get_the_date('M'); ?></span>
                                </div>
                                <div class="related-post-content">
                                    <h4 class="related-post-card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h4>
                                </div>
                            </div>
                <?php
                        endwhile;
                        wp_reset_postdata();
                    else:
                        echo '<p class="no-related">' . __('No related articles found.', 'html5blank') . '</p>';
                    endif;
                }
                ?>
            </div>
            <div class="related-loading-indicator" style="display: none;">
                <svg class="spinner-svg" width="30" height="30" viewBox="0 0 50 50">
                    <circle cx="25" cy="25" r="20" fill="none" stroke-width="4"></circle>
                </svg>
            </div>
        </div>
    </div>
</div>
</main><!-- #primary -->

<?php get_footer(); ?>