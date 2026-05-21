<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="blue-group">
    <div class="blue-title">
        <h3 class="blue-title-text"> <?php echo _e('各國資訊'); ?> </h3>
    </div> 
    <div style=" margin-top: 10px">
        <?php
        $arr = array(
            'post_type' => 'businesslink',
            'posts_per_page' => 30,
            'orderby' => 'meta_value',
            'order' => 'DESC',
            'meta_key' => '_show_order',
        );
        $my_query = new WP_Query($arr);
        if ($my_query->have_posts()) {
            ?>
        <div class="single-article-list">
                    <?php
                    while ($my_query->have_posts()) {
                        $my_query->the_post();
                        $images = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
                        $objImageData = get_post(get_post_thumbnail_id(get_the_ID()));
                        $strAlt = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);
                        ?>
                        <div> 
                            <a href="<?php echo get_post_meta(get_the_ID(), '_metabox_website', true) ?>" target="_blank"><?php the_title(); ?></a>
                        </div>
                        <?php
                    }
                    wp_reset_query();
                    wp_reset_postdata();
                }
                ?>
        </div>
    </div>
</div>

