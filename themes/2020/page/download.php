<?php
/*
  Template Name: Download
 */
ob_start();  // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by
get_header();
?>
<style>
    .download-list{
        width: 100%;
    }
    .download-list div {
        padding: 1rem;
    }
    .download-list div:nth-child(even){
        background-color: #fff;
    }

    .download-list div a{
        font-size: 1.8rem;
        font-weight: bold;
        color: rgba(8, 108, 170,1);
    }

    .download-list div a:hover{
        text-decoration: none;
        color: rgba(8, 108, 170, .6);
    }

    .download-list div a i{
        margin-right: 2rem;
    }
</style>
<div class="row">
    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 ">
        <div class='head-title'>
            <div class="title">
                <h2 class="head"> <?php echo __('下載區') ?> </h2>
            </div>
        </div>
        <div class="info-bg">
            <div class="download-list">
                <?php foreach (download_list() as $val) { ?>
                    <div>
                        <a href="<?php echo get_template_directory_uri() . '/file/' . $val['file'] ?>"
                           download="<?php echo $val['name'] ?>.pdf"
                           ><i class="fa fa-download" aria-hidden="true"></i><?php echo $val['name'] ?></a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
        <?php get_sidebar() ?>
    </div>
</div>
<?php
get_footer();
ob_flush();   // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by


