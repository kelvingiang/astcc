<?php
/*
  Template Name: Link Friend
 */
get_header();
?>
<div class="astcc-page-container">
    <div class="main-content">
        <div class='head-title'>
            <div class="title">
                <h2 class="head"> <?php echo __('Friend Link') ?> </h2>
            </div>
        </div>
        <div class="friend-link-list">
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
                        <div class="friend-link-item">
                            <a href="<?php echo get_post_meta(get_the_ID(), '_metabox_website', true) ?>" target="_blank" class="friend-link-link">
                                <span class="friend-link-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                                </span>
                                <span class="friend-link-title"><?php the_title() ?></span>
                                <span class="friend-link-arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                                </span>
                            </a>
                        </div>
                <?php
                    endwhile;
                endif;
                wp_reset_postdata();
                ?>
        </div>
    </div>

    <div class="sidebar-area">
        <?php get_sidebar() ?>
    </div>
</div>
<?php
get_footer();