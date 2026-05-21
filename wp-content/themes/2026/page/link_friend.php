<?php
/*
  Template Name: Link Friend
 */
get_header();
?>
<div id="silder"><?php get_template_part('template/template', 'silder'); ?></div>
<div class="row my-row">
    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 ">
        <div class='head-title'>
            <div class="title">
                <h2 class="head"> <?php echo __('Friend Link') ?> </h2>
            </div>
        </div>
        <div class="info-bg">
            <div class="single-article-list">
                <?php
                $arrArgs = array(
                    'post_type' => 'friendlink',
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
                        <div>
                            <a href="<?php echo get_post_meta(get_the_ID(), '_metabox_website', true) ?>" target="_blank"><?php the_title() ?></a>
                        </div>
                <?php
                    endwhile;
                endif;
                ?>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
        <?php get_sidebar() ?>
    </div>
</div>
<?php
get_footer();