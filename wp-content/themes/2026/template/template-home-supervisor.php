<!-- Services Section -->
<section id="services">

    <!-- <div class="section-header reveal">
            <span class="subtitle">Dịch vụ cốt lõi</span>
            <h2>Năng lực và <span>Giải pháp</span></h2>
            <p>Chúng tôi tập trung vào nghiên cứu và phát triển những giải pháp có chiều sâu để mang lại giá trị bền vững cho doanh nghiệp.</p>
        </div> -->
    <div class="services-grid">
        <?php
        $arr = array(
            'post_type' => 'supervisor',
            'post_status' => 'publish',
            'supervisor_cate' => 'current',
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
                <div class="service-card reveal">
                    <div class="home_president_current_item_img">
                        <img src="<?php echo esc_url($imgUrl); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
                    </div>
                    <div class="home_president_current_item_name">
                        <?php echo esc_html(get_post_meta(get_the_ID(), '_metabox_job_title', true)); ?>
                    </div>
                    <div class="home_president_current_item_description">
                        <?php the_title(); ?>
                    </div>
                </div>
        <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>

    </div>

</section>