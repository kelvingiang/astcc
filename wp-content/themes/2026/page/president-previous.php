<?php
/*
  Template Name: Presidents Previous
 */
get_header();
?>
<div class="row my-row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 ">

        <div class='head-title'>
            <div class="title">
                <h2 class="head"> <?php echo __('歷屆總會長 - 監事長') ?> </h2>
            </div>
        </div>
        <!-- lay cac thông tin của group current -->
        <div class="info-bg">
            <?php
            $term = get_term_by('slug', 'current', 'supervisor_cate'); // 這裡 'current' 是分類的 slug
            ?>
            <div class="current-title">
                <h3><?php echo $term->description ?></h3>
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
                        }else{
                            $imgUrl = PART_IMAGES . 'no-person.png';
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
        <!-- =========  -->
        <?php get_template_part('template/template', 'group-supervisor'); ?>
    </div>
</div>
<?php
get_footer();