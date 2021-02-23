<?php

class Admin_Metabox_Country {

    public function __construct() {
        add_action('add_meta_boxes', array($this, 'create'));
        add_action('save_post', array($this, 'save'));
    }

    public function create() {
        $id = 'admin-metabox-country';
        $title = '國 家';
        $callback = array($this, 'display');
        add_meta_box($id, $title, $callback, array('post', 'conference'));
    }

    public function display($post) {
        $action = 'admin-metabox-data';
        $name = 'admin-metabox-data-nonce';
        wp_nonce_field($action, $name);
        $country = get_post_meta($post->ID, '_admin_metabox_country', TRUE);
        ?>
        <div class=" content">
            <div class="cell-one"><label class="admin-title">國 家</label> </div>
            <div class="cell-two">
                <select id="sel-country" name="sel-country">
                    <?php foreach (get_guests_country() as $key => $val) { ?>
                        <option  <?php echo $country == $key ? 'selected = selected' : '' ?> value="<?php echo $key ?>"> <?php echo $val ?> </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <?php
    }

    public function save($post_id) {
        // kiem thanh phan an bao mat cua wp
        // NEU HAM NAY TRA VE GIA TRI  LA TRUE THUC HIEN TIEP CAC PHAN DUOI , CON TRA VE FLASE return VE $post_id
        if (!isset($_POST['admin-metabox-data-nonce']))
            return $post_id;
        // NEU HAM NAY TRA VE GIA TRI  LA TRUE THUC HIEN TIEP CAC PHAN DUOI , CON TRA VE FLASE return VE $post_id 
        if (wp_verify_nonce('admin-metabox-data-nonce', 'admin-metabox-data'))
            return $post_id;
        // HAM TU DONG LUU KHI DE QUA LAU NEU TRA VE FLASE return $post_id
        if (define('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        if (!current_user_can('edit_post', $post_id))
            return $post_id;
        // 4 BON PHAN TREN DUNG DE BAO MAT KHI LUU METABOX TRONG WP 
        update_post_meta($post_id, '_admin_metabox_country', $_POST['sel-country']);
    }

}
