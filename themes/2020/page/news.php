<?php
/*
  Template Name: News
 */
?>
<?php
ob_start();  // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by
get_header();
?>
 <div id="silder"><?php get_template_part('template/template', 'silder'); ?></div>
<div class="row my-row">
    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 ">
        <div class='head-title'>
            <div class="title">
                <h2 class="head"> <?php echo __('Asian News Information') ?></h2>
            </div>
        </div>
        <div class="info-bg">
            <?php
            //===CAC THONG SO DUNG DE PHAN TRANG ============================               
            $paged = max(1, get_query_var('page'));
            $showNum = get_option('posts_per_page');
            $offset = ($paged - 1) * $showNum;
// ==LAY TONG SO DONG DE PHAN TRANG  ============================================= 
            $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'category_name' => 'news',
            );

            $the_query = new WP_Query($args);
            $totalpost = $the_query->found_posts;
            wp_reset_postdata();
            wp_reset_query();
//====================================================================
            $arr = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'category_name' => 'news',
                'posts_per_page' => $showNum,
                'offset' => $offset,
                'paged' => $paged,
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
                'meta_key' => '_show_order',
            );
            $wp_query = new WP_Query($arr);
            if ($wp_query->have_posts()):
                while ($wp_query->have_posts()):
                    $wp_query->the_post();
                    ?>
                    <div class="article_item">
                        <a href="<?php the_permalink(); ?>"><?php the_title() ?></a>
                        <div><?php echo get_the_content(); ?></div>
                    </div>
                    <?php
                endwhile;
            endif;
            ?>
            <!-- =======PHAN TRANG ================================================-->             
            <div style="height: 30px">

                <?php
                $ss = home_url('news');

                $config = array(
                    'current_page' => $paged, // Trang hiện tại
                    'total_record' => $totalpost, // Tổng số record
                    'limit' => $showNum, // limit
                    'link_full' => 'index.php?page={page}', // Link full có dạng như sau: domain/com/page/{page}
                    'link_first' => $ss, // Link trang đầu tiên
                    'range' => 5// Số button trang bạn muốn hiển thị 
                );
                require_once (DIR_CLASS . 'pagination.php');
                $paging = new Pagination();
                $paging->init($config);
                echo $paging->html();
                ?>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
        <?php get_sidebar() ?>
    </div>
</div>
<?php
get_footer();
ob_flush();   // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by
?>
