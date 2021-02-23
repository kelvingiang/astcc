<?php
// lay phan header
get_header();
?>
<!-- phan noi dung of trang index --------------------------------------- -->
<div class="row">
    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12"  >
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <?php get_template_part('template/template', 'event-new'); ?>
            </div>

            <!--LAY THONG TIN SU KIEN QUAN TRONG-->   
            <div class="col-xl-8 col-lg-8 col-md-6 col-ms-12">
                <div class=" col-md-12 col-sm-12">
                    <?php get_template_part('template/template', 'event'); ?>
                </div>
                <div class=" col-md-12">
                    <?php get_template_part('template', 'advertising'); ?>
                    <!--LAY TIN TUC CUA HOI VA CAC PHAN NHANH--> 
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-ms-12">
                <?php get_template_part('template/template', 'business') ?>    
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
        <?php get_sidebar(); ?>
    </div>
</div>
<?php
// lay phan footer
get_footer();


