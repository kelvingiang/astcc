<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="blue-group">
    <div class="blue-title">
        <h3 class="blue-title-text"> <?php echo _('現任團隊'); ?> </h3>
    </div>
    <div style=" margin-top: 10px">

        <?php
        $currentArr = array(
            'post_type' => 'supervisor',
            'post_status' => 'publish',
            'supervisor_cate' => 'current',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'meta_key' => '_show_order',
        );
        $query_special = new WP_Query($currentArr);
        if ($query_special->have_posts()) {
            while ($query_special->have_posts()) {
                $query_special->the_post();
                $images = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
                $objImageData = get_post(get_post_thumbnail_id(get_the_ID()));
                $strAlt = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);
        ?>

                <div class="president-box">
                    <div>
                        <img src="<?php echo $images[0]; ?>" alt="<?php echo $strAlt; ?>" title="<?php echo $objImageData->post_title; ?>" />
                    </div>

                    <a class="my_link" href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                        <span><?php echo get_post_meta($post->ID, '_metabox_job_title', true) ?></span>
                    </a>

                </div>

        <?php
            }
            wp_reset_query();
            wp_reset_postdata();
        }
        ?>

        <!-- //===================================== -->
        <?php
        $arr = array(
            'post_type' => 'supervisor',
            'post_status' => 'publish',
            'supervisor_cate' => 'other',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'meta_key' => '_show_order',
        );
        $my_query = new WP_Query($arr);
        if ($my_query->have_posts()) {
        ?>
            <div id='MyCarousel'>
                <ul>
                    <?php
                    while ($my_query->have_posts()) {
                        $my_query->the_post();
                        $images = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
                        $objImageData = get_post(get_post_thumbnail_id(get_the_ID()));
                        $strAlt = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);
                    ?>
                        <li>
                            <div class="carousel-box">
                                <img src="<?php echo $images[0]; ?>" alt="<?php echo $strAlt; ?>" title="<?php echo $objImageData->post_title; ?>" />
                                <div class="nbs-flexisel-title president_slider_text">
                                    <?php the_title(); ?> <i><?php echo get_post_meta($post->ID, '_metabox_job_title', true) ?></i>
                                </div>
                            </div>
                        </li>
                <?php
                    }
                    wp_reset_query();
                    wp_reset_postdata();
                }
                ?>
                </ul>
            </div>
    </div>
</div>

<script type='text/javascript'>
    jQuery(function() {
        jQuery("#MyCarousel").jCarouselLite({
            //        btnNext: ".bounceout .next",
            //        btnPrev: ".bounceout .prev",
            visible: 2, // so item hien thi

            // CAC HIEU UNG
            //  easing: "easeOutBounce",  // hieu ung khi chuyen dong
            auto: 1500 * 2,
            speed: 2000,
            circular: true, // xoay vong lai item khi xem
            autoWidth: true,
            responsive: true,
            vertical: true, // hinh thi kieu ngang hay doc
            hoverPause: true
        });

    });
</script>