<?php

class Admin_Controler_Commerce
{

    public function __construct()
    {
        add_action('init', array($this, 'register_post'));
        add_action('manage_edit-commerce_columns', array($this, 'manage_cols'));
        add_action('manage_commerce_posts_custom_column', array($this, 'render_cols'));

        add_filter('manage_edit-commerce_sortable_columns', array($this, 'views_sort_column'));
        add_filter('request', array($this, 'views_sort_key'));
    }

    public function register_post()
    {
        $labels = array(
            'name' => _x('各國商會', 'suite'),
            'singular_name' => _x('各國商會', 'suite'),
            'add_new' => _x('新增商會', 'suite'),
            'add_new_item' => _x('新增商會', 'suite'),
            'edit_item' => _x('修改商會', 'suite'),
            'new_item' => _x('新商會', 'suite'),
            'all_items' => _x('亞總各國商會', 'suite'),
            'view_item' => _x('顯示亞總各國商會', 'suite'),
            'search_items' => _x('查询', 'suite'),
            'not_found' => _x('找不到資料.', 'suite'),
            'not_found_in_trash' => _x('回收桶找不到資料', 'suite'),
            'parent_item_colon' => '',
            'menu_name' => _x('各國商會', 'suite')
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
            'menu_position' => 5,
            'supports' => array('title', 'thumbnail'),
        );
        register_post_type('commerce', $args);
    }

    public function manage_cols($columns)
    {
        $columns['title']; // cho an cot title mac dinh;
        unset($columns['date']); // an cot ngay mac dinh
        unset($columns['content']); // an cot ngay mac dinh
        unset($columns['order']); // an cot ngay mac dinh
        unset($columns['home']); // an cot ngay mac dinh
        $columns['country'] = _x('國家', 'suite');
        $columns['hoitruong'] = _x('會長', 'suite');
        // $columns['address'] = _x('地 址', 'suite');
        $columns['website'] = _x('網站', 'suite');
        $columns['email'] = _x('Email', 'suite');
        $columns['phone'] = _x('電 話', 'suite');
        // them cot vao bang 
        $columns['date'] = __('Create Date', 'suite');

        return $columns;
    }

    public function render_cols($columns)
    {
        global $post;
        switch ($columns) {
            case 'country':
                echo get_country(get_post_meta($post->ID, '_HH_country', true));
                break;
            case 'hoitruong':
                echo get_post_meta($post->ID, '_HH_name', true);
                break;
                // case 'address':
                //     echo get_post_meta($post->ID, '_HH_address', true);
                //     break;
            case 'website':
                echo get_post_meta($post->ID, '_HH_web', true);
                break;
            case 'email':
                echo get_post_meta($post->ID, '_HH_email', true);
                break;
            case 'phone':
                echo get_post_meta($post->ID, '_HH_tel', true);
                break;
        }
    }

    public function views_sort_column($newcolumn)
    {
        $newcolumn['country'] = 'country';
        return $newcolumn;
    }

    public function views_sort_key($vars)
    {
        if (isset($vars['orderby']) && 'country' == $vars['orderby']) {
            $vars = array_merge(
                $vars,
                array(
                    'meta_key' => '_HH_country', //Custom field key
                    'orderby' => '_HH_country' //Custom field value (number)
                )
            );
        }
        return $vars;
    }
}
