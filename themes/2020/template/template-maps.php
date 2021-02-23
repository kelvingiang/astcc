<div class="row-2">
    <div class="fluid_container">
        <div id="map_canvas" style="position: relative; z-index: 28 ; height: 400px;  width: 100%; margin: 0 auto ;  border-bottom: 3px green solid; border-top: 3px green solid"></div>
    </div>
</div>


<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
    var map;
    function initialize() {
        // read json chuyen thanh du lien cua javacsript 

        var position = new google.maps.LatLng(<?php echo get_option('map_x'); ?>, <?php echo get_option('map_y'); ?>);
        var myOptions = {
            zoom: 17,
            center: position,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById('map_canvas'),
                myOptions);

        var marker = new google.maps.Marker({
            position: position,
            map: map
        });

        var myWindowOptions = {
            content: '<b style="color:red"><?php echo get_option('chamber_name') ?></b>'
        };

        var myInfoWindow = new google.maps.InfoWindow(myWindowOptions);

        //google.maps.event.addListener(marker, 'click', function() {
        myInfoWindow.open(map, marker);
        //});

        map.setCenter(position);
    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script> 

<!-- DANG KY BANG GMAIL DE SU DUNG GOOGLEMAPS https://developers.google.com/maps/documentation/javascript/adding-a-google-map#key-->
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBAV4v2qSBuCA1Rn7NPd09exwP4smcjW_g&callback=initMap">
</script>