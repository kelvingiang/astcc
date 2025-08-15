<?php

class Admin_Metabox_Seo {

    public function __construct() {
        add_action('add_meta_boxes', array($this, 'create'));
        add_action('save_post', array($this, 'save'));
    }

    public function create() {
        $id = 'admin-metabox-seo';
        $title = 'Seo Google';
        $callback = array($this, 'display');
        add_meta_box($id, $title, $callback, array('post','conference'));
    }

    public function display($post) {
        $custom = get_post_custom($post->ID);

        if (isset($custom['_seo_title'][0])) {
            $seo_title = $custom['_seo_title'][0];
        }
        if (isset($custom['_seo_description'][0])) {
            $seo_description = $custom['_seo_description'][0];
        }
        if (isset($custom['_seo_keywords'][0])) {
            $seo_keywords = $custom['_seo_keywords'][0];
        }
        wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');


        if (!empty($seo_title)) {
            $seo_title_val = $seo_title;
        }
        if (!empty($seo_keywords)) {
            $seo_keywords_val = $seo_keywords;
        }
        if (!empty($seo_description)) {
            $seo_description_val = $seo_description;
        }
        ?>
        <p>
            <label for="seo_title" class="label-admin"><?php _e('SEO 標題') ?></label>
            <input type="text" id="seo_title" name="seo_title" value="<?php echo $seo_title_val ?>" style="display: block; width: 100%"/>
        </p>
        <p>
            <label for="seo_description" class="label-admin"><?php _e('SEO 描述 ') ?></label>
            <textarea id="seo_description" name="seo_description" style="display: block; width: 100%"><?php echo $seo_description_val; ?></textarea>
        </p>
        <p>
            <label for="seo_keywords" class="label-admin"><?php _e('SEO 關鍵字') ?></label>
            <textarea id="seo_keywords" name="seo_keywords" style="display: block; width: 100%"><?php echo $seo_keywords_val; ?></textarea>
        </p>
        <?php
    }

    public function save($post_id) {

        // if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        //     return;
        // }

        //Custom fields
        if (isset($_POST['seo_title'])) {
            update_post_meta($post_id, '_seo_title', esc_attr($_POST['seo_title']));
        }
        if (isset($_POST['seo_description'])) {
            update_post_meta($post_id, '_seo_description', esc_attr($_POST['seo_description']));
        }
        if (isset($_POST['seo_keywords'])) {
            update_post_meta($post_id, '_seo_keywords', esc_attr($_POST['seo_keywords']));
        }
    }

}
