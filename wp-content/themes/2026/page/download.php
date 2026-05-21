<?php
/*
  Template Name: Download
 */
get_header();
?>
<div class="row my-row">
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


