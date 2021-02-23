<?php
/*
  Template Name: National Head
 */
?>
<?php
ob_start();  // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by
get_header();
?>
<div class="row">
    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 ">
        <div class='head-title'>
            <div class="title">
                <h2 class="head"><?php _e('National Head') ?></h2>
            </div>
        </div>
        <div class="info-bg" style="color: #515151; display: block;  border-radius:  5px; padding:  10px ">

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
                        <div style="margin-top: 13px; margin-right: 15px">
                            <?php if (has_post_thumbnail()) { ?>
                                <img class="my-img" src="<?php the_post_thumbnail_url() ?>" />
                            <?php } ?>
                        </div>
                        <div>
                            <h3><?php the_title() ?></h3>
                            <label><?php the_content() ?></label>                      
                        </div>
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
<style>
    .national-list{
        clear: both;
        border-bottom: 1px solid #e7e2e2;
        display: block;
        min-height: 100px;
    }
    .national-list div{
        float: left;
    }
    .national-list div h3{
        font-size: 16px;
        letter-spacing: 2px;
        font-weight: bold;
        padding-top: 25px;
    }
    .national-list div label{
        font-weight: 100;
        font-size: 15px;
        letter-spacing: 1px
    }
    .national-list div .my-img{
        width: 80px;
        margin: 10px;
        border-radius: 3px;
        border: 1px #fff solid;
         box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
         background-color: transparent;
    }
</style>
<?php
get_footer();
ob_flush();   // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by

