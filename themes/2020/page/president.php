<?php
/*
  Template Name: Presidents
 */
?>
<?php
ob_start();  // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by
get_header();
?>
<div class="row my-row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 ">
        <div class='head-title'>
            <div class="title">
                <h2 class="head"> <?php echo __('現任團隊') ?> </h2>
            </div>
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
                );
                $wp_query = new WP_Query($arr);
                if ($wp_query->have_posts()):
                    while ($wp_query->have_posts()):
                        $wp_query->the_post();

                        if (has_post_thumbnail()) {
                            $imgUrl = get_the_post_thumbnail_url();
                        }

                ?>
                        <div class="president_current_item">
                            <div class="president_current_item_img">
                                <img src="<?php echo $imgUrl ?>" alt="ssss" />
                            </div>
                            <a href="<?php the_permalink(); ?>">
                                <div class="president_current_item_link">
                                    <p class="title"> <?php the_title() ?></p>
                                    <p class="job"><?php echo get_post_meta($post->ID, '_metabox_job_title', true) ?></p>
                                </div>
                            </a>
                        </div>
                <?php
                    endwhile;
                endif;
                ?>

            </div>
        </div>
        <div class="info-bg">
            <div class="president_previous">
                <?php
                $arr = array(
                    'post_type' => 'supervisor',
                    'post_status' => 'publish',
                    'supervisor_cate' => 'other',
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
    </div>
</div>
<?php
get_footer();
ob_flush();   // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by
?>