<?php
class Admin_Metabox_website{
    public function __construct() {
       // echo __METHOD__;
         add_action('add_meta_boxes' , array($this,'create') );
         add_action( 'save_post' , array($this, 'save'));
    }
    
    
    public function create(){    
  //      echo __METHOD__;
        $id             = 'metabox-website';
        $title          = '網站';
        $callback    = array($this, 'display');
       $screen        =array('advertising','friendlink','businesslink', 'branch', 'chamber'); // CAC POST VA CUSTOMER POST CHO PHEP METABOX NAY HIEN THI
        add_meta_box($id, $title, $callback, $screen);
       
    }

    public function display($post){
    //        echo __METHOD__;
        // thanh an nham bao mat trong wp
        $action = 'metabox-data';
        $name  ='metabox-data-nonce';
        wp_nonce_field($action, $name);
        
        echo ' <div class=mightway-mb-wrap>';
        echo '<p></p>';
        $objhtml = new MyHtml();
            
        // TAO TEXTBOX TITLE
        $inputID                = 'txt_website';
        $inputName            = 'txt_website';
        $inputvalue            = get_post_meta($post->ID, '_metabox_website',true);
        $arr                       = array( 'class' => 'txt_input', 'size' =>  '25', 'id' => $inputID,  'placeholder' => 'http://yourdomain.com');
        echo  '<p><label class="title_text" for ="'. $inputID. '">' .  translate('網站地址')  .' <i> 輸入整個網站的地址如 : http://yahoo.com </i> </label>'
                . $objhtml->textbox( $inputName, $inputvalue, $arr )
                .'</p>';
       
    }
    
        // LUU GIA TRI VAO DATABASE
    public  function save( $post_id){
//  
        // kiem thanh phan an bao mat cua wp
        // NEU HAM NAY TRA VE GIA TRI  LA TRUE THUC HIEN TIEP CAC PHAN DUOI , CON TRA VE FLASE return VE $post_id
        if(!isset($_POST['metabox-data-nonce'])) return $post_id;
       // NEU HAM NAY TRA VE GIA TRI  LA TRUE THUC HIEN TIEP CAC PHAN DUOI , CON TRA VE FLASE return VE $post_id 
        if(wp_verify_nonce('metabox-data-nonce','metabox-data'))            return $post_id; 
        // HAM TU DONG LUU KHI DE QUA LAU NEU TRA VE FLASE return $post_id
        // if(define('DOING_AUTOSAVE') && DOING_AUTOSAVE)            return $post_id;
        
        if(!current_user_can('edit_post', $post_id))            return$post_id;
       // 4 BON PHAN TREN DUNG DE BAO MAT KHI LUU METABOX TRONG WP 
       
        update_post_meta($post_id, '_metabox_website', sanitize_text_field($_POST['txt_website']));
        
    }

}
