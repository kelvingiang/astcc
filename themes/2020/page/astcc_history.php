<?php
/*
  Template Name: Astcc History
 */
?>
<?php
ob_start();  // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by
get_header();
?>

<div class="row my-row">
    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 ">
           <div class='head-title'>
                    <div class="title">
                        <h2 class="head"> <?php _e('Astcc History') ?> </h2>
                    </div>
              </div>
                <div  style="color: #333; font-size: 15px ;   letter-spacing: 2px; border: 1px #d8d8d8 solid;  border-radius:  5px; padding:  10px ">
                    <?php echo get_post_meta('1','_info_history',true);  ?>
                </div>  
    </div>

    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
        <?php get_sidebar() ?>
    </div>
</div>
<?php
get_footer();
 ob_flush();   // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by
 
 ?>
