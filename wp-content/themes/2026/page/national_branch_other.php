<?php
/*
  Template Name: National Branch Other
 */
get_header();
?>
<div class="astcc-page-container">
    <div class="main-content">
        <div class='head-title'>
            <div class="title">
                <h2 class="head"><?php _e('觀察會員國') ?></h2>
            </div>
        </div>
        <div class="national-list">
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
                    if (has_post_thumbnail()) {
                        $imgUrl = get_the_post_thumbnail_url(get_the_ID(), 'full');
                    } else {
                        $imgUrl = get_template_directory_uri() . '/images/no-image.jpg';
                    }
            ?>
                    <div class="national-member-card">
                        <div class="national-member-img">
                            <img src="<?php echo $imgUrl; ?>" alt="<?php the_title(); ?>" />
                        </div>
                        <div class="national-member-info">
                            <h3 class="name"><?php the_title(); ?></h3>
                            <div class="position"><?php the_content(); ?></div>
                        </div>
                        <div class="national-member-contact">
                            <a href="<?php echo get_post_meta(get_the_ID(), '_metabox_website', true); ?>" target="_blank" title="Website">
                                <i class="fa fa-link"></i>
                            </a>
                        </div>
                    </div>
            <?php
                endwhile;
            endif;
            ?>
        </div>
    </div>
    <div class="sidebar-area">
        <?php get_sidebar() ?>
    </div>
</div>
<?php
get_footer();
