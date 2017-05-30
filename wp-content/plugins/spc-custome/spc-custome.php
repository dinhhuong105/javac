<?php
/**
* Plugin Name: Questionnaire
* Author: Unotrung
* Description: Create questionnaire follow post
*/
global $post;

function spc_questionaire() {

	/*
     * Biến $label để chứa các text liên quan đến tên hiển thị của Post Type trong Admin
     */
    $label = array(
        'name' => 'アンケート管理', //Tên post type dạng số nhiều
        'singular_name' => 'アンケート管理', //Tên post type dạng số ít
        'add_new' => '新規追加',
        'add_new_item' => '新規アンケートの作成',
         'edit_item' => 'アンケートを編集する',
         'new_item' => '新規サイト',
         'all_items' => 'アンケート一覧',
         'view_item' => 'アンケートの説明を見る',
         'search_items' => '検索する',
         'not_found' => 'アンケートが見つかりませんでした。',
         'not_found_in_trash' => 'ゴミ箱内にアンケートが見つかりませんでした。'
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
        'menu_position' => 10, //Thứ tự vị trí hiển thị trong menu (tay trái)
        'menu_icon' => 'dashicons-testimonial', //Đường dẫn tới icon sẽ hiển thị
        'can_export' => true, //Có thể export nội dung bằng Tools -> Export
        'has_archive' => true, //Cho phép lưu trữ (month, date, year)
        'exclude_from_search' => false, //Loại bỏ khỏi kết quả tìm kiếm
        'publicly_queryable' => true, //Hiển thị các tham số trong query, phải đặt true
        'capability_type' => 'post'
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
    remove_submenu_page( 'edit.php?post_type=question_post','review' );
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
 include_once('templates/questionaire-attr.php');
}

/**
 Lưu dữ liệu meta box khi nhập vào
 @param post_id là ID của post hiện tại
**/
if(isset($_POST)){
  function questionaire_attr_save( $post_id )
  {
      //Description form questionnair
      $ques_description =   $_POST['ques_description']  ;
      update_post_meta( $post_id, '_question_description', $ques_description );

      $question =   $_POST['question'];
      update_post_meta( $post_id, '_question_type', $question );

      $limited_answer =   $_POST['limited_answer']  ;
      update_post_meta( $post_id, '_limited_answer', $limited_answer );

      $_sort_question =   $_POST['_sort_question'];
      update_post_meta( $post_id, '_sort_question', $_sort_question );
  }
  add_action( 'save_post', 'questionaire_attr_save' );
}

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
    if($_POST['status'] == '1'){
        update_report_status_comment($_POST['comment_ID']);
    }
    wp_send_json(['success'=>$result]);
}
add_action('wp_ajax_update_comment', 'update_status_comment');

/**
 * Change report status when unapprove comment
 * @author Hung Nguyen
 */
function update_report_status_comment($comment_id){
    if ( function_exists ( 'wprc_table_name' ) ){
        global $wpdb;
        $table_name = wprc_table_name();
        $query = "UPDATE $table_name SET status='processed' WHERE comment_id = $comment_id";
        $wpdb->query($query);
    }
}


/**
* export to file
*/
add_action( 'admin_post_exportcsv', 'csv_file' );
function csv_file() {
    include_once('templates/csv.php'); 
}


function report_link($actions, $page_object){
  if($page_object->post_type == 'question_post'){
    $actions['report_page'] = '<a href="'.admin_url( 'edit.php?post_type=question_post&page=review&post=' . $page_object->ID ).'">Report</a>';
    unset($actions['inline hide-if-no-js']);
    // print_r($actions);exit;
  }
  return $actions;
}
add_filter('post_row_actions', 'report_link', 10, 2);

add_action( 'admin_post_review', 'report_question' );
function report_question(){
  include_once('templates/exportcsv.php'); 
}

add_action('admin_menu', 'test_plugin_setup_menu');
 
function test_plugin_setup_menu(){
  add_submenu_page( 'edit.php?post_type=question_post','アンケート詳細', 'アンケート詳細', 'manage_options', 'review', 'test_init' );
}

function test_init(){
  include_once('templates/exportcsv.php'); 
  include_once('templates/answer-attr.php'); 
}

/**
* update limited comment
*/
function update_status_limited_comment(){
  if(isset($_POST['post_ID'])){
    $post_id = $_POST['post_ID'];
    $status = $_POST['status']*-1;
    $result = update_post_meta( $post_id,'_limited_answer',$status );
    wp_send_json(['success'=>$result,'status'=>$status]);
  }
}
add_action('wp_ajax_limited_comment', 'update_status_limited_comment');

/**
* update status post
*/
function update_status_post(){
  if(isset($_POST['post_ID'])){
    $post_id = $_POST['post_ID'];
    $status = $_POST['status']=='publish'?'private':'publish';
    $close = $_POST['status']=='publish'?'open':'close';
    global $wpdb;
    $query = "UPDATE ".$wpdb->prefix."posts SET post_status='".$status."',comment_status='".$close."', ping_status='".$close."', post_modified= '".date("Y-m-d H:i:s")
."'  WHERE ID = '".$post_id."'";
    $result = $wpdb->query($query);
    if($_POST['status']=='publish'){
        update_report_status_post($_POST['post_ID']);
    }
    wp_send_json(['success'=>$result,'status'=>$status]);
  }
}
add_action('wp_ajax_post_status', 'update_status_post');

/**
 * Change status of report when unpublish questionnaire
 * @author Hung Nguyen
 */
function update_report_status_post( $post_id ) {
    if ( function_exists ( 'wprc_table_name' ) ){
        global $wpdb;
        $table_name = wprc_table_name();
        $query = "UPDATE $table_name SET status='processed' WHERE post_id = $post_id";

        $wpdb->query($query);
    }
}

/**
* disable editable post after has comment
**/
/*function stoppostedition_filter( $capauser, $capask, $param){

  global $wpdb;   

  $post = get_post( $param[2] );
  $num_comment =  wp_count_comments( $param[2] );
  if( $post->post_status == 'publish' && $post->post_type == 'question_post'){

      // Disable post edit only for authore role
      if( $capauser['administrator'] == 1 ){

        if( ( $param[0] == "edit_post") || ( $param[0] == "delete_post" ) ) {
          if($num_comment->approved > 0){
            foreach( (array) $capask as $capasuppr) {

                if ( array_key_exists($capasuppr, $capauser) ) {

                  $capauser[$capasuppr] = 0;

                }
              }
          }
        }
      }
  }
  return $capauser;
}
add_filter('user_has_cap', 'stoppostedition_filter', 100, 3 );*/
