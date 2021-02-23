<?php

class Admin_Branch_Controler {
   private  $prefix_name = '_branch_order';
    public function __construct() {
        add_action('init', array($this, 'register_post'));
        add_action('manage_edit-branch_columns', array($this, 'manage_cols'));
        add_action('manage_branch_posts_custom_column', array($this, 'render_cols'));
        //====== tao taxonomy =========
        add_action('init', array($this, 'register_taxonomy'));
        add_action('branch_cate_add_form_fields', array($this, 'add_meta_form'));
        add_action('branch_cate_edit_form_fields', array($this, 'edit_meta_form'));
        add_action('create_branch_cate', array($this, 'save_custom_meta'));
        add_action('edited_branch_cate', array($this, 'save_custom_meta'));
        add_filter("manage_edit-branch_cate_columns", array($this, 'tag_columns'));
        add_filter("manage_branch_cate_custom_column", array($this, 'manage_tag_columns'), 10, 3);

        //==== tao tag============================================
        //  add_action('init', array($this, 'register_tag'));
        //  
        //==== xap xep ============================================
        add_filter('manage_edit-branch_sortable_columns', array($this, 'sortable_views_column'));
        add_filter('request', array($this, 'sort_views_column'));
    }

    public function register_post() {
        $labels = array(
            'name' => _x('各國分會', 'suite'),
            'singular_name' => _x('各國分會', 'suite'),
            'add_new' => _x('新增', 'suite'),
            'add_new_item' => _x('新增', 'suite'),
            'edit_item' => _x('修改', 'suite'),
            'new_item' => _x('新增', 'suite'),
            'all_items' => _x('各國分會', 'suite'),
            'view_item' => _x('各國分會', 'suite'),
            'search_items' => _x('查询', 'suite'),
            'not_found' => _x('No slides found.', 'suite'),
            'not_found_in_trash' => _x('No  found in Trash.', 'suite'),
            'parent_item_colon' => '',
            'menu_name' => _x('各國分會', 'suite')
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
            'menu_position' => 11,
            'supports' => array('title', 'editor'),
        );
        register_post_type('branch', $args);
    }

    // tao function thay doi hien thi mac dinh
    public function manage_cols($columns) {
        $columns['title']; // cho an cot title mac dinh;
        unset($columns['date']); // an cot ngay mac dinh
        // them cot vao bang 
        //  $columns['supervisor_image'] = _x('照片', 'suite');
        $columns['order'] = _x('次序', 'suite');
        $columns['date'] = __('Create Date', 'suite');

        return $columns;
    }

// function dua noi dung vao cac cot moi  tạo
    public function render_cols($columns) {
        global $post;

//        if ($columns == 'supervisor_image') {
//            if (has_post_thumbnail()) {
//                the_post_thumbnail(array(80, 80));  // Other resolutions);
//                //  set_post_thumbnail_size(50, 50); // 50 pixels wide by 50 pixels tall, resize mode
//            }
//        }
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
        register_taxonomy('branch_cate', 'branch', array(
            'labels' => $labels,
            'public' => true,
            //'show_ui' => true,
            'show_tagcloud' => true,
            'hierarchical' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'branch-category',
            )
        ));
    }

    public function add_meta_form() {
        ?>
        <div class="form-field">
            <label>   <?php _e('Order') ?></label>
            <input type="text" name="branch_order" id="branch_order" value="01" />
        </div>

        <?php
    }

    public function Edit_Meta_Form($term) {
        // LAY GIA TRI TRONG OPTION TABLE
        //$arr_value = get_option($this->prefix_name . $term->term_id);
             $option_name = $this->prefix_name;
        $arr_value = get_post_meta($term->term_id, $option_name,true );

        ?>
        <tr class="form-field">
            <th scope="row" valign="top">   <label>   <?php _e('Order') ?></label> </th>
            <td>    <input type="text" name="branch_order" id="branch_order" value="<?php echo $arr_value; ?>" /></td>
        </tr>
        <?php
    }

    public function manage_tag_columns($out, $column_name, $theme_id) {

        $theme = get_term($theme_id, 'branch_cate');
        
        $strMetaTax = get_post_meta($theme->term_id, $this->prefix_name , true);
        switch ($column_name) {
            case 'order':
                echo $strMetaTax;
            default:
                break;
        }
        return $out;
    }

    public function tag_columns($theme_columns) {
        $new_columns = array(
            'cb' => '<input type="checkbox" />',
            'name' => __('Name'),
            'slug' => __('slug'),
            'order' => __('Order'),
            'posts' => __('Count')
        );

        return $new_columns;
    }

    public function save_custom_meta($term_id) {


        $option_name = $this->prefix_name;
        update_post_meta($term_id, $option_name, $_POST['branch_order']);
    //    $option_value = $_POST['cate'];
     //   update_option($option_name, $option_value);
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
