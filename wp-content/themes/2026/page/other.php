<?php
/*
  Template Name: Other
 */
get_header();
?>

<div class="row">

    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 ">

        <div class='head-title'>

            <div class="title">

                <h2 class="head"> <?php echo __('行程資訊') ?> </h2>

            </div>

        </div>

        <div class="info-bg">

            <?php

            $_SESSION['conference_cate'] = "other";

            //===CAC THONG SO DUNG DE PHAN TRANG ============================               

            $paged = max(1, get_query_var('page'));

            $showNum = get_option('posts_per_page');

            $offset = ($paged - 1) * $showNum;

// ==LAY TONG SO DONG DE PHAN TRANG  ============================================= 

            $args = array(

                'post_type' => 'conference',

                'post_status' => 'publish',

                'conference_cate' => 'other',

            );



            $the_query = new WP_Query($args);

            $totalpost = $the_query->found_posts;

            wp_reset_postdata();

            wp_reset_query();

//====================================================================

            $arr = array(

                'post_type' => 'conference',

                'post_status' => 'publish',

                'conference_cate' => 'other',

                'posts_per_page' => $showNum,

                'offset' => $offset,

                'paged' => $paged,

                'orderby' => 'meta_value',

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

                $ss = home_url('other');

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

    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">

        <?php get_sidebar() ?>

    </div>

</div>
<?php
get_footer();



