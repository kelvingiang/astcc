<?php
class Admin_Link_business_controler {

    public function __construct() {
        add_action('init', array($this, 'register_post'));
        add_action('manage_edit-businesslink_columns', array($this, 'manage_cols'));
        add_action('manage_businesslink_posts_custom_column', array($this, 'render_cols'));
    }

    public function register_post() {
        $labels = array(
            'name' => __('商情資訊'),
            'singular_name' => __('商情資訊'),
            'add_new' => _x('新增', 'suite'),
            'add_new_item' => _x('新增', 'suite'),
            'new_item' => __('新增'),
            'edit_item' => __('修改'),
            'all_items' => __('商情資訊'),
            'view_item' => __('View'),
            'search_items' => __('Search'),
            'not_found' => __('No Found'),
            'not_found_in_trash' => __('No Found Any Friendl link'),
            'parent_item_colon' => '',
            'menu_name' => __('商情資訊'),
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_icon' => ICON_DIR . 'link16x16.png',
            'query_var' => true,
            'rewrite' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 13,
            'supports' => array('title')
        );
        register_post_type('businesslink', $args);
    }

    public function manage_cols($columns) {
        $columns['title'];
        unset($columns['date']); 
        unset($columns['content']);
       // $columns['website'] = _x('網 頁', 'suite');
        $columns['date'] = _x('日期',' suite');

        return $columns;
    }

    public function render_cols($columns) {
        global $post;

        if ($columns == 'website') {
            echo get_post_meta($post->ID, '_metabox_website', true);
        }
    }

}
