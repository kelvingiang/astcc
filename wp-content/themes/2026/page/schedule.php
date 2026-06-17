<?php
/*
  Template Name:  Schedule
 */
?>
<?php get_header(); ?>
<div class="astcc-page-container">

    <div class="main-content">
        <div class='head-title'>
            <div class="title">
                <h2 class="head"> <?php echo __('行事曆') ?> </h2>
            </div>
        </div>
        <div class="schedule-list">
            <?php
            global $wpdb;
            // PHAN get_resuls GET DATA FROM MY CREATE TABEL
            $table = $wpdb->prefix . 'schedule';
            $query = "SELECT * FROM {$table} WHERE status = 1  ORDER BY year  DESC, month  DESC, day  DESC";
            $reback = $wpdb->get_results($query, ARRAY_A);

            // LAY CAC  ROW CO THANG VA NAM TRUNG NHAU TAO KEY ARRAY
            $tmp = array();
            foreach ($reback as $arg) {
                $tmp[$arg['month'] . ' / ' . $arg['year']][] = $arg['id']; // AP DUNG CACH ARRAY KEY KO CHO PHEP TRUNG 
            }
            foreach ($tmp as $key => $value) {
            ?>
                <div class="my_month"><label><?php echo $key ?></label></div>
                <?php
                foreach ($value as $id) {
                    foreach ($reback as $item) {
                        if (in_array($id, $item)) {
                ?>
                            <div class="schedule-item">
                                <div class="schedule_title">
                                    <h4><?php echo $item['title']; ?></h4>
                                </div>
                                <div class="schedule-time-grid">
                                    <div class="time-block">
                                        <div class="meta-item"><label>開始日期 :</label> <span><?php echo $item['date'] . ' - ' . $item['weekdays']; ?></span></div>
                                        <div class="meta-item"><label>時間 :</label> <span><?php echo $item['time']; ?></span></div>
                                    </div>
                                    <div class="time-block">
                                        <div class="meta-item"><label>結束日期 :</label> <span><?php echo $item['finish_date'] . ' - ' . $item['finish_week']; ?></span></div>
                                        <div class="meta-item"><label>時間 :</label> <span><?php echo $item['finish_time']; ?></span></div>
                                    </div>
                                </div>
                                <div class="schedule-info">
                                    <div class="detail-row"><label>地點 :</label> <span><?php echo $item['place']; ?></span></div>
                                    <div class="detail-row"><label>備註 :</label> <span><?php echo nl2br($item['note']); ?></span></div>
                                </div>
                            </div>
            <?php
                        }
                    }
                }
            }
            ?>
        </div>
    </div>
    <div class="sidebar-area">
        <?php get_sidebar(); ?>
    </div>
</div>


<?php
get_footer();
