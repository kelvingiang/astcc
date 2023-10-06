<?php
// lay phan header
get_header();
?>
<!-- phan noi dung of trang index --------------------------------------- -->
<div class="row">
    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12"  >
        <div class="row">
            <div class="col-md-12 col-sm-12">
                 <?php get_template_part('template/template', 'country'); ?>
            </div>

            <!--LAY THONG TIN SU KIEN QUAN TRONG-->   
            <div class="col-xl-12 col-lg-12 col-md-12 col-ms-12">
                <div class=" col-md-12 col-sm-12">
                    <?php get_template_part('template/template', 'event'); ?>
                   
                </div>
                <div class=" col-md-12">
                    <?php get_template_part('template/template', 'maps'); ?>
                    <!--LAY TIN TUC CUA HOI VA CAC PHAN NHANH--> 
                </div>
            </div>
            <!-- <div class="col-xl-4 col-lg-4 col-md-6 col-ms-12">
                <?php //get_template_part('template/template', 'business') ?>    
                <?php // get_template_part('template/template', 'business_1') ?>    
                <?php //get_template_part('template/template', 'business_2') ?>    
            </div> -->
        </div>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
        <?php get_sidebar(); ?>
    </div>
</div>
<?php
// lay phan footer
get_footer();


