<!-- <div id="map_canvas" style="position: relative; z-index: 28 ; height: 400px;  width: 100%; margin: 0 auto"></div> -->

<!-- <script type="text/javascript">
    var map;

    function initMap() {
        var position = new google.maps.LatLng(<?php echo get_option('map_x'); ?>, <?php echo get_option('map_y'); ?>);
        var myOptions = {
            zoom: 17,
            center: position,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);

        var marker = new google.maps.Marker({
            position: position,
            map: map
        });

        var myWindowOptions = {
            content: '<b style="color:red"><?php echo get_option('chamber_name') ?></b>'
        };

        var myInfoWindow = new google.maps.InfoWindow(myWindowOptions);
        myInfoWindow.open(map, marker);
    }
</script> -->

<!-- ✅ 僅保留這一行載入 Maps API，指定 callback=initMap -->
<!-- <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBAV4v2qSBuCA1Rn7NPd09exwP4smcjW_g&callback=initMap">
</script> -->

<div>
    <a href="https://www.google.com/maps/place/111+Somerset+Rd,+%2306+09+TripleOne+Somerset,+Singapore+238164/@1.2999795,103.8374312,649m/data=!3m1!1e3!4m5!3m4!1s0x31da1990e8a47437:0xffb4450e7944d669!8m2!3d1.3002246!4d103.8373209!5m1!1e2?entry=ttu&g_ep=EgoyMDI2MDUyNi4wIKXMDSoASAFQAw%3D%3D" target="_blank">
        <img src="<?php echo PART_IMAGES ?>maps.webp" alt="Map Image" style="width: 100%; height: auto;">
    </a>
</div>
