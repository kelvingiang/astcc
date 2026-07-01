<?php
class Admin_Controller_Countries{
    public  function __construct() {
        add_action('init', array($this, 'register_post'));
        add_action('manage_edit-countries_columns', array($this, 'manage_cols'));
        add_action('manage_countries_posts_custom_column', array($this, 'render_cols'));
    }
    
     public function register_post() {
        $labels = array(
            'name' => _x('各國通訊', 'suite'),
            'singular_name' => _x('各國通訊', 'suite'),
            'add_new' => _x('新增通訊', 'suite'),
            'add_new_item' => _x('新增通訊', 'suite'),
            'edit_item' => _x('修改通訊', 'suite'),
            'new_item' => _x('新通訊', 'suite'),
            'all_items' => _x('亞總各國通訊', 'suite'),
            'view_item' => _x('顯示亞總各國通訊', 'suite'),
            'search_items' => _x('查询', 'suite'),
            'not_found' => _x('找不到資料.', 'suite'),
            'not_found_in_trash' => _x('回收桶找不到資料', 'suite'),
            'parent_item_colon' => '',
            'menu_name' => _x('各國通訊', 'suite')
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
            'menu_position' => 4,
            'supports' => array('title', 'thumbnail'),
        );
        register_post_type('countries', $args);
    }
    
    public function manage_cols($columns){
                $date_label = _x('Create Date', 'suite');

        $columns['title']; // cho an cot title mac dinh;
        unset($columns['date']); // an cot ngay mac dinh
        $columns['hoitruong'] = _x('總會長','suite');
        $columns['thuky'] = _x('秘書長','suite');
        $columns['email'] = _x('Email','suite');
        $columns['phone'] = _x('電話','suite');
        // them cot vao bang 
        $columns['date'] = $date_label;

        return $columns;
    }
    
    public function render_cols($columns){
         global $post;
        switch ($columns){
            case 'hoitruong' :
                echo get_post_meta($post->ID, '_HT_name', true);
                break;
            case 'thuky':
                echo get_post_meta($post->ID,'_TK_name',true);
                break;
            case 'email' :
                echo get_post_meta($post->ID,'_HT_email',true);
                break;
            case 'phone':
                echo get_post_meta($post->ID,'_HT_tel',true);
                break;
        }
    }
}
