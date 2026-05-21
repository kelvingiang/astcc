<?php

class Admin_Metabox_Commerce {

    public function __construct() {
        add_action('add_meta_boxes', array($this, 'create'));
        add_action('save_post', array($this, 'save'));
    }

    public function create() {
        $id = 'admin-metabox-countries';
        $title = '聯　絡　資　訊';
        $callback = array($this, 'display');
        add_meta_box($id, $title, $callback, array('commerce'));
    }

    public function display($post) {
        $action = 'admin-metabox-data';
        $name = 'admin-metabox-data-nonce';
        wp_nonce_field($action, $name);
        $post_id = $post->ID;
        $countryCode = get_post_meta($post_id, '_HH_country', true);
        ?>
        <div class ="content">
            <div class ="cell-one"> <lable class="label-admin"> 國 家 </label></div>
            <div class ="cell-two"> 
                <select id='HH_country' name='HH_country' style='width: 100px'>
                    <?php foreach (get_guests_country() as $key => $val) { ?>
                        <option value='<?php echo $key ?>' <?php echo $countryCode == $key ? 'selected' : '' ?>  > <?php echo $val ?> </option>
                     <?php } ?>
                </select>
            </div>
        </div>
        <div class ="content">
            <div class ="cell-one"> <lable class="label-admin"> 總會長 </label></div>
            <div class ="cell-two"> <input type="text" id="HH_name" name="HH_name" value="<?php echo get_post_meta($post_id, '_HH_name', true); ?>"/>  </div>
        </div>
        <div class ="content">
            <div class ="cell-one"> <lable class="label-admin">地址 </label></div>
            <div class ="cell-two"> <input type="text" id="HH_address" name="HH_address" value="<?php echo get_post_meta($post_id, '_HH_address', true) ?>" />  </div>
        </div>
        <div class ="content">
            <div class ="cell-one"> <lable class="label-admin"> 電話 </label></div>
            <div class ="cell-two"> <input type="text" id="HH_tel" name="HH_tel" value="<?php echo get_post_meta($post_id, '_HH_tel', true) ?>"/>  </div>
        </div>
        <div class ="content">
            <div class ="cell-one"> <lable class="label-admin"> 傳真</label></div>
            <div class ="cell-two"> <input type="text" id="HH_fax" name="HH_fax" value="<?php echo get_post_meta($post_id, '_HH_fax', true) ?>"/>  </div>
        </div>
        <div class ="content">
            <div class ="cell-one"> <lable class="label-admin"> Email </label></div>
            <div class ="cell-two"> <input type="text" id="HH_email" name="HH_email" value="<?php echo get_post_meta($post_id, '_HH_email', true) ?>"/>  </div>
        </div>
     <div class ="content">
            <div class ="cell-one"> <lable class="label-admin"> 網站 </label></div>
            <div class ="cell-two"> <input type="text" id="HH_web" name="HH_web" value="<?php echo get_post_meta($post_id, '_HH_web', true) ?>"/>  </div>
        </div>
        <?php
    }

    public function save($post_id) {
//        echo '<pre>';
//        print_r($_POST);
//        echo '</pre>';
//        die();
        // kiem thanh phan an bao mat cua wp
        // NEU HAM NAY TRA VE GIA TRI  LA TRUE THUC HIEN TIEP CAC PHAN DUOI , CON TRA VE FLASE return VE $post_id
        if (!isset($_POST['admin-metabox-data-nonce']))
            return$post_id;
        // NEU HAM NAY TRA VE GIA TRI  LA TRUE THUC HIEN TIEP CAC PHAN DUOI , CON TRA VE FLASE return VE $post_id 
        if (wp_verify_nonce('admin-metabox-data-nonce', 'admin-metabox-data'))
            return $post_id;
        // HAM TU DONG LUU KHI DE QUA LAU NEU TRA VE FLASE return $post_id
        // if (define('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        if (!current_user_can('edit_post', $post_id))
            return$post_id;


        // 4 BON PHAN TREN DUNG DE BAO MAT KHI LUU METABOX TRONG WP 
        if (!empty($_POST['HH_name'])) {
            update_post_meta($post_id, '_HH_name', $_POST['HH_name']);
        }
        if (!empty($_POST['HH_email'])) {
            update_post_meta($post_id, '_HH_email', $_POST['HH_email']);
        }
        if (!empty($_POST['HH_tel'])) {
            update_post_meta($post_id, '_HH_tel', $_POST['HH_tel']);
        }
        if (!empty($_POST['HH_fax'])) {
            update_post_meta($post_id, '_HH_fax', $_POST['HH_fax']);
        }

        if (!empty($_POST['HH_address'])) {
            update_post_meta($post_id, '_HH_address', $_POST['HH_address']);
        }
        
         if (!empty($_POST['HH_web'])) {
            update_post_meta($post_id, '_HH_web', $_POST['HH_web']);
        }

        if ($_POST['HH_country'] != '00') {
            update_post_meta($post_id, '_HH_country', $_POST['HH_country']);
        }
    }

}
?>
