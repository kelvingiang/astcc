<?php get_header(); ?>


<div class="president_single">
    <?php if (have_posts()): while (have_posts()) : the_post(); ?>
            <?php $did = get_the_id(); ?>
            <!-- article -->
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="president_single_title"><?php the_title(); ?> <span><?php echo get_post_meta($post->ID, '_metabox_job_title', true) ?></span> </div>
                <!-- post thumbnail -->
                <?php if (has_post_thumbnail()) : ?>
                    <div class="president_single_img">
                        <img src="<?php the_post_thumbnail_url() ?>" />
                    </div>
                <?php endif; ?>
                <div class="president_single_content"> <?php the_content(); ?></div>
            </article>
            <div class=" clear"></div>
            <!-- /article -->
        <?php endwhile; ?>
    <?php endif; ?>
</div>


<div class="info-bg">
    <div class="president_current">
        <?php
        $arr = array(
            'post_type' => 'supervisor',
            'post_status' => 'publish',
            'supervisor_cate' => 'current',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'meta_key' => '_show_order',
            'post__not_in' => array($did)
        );
        $wp_query = new WP_Query($arr);
        if ($wp_query->have_posts()):
            while ($wp_query->have_posts()):
                $wp_query->the_post();

                if (has_post_thumbnail()) {
                    $imgUrl = get_the_post_thumbnail_url();
                }else {
                    $imgUrl = PART_IMAGES . 'no-person.png';
                }

        ?>
                <div class="president_current_item">
                    <div class="president_current_item_img">
                        <img src="<?php echo $imgUrl ?>" alt="ssss" />
                    </div>
                    <a href="<?php the_permalink(); ?>">
                        <div class="president_current_item_link">
                            <p class="title"> <?php the_title() ?></p>
                            <p class="job"><?php echo get_post_meta($post->ID, '_metabox_job_title', true) ?></p>
                        </div>
                    </a>
                </div>
        <?php
            endwhile;
        endif;
        ?>

    </div>
</div>

<?php get_template_part('template/template', 'group-supervisor'); ?>

<?php get_footer(); ?>