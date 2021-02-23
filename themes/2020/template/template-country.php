<?php
$args = array(
    'post_type' => 'chamber',
    'posts_per_page' => -1,
    'orderby' => 'meta_value',
    'order' => 'DESC',
    'meta_key' => '_show_order',
);
$wp_query = new WP_Query($args);
?>
<style>
    #president-space{
        border-radius: 0px;
        margin-top: 0px;
        background-color:  #ed7701;

    }
    #president-space .nbs-flexisel-nav-left,   #president-space .nbs-flexisel-nav-right{
        display: none;
    }
</style>
<div id="president-space">
    <ul id="flexisel-president" style=" border-radius: 0px;  background-color:  #ed7701;height: auto;">
        <?php
        if ($wp_query->have_posts()):
            while ($wp_query->have_posts()):
                $wp_query->the_post();
                ?>
                <li style=" background-color: #ccc; border-right: 1px solid #fff" > 
                    <div class="flexisel-president-item"  >
                        <?php if (has_post_thumbnail()): ?>
                            <img style="width: 80%; margin-bottom: 10px; border-radius: 5px; border: 1px solid #fff" 
                                 class="list-img"  
                                 src="<?php the_post_thumbnail_url() ?>" 
                                 srcset="<?php the_post_thumbnail_url() ?>" />
                             <?php endif; ?>
                        <br>
                        <label style='color: #015099 ; font-weight: bold; margin-top: 20px; font-size: 1.5rem'><?php the_title(); ?></label><br>
                          
                    </div>   
                </li>
                <?php
            endwhile;
        endif;
        wp_reset_postdata();
        wp_reset_query();
        ?>
    </ul>
</div>
<div class="clearout"></div>
<script>

    jQuery("#flexisel-president").flexisel({
        visibleItems: 3,
        itemsToScroll: 1,
        autoPlay: {
            enable: true,
            interval: 8000,
            pauseOnHover: false
        }
    });

</script>
