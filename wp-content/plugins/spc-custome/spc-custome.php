<?php
/**
* Plugin Name: SPc-Questionnaire
* Author: Unotrung
* Description: Create questionaire follow post
*/


function spc_questionaire() {

	/*
     * Biến $label để chứa các text liên quan đến tên hiển thị của Post Type trong Admin
     */
    $label = array(
        'name' => 'アンケート管理', //Tên post type dạng số nhiều
        'singular_name' => 'Questionaire' //Tên post type dạng số ít
    );
 
    /*
     * Biến $args là những tham số quan trọng trong Post Type
     */
    $args = array(
        'labels' => $label, //Gọi các label trong biến $label ở trên
        'description' => 'Create questionaire follow post', //Mô tả của post type
        'supports' => array(
            'title',
            'editor',
            'author',
            'thumbnail',
            'revisions'
        ), //Các tính năng được hỗ trợ trong post type
        'taxonomies' => array( 'category' ), //Các taxonomy được phép sử dụng để phân loại nội dung , 'post_tag' 
        'hierarchical' => false, //Cho phép phân cấp, nếu là false thì post type này giống như Post, true thì giống như Page
        'public' => true, //Kích hoạt post type
        'show_ui' => true, //Hiển thị khung quản trị như Post/Page
        'show_in_menu' => true, //Hiển thị trên Admin Menu (tay trái)
        'show_in_nav_menus' => true, //Hiển thị trong Appearance -> Menus
        'show_in_admin_bar' => true, //Hiển thị trên thanh Admin bar màu đen.
        'menu_position' => 5, //Thứ tự vị trí hiển thị trong menu (tay trái)
        'menu_icon' => 'dashicons-testimonial', //Đường dẫn tới icon sẽ hiển thị
        'can_export' => true, //Có thể export nội dung bằng Tools -> Export
        'has_archive' => true, //Cho phép lưu trữ (month, date, year)
        'exclude_from_search' => false, //Loại bỏ khỏi kết quả tìm kiếm
        'publicly_queryable' => true, //Hiển thị các tham số trong query, phải đặt true
        'capability_type' => 'post' //
    );
 
    register_post_type('question_post', $args); //Tạo post type với slug tên là questionaire và các tham số trong biến $args ở trên
}

add_action( 'init', 'spc_questionaire' );

/**
* Change label menu, submenu
*/
function change_post_menu_label() {
  global $submenu;
  // echo "<pre>";print_r($submenu);echo "</pre>"; //Print menus and find out the index of your custom post type menu from it.
  $submenu['edit.php?post_type=question_post'][5][0] = 'アンケート一覧'; // Replace the 27 with your custom post type menu index from displayed above $menu array 
  $submenu['edit.php?post_type=question_post'][10][0] = 'アンケート作成'; 
}
add_action( 'admin_menu', 'change_post_menu_label' );
/**
* Do not show category submenu in Questionnaires menu
*/
add_action( 'admin_menu', 'remove_wp_menu', 999 );
function remove_wp_menu(){
    remove_submenu_page( 'edit.php?post_type=question_post', 'edit-tags.php?taxonomy=category&amp;post_type=question_post' );
}
/**
 Khai báo meta box
**/
function questionaire_meta_box()
{
 add_meta_box( 'thong-tin', '新規アンケートの作成', 'questionaire_attr', 'question_post' );
}
add_action( 'add_meta_boxes', 'questionaire_meta_box' );

/**
* 
*/

function questionaire_attr( $post )
{
 // Tạo trường Link Download
 /*echo ( '<label for="link_download">Link Download: </label>' );
 echo ('<input type="text" id="link_download" name="link_download" value="'.esc_attr( $link_download ).'" />');*/
 include_once('templates/questionaire-attr.php');

}

/**
 Lưu dữ liệu meta box khi nhập vào
 @param post_id là ID của post hiện tại
**/
if(isset($_POST)){
  function questionaire_attr_save( $post_id )
  {
       $question =   $_POST['question']  ;
      update_post_meta( $post_id, '_question_type', $question );
       $limited_answer =   $_POST['limited_answer']  ;
       update_post_meta( $post_id, '_limited_answer', $limited_answer );
  }
  add_action( 'save_post', 'questionaire_attr_save' );
}


/**
 Khai báo meta box Answer list
**/
function answer_meta_box()
{
    add_meta_box( 'answers', '回答一覧', 'answer_attr', 'question_post' );
}
add_action( 'add_meta_boxes', 'answer_meta_box' );

/**
* 
*/

function answer_attr( $post )
{
    include_once('templates/answer-attr.php');
}

/**
* update status comment
*/
function update_status_comment(){
    $commentarr = array();
    $commentarr['comment_ID'] = $_POST['comment_ID'];
    $commentarr['comment_approved'] = $_POST['status']?0:1;
   $result = wp_update_comment( $commentarr );
    wp_send_json(['success'=>$result]);
}
add_action('wp_ajax_update_comment', 'update_status_comment');



/**
 Khai báo meta box
**/
function exportcsv() {
    include_once('templates/exportcsv.php'); 
}
function report_meta_box()
{
 add_meta_box( 'answer-report', 'レポート', 'exportcsv', 'question_post' );
}
add_action( 'add_meta_boxes', 'report_meta_box' );

/**
* export to file
*/
add_action( 'admin_post_exportcsv', 'csv_file' );
function csv_file() {
    include_once('templates/csv.php'); 
}