<?php
/*
  Template Name: Astcc History
 */
get_header();
?>

<div class="astcc-page-container">
    <div class="main-content">
        <div class="head-title">
            <h2 class="head"><?php _e('Astcc History') ?></h2>
        </div>
        <div class="history-content-panel one-column">
            <?php echo get_post_meta('1', '_info_history', true);  ?>
        </div>
    </div>

    <div class="sidebar-area">
        <?php get_sidebar() ?>
    </div>
</div>
<?php
get_footer();
?>