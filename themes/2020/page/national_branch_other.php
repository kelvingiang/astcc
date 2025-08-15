<?php
/*
  Template Name: National Branch Other
 */
get_header();
?>
<div class="row my-row">
    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 ">
        <div class='head-title'>
            <div class="title">
                <h2 class="head"><?php _e('觀察會員國') ?></h2>
            </div>
        </div>
        <div class="info-bg">
            <?php
            $arr = array(
                'post_type' => 'branch',
                'branch_cate' => 'other',
                'orderby' => 'meta_val',
                'order' => 'DESC',
                'meta_key' => '_show_order',
            );
            $wp_query = new WP_Query($arr);
            if ($wp_query->have_posts()):
                while ($wp_query->have_posts()):
                    $wp_query->the_post();
            ?>
                    <div class="national-other-list">
                        <a href="<?php echo get_post_meta($post->ID, '_metabox_website', true); ?>" target="_blank">
                            <div>
                                <?php if (has_post_thumbnail()) { ?>
                                    <img class="my-img" src="<?php the_post_thumbnail_url() ?>" />
                                <?php } else { ?>
                                    <img class="my-img" src="<?php echo PART_IMAGES . 'no-image.jpg' ?>" />
                                <?php } ?>
                                <h3><?php the_title() ?></h3>
                            </div>
                        </a>
                    </div>
            <?php
                endwhile;
            endif;
            ?>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4">
        <?php get_sidebar() ?>
    </div>
</div>
<?php
get_footer();
