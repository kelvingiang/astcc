<?php
/*
  Template Name: National Head
 */
?>
<?php
ob_start();  // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by
get_header();
?>
<div class="row my-row">
    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 ">
        <div class='head-title'>
            <div class="title">
                <h2 class="head"><?php _e('National Head') ?></h2>
            </div>
        </div>
        <div class="info-bg">

            <?php
            $arrArgs = array(
                'post_type' => 'chamber',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'orderby' => 'meta_value',
                'order' => 'DESC',
                'meta_key' => '_show_order',
            );
            $wp_query = new WP_Query($arrArgs);
            if ($wp_query->have_posts()):
                while ($wp_query->have_posts()):
                    $wp_query->the_post();
            ?>
                    <div class="national-list">
                        <a href="<?php echo get_post_meta($post->ID, '_metabox_website', true); ?>"  target="_blank">
                            <div style="margin-top: 13px; margin-right: 15px">
                                <?php if (has_post_thumbnail()) { ?>
                                    <img class="my-img" src="<?php the_post_thumbnail_url() ?>" />
                                <?php } ?>
                            </div>
                            <div>
                                <h3><?php the_title() ?></h3>
                                <label><?php the_content() ?></label>
                            </div>
                        </a>
                    </div>
            <?php
                endwhile;
            endif;
            ?>
        </div>
    </div>
    <div class="col-lg-3 col-lg-3 col-md-4 col-sm-12">
        <?php get_sidebar() ?>
    </div>
</div>

<?php
get_footer();
ob_flush();   // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by
