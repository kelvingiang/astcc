<?php
/*
  Template Name:  Schedule
 */
?>
<?php get_header(); ?>

<div class="row" style="padding-top: 30px" >
    <div class="first-space col-lg-3 col-md-4 col-sm-12 col-xs-12">
        <?php get_sidebar(); ?>
    </div>
    <div class="second-space col-lg-9 col-md-8 col-sm-12 col-xs-12">
        <div class="group-border">

            <div>
                <div style="text-align: left;  color:  #123E66; font-weight: bold; font-size: 20px">行事曆 </div>
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
                    <div class="my_month"><label style=" padding-left: 5px; font-size: 15px"><?php echo $key ?></label></div>
                    <?php
                    foreach ($value as $id) {
                        foreach ($reback as $item) {
                            if (in_array($id, $item)) {
                                $time = explode('-', $item['time']);
                                $TimeStart = sanitize_text_field($time[0]);
                                $TimeEnd = sanitize_text_field($time[1]);
                                ?>
                                <div class ="row my_row ">
                                    <div class=" col-md-12" ><label class="label-title "><?php echo $item['title']; ?></label> </div> 
                                    <div class="col-md-12 my_text">
                                        <label>日期:</label> <?php echo $item['date'] . '-' . $item['weekdays']; ?>
                                        <label style="padding-left: 50px">時間:</label> <?php echo $TimeStart ?>
                                        <b><?php echo $TimeEnd == "" ? "開始" : "至 " ?></b> <?php echo $TimeEnd ?> 
                                    </div>
                                    <div class="col-md-12 my_hide">
                                        <div>
                                            <label>地點:</label> <?php echo $item['place']; ?><br>
                                            <label>備註:</label> <?php echo $item['note']; ?> 
                                        </div> 
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
    </div>

    <div class="last-space col-lg-3 col-md-4 col-sm-12 col-xs-12">
        <?php get_sidebar('mobile'); ?>
    </div>
</div>


<script type="text/javascript">
    jQuery(document).ready(function () {

//        jQuery('.my_row').click(function() {
//            jQuery(this).children('.my_hide').stop(true, false).slideDown('slow');
////            jQuery(this).children('.my_hide').fadeIn("slow");
//        }).toggle("slow", function() {
//            jQuery(this).children('.my_hide').stop(true, false).slideUp('80');
////            jQuery(this).children('.my_hide').hide(10);
//        });

//jQuery('.my_row').click(function() {
//            jQuery(this).children('.my_hide').toggle("slow")
//        });
//    });

        jQuery('.my_row').click(function () {
            jQuery('.my_hide').slideUp('80');
            jQuery('.my_row').css({'background-color': '#fff', 'color': '#8C8888'});
            jQuery(this).children('.my_hide').slideDown('slow');
            jQuery(this).css({'background-color': '#E3E4E5', 'color': '#333'});
        });
    });
</script>
<?php
get_footer();
