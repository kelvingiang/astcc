<?php
/*
  Template Name:  Schedule
 */
?>
<?php get_header(); ?>
<div id="silder"><?php get_template_part('template/template', 'silder'); ?></div>
<div class="row my-row" style="padding-top: 30px">

    <div class="second-space col-lg-9 col-md-8 col-sm-12 col-xs-12">
        <div class='head-title'>
            <div class="title">
                <h2 class="head"> <?php echo __('行事曆') ?> </h2>
            </div>
        </div>
        <div class="group-border">
            <?php
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
                            <div class="row my_row ">
                                <div class=" col-md-12 schedule_title">
                                    <?php echo $item['title']; ?>
                                </div>
                                <div class="col-md-6 my_text">
                                    <label>日期 :</label> <?php echo $item['date'] . ' - ' . $item['weekdays']; ?>
                                    <label style="padding-left: 10px">時間 :</label> <?php echo $item['time'] ?>
                                </div>
                                <div class="col-md-6 my_text">
                                    <label>結束日期 :</label> <?php echo $item['finish_date'] . ' - ' . $item['finish_week']; ?>
                                    <label style="padding-left: 10px">時間 :</label> <?php echo $item['finish_time'] ?>
                                </div>
                                <div class="col-md-12 my_hide">

                                    <label>地點 : </label> <?php echo $item['place']; ?><br>
                                    <label>備註 : </label> <?php echo $item['note']; ?>

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
    <div class="first-space col-lg-3 col-md-4 col-sm-12 col-xs-12">
        <?php get_sidebar(); ?>
    </div>

    <!-- <div class="last-space col-lg-3 col-md-4 col-sm-12 col-xs-12"> -->
    <?php // get_sidebar('mobile'); 
    ?>
    <!-- </div> -->
</div>


<script type="text/javascript">
    jQuery(document).ready(function() {


        jQuery('.my_row').click(function() {
            // jQuery('.my_row').css({
            //     'background-color': '#fff',
            //     'color': '#8C8888',
            // });
            var dd = jQuery(this).children('.my_hide').css('display');

            if (dd !== 'block') {
                jQuery('.my_hide').slideUp('80');
                jQuery('.my_row').removeClass('selected');

                jQuery(this).addClass('selected');
                jQuery(this).children('.my_hide').slideDown('slow');
                // jQuery(this).css({
                //     'background-color': '#E3E4E5',
                //     'color': "#000",
                // });
            }
        });
    });
</script>
<?php
get_footer();
