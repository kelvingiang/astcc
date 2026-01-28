<?php

class Admin_Search_By_Meta_Value {

    public function __construct() {
        // XET THEO DIEU KIEN MA CHON FUNCTION SEARCH       
        if (isset($_GET['s']) && @$_GET['s'] !== '' && @$_GET['countrycode'] == '-1') {   // modify on 29-08
            add_filter('posts_search', array($this, 'Menber_posts_search'), 10, 2);
            add_filter('posts_join', array($this, 'Member_posts_join'), 10, 2);
            add_filter('posts_distinct', array($this, 'segnalazioni_search_distinct'), 10, 2);
        } elseif (isset($_GET['countrycode']) && @$_GET['countrycode'] !== '-1' && @$_GET['s'] == '') {
            add_filter('posts_search', array($this, 'Menber_posts_country'), 10, 2);
            add_filter('posts_join', array($this, 'Member_posts_join'), 10, 2);
            add_filter('posts_distinct', array($this, 'segnalazioni_search_distinct'), 10, 2);
        } elseif ((isset($_GET['s']) && @$_GET['s'] !== '') && (isset($_GET['countrycode']) && @$_GET['countrycode'] !== '-1')) {
            add_filter('posts_search', array($this, 'Menber_posts_country_search'), 10, 2);
            add_filter('posts_join', array($this, 'Member_posts_join'), 10, 2);
            add_filter('posts_distinct', array($this, 'segnalazioni_search_distinct'), 10, 2);
        }
    }

    // TIM KIEM CA QUOC GIA VA NGUOI LIEU HE TEN CTY
    public function Menber_posts_country_search($search, $query) {
        global $wpdb;

        if ($query->query_vars['post_type'] == "member") :
            $countrycode = $_GET['countrycode'];
            $s = $query->query_vars['s'];
            $search = 'AND ( ( ( ' . $wpdb->prefix . 'posts.post_title LIKE \'%' . $s . '%\' ) ' .
                    'OR ( ' . $wpdb->prefix . 'posts.post_content LIKE \'%' . $s . '%\' ) ' .
//                    'OR ( ' . $wpdb->prefix . 'postmeta.meta_value LIKE \'%' . $s . '%\' ' .
//                    'AND ' . $wpdb->prefix . 'postmeta.meta_key = \'m_user\' )' .
                    'OR ( ' . $wpdb->prefix . 'postmeta.meta_value LIKE \'%' . $s . '%\' ' .
                    'AND ' . $wpdb->prefix . 'postmeta.meta_key = \'_m_contact\' )' .
                    'OR (' . $wpdb->prefix . 'postmeta.meta_value = \'' . $countrycode . '\' ' .
                    'AND ' . $wpdb->prefix . 'postmeta.meta_key = \'_m_country\' )))';
//modify add them kieu serch m_fullnam va m_email
        endif;

        return $search;
    }

    // TIM KIEM THEO QUOC GIA
    public function Menber_posts_country($search, $query) {
        global $wpdb;
        echo $_GET['countrycode'];

        if ($query->query_vars['post_type'] == "member" && $_GET['countrycode'] != '-1') :
            $countrycode = $_GET['countrycode'];
            $search = 'AND ( ( ( ' . $wpdb->prefix . 'posts.post_title LIKE \'%' . $countrycode . '%\' ) ' .
                    'OR ( ' . $wpdb->prefix . 'posts.post_content LIKE \'%' . $countrycode . '%\' ) ' .
//                    'OR ( ' . $wpdb->prefix . 'postmeta.meta_value LIKE \'%' . $s . '%\' ' .
//                    'AND ' . $wpdb->prefix . 'postmeta.meta_key = \'m_user\' )' .
//                    'OR ( ' . $wpdb->prefix . 'postmeta.meta_value LIKE \'%' . $s . '%\' ' .
//                    'AND ' . $wpdb->prefix . 'postmeta.meta_key = \'m_email\' )' .
                    'OR (' . $wpdb->prefix . 'postmeta.meta_value = \'' . $countrycode . '\' ' .
                    'AND ' . $wpdb->prefix . 'postmeta.meta_key = \'_m_country\' )))';
//modify add them kieu serch m_fullnam va m_email
        endif;

        return $search;
    }

// THEM DIEU KIEN SEARCH MAC DINH CHI SEARCH TITLE
    public function Menber_posts_search($search, $query) {
        global $wpdb;
        if ($query->query_vars['post_type'] == "member" && $query->query_vars['s'] != ' ') :
            $s = $query->query_vars['s'];
            $search = 'AND ( ( ( ' . $wpdb->prefix . 'posts.post_title LIKE \'%' . $s . '%\' ) ' .
                    'OR ( ' . $wpdb->prefix . 'posts.post_content LIKE \'%' . $s . '%\' ) ' .
//                    'OR ( ' . $wpdb->prefix . 'postmeta.meta_value LIKE \'%' . $s . '%\' ' .
//                    'AND ' . $wpdb->prefix . 'postmeta.meta_key = \'m_user\' )' .
//                    'OR ( ' . $wpdb->prefix . 'postmeta.meta_value LIKE \'%' . $s . '%\' ' .
//                    'AND ' . $wpdb->prefix . 'postmeta.meta_key = \'m_email\' )' .
                    'OR (' . $wpdb->prefix . 'postmeta.meta_value LIKE \'%' . $s . '%\' ' .
                    'AND ' . $wpdb->prefix . 'postmeta.meta_key = \'_m_contact\' )))';
//modify add them kieu serch m_fullnam va m_email
        endif;


        if ($query->query_vars['post_type'] == "friend" && $query->query_vars['s'] !== ' ') :
            $s = $query->query_vars['s'];
            $search = 'AND ( ( ( ' . $wpdb->prefix . 'posts.post_title LIKE \'%' . $s . '%\' ) ' .
                    'OR ( ' . $wpdb->prefix . 'posts.post_content LIKE \'%' . $s . '%\' ) ' .
                    'OR ( ' . $wpdb->prefix . 'postmeta.meta_value LIKE \'%' . $s . '%\' ' .
                    'AND ' . $wpdb->prefix . 'postmeta.meta_key = \'p_name\' ) ) )';
        endif;

        return $search;
    }

    //==============================================================================================   
// JION THEM TABLE DE SEARCH
    public function Member_posts_join($join, $query) {

        global $wpdb;

        if ($query->query_vars['post_type'] == "member" || $query->query_vars['post_type'] == "friend" && $query->query_vars['s'] !== '') :
            $join = ' INNER JOIN ' . $wpdb->prefix . 'postmeta ON ' . $wpdb->prefix . 'postmeta.post_id = ' . $wpdb->prefix . 'posts.ID ';
        endif;
        return $join;
    }

// TRUONG HOP SEARCH VALUE CO TRONG TITLE SE RA NHIEU DONG ,DUNG HAM DUOI DE CHO NO VE 1 DONG    
    function segnalazioni_search_distinct($where, $query) {
        global $pagenow, $wpdb;

        if (is_admin() && $pagenow == 'edit.php' && $query->query_vars['post_type'] == 'member' && $query->query_vars['s'] != '') {
            return "DISTINCT";
        }
        return $where;
    }

}

