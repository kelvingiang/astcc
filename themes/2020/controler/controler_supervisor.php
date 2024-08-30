<?php

class Admin_Controler_Supervisor
{

    public function __construct()
    {
        add_action('init', array($this, 'register_post'));
        add_action('manage_edit-supervisor_columns', array($this, 'manage_cols'));
        add_action('manage_supervisor_posts_custom_column', array($this, 'render_cols'));

        add_action('init', array($this, 'register_taxonomy'));
    }

    public function register_post()
    {
        $labels = array(
            'name' => _x('歷屆會長', 'suite'),
            'singular_name' => _x('歷屆會長', 'suite'),
            'add_new' => _x('新增', 'suite'),
            'add_new_item' => _x('新增', 'suite'),
            'edit_item' => _x('修改', 'suite'),
            'new_item' => _x('新成員', 'suite'),
            'all_items' => _x('所有', 'suite'),
            'view_item' => _x('顯示', 'suite'),
            'search_items' => _x('查询', 'suite'),
            'not_found' => _x('No slides found.', 'suite'),
            'not_found_in_trash' => _x('No  found in Trash.', 'suite'),
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
            'supports' => array('title', 'thumbnail', 'editor'),
        );
        register_post_type('supervisor', $args);
    }

    // tao function thay doi hien thi mac dinh
    public function manage_cols($columns)
    {
        $columns['title']; // cho an cot title mac dinh;
        unset($columns['date']); // an cot ngay mac dinh
        unset($columns['order']);
        unset($columns['content']);
        unset($columns['taxonomy-supervisor_cate']);
        unset($columns['home']);
        $columns['supervisor_image'] = _x('照片', 'suite');
        // $columns['content'] = _x('職稱', 'suite');
        // them cot vao bang 
        $columns['job_title'] = _x('職稱', 'suite');
        // $columns['current'] = _x('現任', 'suite');
        $columns['order'] = _x('次序', 'suite');
        $columns['taxonomy-supervisor_cate'] = _x('類別', 'suite');
        $columns['date'] = __('Create Date', 'suite');

        return $columns;
    }

    // function dua noi dung vao cac cot moi  tạo
    public function render_cols($columns)
    {
        global $post;
        if ($columns == 'supervisor_image') {
            if (has_post_thumbnail()) {
                the_post_thumbnail(array(30, 30));  // Other resolutions);
                //  set_post_thumbnail_size(50, 50); // 50 pixels wide by 50 pixels tall, resize mode
            }
        }
        if ($columns == 'job_title') {
            echo get_post_meta($post->ID, '_metabox_job_title', true);
        }

        // if ($columns == 'current') {
        //     $ss = get_post_meta($post->ID, '_admin_metabox_special', true);
        //     if ($ss == 'on') {
        //         echo "<img src='" . PART_ICON . "active32x32.png'>";
        //     }
        // }
        //show product thumb
        //    $img = get_post_meta($post->ID, 'm_image', true);
        //    if ($columns == 'member_image') {
        //        echo '<img  style="width:30px; height: 30px; border-radius: 3px; border: 1px #999 solid" class="attachment-post-thumbnail wp-post-image" src="' . get_image('avata/' . $img) . '">';
        //    }
    }


    // tao taxomomy 
    public function register_taxonomy()
    {
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
        register_taxonomy('supervisor_cate', 'supervisor', array(
            'labels' => $labels,
            'public' => true,
            //'show_ui' => true,
            'show_tagcloud' => true,
            'hierarchical' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'supervisor-category',
            )
        ));
    }
}
