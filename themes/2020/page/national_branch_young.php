<?php
/*
  Template Name: National Branch Young
 */
?>
<?php
ob_start();  // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by
get_header();
?>
<div class="row my-row">
    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 ">
        <div class='head-title'>
            <div class="title">
                <h2 class="head"><?php _e('青商會') ?></h2>
            </div>
        </div>
        <div class="info-bg">
            <div class="other-branch">
                <?php
                $arr = array(
                    'post_type' => 'branch',
                    'branch_cate' => 'young',
                    'orderby' => 'meta_val',
                    'order' => 'DESC',
                    'meta_key' => '_show_order',
                );
                $wp_query = new WP_Query($arr);
                if ($wp_query->have_posts()):
                    while ($wp_query->have_posts()):
                        $wp_query->the_post();
                ?>
                        <div class="branch-item">
                            <a href="<?php echo get_post_meta($post->ID, '_metabox_website', true); ?>" target="_blank">
                                <?php the_title() ?>
                            </a>
                        </div>
                <?php
                    endwhile;
                endif;
                ?>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4">
        <?php get_sidebar() ?>
    </div>
</div>

<?php
get_footer();
ob_flush();   // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by
