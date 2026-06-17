<?php get_header(); ?>

<div class="astcc-page-container single-full-width">
    <div class="sing-content">
        <div class="president_single">
            <?php if (have_posts()): while (have_posts()) : the_post(); ?>
                    <?php
                    // [17/06/2026] Cập nhật hàm: Dùng get_the_ID() chuẩn WordPress thay vì get_the_id()
                    $did = get_the_ID();
                    ?>
                    <!-- article -->
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="president_single_title">
                            <?php the_title(); ?>
                            <span>
                                <?php
                                // [17/06/2026] Bảo mật: Thêm hàm esc_html() để làm sạch dữ liệu hiển thị từ meta box
                                echo esc_html(get_post_meta($did, '_metabox_job_title', true));
                                ?>
                            </span>
                        </div>
                        <!-- post thumbnail -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="president_single_img">
                                <?php // [17/06/2026] SEO & Bảo mật: Thêm thuộc tính alt tự động lấy tiêu đề bài viết và dùng esc_url() 
                                ?>
                                <img src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
                            </div>
                        <?php endif; ?>
                        <div class="president_single_content"> <?php the_content(); ?></div>
                    </article>
                    <div class=" clear"></div>
                    <!-- /article -->
                <?php endwhile; ?>
            <?php endif; ?>
        </div>


        <div class="info-bg">
            <div class="president_current">
                <?php
                $arr = array(
                    'post_type' => 'supervisor',
                    'post_status' => 'publish',
                    'supervisor_cate' => 'current',
                    'orderby' => 'meta_value_num',
                    'order' => 'DESC',
                    'meta_key' => '_show_order',
                    'post__not_in' => array($did)
                );
                $wp_query = new WP_Query($arr);
                if ($wp_query->have_posts()):
                    while ($wp_query->have_posts()):
                        $wp_query->the_post();

                        if (has_post_thumbnail()) {
                            $imgUrl = get_the_post_thumbnail_url();
                        } else {
                            $imgUrl = PART_IMAGES . 'no-person.png';
                        }

                ?>
                        <div class="president_current_item">
                            <?php // [17/06/2026] Trải nghiệm người dùng (UX): Đưa thẻ <a> bao bọc cả khu vực ảnh và tiêu đề để người dùng dễ bấm hơn 
                            ?>
                            <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit; display: block;">
                                <div class="president_current_item_img">
                                    <?php // [17/06/2026] SEO & Bảo mật: Xóa thẻ alt="ssss" vô nghĩa và thay bằng hàm tự động lấy tên bài viết, kết hợp esc_url() 
                                    ?>
                                    <img src="<?php echo esc_url($imgUrl); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
                                </div>
                                <div class="president_current_item_link">
                                    <p class="title"> <?php the_title() ?></p>
                                    <p class="job">
                                        <?php
                                        // [17/06/2026] Bảo mật: Thêm hàm esc_html() để làm sạch dữ liệu chức vụ 
                                        echo esc_html(get_post_meta(get_the_ID(), '_metabox_job_title', true));
                                        ?>
                                    </p>
                                </div>
                            </a>
                        </div>
                <?php
                    endwhile;
                    // [17/06/2026] Lỗi Logic: Thêm wp_reset_postdata() để khôi phục dữ liệu post gốc sau khi dùng vòng lặp WP_Query()
                    wp_reset_postdata();
                endif;
                ?>

            </div>
        </div>

        <?php get_template_part('template/template', 'group-supervisor'); ?>
    </div>
</div>
<?php get_footer(); ?>