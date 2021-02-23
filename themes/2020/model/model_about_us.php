<?php

class Admin_Model_About_Us {

    public function __construct() {
        
    }

    public function Save($arr) {

        update_option("chamber_name", $arr['txt-chamber']);
        update_option("contact_us_name", $arr['txt-name']);
        update_option("contact_us_address", $arr['txt-address']);
        update_option("contact_us_mobile", $arr['txt-mobile']);
        update_option("contact_us_phone", $arr['txt-phone']);
        update_option("contact_us_fax", $arr['txt-fax']);
        update_option("contact_us_email", $arr['txt-email']);
        update_option("map_x", $arr['txt-map-x']);
        update_option("map_y", $arr['txt-map-y']);

        update_post_meta(1, '_info_charter', $arr['info-charter']);
        update_post_meta(1, '_info_history', $arr['info-history']);
        update_post_meta(1, '_info_picture', $arr['info-picture']);
    }

}
