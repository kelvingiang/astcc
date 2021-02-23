<?php
/*
  Template Name: National Branch
 */
?>
<?php
ob_start();  // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by
get_header();
?>
<div class="row">
    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 ">
        <div class='head-title'>
            <div class="title">
                <h2 class="head"><?php _e('National Branch') ?></h2>
            </div>
        </div>
        <div class="info-bg" style="color: #515151; display: block;  border-radius:  5px; padding:  10px ">
            <?php
            $arrArgs = array(
                'post_type' => 'branch',
                'post_status' => 'publish',
                'taxonomy' => 'branch_cate',
            );
            $categories = get_categories($arrArgs);

            $new_arr_cate = array();
            foreach ($categories as $cate) {
                $arr_cate['ID'] = $cate->cat_ID;
                $arr_cate['name'] = $cate->cat_name;
                $arr_cate['slug'] = $cate->slug;
                $arr_cate['count'] = $cate->category_count;
                $arr_cate['order'] = get_post_meta($cate->cat_ID, '_branch_order', true);
                $new_arr_cate[] = $arr_cate;
            }

            function compare_order($a, $b) {
                return strnatcmp($b['order'], $a['order']);
            }

            // sort alphabetically by name
            usort($new_arr_cate, 'compare_order');

            foreach ($new_arr_cate as $cate_val) {
                ?>
                <div style="border-bottom: 2px #fff solid; margin-bottom: 10px;">
                    <div class="country"> <?php echo $cate_val['name']; ?> <i class="fa fa-angle-double-down"></i></div>
                    <div class="branch">
                        <?php
                        $arr = array(
                            'post_type' => 'branch',
                            'branch_cate' => $cate_val['slug'],
                            'orderby' => 'meta_value',
                            'order' => 'DESC',
                            'meta_key' => '_show_order',
                        );
                        $wp_query = new WP_Query($arr);
                        if ($wp_query->have_posts()):
                            while ($wp_query->have_posts()):
                                $wp_query->the_post();
                                ?>
                                <div class="branch-item">
                                    <?php the_title() ?>
                                    <?php the_content() ?>
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
    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4">
        <?php get_sidebar() ?>
    </div>
</div>
<style>
    .country{
        border-bottom: 1px solid #e7e2e2;
        display: block;
        height: 40px;
        font-size: 18px;
        font-weight: bold;
        line-height: 40px;
        background-color:#286090;
        color: white;
        padding-left: 15px;
        border-radius: 3px 3px 0 0;
        letter-spacing: 3px;
        cursor: pointer;
    }

    .country i{
        float: right;
        padding-top: 12px;
        padding-right: 10px;
    }

    .branch {
        display: none;
    }

    .branch-item{
        border-bottom: 1px dotted #ccc;
        min-height: 30px;
        font-size: 18px;
        padding: 5px;
        padding-left: 15px;
        margin-top: 3px;
    }
    
    .branch-item:hover{
        background-color:#f6f4f4;
    }

</style>
<script type="text/javascript" language="javascript">
    jQuery(document).ready(function () {
        jQuery('.branch').first().css("display", "block");
        jQuery('.branch').first().siblings('.country').children('i').addClass('fa-angle-double-up');
        jQuery('.branch').first().siblings('.country').children('i').removeClass('fa-angle-double-down');

        jQuery('.country').click(function () {
            jQuery(".branch").slideUp('30');
            jQuery('.country').children('i').removeClass('fa-angle-double-up');
            jQuery('.country').children('i').addClass('fa-angle-double-down');

            var contentDisplay = jQuery(this).siblings(".branch").css('display');
            if (contentDisplay === 'none') {
                jQuery(this).siblings(".branch").slideDown('slow');
                jQuery(this).children('i').removeClass('fa-angle-double-down');
                jQuery(this).children('i').addClass('fa-angle-double-up');
            }
        });

    });
</script> 
<?php
get_footer();
ob_flush();   // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by

