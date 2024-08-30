    <div id="news-home" class="animation-item">
        <div class="news-home-title">
            <div class="title-first title-select" onclick=" ChangSelect('.title-first', '.content-first')">
                <h3>亞總最新消息</h3>
            </div>
            <div class="title-second" onclick="ChangSelect('.title-second', '.content-second')">
                <h3>各會員國最新消息</h3>
            </div>
            <div class="title-third" onclick="ChangSelect('.title-third', '.content-third')">
                <h3>青商會最新消息</h3>
            </div>
            <div class="title-fourth" onclick="ChangSelect('.title-fourth', '.content-fourth')">
                <h3>會務資料</h3>
            </div>
        </div>

        <div class="news-home-content">
            <div class="content-first content-select">
                <div class="content-list">
                    <?php
                    $newArr = array(
                        'post_type' => 'post',
                        'posts_per_page' => 10,
                        'category_name' => 'news',
                    );
                    $newQuery = new WP_Query($newArr);
                    if ($newQuery->have_posts()) {
                        while ($newQuery->have_posts()) {
                            $newQuery->the_post();
                    ?>
                            <div>
                                <div><a class="news-link" href="<?php echo get_the_permalink() ?>"><?php the_title(); ?></a></div>
                                <div><?php echo get_the_date('Y-m-d', get_the_ID()) ?></div>
                            </div>
                    <?php
                        }
                    }
                    wp_reset_postdata();
                    wp_reset_query();
                    ?>
                </div>
            </div>

            <div class="content-second">
                <div class="content-list">
                    <?php
                    $memberArr = array(
                        'post_type' => 'post',
                        'posts_per_page' => 10,
                        'category_name' => 'member',
                    );
                    $memberQuery = new WP_Query($memberArr);
                    if ($memberQuery->have_posts()) {
                        while ($memberQuery->have_posts()) {
                            $memberQuery->the_post();
                    ?>
                            <div>
                                <div><a class="news-link" href="<?php echo get_the_permalink() ?>"><?php the_title(); ?></a></div>
                                <div><?php echo get_the_date('Y-m-d', get_the_ID()) ?></div>
                            </div>
                    <?php
                        }
                    }
                    wp_reset_postdata();
                    wp_reset_query();
                    ?>
                </div>
            </div>

            <div class="content-third">
                <div class="content-list">
                    <?php
                    $youngArr = array(
                        'post_type' => 'post',
                        'posts_per_page' => 10,
                        'category_name' => 'young',
                    );
                    $youngQuery = new WP_Query($youngArr);
                    if ($youngQuery->have_posts()) {
                        while ($youngQuery->have_posts()) {
                            $youngQuery->the_post();
                    ?>
                            <div>
                                <div> <a class="news-link" href="<?php echo get_the_permalink() ?>"><?php the_title(); ?></a></div>
                                <div><?php echo get_the_date('Y-m-d', get_the_ID()) ?></div>
                            </div>
                    <?php
                        }
                    }
                    wp_reset_postdata();
                    wp_reset_query();
                    ?>
                </div>
            </div>

            <div class="content-fourth">
                <div class="content-list">
                    <?php
                    $condArr = array(
                        'post_type' => 'post',
                        'posts_per_page' => 10,
                        'category_name' => 'conferen',
                    );
                    $condQuery = new WP_Query($condArr);
                    if ($condQuery->have_posts()) {
                        while ($condQuery->have_posts()) {
                            $condQuery->the_post();
                    ?>
                            <div>
                                <div><a class="news-link" href="<?php echo get_the_permalink() . '/?cate=guidelines' ?>"><?php the_title(); ?></a></div>
                                <div><?php echo get_the_date('Y-m-d', get_the_ID()) ?></div>
                            </div>
                    <?php
                        }
                    }
                    wp_reset_postdata();
                    wp_reset_query();
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        jQuery(document).ready(function() {});

        function ChangSelect(titleSelect, contentSelect) {
            jQuery(titleSelect).parents().siblings('.news-home-content').children().removeClass('content-select');

            jQuery(titleSelect).siblings().removeClass('title-select');

            jQuery(titleSelect).addClass('title-select');

            jQuery(titleSelect).parents().siblings('.news-home-content').children(contentSelect).addClass('content-select');

        }
    </script>