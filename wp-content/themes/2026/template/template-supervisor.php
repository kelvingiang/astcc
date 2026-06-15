<?php
/**
 * Template part for displaying the supervisor sidebar component.
 *
 * This template displays the "Current Team" and a carousel for the "Advisory Team".
 * It is typically used within a sidebar.
 *
 * @package 2026
 */
?>
<div>
     <div>

        <?php
        // Display the "Current Team".
        $current_team_args = array(
            'post_type'       => 'supervisor',
            'post_status'     => 'publish',
            'supervisor_cate' => 'current',
            'orderby'         => 'meta_value_num',
            'order'           => 'DESC',
            'meta_key'        => '_show_order',
        );
        $current_team_query = new WP_Query($current_team_args);

        if ($current_team_query->have_posts()) :
            while ($current_team_query->have_posts()) : $current_team_query->the_post();
                if (has_post_thumbnail()) {
                    $img_url    = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                    $thumb_id   = get_post_thumbnail_id();
                    $img_alt    = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
                    $img_title  = get_the_title($thumb_id);
                } else {
                    $img_url    = PART_IMAGES . 'no-person.png';
                    $img_alt    = get_the_title();
                    $img_title  = get_the_title();
                }
                $job_title = get_post_meta(get_the_ID(), '_metabox_job_title', true);
                ?>
                <a href="<?php the_permalink(); ?>" class="supervisor-card">
                    <div class="supervisor-card__img">
                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img_alt); ?>" title="<?php echo esc_attr($img_title); ?>" />
                    </div>
                    <div class="supervisor-card__info">
                        <p class="name"><?php the_title(); ?></p>
                        <p class="job"><?php echo esc_html($job_title); ?></p>
                    </div>
                </a>
                <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>
        <?php
        // Display the "Advisory Team" carousel.
        $advisory_team_args = array(
            'post_type'       => 'supervisor',
            'post_status'     => 'publish',
            'supervisor_cate' => 'other',
            'orderby'         => 'meta_value_num',
            'order'           => 'DESC',
            'meta_key'        => '_show_order',
        );
        $advisory_team_query = new WP_Query($advisory_team_args);

        if ($advisory_team_query->have_posts()) :
            ?>
            <h3 class="widget-title advisory-title"><?php _e('顧問團隊', '2026'); ?></h3>
            <div class="swiper advisory-swiper">
                <div class="swiper-wrapper">
                    <?php
                    while ($advisory_team_query->have_posts()) : $advisory_team_query->the_post();
                        if (has_post_thumbnail()) {
                            $img_url    = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                            $thumb_id   = get_post_thumbnail_id();
                            $img_alt    = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
                        } else {
                            $img_url    = PART_IMAGES . 'no-person.png';
                            $img_alt    = get_the_title();
                        }
                        $job_title = get_post_meta(get_the_ID(), '_metabox_job_title', true);
                        ?>
                        <div class="swiper-slide">
                            <div class="advisory-card">
                                <div class="advisory-card__img">
                                    <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img_alt); ?>" />
                                </div>
                                <div class="advisory-card__info">
                                    <p class="name"><?php the_title(); ?></p>
                                    <p class="job"><i><?php echo esc_html($job_title); ?></i></p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php
            wp_reset_postdata();
        endif;
        ?>
</div>

<?php if ($advisory_team_query->have_posts()) : ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const advisorySwiperEl = document.querySelector('.advisory-swiper');
    if (!advisorySwiperEl) return;

    const slideCount = advisorySwiperEl.querySelectorAll('.swiper-slide').length;

    // Khởi tạo Swiper cho carousel đội ngũ cố vấn
    var advisorySwiper = new Swiper(advisorySwiperEl, {
        direction: 'vertical',
        slidesPerView: 2,
        spaceBetween: 10,
        // Chỉ bật loop và autoplay nếu có đủ slide (>= 4) để slider hoạt động đúng
        loop: slideCount >= 4,
        speed: 2000,
        autoplay: slideCount >= 4 ? {
            delay: 10000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        } : false,
    });
});
</script>
<?php endif; ?>