<?php

class Admin_Controler_Chamber {

    public function __construct() {
        add_action('init', array($this, 'register_post'));
        add_action('manage_edit-chamber_columns', array($this, 'manage_cols'));
        add_action('manage_chamber_posts_custom_column', array($this, 'render_cols'));
        //====== tao taxonomy =========
       // add_action('init', array($this, 'register_taxonomy'));

        //==== tao tag============================================
        //  add_action('init', array($this, 'register_tag'));
        //==== xap xep ============================================
        add_filter('manage_edit-chamber_sortable_columns', array($this, 'sortable_views_column'));
        add_filter('request', array($this, 'sort_views_column'));
    }

    public function register_post() {
        $labels = array(
            'name' => _x('各國總會', 'suite'),
            'singular_name' => _x('各國總會', 'suite'),
            'add_new' => _x('新增', 'suite'),
            'add_new_item' => _x('新增', 'suite'),
            'edit_item' => _x('修改', 'suite'),
            'new_item' => _x('新增', 'suite'),
            'all_items' => _x('各國總會', 'suite'),
            'view_item' => _x('各國總會', 'suite'),
            'search_items' => _x('查询', 'suite'),
            'not_found' => _x('No slides found.', 'suite'),
            'not_found_in_trash' => _x('No  found in Trash.', 'suite'),
            'parent_item_colon' => '',
            'menu_name' => _x('各國總會', 'suite')
        );
        $args = array(
            'labels' => $labels,
            'public' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_icon' => PART_ICON . 'admin16x16.png',
            'query_var' => true,
            'rewrite' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 11,
            'supports' => array('title', 'thumbnail', 'editor'),
        );
        register_post_type('chamber', $args);
    }

    // tao function thay doi hien thi mac dinh
    public function manage_cols($columns) {
        $columns['title']; // cho an cot title mac dinh;
        unset($columns['date']); // an cot ngay mac dinh
        // them cot vao bang 
        $columns['supervisor_image'] = _x('照片', 'suite');
        $columns['order'] = _x('次序', 'suite');
        $columns['date'] = __('Create Date', 'suite');

        return $columns;
    }

// function dua noi dung vao cac cot moi  tạo
    public function render_cols($columns) {
        global $post;

        if ($columns == 'supervisor_image') {
            if (has_post_thumbnail()) {
                the_post_thumbnail(array(80, 80));  // Other resolutions);
                //  set_post_thumbnail_size(50, 50); // 50 pixels wide by 50 pixels tall, resize mode
            }
        }
//        if ($columns == 'content') {
//            the_content();
//        }
        //show product thumb
//    $img = get_post_meta($post->ID, 'm_image', true);
        if ($columns == 'order') {
            echo get_post_meta($post->ID, '_show_order', true);
        }
    }

    //==========================================================
    // tao taxomomy 
    public function register_taxonomy() {
        $labels = array(
            'name' => __('Category'),
            'singular_name' => __('Category'),
            'search_items' => __('Search Categories'),
            'all_items' => __('Categories'),
            'parent_item' => __('Parent Category'),
            'parent_item_colon' => __('Parent Category'),
            'edit_item' => __('Edit Category'),
            'update_item' => __('Update Category'),
            'add_new_item' => __('Add New Category'),
            'new_item_name' => __('New Category Name'),
            'menu_name' => __('Category')
        );
        register_taxonomy('chamber_cate', 'chamber', array(
            'labels' => $labels,
            'public' => true,
            //'show_ui' => true,
            'show_tagcloud' => true,
            'hierarchical' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'chamber-category',
            )
        ));
    }

    //============================================================
    // tao tag
    public function register_tag() {
        $labels = array(
            'name' => __('Tags'),
            'singular_name' => __('Tags'),
            'search_items' => __('Search'),
            'all_items' => __(' Tags'),
            // 'parent_item' => _x('Parent Category', 'dp'),
            // 'parent_item_colon' => _x('Parent Category:', 'dp'),
            'edit_item' => __('Edit'),
            'update_item' => __('Update'),
            'add_new_item' => __('Add New'),
            'new_item_name' => __('Add New'),
            'menu_name' => __('Tags')
        );
        register_taxonomy('chamber_tag', 'chamber', array(
            'hierarchical' => FALSE, // neu la tags ta khai bao la false, la category la true 
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'chamber-tag',
                'hierarchical' => true
            )
        ));
    }

    //==== sap xep lai thu tu ============================================
    public function sortable_views_column($newcolumn) {
        $newcolumn['order'] = 'order';
        return $newcolumn;
    }

    public function sort_views_column($vars) {
        if (isset($vars['orderby']) && 'order' == $vars['orderby']) {
            $vars = array_merge($vars, array(
                'meta_key' => '_show_order', //Custom field key
                'orderby' => '_show_order' //Custom field value (number)
                    )
            );
        };
        return $vars;
    }

}
