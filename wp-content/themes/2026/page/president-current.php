<?php
/*
  Template Name: President Current
 */
get_header();
?>

<div class="president-page-wrapper">
    <div class="president-section">
        <div class="head-title">
            <h2 class="head"> <?php echo __('現任團隊') ?> </h2>
        </div>

        <div class="president_current">
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
                    <div class="president_current_item">
                        <div class="president_current_item_img">
                            <img src="<?php echo $imgUrl ?>" alt="<?php the_title(); ?>" />
                        </div>
                        <a href="<?php the_permalink(); ?>">
                            <div class="president_current_item_link">
                                <p class="title"> <?php the_title() ?></p>
                                <p class="job"><?php echo get_post_meta(get_the_ID(), '_metabox_job_title', true) ?></p>
                            </div>
                        </a>
                    </div>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>

        </div>

        <div class="president_advisory">
            <?php

            $arr_other = array(
                'post_type' => 'supervisor',
                'post_status' => 'publish',
                'supervisor_cate' => 'other',
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
                'meta_key' => '_show_order',
            );
            $other_query = new WP_Query($arr_other);
            if ($other_query->have_posts()):
                while ($other_query->have_posts()):
                    $other_query->the_post();

                    if (has_post_thumbnail()) {
                        $imgUrl_other = get_the_post_thumbnail_url();
                    } else {
                        $imgUrl_other = PART_IMAGES . 'no-person.png';
                    }

            ?>
                    <div class="president_advisory_item">
                        <div class="president_advisory_item_img">
                            <img src="<?php echo $imgUrl_other; ?>" alt="<?php the_title(); ?>" />
                        </div>
                        <p class="president_advisory_item_name"> <?php the_title() ?></p>
                        <p class="president_advisory_item_job"><?php echo get_post_meta(get_the_ID(), '_metabox_job_title', true) ?></p>
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
get_footer();
