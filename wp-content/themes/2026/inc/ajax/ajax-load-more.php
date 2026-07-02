<?php
// [02/07/2026] Tách các hàm xử lý AJAX sang file riêng để dễ quản lý

// Hàm xử lý AJAX để tải thêm bài viết
function astcc_load_more_news_posts() {
    check_ajax_referer('load_more_posts_nonce', 'nonce');

    // Đọc trực tiếp tham số từ yêu cầu AJAX
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $limit = isset($_POST['limit']) ? intval($_POST['limit']) : 2;
    $category_slug = isset($_POST['category_slug']) ? sanitize_text_field($_POST['category_slug']) : 'news';
    $post_type = isset($_POST['post_type']) ? sanitize_text_field($_POST['post_type']) : 'post';

    $args = array(
        'post_type' => $post_type,
        'post_status' => 'publish',
        'posts_per_page' => $limit,
        'offset' => $offset,
        'orderby' => 'ID',
        'order' => 'DESC',
    );

    if (!empty($category_slug)) {
        if ($post_type === 'conference') {
            $args['conference_cate'] = $category_slug;
        } else {
            $args['category_name'] = $category_slug;
        }
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div class="article_item">
                <a href="<?php the_permalink(); ?>"><?php the_title() ?></a>
                <div><?php echo get_the_content(); ?></div>
            </div>
            <?php
        }
    }
    wp_die(); // Bắt buộc phải có để kết thúc AJAX đúng cách
}
add_action('wp_ajax_load_more_news_posts', 'astcc_load_more_news_posts');
add_action('wp_ajax_nopriv_load_more_news_posts', 'astcc_load_more_news_posts');

// AJAX handler for loading more related posts
function astcc_load_more_related_posts() {
    check_ajax_referer('load_more_related_nonce', 'nonce');

    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $limit = isset($_POST['limit']) ? intval($_POST['limit']) : 2;
    $category_slug = isset($_POST['category_slug']) ? sanitize_text_field($_POST['category_slug']) : '';
    $exclude_post_id = isset($_POST['exclude_post_id']) ? intval($_POST['exclude_post_id']) : 0;
    $post_type = isset($_POST['post_type']) ? sanitize_text_field($_POST['post_type']) : 'post';

    $args = array(
        'post_type' => $post_type,
        'post_status' => 'publish',
        'posts_per_page' => $limit,
        'offset' => $offset,
        'orderby' => 'ID',
        'order' => 'DESC',
        'post__not_in' => array($exclude_post_id),
    );

    if (!empty($category_slug)) {
        if ($post_type === 'conference') {
            $args['conference_cate'] = $category_slug;
        } else {
            $args['category_name'] = $category_slug;
        }
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div class="related-post-card reveal">
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
        }
        wp_reset_postdata();
    }
    wp_die();
}
add_action('wp_ajax_load_more_related_posts', 'astcc_load_more_related_posts');
add_action('wp_ajax_nopriv_load_more_related_posts', 'astcc_load_more_related_posts');
