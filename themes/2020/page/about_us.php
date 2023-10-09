<?php
/*
  Template Name: About Us
 */
?>
<?php
ob_start();  // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by
get_header();

?>
<div class="row">
    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 ">
        <div class='head-title'>
            <div class="title">
                <h2 class="head"> <?php echo _e('Contact Us') ?> </h2>
            </div>
        </div>
        <div class="info-bg" style="color: #515151; font-size: 15px ;   letter-spacing: 2px; border: 1px #d8d8d8 solid;  border-radius:  5px; padding:  10px ">
            <div class="row">
                <div class="col-md-2"><?php _e('Address') ?></div>
                <div class="col-md-10"><?php echo get_option('contact_us_address'); ?></div>
                <div class="col-md-12 gachduoi"></div>
                <div class="col-md-2"><?php _e('Mobile') ?></div>
                <div class="col-md-10"><?php echo get_option('contact_us_mobile'); ?></div>
                <div class="col-md-12 gachduoi"></div>
                <div class="col-md-2"><?php _e('Phone') ?></div>
                <div class="col-md-10"><?php echo get_option('contact_us_phone'); ?></div>
                <div class="col-md-12 gachduoi"></div>
                <div class="col-md-2"><?php _e('Fax') ?></div>
                <div class="col-md-10"><?php echo get_option('contact_us_fax'); ?></div>
                <div class="col-md-12 gachduoi"></div>
                <div class="col-md-2"><?php _e('E-mail') ?></div>
                <div class="col-md-10"><?php echo get_option('contact_us_email'); ?></div>
                <div class="col-md-12 gachduoi"></div>
            </div>
            <div style=" margin-top: 50px">
                <?php get_template_part('template/template', 'maps'); ?>
            </div>
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
<style>
    .gachduoi{
        border-bottom: 1px #ccc solid;
        margin: 10px 0;
    }
</style>