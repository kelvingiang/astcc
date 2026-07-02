<?php
/*
  Template Name: News Other
 */
get_header();
?>
<div class="astcc-page-container">
    <div class="main-content">
        <div class='head-title'>
            <div class="title">
                <h2 class="head"> <?php echo __('各會員體最新消息') ?></h2>
            </div>
        </div>
        <div class="article-list" data-category="member">
            <?php
            $arr = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'category_name' => 'member',
                'posts_per_page' => 5, // Tải 5 tin tức đầu tiên
                'orderby' => 'ID',
                'order' => 'DESC',
            );
            $wp_query = new WP_Query($arr);
            if ($wp_query->have_posts()):
                while ($wp_query->have_posts()):
                    $wp_query->the_post();
            ?>
                    <div class="article_item">
                        <a href="<?php the_permalink(); ?>"><?php the_title() ?></a>
                        <div><?php echo get_the_content(); ?></div>
                    </div>
            <?php
                endwhile;
            endif;
            wp_reset_postdata();
            ?>
        </div>
        <div class="loading-indicator" style="display: none; text-align: center; padding: 2rem;">
            <!-- [15/06/2026] Sử dụng SVG Spinner tự xoay bằng CSS inline để chạy độc lập không phụ thuộc vào compile SASS -->
            <svg class="spinner-svg" width="40" height="40" viewBox="0 0 50 50" style="animation: svg-rotate 2s linear infinite; display: inline-block; vertical-align: middle;">
                <circle cx="25" cy="25" r="20" fill="none" stroke="#64748b" stroke-width="4" stroke-linecap="round" style="animation: svg-dash 1.5s ease-in-out infinite;"></circle>
            </svg>
            <style>
                @keyframes svg-rotate {
                    100% {
                        transform: rotate(360deg);
                    }
                }

                @keyframes svg-dash {
                    0% {
                        stroke-dasharray: 1, 150;
                        stroke-dashoffset: 0;
                    }

                    50% {
                        stroke-dasharray: 90, 150;
                        stroke-dashoffset: -35;
                    }

                    100% {
                        stroke-dasharray: 90, 150;
                        stroke-dashoffset: -124;
                    }
                }
            </style>
        </div>
    </div>

    <div class="sidebar-area">
        <?php get_sidebar() ?>
    </div>
</div>
<?php
get_footer();
