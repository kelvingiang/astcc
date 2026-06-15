<?php
/*
  Template Name: News
 */
get_header();
?>
<div class="astcc-page-container">
    <div class="main-content">
        <div class='head-title'>
            <div class="title">
                <h2 class="head"> <?php echo __('Asian News Information') ?></h2>
            </div>
        </div>
        <div class="article-list">
            <?php
            $arr = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'category_name' => 'news',
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
        <div class="loading-indicator" style="display: none;">
            <p><?php _e('Đang tải thêm tin...', 'astcc'); ?></p>
        </div>
    </div>

    <div class="sidebar-area">
        <?php //get_sidebar() ?>
    </div>
</div>
<?php
get_footer();
