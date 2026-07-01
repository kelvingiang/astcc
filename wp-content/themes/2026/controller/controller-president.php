<?php

class Admin_Controller_President {

    public function __construct() {
        add_action('init', array($this, 'register_post'));
        add_action('manage_edit-president_columns', array($this, 'manage_cols'));
        add_action('manage_president_posts_custom_column', array($this, 'render_cols'));
    }

    public function register_post() {
        $labels = array(
            'name' => _x('會長', 'suite'),
            'singular_name' => _x('會長', 'suite'),
            'add_new' => _x('新增會長', 'suite'),
            'add_new_item' => _x('新增', 'suite'),
            'edit_item' => _x('修改', 'suite'),
            'new_item' => _x('新增', 'suite'),
            'all_items' => _x('所有會長', 'suite'),
            'view_item' => _x('顯示會長', 'suite'),
            'search_items' => _x('查询', 'suite'),
            'not_found' => _x('No slides found.', 'suite'),
            'not_found_in_trash' => _x('No 會長 found in Trash.', 'suite'),
            'parent_item_colon' => '',
            'menu_name' => _x('歷屆會長', 'suite')
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
            'supports' => array('title', 'thumbnail'),
        );
        register_post_type('president', $args);
    }

    // tao function thay doi hien thi mac dinh
    public function manage_cols($columns) {
        $date_label = _x('Create Date', 'suite');

        $columns['title']; // cho an cot title mac dinh;
        unset($columns['date']); // an cot ngay mac dinh
        $columns['content'] = _x('職稱','suite');
        // them cot vao bang 
        $columns['president_image'] = _x('照片', 'suite');
        $columns['date'] = $date_label;

        return $columns;
    }

// function dua noi dung vao cac cot moi  tạo
    public function render_cols($columns) {
        if ($columns == 'president_image') {
            if (has_post_thumbnail()) {
                the_post_thumbnail(array(80,80) );  // Other resolutions);
              //  set_post_thumbnail_size(50, 50); // 50 pixels wide by 50 pixels tall, resize mode
            }
        }
        if($columns == 'content'){
            the_content();
        }
        //show product thumb
//    $img = get_post_meta($post->ID, 'm_image', true);
//    if ($columns == 'member_image') {
//        echo '<img  style="width:30px; height: 30px; border-radius: 3px; border: 1px #999 solid" class="attachment-post-thumbnail wp-post-image" src="' . get_image('avata/' . $img) . '">';
//    }
    }

}
