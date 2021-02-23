<div>
    <div class="article-list">
        <?php

//====================================================================
        $arr = array(
            'post_type' => 'conference',
            'post_status' => 'publish',
            'conference_cate' => 'other',
            'posts_per_page' => $showNum,
            'offset' => $offset,
            'paged' => $paged,
            'meta_query' => array(
                array(
                    'key' => '_metabox_home',
                    'value' => 'on',
                    'compare' => '='
                )
            )
        );
        $wp_query = new WP_Query($arr);
        if ($wp_query->have_posts()):
            while ($wp_query->have_posts()):
                $wp_query->the_post();
                ?>
                <div><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></div>
                <?php
            endwhile;
        endif;
        ?>
    </div>  
    <div>
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
<style>
    .article-list div{
        min-height: 30px;
        border-bottom: 1px solid #ccc;
        line-height: 30px;
        display: block;
    }
    .article-list div a{
        padding-left: 5px;
        color:#35556e;
        font-weight: bold;
        display: block;
    }
    .article-list div a:hover{
        text-decoration: none;
        color: #ccc;
    }
</style>