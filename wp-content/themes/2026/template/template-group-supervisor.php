<div style="margin-top: 1rem;">
       <div class="head-title">
            <div class="title">
                <h2 class="head"> <?php echo __('歷屆總會長 - 監事長') ?> </h2>
            </div>
        </div>
    <?php
    $args = array(
        'taxonomy' => 'supervisor_cate',
    );
    $cats = get_categories($args);


    //sắp xếp lại thứ tự theo option của category ====================================
    usort($cats, function ($a, $b) {
        $option_value_a = get_option('option_supervisor_cate_' . $a->term_id); // 替換為自訂字段值
        $option_value_b = get_option('option_supervisor_cate_' . $b->term_id); // 替換為自訂字段值

        // Kiểm tra nếu option không tồn tại hoặc không phải là mảng, gán giá trị mặc định là 0
        $order_a = (is_array($option_value_a) && isset($option_value_a['cate_order'])) ? (int) $option_value_a['cate_order'] : 0;
        $order_b = (is_array($option_value_b) && isset($option_value_b['cate_order'])) ? (int) $option_value_b['cate_order'] : 0;

        // 這裡可以根據需要使用不同的比較方法，下面是以數字形式比較的例子
        if ($order_a == $order_b) {
            return 0;
        }
        // trả về theo kiểu giảm dần =======================================
        return ($order_a > $order_b) ? -1 : 1;
    });

    $cus_post = 'supervisor';
    $cate_name = 'supervisor_cate';
    ?>
    <div class="president-timeline">
        <?php
        $timeline_alternator = 'left'; // Bắt đầu với bên trái
        foreach ($cats as $cat) {
            if ($cat->slug == 'current' || $cat->slug == 'other') {
                continue;
            }
        ?>
            <div class="timeline-item <?php echo $timeline_alternator; ?>">
                <div class="timeline-content">
                    <div class="president_group_title"><?php echo $cat->description ?></div>
                    <div class="president_previous">
                        <?php
                        $arr = array(
                            'post_type' => 'supervisor',
                            'post_status' => 'publish',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => $cate_name,
                                    'field'    => 'slug',
                                    'terms'    => $cat->slug,
                                ),
                            ),
                            'orderby' => 'meta_value_num',
                            'order' => 'DESC',
                            'meta_key' => '_show_order',
                        );
                        $wp_query = new WP_Query($arr);
                        if ($wp_query->have_posts()) :
                            while ($wp_query->have_posts()) :
                                $wp_query->the_post();

                                if (has_post_thumbnail()) {
                                    $imgUrl = get_the_post_thumbnail_url();
                                } else {
                                    $imgUrl = PART_IMAGES . 'no-person.png';
                                }

                         ?>
                                <div class="president_previous_item">
                                    <div class="president_item_img">
                                        <img src="<?php echo $imgUrl ?>" alt="<?php the_title(); ?>" />
                                    </div>

                                    <div class="president_previous_item_link">
                                        <p class="title"> <?php the_title() ?></p>
                                        <p class="job"><?php echo get_post_meta(get_the_ID(), '_metabox_job_title', true) ?></p>
                                    </div>

                                </div>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        <?php
            $timeline_alternator = ($timeline_alternator == 'left') ? 'right' : 'left'; // Chuyển đổi bên
        } ?>
    </div>
</div>