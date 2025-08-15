<?php

class Admin_Metabox_Order {

    public function __construct() {
        add_action('add_meta_boxes', array($this, 'create'));
        add_action('save_post', array($this, 'save'));
    }

    public function create() {
        $id = 'admin-metabox-order';
        $title = __('次序排列');
        $callback = array($this, 'display');
        add_meta_box($id, $title, $callback, array('post','conference','chamber','advertising','businesslink','friendlink','slide','branch'));
    }

    public function display($post) {
        $action = 'admin-metabox-data';
        $name = 'admin-metabox-data-nonce';
        wp_nonce_field($action, $name);
        $post_id = $post->ID;
        //   $checkValue = get_post_meta($post->ID, '_show_home_page', true) == 1 ? "checked" : " ";
        ?>
        <div class="meta-row">
            <div class="title-cell">
                <label class="title_text"><?php echo __('次序'); ?> <i><?php echo __('排列是從大到石小') ?></i></label>
            </div>
            <div class="text-cell">
                <?php $order_val = get_post_meta($post_id, '_show_order', TRUE) == "" ? '01' :  get_post_meta($post_id, '_show_order', TRUE);   ?>
                <input type="text" name="txt-order" id="txt-order" class="txt_input type-number" value="<?php echo $order_val ?>"  /> 
            </div>
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
        // if (define('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        //     return $post_id;

        if (!current_user_can('edit_post', $post_id))
            return$post_id;

        // 4 BON PHAN TREN DUNG DE BAO MAT KHI LUU METABOX TRONG WP 
        if (!empty($_POST['txt-order'])) {
            update_post_meta($post_id, '_show_order', $_POST['txt-order']);
        }


//==== tra ve trang grid============================================
        add_action('redirect_post_location', 'custom_redirect');
    }

}
