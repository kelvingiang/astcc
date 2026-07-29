    <div id="news-home">
        <div class="news-home-header">
            <h2 class="section-title">最新消息</h2>
            <?php
            // 2026-06-09: 將頁籤配置定義為單一數據源
            $tabs = array(
                'tab-first' => array(
                    'title' => '亞總最新消息',
                    'cat' => 'news',
                    'link_suffix' => ''
                ),
                'tab-second' => array(
                    'title' => '各會員國最新消息',
                    'cat' => 'member',
                    'link_suffix' => ''
                ),
                'tab-third' => array(
                    'title' => '青商會最新消息',
                    'cat' => 'young',
                    'link_suffix' => ''
                ),
                'tab-fourth' => array(
                    'title' => '會務資料',
                    'cat' => 'conferen',
                    'link_suffix' => '/?cate=guidelines'
                )
            );
            // 2026-06-09: 獲取第一個頁籤的鍵以將其設置為活動狀態。增加對舊版 PHP 的兼容性。
            $first_tab_id = function_exists('array_key_first') ? array_key_first($tabs) : (empty($tabs) ? null : array_keys($tabs)[0]);
            ?>
            <div class="news-home-tabs">
                <?php foreach ($tabs as $tab_id => $tab_data) : ?>
                    <button class="tab-btn <?php echo ($tab_id === $first_tab_id) ? 'active' : ''; ?>" onclick="switchNewsTab('<?php echo esc_attr($tab_id); ?>', this)">
                        <?php echo esc_html($tab_data['title']); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="news-home-body">
            <?php foreach ($tabs as $tab_id => $tab_data) : ?>
                <?php
                $query = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => 5,
                    'category_name' => $tab_data['cat'],
                    'orderby' => 'date',
                    'order' => 'DESC',
                ));
                ?>
                <div id="<?php echo esc_attr($tab_id); ?>" class="news-tab-content <?php echo ($tab_id === $first_tab_id) ? 'active' : ''; ?>">
                    <div class="news-list">
                        <?php if ($query->have_posts()) : ?>
                            <?php while ($query->have_posts()) : $query->the_post(); ?>
                                <a href="<?php echo esc_url(get_the_permalink() . $tab_data['link_suffix']); ?>" class="news-item">
                                    <div class="news-date">
                                        <span class="day"><?php echo get_the_date('d'); ?></span>
                                        <span class="month-year"><?php echo get_the_date('Y-m'); ?></span>
                                    </div>
                                    <div class="news-info">
                                        <h3 class="news-title"><?php echo esc_html(get_the_title()); ?></h3>
                                        <span class="news-readmore">閱讀更多 <i class="fa fa-angle-right"></i></span>
                                    </div>
                                </a>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <p class='no-news'>目前沒有最新消息。</p>
                        <?php endif; ?>
                    </div><!-- .news-list -->
                    <?php wp_reset_postdata(); ?>
                </div><!-- .news-tab-content -->
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        function switchNewsTab(tabId, btn) {
            // 2026-06-09: 更新按鈕
            const buttons = btn.parentElement.querySelectorAll('.tab-btn');
            buttons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // 2026-06-09: 更新內容
            const contents = document.querySelector('.news-home-body').querySelectorAll('.news-tab-content');
            contents.forEach(c => c.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');
        }
    </script>