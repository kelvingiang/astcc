<?php

class Admin_Metabox_Countries {

    public function __construct() {
        add_action('add_meta_boxes', array($this, 'create'));
        add_action('save_post', array($this, 'save'));
    }

    public function create() {
        $id = 'admin-metabox-countries';
        $title = '聯　絡　資　訊';
        $callback = array($this, 'display');
        add_meta_box($id, $title, $callback, array('countries'));
    }

    public function display($post) {
        $action = 'admin-metabox-data';
        $name = 'admin-metabox-data-nonce';
        wp_nonce_field($action, $name);
        $post_id = $post->ID
        ?>
        <div class ="content">
            <div class ="cell-one"> <lable class="label-admin"> 總會長 </label></div>
            <div class ="cell-two"> <input type="text" id="HT_name" name="HT_name" value="<?php echo get_post_meta($post_id, '_HT_name', true); ?>"/>  </div>
        </div>
        <div class ="content">
            <div class ="cell-one"> <lable class="label-admin"> 總會長 email </label></div>
            <div class ="cell-two"> <input type="text" id="HT_email" name="HT_email" value="<?php echo get_post_meta($post_id, '_HT_email', true) ?>" />  </div>
        </div>
        <div class ="content">
            <div class ="cell-one"> <lable class="label-admin"> 總會長電話 </label></div>
            <div class ="cell-two"> <input type="text" id="HT_tel" name="HT_tel" value="<?php echo get_post_meta($post_id, '_HT_tel', true) ?>"/>  </div>
        </div>
        <div class ="content">
            <div class ="cell-one"> <lable class="label-admin"> 總會長傳真</label></div>
            <div class ="cell-two"> <input type="text" id="HT_fax" name="HT_fax" value="<?php echo get_post_meta($post_id, '_HT_fax', true) ?>"/>  </div>
        </div>
<hr style="border: 2px solid #D9D5D5">
  <div class ="content">
            <div class ="cell-one"> <lable class="label-admin"> 秘書長 </label></div>
            <div class ="cell-two"> <input type="text" id="TK_name" name="TK_name" value="<?php echo get_post_meta($post_id, '_TK_name', true) ?>"/>  </div>
        </div>
        <div class ="content">
            <div class ="cell-one"> <lable class="label-admin"> 秘書長 email </label></div>
            <div class ="cell-two"> <input type="text" id="TK_email" name="TK_email" value="<?php echo get_post_meta($post_id, '_TK_email', true) ?>"/>  </div>
        </div>
        <div class ="content">
            <div class ="cell-one"> <lable class="label-admin"> 秘書長電話 </label></div>
            <div class ="cell-two"> <input type="text" id="TK_tel" name="TK_tel" value="<?php echo get_post_meta($post_id, '_TK_tel', true) ?>"/>  </div>
        </div>
        <div class ="content">
            <div class ="cell-one"> <lable class="label-admin"> 秘書長傳真</label></div>
            <div class ="cell-two"> <input type="text" id="TK_fax" name="TK_fax" value="<?php echo get_post_meta($post_id, '_TK_fax', true) ?>"/>  </div>
        </div>
<hr style="border: 2px solid #D9D5D5">
  <div class ="content">
            <div class ="cell-one"> <lable class="label-admin"> 秘書處 </label></div>
            <div class ="cell-two"> <input type="text" id="VP_name" name="VP_name" value="<?php echo get_post_meta($post_id, '_VP_name', true) ?>"/>  </div>
        </div>
        <div class ="content">
            <div class ="cell-one"> <lable class="label-admin"> 秘書處 email </label></div>
            <div class ="cell-two"> <input type="text" id="VP_email" name="VP_email" value="<?php echo get_post_meta($post_id, '_VP_email', true) ?>"/>  </div>
        </div>
        <div class ="content">
            <div class ="cell-one"> <lable class="label-admin"> 秘書處電話 </label></div>
            <div class ="cell-two"> <input type="text" id="VP_tel" name="VP_tel" value="<?php echo get_post_meta($post_id, '_VP_tel', true) ?>"/>  </div>
        </div>
        <div class ="content">
            <div class ="cell-one"> <lable class="label-admin"> 秘書處傳真</label></div>
            <div class ="cell-two"> <input type="text" id="VP_fax" name="VP_fax" value="<?php echo get_post_meta($post_id, '_VP_fax', true) ?>"/>  </div>
        </div>
        <?php
    }

    public function save($post_id) {
        // kiem thanh phan an bao mat cua wp
        // NEU HAM NAY TRA VE GIA TRI  LA TRUE THUC HIEN TIEP CAC PHAN DUOI , CON TRA VE FLASE return VE $post_id
        if (!isset($_POST['admin-metabox-data-nonce']))
            return$post_id;
        // NEU HAM NAY TRA VE GIA TRI  LA TRUE THUC HIEN TIEP CAC PHAN DUOI , CON TRA VE FLASE return VE $post_id 
        if (wp_verify_nonce('admin-metabox-data-nonce', 'admin-metabox-data'))
            return $post_id;
        // HAM TU DONG LUU KHI DE QUA LAU NEU TRA VE FLASE return $post_id
        if (define('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        if (!current_user_can('edit_post', $post_id))
            return$post_id;
        
       
        // 4 BON PHAN TREN DUNG DE BAO MAT KHI LUU METABOX TRONG WP 
         if(!empty($_POST['HT_name'])){
           update_post_meta($post_id, '_HT_name', $_POST['HT_name']);
         }
         if(!empty($_POST['HT_email'])){
           update_post_meta($post_id, '_HT_email', $_POST['HT_email']);
         }
          if(!empty($_POST['HT_tel'])){
           update_post_meta($post_id, '_HT_tel', $_POST['HT_tel']);
         }
          if(!empty($_POST['HT_fax'])){
           update_post_meta($post_id, '_HT_fax', $_POST['HT_fax']);
         }
         
           if(!empty($_POST['TK_name'])){
           update_post_meta($post_id, '_TK_name', $_POST['TK_name']);
         }
         if(!empty($_POST['TK_email'])){
           update_post_meta($post_id, '_TK_email', $_POST['TK_email']);
         }
          if(!empty($_POST['TK_tel'])){
           update_post_meta($post_id, '_TK_tel', $_POST['TK_tel']);
         }
          if(!empty($_POST['TK_fax'])){
           update_post_meta($post_id, '_TK_fax', $_POST['TK_fax']);
         }
         
         if(!empty($_POST['VP_name'])){
           update_post_meta($post_id, '_VP_name', $_POST['VP_name']);
         }
         if(!empty($_POST['VP_email'])){
           update_post_meta($post_id, '_VP_email', $_POST['VP_email']);
         }
          if(!empty($_POST['VP_tel'])){
           update_post_meta($post_id, '_VP_tel', $_POST['VP_tel']);
         }
          if(!empty($_POST['VP_fax'])){
           update_post_meta($post_id, '_VP_fax', $_POST['VP_fax']);
         }
    }

}
?>
