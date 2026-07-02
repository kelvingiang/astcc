<?php
/*
  Template Name: National Branch
 */
get_header();
?>
<div class="astcc-page-container">
    <div class="main-content">
        <div class='head-title'>
            <div class="title">
                <h2 class="head"><?php _e('National Branch') ?></h2>
            </div>
        </div>
        <div class="branch-list">
            <?php
            $arrArgs = array(
                'post_type' => 'branch',
                'post_status' => 'publish',
                'taxonomy' => 'branch_cate',
            );
            $categories = get_categories($arrArgs);

            $new_arr_cate = array();
            foreach ($categories as $cate) {
                if ($cate->slug == "young" || $cate->slug == "other") {
                    continue;
                }
                $arr_cate['ID'] = $cate->cat_ID;
                $arr_cate['name'] = $cate->cat_name;
                $arr_cate['slug'] = $cate->slug;
                $arr_cate['count'] = $cate->category_count;
                $arr_cate['order'] = get_post_meta($cate->cat_ID, '_branch_order', true);
                $new_arr_cate[] = $arr_cate;
            }

            function compare_order($a, $b)
            {
                return strnatcmp($b['order'], $a['order']);
            }

            // sort alphabetically by name
            usort($new_arr_cate, 'compare_order');

            foreach ($new_arr_cate as $cate_val) {
            ?>
                <div>
                    <div class="country"> <?php echo $cate_val['name']; ?> <i class="fa fa-angle-double-down"></i></div>
                    <div class="branch">
                        <?php
                        $arr = array(
                            'post_type' => 'branch',
                            'branch_cate' => $cate_val['slug'],
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
                                    <a href="<?php echo get_post_meta(get_the_ID(), '_metabox_website', true); ?>" target="_blank">
                                        <?php the_title() ?>
                                    </a>
                                </div>
                        <?php
                            endwhile;
                        endif;
                        ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="sidebar-area">
        <?php get_sidebar() ?>
    </div>
</div>
<script type="text/javascript" language="javascript">
    jQuery(document).ready(function() {
        // Initialize the first branch to be open and active
        jQuery('.branch').first().slideDown('slow');
        jQuery('.branch').first().siblings('.country').addClass('active');

        jQuery('.country').click(function() {
            var $thisCountry = jQuery(this);
            var $thisBranch = $thisCountry.siblings(".branch");

            // Close all other branches and remove their active state
            jQuery(".branch").not($thisBranch).slideUp('fast');
            jQuery('.country').not($thisCountry).removeClass('active');

            var contentDisplay = $thisBranch.css('display');
            if (contentDisplay === 'none') {
                $thisBranch.slideDown('slow');
                $thisCountry.addClass('active');
            } else {
                $thisBranch.slideUp('slow');
                $thisCountry.removeClass('active');
            }
        });

    });
</script>
<?php
get_footer();
