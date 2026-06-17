<?php
/*
  Template Name: Download
 */
get_header();
?>
<div class="astcc-page-container">
    <div class="main-content">
        <div class='head-title'>
            <div class="title">
                <h2 class="head"> <?php echo __('下載區') ?> </h2>
            </div>
        </div>
        <div class="download-list">
            <?php foreach (download_list() as $val) { ?>
                <div class="download-item">
                    <a href="<?php echo get_template_directory_uri() . '/file/' . $val['file'] ?>" download="<?php echo $val['name'] ?>.pdf" class="download-link">
                        <span class="download-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        </span>
                        <span class="download-title"><?php echo $val['name'] ?></span>
                        <span class="download-action-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>
                        </span>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="sidebar-area">
        <?php get_sidebar() ?>
    </div>
</div>
<?php
get_footer();


