<?php
/*
  Template Name: Astcc Charter
 */
get_header();
?>
<div class="astcc-page-container">
    <div class="main-content">
        <div class='head-title'>
            <div class="title">
                <h2 class="head"> <?php _e('Astcc Charter') ?></h2>
            </div>
        </div>
        <div class="history-content-panel one-column">
            <?php echo get_post_meta('1', '_info_charter', true) ?>
        </div>
    </div>

    <div class="sidebar-area">
        <?php get_sidebar() ?>
    </div>
</div>
<?php
get_footer();
?>