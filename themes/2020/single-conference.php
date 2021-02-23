<?php get_header(); ?>
<div class="row">
    <div class="col-lg-9">
        <?php if (have_posts()): while (have_posts()) : the_post(); ?>
                <?php
                $did = get_the_id();
                ?>
                <!-- article -->
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="border-bottom: 2px solid #333; padding-bottom: 25px">
                    <h1 style=" font-size: 23px; font-weight: bold; color:  #35556e; letter-spacing: 2px">
        <?php the_title(); ?>
                    </h1>
                    <!-- post thumbnail -->
        <?php if (has_post_thumbnail()) : // Check if Thumbnail exists  ?>
                        <div style='text-align: center'>
                            <img  src="<?php the_post_thumbnail_url() ?>"  style=" width: 80%; margin: 10px; border-radius: 5px"/>
                        </div>
        <?php endif; ?>
                    <div class="content-style"> <?php the_content(); // Dynamic Content        ?></div>
                </article>
                <!-- /article -->
            <?php endwhile; ?>
<?php endif; ?>
        </section>

        <div class="single-article-list">
            <?php
//= List  ===================================================================
            $arr = array(
                'post_type' => 'conference',
                'post_status' => 'publish',
                'conference_cate' => $_SESSION['conference_cate'],
                'posts_per_page' => 15,
                'orderby' => 'meta_value',
                'order' => 'DESC',
                'meta_key' => '_show_order',
            );
            $wp_query = new WP_Query($arr);
            if ($wp_query->have_posts()):
                while ($wp_query->have_posts()):
                    $wp_query->the_post();
                    if ($did == get_the_id()) {
                        continue;
                    }
                    ?>
                    <div><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></div>
                    <?php
                endwhile;
            endif;
            ?>
        </div>
        <div class="more-link">
            <a  href="<?php echo home_url($_SESSION['conference_cate']) ?>"><?php _e('More') ?></a>
        </div>
    </div>
    <div class="col-lg-3">
<?php get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>
