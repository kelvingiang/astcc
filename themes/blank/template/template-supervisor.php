<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="blue-group">
    <div class="blue-title">
        <h3 class="blue-title-text"> <?php echo _('總會會職人員'); ?> </h3>
    </div> 
    <div style=" margin-top: 10px">

        <?php
        $speacilArr = array(
            'post_type' => 'supervisor',
            'posts_per_page' => -1,
            'orderby' => 'meta_value',
            'order' => 'DESC',
            'meta_key' => '_admin_metabox_order',
            'meta_query' => array(array('key' => '_admin_metabox_special', 'value' => 'on',))
        );
        $query_special = new WP_Query($speacilArr);
        if ($query_special->have_posts()) {
            while ($query_special->have_posts()) {
                $query_special->the_post();
                $images = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
                $objImageData = get_post(get_post_thumbnail_id(get_the_ID()));
                $strAlt = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);
                ?>

                <div class="box" style="border-bottom: 1px solid #ccc">
                    <img src="<?php echo $images[0]; ?>"  alt="<?php echo $strAlt; ?>" title="<?php echo $objImageData->post_title; ?>" />
                    <div class="nbs-flexisel-title">
                        <label class=' label-title'><?php the_content(); ?></label>
                        <label style='font-size: 12px' ><?php the_title(); ?></label>
                    </div>
                </div>

                <?php
            }
            wp_reset_query();
            wp_reset_postdata();
        }
        ?>


        <?php
        $arr = array(
            'post_type' => 'supervisor',
            'posts_per_page' => -1,
            'orderby' => 'meta_value',
            'order' => 'DESC',
            'meta_key' => '_admin_metabox_order',
            'meta_query' => array(array('key' => '_admin_metabox_special', 'value' => 'off',))
        );
        $my_query = new WP_Query($arr);
        if ($my_query->have_posts()) {
            ?>
            <div id ='MyCarousel'>
                <ul>
                    <?php
                    while ($my_query->have_posts()) {
                        $my_query->the_post();
                        $images = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
                        $objImageData = get_post(get_post_thumbnail_id(get_the_ID()));
                        $strAlt = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);
                        ?>
                        <li style=" border-bottom:  1px solid #D8D8D8; margin-top: 10px; height: 200px;"> 
                            <div class="carousel-box">
                                <img src="<?php echo $images[0]; ?>"  alt="<?php echo $strAlt; ?>" title="<?php echo $objImageData->post_title; ?>" />
                                <div class="nbs-flexisel-title">
                                    <label class=' label-title'><?php the_content(); ?></label>
                                    <label style='font-size: 12px' ><?php the_title(); ?></label>
                                </div>
                            </div>
                        </li>
                        <?php
                    }
                    wp_reset_query();
                    wp_reset_postdata();
                }
                ?>
            </ul>
        </div>
    </div>
</div>

<script type='text/javascript'>
    jQuery(function () {
        jQuery("#MyCarousel").jCarouselLite({
            //        btnNext: ".bounceout .next",
            //        btnPrev: ".bounceout .prev",
            visible: 3, // so item hien thi

            // CAC HIEU UNG
            //  easing: "easeOutBounce",  // hieu ung khi chuyen dong
            auto: 1500 * 2,
            speed: 2000,
            circular: true, // xoay vong lai item khi xem
            autoWidth: true,
            responsive: true,
            vertical: true, // hinh thi kieu ngang hay doc
            hoverPause: true
        });

    });

</script>
