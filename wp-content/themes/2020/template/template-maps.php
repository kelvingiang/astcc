<div id="map_canvas" style="position: relative; z-index: 28 ; height: 400px;  width: 100%; margin: 0 auto"></div>

<script type="text/javascript">
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
</script>

<!-- ✅ 僅保留這一行載入 Maps API，指定 callback=initMap -->
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBAV4v2qSBuCA1Rn7NPd09exwP4smcjW_g&callback=initMap">
</script>
