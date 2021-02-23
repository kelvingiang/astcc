<?php

class Admin_Slider_controler {

    public function __construct() {
        add_action('init', array($this, 'register_post'));
        add_action('manage_edit-slide_columns', array($this, 'manage_cols'));
        add_action('manage_slide_posts_custom_column', array($this, 'render_cols'));
    }

    public function register_post() {
        $labels = array(
            'name' => _x('幻燈片 1380 x 430 ', 'suite'),
            'singular_name' => _x('幻燈片', 'suite'),
            'add_new' => _x('新增幻燈片', 'suite'),
            'add_new_item' => _x('新增幻燈片', 'suite'),
            'edit_item' => _x('修改幻燈片', 'suite'),
            'new_item' => _x('新增幻燈片', 'suite'),
            'all_items' => _x('幻燈片名單', 'suite'),
            'view_item' => _x('View Slide', 'suite'),
            'search_items' => _x('Search Slides', 'suite'),
            'not_found' => _x('No slides found.', 'suite'),
            'not_found_in_trash' => _x('No slides found in Trash.', 'suite'),
            'parent_item_colon' => '',
            'menu_name' => _x('幻燈片', 'suite')
        );
        $args = array(
            'labels' => $labels,
            'public' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_icon' => ICON_DIR . 'admin16x16.png',
            'query_var' => true,
            'rewrite' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 17,
            'supports' => array('title', 'thumbnail')
        );
        register_post_type('slide', $args);
    }

    public function manage_cols($columns) {
        //  $title_label = _x('標題', 'suite');
        //  $date_label = _x($columns['date'], 'suite'); // get data form columns defauld;

        $columns['title']; // 
        $columns['slide_img'] = _x('照片', 'suite');
        unset($columns['date']);
        $columns['order'] = _x('次序', 'suite');
        $columns['date'] = _x('日期', 'suite');

        return $columns;
    }

    public function render_cols($columns) {
        global $post;
        if ($columns == 'slide_img') {
            if (has_post_thumbnail()) {
                ?>
                <img class='img-link' style='margin-bottom: 8px; height: 80px' src=" <?php the_post_thumbnail_url() ?>"/>
            <?php
            }
        }
        
        if($columns == 'order'){
            echo get_post_meta($post->ID, '_show_order', true);
        }
    }

}
