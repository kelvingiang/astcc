<div class="info-bg" style="background-color: #f7f7f7; border-color:#f7f7f7">
    <?php
    $args = array(
        'taxonomy' => 'supervisor_cate',
    );
    $cats = get_categories($args);


    //sắp xếp lại thứ tự theo option của category ====================================
    usort($cats, function ($a, $b) {
        $option_value_a = get_option('option_supervisor_cate_' . $a->term_id); // 替換為自訂字段值
        $option_value_b = get_option('option_supervisor_cate_' . $b->term_id); // 替換為自訂字段值

        // 這裡可以根據需要使用不同的比較方法，下面是以數字形式比較的例子
        if ($option_value_a['cate_order'] == $option_value_b['cate_order']) {
            return 0;
        }
        // trả về theo kiểu giảm dần =======================================
        return ($option_value_a['cate_order'] > $option_value_b['cate_order']) ? -1 : 1;
    });

    $cus_post = 'supervisor';
    $cate_name = 'supervisor_cate';


    foreach ($cats as $cat) {
        if ($cat->slug == 'current' || $cat->slug == 'other') {
            continue;
        }
    ?>
        <div class="president_space">
            <div class="president_group_title"><?php echo $cat->description ?></div>
            <div class="president_previous">
                <?php
                $arr = array(
                    'post_type' => 'supervisor',
                    'post_status' => 'publish',
                    $cate_name => $cat->slug,
                    'orderby' => 'meta_value_num',
                    'order' => 'DESC',
                    'meta_key' => '_show_order',
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
                        <div class="president_previous_item">
                            <div class="president_item_img">
                                <img src="<?php echo $imgUrl ?>" alt="ssss" />
                            </div>

                            <div class="president_previous_item_link">
                                <p class="title"> <?php the_title() ?></p>
                                <p class="job"><?php echo get_post_meta($post->ID, '_metabox_job_title', true) ?></p>
                            </div>

                        </div>
                <?php
                    endwhile;
                endif;

                ?>
            </div>

        </div>
    <?php } ?>
</div>