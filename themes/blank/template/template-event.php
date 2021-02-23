<div>
    <?php
    $argsevent = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'orderby' => 'meta_value',
        'order' => 'DESC',
        'meta_key' => '_show_order',
        'meta_query' => array(
            array('key' => '_metabox_home', 'value' => 'on',))
    );
    $myQuery = new WP_Query($argsevent);
    if ($myQuery->have_posts()):
        while ($myQuery->have_posts()):
            $myQuery->the_post();
            ?>

            <div class="blue-group">
                <div class="blue-title">
                    <h3 class="blue-title-text"> <?php the_title() ?> </h3>
                </div>
                <div class="blue-content"><?php echo get_the_content() ?></div>
            </div>
            <?php
        endwhile;
    endif;
    ?>
</div>
