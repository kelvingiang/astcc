<div>
    <?php
    $argsevent = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'orderby' => 'meta_value_num',
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
                <div style="float: left; width: 30%">
                    <?php if (has_post_thumbnail()): ?>
                        <img style="width: 90%; margin: 10px; border-radius: 5px; border: 1px solid #fff" 
                             class="list-img"  
                             src="<?php the_post_thumbnail_url() ?>" 
                             srcset="<?php the_post_thumbnail_url() ?>" />
                         <?php endif; ?>
                </div>
                <div class="blue-content"><?php echo get_the_content() ?></div>
                <div style=" clear:  both"></div>
            </div>
            <?php
        endwhile;
    endif;
    ?>
</div>
