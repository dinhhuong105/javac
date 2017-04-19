<?php


/*-------------------------------------------*/
/* more-linkのハッシュ消し
/*-------------------------------------------*/
function remove_more_jump_link($link) {
    $offset = strpos($link, '#more-');
    if ($offset) {
        $end = strpos($link, '"',$offset);
    }
    if ($end) {
        $link = substr_replace($link, '', $offset, $end-$offset);
    }
    return $link;
}
add_filter('the_content_more_link', 'remove_more_jump_link');



/*-------------------------------------------*/
/* <head>内のWordPressのバージョンを消す
/*-------------------------------------------*/
remove_action('wp_head','wp_generator');


/*-------------------------------------------*/
/* アイキャッチ画像
/*-------------------------------------------*/
add_theme_support('post-thumbnails'); //アイキャッチ画像を使用する
//set_post_thumbnail_size(75, 75, true); サイズを指定して切り抜き
add_image_size('list_thumbnail', 150, 150, true); //一覧サムネイル
add_image_size('movie_thumbnail', 300, 300, true); //動画用サムネイル
//add_image_size('slide_thumbnail', 640, 400, true); //スライドエリア用
//add_image_size('single_thumbnail', 300, 200, true); //singleエリア用

////pc
//add_image_size( '900_thumbnail', 900, 400,true ); //スライドpc
//add_image_size( '320_thumbnail', 320, 200, true ); //pc一覧用320px
//add_image_size( '200_thumbnail', 200, 150, true ); //pc一覧用200px topランキング部分
//add_image_size( 'ranking_thumbnail', 200, 170, true ); //pc一覧用200px ランキング一覧部分
//add_image_size( '670_thumbnail', 670, 450, true ); //pc シングルtop


/*-------------------------------------------*/
/* パンくずリスト
/*-------------------------------------------*/
function breadcrumb(){
    global $post;
    $str ='';
    if(!is_home()&&!is_admin()){ /* !is_admin は管理ページ以外という条件分岐 */
        $str.= '<div id="breadcrumb">';
        $str.= '<ul class="breadcrumbList">';
        $str.= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . home_url('/') .'"itemprop="url" >トップ<i class="fa fa-chevron-right arrowIcon"></i></a></li>';

        /* 投稿のページ */
        if(is_single()){
             if( $post->post_type === "movingimage_post" ){
                   $cats = get_the_terms($post->ID, 'movingimage_cat');
                   $count_cat = is_array($cats)?count($cats):0;
                   $new_cats = array();
                   for($i = 0; $i < $count_cat; $i++) {
                            $ancestors = get_ancestors( $cats[$i]->term_id, 'movingimage_cat' );
                            $count_anc = count($ancestors);
                            $new_cats[$count_anc] = $cats[$i];  // 先祖の数をキーとした要素
                   }
                   ksort($new_cats);    // キーでソートする
                   foreach($new_cats as $cat){
                            $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.get_category_link($cat->term_id). '" itemprop="url" ><span itemprop="title">'. $cat->name . '</span><i class="fa fa-chevron-right arrowIcon"></i></a></li>';
                   }
             }elseif( $post->post_type === "item_post" ){
                $cats = get_the_terms($post->ID, 'item_cat');
               $count_cat = is_array($cats)?count($cats):0;
               $new_cats = array();
               for($i = 0; $i < $count_cat; $i++) {
                        $ancestors = get_ancestors( $cats[$i]->term_id, 'item_cat' );
                        $count_anc = count($ancestors);
                        $new_cats[$count_anc] = $cats[$i];  // 先祖の数をキーとした要素
               }
               ksort($new_cats);    // キーでソートする
               $end_term = end($new_cats);
               $end_term_id = $end_term->term_id;
               foreach($new_cats as $cat){
                        $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.get_category_link($cat->term_id). '" itemprop="url" ><span itemprop="title">'. $cat->name . '</span>';
                        if( $cat->term_id != $end_term_id ){$str .= '<i class="fa fa-chevron-right arrowIcon"></i>';}
                        $str .= '</a></li>';
               }

             }else{
                   $categories = get_the_category($post->ID);
                   $cat = $categories;
                   $catId = $categories[0]->cat_ID;
                   usort( $cat , '_usort_terms_by_ID');

            $ancestors = $cat ;
            if ($catId == 1) {
                foreach($ancestors as $ancestor){
                    $str;
                }
                $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_category_link($cat[0] -> term_id). '" itemprop="url" ><span itemprop="title">'. $cat[0]-> cat_name . '</span></a></li>';
            }else {
                foreach($ancestors as $ancestor){
                    $str;
                }
                $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_category_link($cat[1] -> term_id). '" itemprop="url" ><span itemprop="title">'. $cat[1]-> cat_name . '</span><i class="fa fa-chevron-right arrowIcon"></i></a></li>';
                $str.= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_category_link($cat[2] -> term_id). '" itemprop="url" ><span itemprop="title">'. $cat[2]-> cat_name .'</span></a></li>';
                }
            }
        }

        /* 固定ページ */
        elseif(is_page()){
            if($post -> post_parent != 0 ){
                $ancestors = array_reverse(get_post_ancestors( $post->ID ));
                foreach($ancestors as $ancestor){
                    $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_permalink($ancestor).'" itemprop="url" ><span itemprop="title">'. get_the_title($ancestor) .'</span></a></li>';
                }
            }
            $str.= '<li class="fixPage" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. $post -> post_title .'</span></li>';
        }

        /* カテゴリページ */
        elseif(is_category()) {
            $cat = get_queried_object();
            $parent = get_category($cat->category_parent);
            $str.='<li class="cat" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">' . $cat->name . '</span></li>';
        }

        /* タグページ */
        elseif(is_tag()){
            $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. single_tag_title( '' , false ). '</span></li>';
        }

				/* 動画タクソノミーページ */
				elseif(is_tax('movingimage_cat')){
					$tax = get_queried_object();
					$breadcrumb = '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.get_category_link($tax->term_id).
						'" itemprop="url" ><span itemprop="title">'. $tax->name . '</span><i class="fa fa-chevron-right arrowIcon"></i></a></li>';

					$tax_list = get_ancestors( $tax->term_id, 'movingimage_cat' );
					foreach( $tax_list as $tax_id ){
						$tax = get_term_by( 'id', $tax_id, 'movingimage_cat');
						$breadcrumb = '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.get_category_link($tax->term_id).
							'" itemprop="url" ><span itemprop="title">'. $tax->name . '</span><i class="fa fa-chevron-right arrowIcon"></i></a></li>'.$breadcrumb;
					}
					$str .= $breadcrumb;
				}

        /* 時系列アーカイブページ */
        elseif(is_date()){
            if(get_query_var('day') != 0){
                $str.='<li itemscope itemtype="http://data-vocabulary.org/"><a href="'. get_year_link(get_query_var('year')). '" itemprop="url" ><span itemprop="title">' . get_query_var('year'). '年</span></a></li>';
                $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_month_link(get_query_var('year'), get_query_var('monthnum')). '" itemprop="url" ><span itemprop="title">'. get_query_var('monthnum') .'月</span></a></li>';
                $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. get_query_var('day'). '</span>日</li>';
            } elseif(get_query_var('monthnum') != 0){
                $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_year_link(get_query_var('year')) .'" itemprop="url" ><span itemprop="title">'. get_query_var('year') .'年</span.</a></li>';
                $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. get_query_var('monthnum'). '</span>月</li>';
            } else {
                $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. get_query_var('year') .'年</span></li>';
            }
        }

        /* 投稿者ページ */
        elseif(is_author()){
            $str .='<li class="fixPage" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. get_the_author_meta('display_name', get_query_var('author')).'</span></li>';
        }

        /* 添付ファイルページ */
        elseif(is_attachment()){
            if($post -> post_parent != 0 ){
                $str.= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_permalink($post -> post_parent).'" itemprop="url" ><span itemprop="title">'. get_the_title($post -> post_parent) .'</span></a></li>';
            }
            $str.= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">' . $post -> post_title . '</span></li>';
        }

        /* 検索結果ページ */
        elseif(is_search()){
            $str.='<li class="fixPage" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">「'. get_search_query() .'」の検索結果</span></li>';
        }

        /* 404 Not Found ページ */
        elseif(is_404()){
            $str.='<li class="fixPage" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">お探しのページが見つかりません</span></li>';
        }

        /* その他のページ */
        else{
            $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. wp_title('', false) .'</span></li>';
        }
        $str.='</ul>';
        $str.='</div>';
    }
    echo $str;
}


/*-------------------------------------------*/
/* ページネーション
/*-------------------------------------------*/

function pagination($pages = '', $range = 2)
{
    $showitems = ($range * 2)+1;//表示するページ数（５ページを表示）

    global $paged;//現在のページ値
    if(empty($paged)) $paged = 1;//デフォルトのページ

    if($pages == '')
    {
        global $wp_query;
        $pages = $wp_query->max_num_pages;//全ページ数を取得
        if(!$pages)//全ページ数が空の場合は、１とする
        {
            $pages = 1;
        }
    }

    if(1 != $pages)//全ページが１でない場合はページネーションを表示する
    {
        echo "<div class=\"pagination\">\n";
        echo "<ul>\n";
        //Prev：現在のページ値が１より大きい場合は表示
        if($paged > 1) echo "<li class=\"prev\"><a href='".get_pagenum_link($paged - 1)."'><i class=\"fa fa-chevron-left\"></i></a></li>\n";

        for ($i=1; $i <= $pages; $i++)
        {
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
            {
                //三項演算子での条件分岐
                echo ($paged == $i)? "<li class=\"active\">".$i."</li>\n":"<li><a href='".get_pagenum_link($i)."'>".$i."</a></li>\n";
            }
        }
        //Next：総ページ数より現在のページ値が小さい場合は表示
        if ($paged < $pages) echo "<li class=\"next\"><a href=\"".get_pagenum_link($paged + 1)."\"><i class=\"fa fa-chevron-right\"></i></a></li>\n";
        echo "</ul>\n";
        echo "</div>\n";
    }
}

function paginate_comments($pages = '', $range = 2){
  $showitems = ($range * 2)+1;//表示するページ数（５ページを表示）

  $paged = get_query_var('cpage');
	if ( !$paged ) $paged = 1;
	$pages = get_comment_pages_count();

  if(1 != $pages)//全ページが１でない場合はページネーションを表示する
  {
      echo "<div class=\"pagination\">\n";
      echo "<ul>\n";
      // Prev：現在のページ値が１より大きい場合は表示
      $before = $paged-1;
      if($paged > 1) echo "<li class=\"prev\"><a href='".get_permalink()."/comment-page-".$before."#comments'><i class=\"fa fa-chevron-left\"></i></a></li>\n";

      for ($i=1; $i <= $pages; $i++)
      {
          if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
          {
              // 三項演算子での条件分岐
              echo ($paged == $i)? "<li class=\"active\">". $i ."</li>\n":"<li><a href='".get_permalink()."/comment-page-". $i ."#comments'>". $i ."</a></li>\n";
          }
      }
      // Next：総ページ数より現在のページ値が小さい場合は表示
      $next = $paged+1;
      if ($paged < $pages) echo "<li class=\"next\"><a href='".get_permalink()."/comment-page-".$next."#comments'><i class=\"fa fa-chevron-right\"></i></a></li>\n";
      echo "</ul>\n";
      echo "</div>\n";
  }
}

/*-------------------------------------------*/
/* WordPress Popular Postsのカスタマイズ
/* ランキング部分
/*-------------------------------------------*/

function my_custom_popular_posts_html_list( $mostpopular, $instance ){
//    if (is_singular('movingimage_post') || is_page('movie-ranking')) {
//        $output = '<ul class="movieList">';
//    } else {
//        $output = '<ul class="articleList rankingList">';
//    }

    $output = "";
    // 人気記事ランキングのループ処理
    foreach( $mostpopular as $popular ) {
        // URL
        $url = get_the_permalink( $popular->id );
        // ページビュー
        $views = number_format_i18n($popular->pageviews);
        // タイトル
        $title = get_the_title($popular->id);
        // 日付
        $date = date_i18n($instance['stats_tag']['date']['format'], strtotime($popular->date));
        // サムネイル
        $thumbnail = '';
        // カテゴリー
        $category_name = '';
        // 投稿者
        //        $author = get_the_author_meta('display_name', $popular->uid);
        $author='';


        $tmp_post = get_post($popular->id);

        if ($tmp_post->post_type === "movingimage_post"){
            $mv_cat = get_the_terms($popular->id, 'movingimage_cat');
            if( is_array($mv_cat) ){
            	usort( $mv_cat , '_usort_terms_by_ID');
            	$category_name = end($mv_cat)->name;
              }else{
                    $category_name = "";
              }
            $thumbnail = get_the_post_thumbnail( $popular->id ,'movie_thumbnail');
        } else {
            $thumbnail = get_the_post_thumbnail( $popular->id ,'list_thumbnail');
            $category = get_the_category($popular->id);
            usort( $category , '_usort_terms_by_ID');//タームID順に取得
            $category_name = end($category)->cat_name;
            $author = get_the_author_meta('display_name', $popular->uid);
        }

        $output .= '<li>';
        $output .=      '<a href="'. $url .'">';
        $output .=         '<div class="imgArea">' . $thumbnail . '</div>';
        $output .=         '<div class="content">';
        $output .=             '<div class="articleData">';
        $output .=                 '<p class="data">'. $date .'</p>';
        $output .=                 '<p class="cat">'. $category_name . "</p>";
        $output .=             '</div>';
        $output .=             '<h2>' . $title . '</h2>';
        $output .=             '<div class="articleData">';
        $output .=                 '<p class="name">'. $author . '</p>';
        $output .=                 '<p class="pv"><i class="fa fa-heart" aria-hidden="true"></i> '. $views . "</p>";
        $output .=             '</div>';
        $output .=         '</div>';
        $output .=      '</a>';
        $output .= '</li>';
    }

//    $output .= '</ul>';

    return $output;
}

add_filter( 'wpp_custom_html', 'my_custom_popular_posts_html_list', 10, 2 );






/*---------------------------------------------------------------*/
/* WordPressの投稿作成画面で必須項目を作る（空欄ならJavaScriptのアラート）
/*---------------------------------------------------------------*/
add_action( 'admin_head-post-new.php', 'mytheme_post_edit_required' ); // 新規投稿画面でフック
add_action( 'admin_head-post.php', 'mytheme_post_edit_required' );     // 投稿編集画面でフック
function mytheme_post_edit_required() {
?>
<script type="text/javascript">
    jQuery(document).ready(function($){
        if(
					 $('#post_type').val() == 'post' ||
					 $('#post_type').val() == 'movingimage_post'
				){ // post_type 判定。例は投稿ページ。固定ページ、カスタム投稿タイプは適宜追加
            $("#post").submit(function(e){ // 更新あるいは下書き保存を押したとき
                if('' == $('#title').val()) { // タイトル欄の場合
                    alert('タイトルを入力してください！');
                    $('.spinner').hide(); // spinnerアイコンを隠す
                    $('#publish').removeClass('button-primary-disabled'); // #publishからクラス削除
                    $('#title').focus(); // 入力欄にフォーカス
                    return false;
                }

								var cate = $('#post_type').val() == 'post'?$("#taxonomy-category input:checked"):$("#taxonomy-movingimage_cat input:checked");
								if(cate.length < 1 ) { // カテゴリーがチェックされているかどうか。条件を要確認。普通は設定したカテゴリーになるから要らない
										alert('カテゴリーを選択してください');
										$('.spinner').hide();
										$('#publish').removeClass('button-primary-disabled');
										$('#taxonomy-category').focus();
										return false;
								}

								if($('#post_type').val() == 'movingimage_post') {
									if($("#acf-field-movie").val() == '') {
										alert('動画を入力してください！');
                    $('.spinner').hide();
                    $('#publish').removeClass('button-primary-disabled');
                    $('#post_name').focus();
                    return false;
									}
								}

                if($("#post_name").val() == '') {
                    alert('スラッグを入力してください！');
                    $('.spinner').hide();
                    $('#publish').removeClass('button-primary-disabled');
                    $('#post_name').focus();
                    return false;
                } else if( $("#post_name").val().indexOf("questionary") != -1) {
                    alert('「questionary」が含まれていないスラッグを入力してください！');
                    $('.spinner').hide();
                    $('#publish').removeClass('button-primary-disabled');
                    $('#post_name').focus();
                    return false;
                }
                if( $("#set-post-thumbnail img").length < 1 ) { // アイキャッチ画像
                    alert('アイキャッチ画像を設定してください！');
                    $('.spinner').hide();
                    $('#publish').removeClass('button-primary-disabled');
                    $('#set-post-thumbnail').focus();
                    return false;
                }
            });
        }
    });
</script>
<?php
}


/*------------------------------------------*/
/* 投稿後にカテゴリの階層が変わらないようにする
/*------------------------------------------*/
function lig_wp_category_terms_checklist_no_top( $args, $post_id = null ) {
    $args['checked_ontop'] = false;
    return $args;
}
add_action( 'wp_terms_checklist_args', 'lig_wp_category_terms_checklist_no_top' );


/*------------------------------------------*/
/* ビジュアルリッチエディタ非表示
/*------------------------------------------*/
add_filter('user_can_richedit' , create_function('' , 'return false;') , 50);


/*------------------------------------------*/
/*ユーザー項目
/*------------------------------------------*/
function update_profile_fields( $contactmethods ) {
    //項目の削除
    //    unset($contactmethods['jabber']);
    unset($contactmethods['url']);

    //項目の追加
    $contactmethods['twitter'] = 'Twitter';
    $contactmethods['facebook'] = 'Facebook';
    $contactmethods['instagram'] = 'Instagram';
    return $contactmethods;
}
add_filter('user_contactmethods','update_profile_fields',10,1);


/*-------------------------------------------*/
/*投稿一覧に「サムネイル」「スラッグ」「文字数」追加
/*-------------------------------------------*/

function add_posts_columns($columns) {
    $columns['thumbnail'] = 'サムネイル';
    $columns['slug'] = 'スラッグ';
    $columns['count'] = '文字数';

    echo '<style type="text/css">
	.fixed .column-thumbnail {width: 90px;}
	.fixed .column-slug, .fixed .column-count {width: 10%;}
	</style>';

    return $columns;
}
function add_posts_columns_row($column_name, $post_id) {
    if ( 'thumbnail' == $column_name ) {
        $thumb = get_the_post_thumbnail($post_id, array(80,80), 'thumbnail');
        echo ( $thumb ) ? $thumb : '－';
    } elseif ( 'slug' == $column_name ) {
        $slug = get_post($post_id) -> post_name;
        echo $slug;
    } elseif ( 'count' == $column_name ) {
        $count = mb_strlen(strip_tags(get_post_field('post_content', $post_id)));
        echo $count;
    }
}
add_filter( 'manage_posts_columns', 'add_posts_columns' );
add_action( 'manage_posts_custom_column', 'add_posts_columns_row', 10, 2 );



/*-------------------------------------------*/
/*投稿一覧のコメントを削除
/*-------------------------------------------*/
function custom_columns ($columns) {
    unset($columns['comments']);
    return $columns;
}
add_filter( 'manage_posts_columns', 'custom_columns' );



/*-------------------------------------------*/
/*投稿画面のスラッグ入力欄を拡げる
/*-------------------------------------------*/
function ryus_expand_slug_input(){
    global $pagenow;
    if (is_admin() && ($pagenow=='post-new.php' || $pagenow=='post.php')) {
        echo '<style type="text/css">
            #post_name {
                width:500px;
            }
        </style>';
    }
}

add_action('admin_head', 'ryus_expand_slug_input');


/*-------------------------------------------*/
/*管理画面の「Wordpressのご利用ありがとうございます。」の文言を削除
/*-------------------------------------------*/
add_filter('admin_footer_text', '__return_empty_string');



/*-------------------------------------------*/
/*編集画面のタイトルに文字数カウンタを追加
/*-------------------------------------------*/
function excerpt_count_js(){
    echo '<script>jQuery(document).ready(function(){
jQuery("#titlewrap").after("<div style=\"position:absolute;top:5px;right:5px;color:#666;\"><small>文字数: </small><input type=\"text\" value=\"0\" maxlength=\"3\" size=\"3\" id=\"title_counter\" readonly=\"\" style=\"background:#fff;\"></div>");
     jQuery("#title_counter").val(jQuery("#title").val().length);
     jQuery("#title").keyup( function() {
     jQuery("#title_counter").val(jQuery("#title").val().length);
   });
});</script>';
}
add_action( 'admin_head-post.php', 'excerpt_count_js');
add_action( 'admin_head-post-new.php', 'excerpt_count_js');


/*-------------------------------------------*/
/*編集画面のスラッグに文字数カウンタを追加
/*-------------------------------------------*/
function slug_count_js(){
    echo '<script>jQuery(document).ready(function(){
jQuery("#slugdiv").append("<div style=\"position:absolute;top:5px;right:35px;color:#666;\"><small>文字数: </small><input type=\"text\" value=\"0\" maxlength=\"3\" size=\"3\" id=\"slug_counter\" readonly=\"\" style=\"background:#fff;\"></div>");
     jQuery("#slug_counter").val(jQuery("#post_name").val().length);
     jQuery("#post_name").keyup( function() {
     jQuery("#slug_counter").val(jQuery("#post_name").val().length);
   });
});</script>';
}
add_action( 'admin_head-post.php', 'slug_count_js');
add_action( 'admin_head-post-new.php', 'slug_count_js');




/*-------------------------------------------*/
/*	投稿画面パーマリンク非表示
/*-------------------------------------------*/
add_filter( 'get_sample_permalink_html', '__return_false' );


/*-------------------------------------------*/
/*	投稿画面　本文チェックリスト
/*-------------------------------------------*/
add_action( 'admin_head-post-new.php', 'add_body_check' ); // 新規投稿画面でフック
add_action( 'admin_head-post.php', 'add_body_check' );     // 投稿編集画面でフック
function add_body_check() {
?>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $("#postdivrich").after('<div class="postbox"><div class="inside"><small>書いた記事は下記項目をクリアしていますか？</small><br><ul><li><input type="checkbox" name="checklists" value="check01">見出しタグの順番は適切かチェック<a href="http://bazubu.com/how-to-use-h-tags-26344.html" target="_blank">参照ページ</a></li><li><input type="checkbox" name="checklists" value="check02">書き出しで問題提起・解決策・根拠を示している<a href="http://bazubu.com/web-writing-13266.html" target="_blank">参照ページ</a></li><li><input type="checkbox" name="checklists" value="check03">代名詞を使わないよう心がける。（心がける程度でいいです）</li><li><input type="checkbox" name="checklists" value="check04">最初の見出しの前に導入文を入れてください</li></ul></div></div>');
    });
</script>
<?php
}

/*-------------------------------------------*/
/*	投稿画面　参考文献
/*-------------------------------------------*/
function add_refarence_url() {
    echo "<ol style='margin-left:10px;'>
		<li><a href='http://bazubu.com/contet-seo-18508.html' target='_blank'>コンテンツSEOの効果と７つの手順</a></li>\n
		<li><a href='http://bazubu.com/seo-13666.html' target='_blank'>検索上位を独占するために弊社が行っている36の手順</a></li>\n
		<li><a href='http://bazubu.com/web-writing-13266.html' target='_blank'>たった1記事で8万人に読まれる文章を書けるようになるライティング術</a></li>\n
		<li><a href='http://bazubu.com/how-to-use-h-tags-26344.html' target='_blank'>見出しタグの使い方と絶対に知っておくべき注意点</a></li>
		<li><a href='http://bazubu.com/blogtitle-3527.html' target='_blank'>１０個の実例から学ぶ！読まれるブログ記事タイトルの６つのルール</a></li>
		";
}
function add_refarence_url_hooks() {
    add_meta_box('refarence_url', 'はじめに読んでください', 'add_refarence_url', 'post', 'side', 'high');
}
function add_refarence_url_init() {
    add_action('admin_menu', 'add_refarence_url_hooks');
}
add_action('init', 'add_refarence_url_init');


/*-------------------------------------------*/
/*	投稿画面　スラッグチェックリスト
/*-------------------------------------------*/
add_action( 'admin_head-post-new.php', 'add_slug_comment' ); // 新規投稿画面でフック
add_action( 'admin_head-post.php', 'add_slug_comment' );     // 投稿編集画面でフック
function add_slug_comment() {
?>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $("#slugdiv").append('<div class="inside"><small>スラッグは下記項目をクリアしていますか？</small><br><ul><li><input type="checkbox" name="checklists" value="check01">半角英数でキーワードのニュアンスと近い文字列・_（アンダーバー）でなく-（ハイフン）で記入・30文字以内程度</li></ul></div><br><div class="inside"><a href="https://translate.google.co.jp/?hl=ja" target="_brank">翻訳はこちら</a></div>');
    });
</script>
<?php
}



/*-------------------------------------------*/
/*投稿タイトル部分のカスタマイズ　jsの中にmugyuu-admin.js追加してある
/*-------------------------------------------*/
//add_action('admin_enqueue_scripts', 'mugyuu_admin_asset');
add_action( 'admin_head-post-new.php', 'add_title_comment' ); // 新規投稿画面でフック
add_action( 'admin_head-post.php', 'add_title_comment' );     // 投稿編集画面でフック
function add_title_comment(){
?>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $("#edit-slug-box").hide();
        $("#titlediv").after('<div class="postbox"><div class="inside"><ul><li><input type="checkbox" name="checklists" value="check01">タイトルは32文字程度に収めましょう！（あくまで目安です）</li><li><input type="checkbox" name="checklists" value="check02">キーワードが含まれているか確認！</li><li><input type="checkbox" name="checklists" value="check03">ベネフィット（閲覧者が見たい内容）が伝わっているか確認！</li><li><input type="checkbox" name="checklists" value="check04">数字を入れて具体性を高める</li><li><input type="checkbox" name="checklists" value="check05">簡便性（手軽とか簡単等、ユーザーにメリットがあるようなニュアンス）が含まれている</li></ul></div></div>');

    });
</script>
<?
}


/*-------------------------------------------*/
/*	投稿画面　メディアを追加文言
/*-------------------------------------------*/
add_action( 'admin_head-post-new.php', 'add_media_comment' ); // 新規投稿画面でフック
add_action( 'admin_head-post.php', 'add_media_comment' );     // 投稿編集画面でフック
function add_media_comment() {
?>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $("#wp-content-editor-tools").after("<div class='postbox'><div class='inside'>画像素材はサイト構築表の中にある<a href='https://docs.google.com/spreadsheets/d/1aZYUJgjmFiNSU0Qka9HekY0zmWlIhVHUV7UpvpEBjcs/edit#gid=1494244059 プレビュー' target='_brank'>素材集のシート</a>から拾って下さい<br>サイズは横が900px以上のみを選んで下さい<br>アイキャッチ画像は横2：縦1程度の比率に合わせて下さい。（横のサイズの半分以上のサイズ）</div></div>");
    });
</script>
<?php
}

/*-------------------------------------------*/
/*	投稿画面　テーブル作成のボタンを追加
/*-------------------------------------------*/
add_action( 'admin_head-post-new.php', 'add_table_link' ); // 新規投稿画面でフック
add_action( 'admin_head-post.php', 'add_table_link' );     // 投稿編集画面でフック
function add_table_link() {
?>
<script type="text/javascript">
		jQuery(document).ready(function($){
			$("#wp-content-editor-container").before("<div class=\"quicktags-toolbar wp-editor-container\"><a target=\"_blank\" href=\"https://tabletag.net/ja/\" class=\"button\" style=\"margin:2px;height:26px\">テーブル作成</a></div>");
			 //ed_toolbar
    });
</script>
<?php
}


/*-------------------------------------------*/
/* 投稿画面　メタ入力追加
/*-------------------------------------------*/

add_action('admin_menu', 'add_custom_fields');
add_action('save_post', 'save_custom_fields');

// 記事ページと固定ページでカスタムフィールドを表示
function add_custom_fields() {
    add_meta_box( 'my_sectionid', 'メタ入力', 'my_custom_fields', 'post');
    add_meta_box( 'my_sectionid', 'メタ入力', 'my_custom_fields', 'page');
}

function my_custom_fields() {
    global $post;
    $keywords = get_post_meta($post->ID,'keywords',true);
    $description = get_post_meta($post->ID,'description',true);

    echo '<p>キーワード（半角カンマ区切り）<br>';
    echo '<input type="text" name="keywords" value="'.esc_html($keywords).'" size="60" /></p>';

    echo '<p>ページの説明（description）160文字以内<br>';
    echo '<textarea class="cancel-enter" style="width: 600px;height: 80px;" name="description" maxlength="160">'.esc_html($description).'</textarea></p>';

    echo '<div class="inside"><small>メタキーワード、ページの説明は下記項目をクリアしていますか？</small><br><ul><li><input type="checkbox" name="checklists" value="check01">キーワード：ドライブシートと一致したキーワードを入れましょう（最大4つ以内程度）</li><li><input type="checkbox" name="checklists" value="check02">ページの説明：適切に記入できているか？<a href="http://bazubu.com/how-to-optimize-meta-description-26891.html" target="_brank">参照ページ</a></li></ul></div>';
?>
	<script>
		jQuery('.cancel-enter').keydown(function(e) {
	    if(e.which == 13) { return false; }
		});
		jQuery('.cancel-enter').keyup(function(e) {
			var textarea = jQuery(this);
			var text = textarea.val();
			var new_text = text.replace(/\n/g, '');
			if(new_text != text) {
				textarea.val(new_text);
			}
		});
		function checkChange(e){
	    var old = v = jQuery(e).text();
	    return function(){
        v = jQuery(e).text();
        if(old != v) {
          old = v;
        }
	    }
		}
	</script>
<?php
}

// カスタムフィールドの値を保存
function save_custom_fields( $post_id ) {
    if(!empty($_POST['keywords']))
        update_post_meta($post_id, 'keywords', $_POST['keywords'] );
    else delete_post_meta($post_id, 'keywords');

    if(!empty($_POST['description']))
        update_post_meta($post_id, 'description', $_POST['description'] );
    else delete_post_meta($post_id, 'description');
}

function my_description() {
	// 初期値設定
	$robots = true;
	$paged = get_query_var('paged');
	# questionary
	if( preg_match('%^/questionary/.*%',$_SERVER['REQUEST_URI']) ){
		$questionary_str = "/questionary/";
		# questionary single view
		if( preg_match('%.*'.$questionary_str.'board/view/.*%',$_SERVER['REQUEST_URI']) ){
			global $wpdb;
			$board_id = str_replace($questionary_str."board/view/", "", $_SERVER['REQUEST_URI']);
			$board_id = strpos($board_id, '?') !== false ? strstr($board_id, "?", TRUE) : $board_id;//パラメータ以前を取得
			$query = "
				SELECT
					`title`,`overview`
				FROM
					`boards`
				WHERE
					`id` LIKE {$board_id}
				LIMIT 1
			";
			profiler::console($board_id );
			$results = $wpdb->get_results( $query, OBJECT );
			$board = current($results);
			if( !empty($board) )
			{
				$description = mb_strimwidth(str_replace("\r\n", " ", $board->overview), 0, 100, '...', 'utf-8');
				$title = $board->title.'｜'.get_bloginfo('name');
			}
		}elseif(
			preg_match('%.*'.$questionary_str.'$%',$_SERVER['REQUEST_URI']) ||
			preg_match('%.*'.$questionary_str.'board/$%',$_SERVER['REQUEST_URI'])
		){
		# 質問掲示板TOP
			$title = '質問掲示板｜'.get_bloginfo('name');
		}else{
			$robots = false;
		}
	}else{
		if( is_single() || is_page() ){
			$custom = get_post_custom(); #カスタムフィールドの値を読み込む
			$keywords = !empty($custom['keywords']) && is_array($custom['keywords'])?current($custom['keywords']):"";
			$description = !empty($custom['description']) && is_array($custom['description'])?current($custom['description']):"";

			if( is_page() ){// 固定ページ
				$title = get_the_title();
				if( !empty($paged) ){ $title .= '/'.$paged.'ページ目'; }
				$title .= get_bloginfo('name');
			}else{// 記事ページ
				$title = get_the_title().'｜'.get_bloginfo('name');
			}
		}elseif( is_home() ){// トップページ
			$title = get_bloginfo('name');
			$keywords = "子育て,育児,妊娠,出産";
			$description = get_bloginfo('description');
		}elseif( is_category() ){// カテゴリーページ
			$title = single_cat_title("",false)."の記事一覧";
			if( !empty($paged) ){ $title .= '/'.$paged.'ページ目'; }
			$title .= get_bloginfo('name');
			$description = single_cat_title("",false)."の記事一覧";
		}elseif( is_tag() ){// タグページ
			$title = single_tag_title("", false)."の記事一覧";
			$robots = false;
		}elseif( is_author() ){// authorページ
			$title = get_the_author()."の紹介ページ｜".get_bloginfo('name');
		}elseif( is_search () ){// 検索結果ページ
			$title = get_search_query()."の検索結果一覧｜".get_bloginfo('name');
		}elseif( is_404() ){//404
			$title = "お探しのページが見つかりません｜".get_bloginfo('name');
			$robots = false;
		}else{
			$robots = false;
		}
	}

	echo($robots === true ? '<meta name="robots" content="index, follow" />' : '<meta name="robots" content="noindex, follow" />');
	if( !empty($keywords) ){ echo("<meta name=\"keywords\" content=\"".$keywords."\">");}
	if( !empty($description) ){ echo("<meta name=\"description\" content=\"".$description."\" />");}
	if( !empty($title) ){ echo("<title>".$title."</title>"); }
}

/*-------------------------------------------*/
/*ダッシュボード非表示設定
/*-------------------------------------------*/
function edit_menus () {
	if (!current_user_can('administrator')) { //level10以以外（管理者でない場合）のユーザーの場合ウィジェットをremoveする
		remove_menu_page( 'index.php' );                  // ダッシュボード
		remove_menu_page( 'edit.php?post_type=page' );    // 固定ページ
		remove_menu_page( 'edit-comments.php' );          // コメント
		remove_menu_page( 'themes.php' );                 // 外観
		remove_menu_page( 'plugins.php' );                // プラグイン
		remove_menu_page( 'tools.php' );                  // ツール
		remove_menu_page( 'options-general.php' );        // 設定
		remove_menu_page( 'wpcf7' );   //Contact Form 7（お問い合わせ）
		if( !current_user_can('movie-editor') && !current_user_can('movie-author') ){
			// 動画系消す
			remove_menu_page('edit.php?post_type=movingimage_post');
    }
		if( !current_user_can('item-author') ){
      // 商品系消す
			remove_menu_page('edit.php?post_type=item_post');
		}
    if(current_user_can('movie-editor') || current_user_can('movie-author') || current_user_can('item-author')){
			// 通常投稿系消す
			remove_menu_page('edit.php');
		}
	}
}
add_action('admin_menu', 'edit_menus');

/*-------------------------------------------*/
/*管理画面バー、こんにちは◯◯さんを任意にする
/*-------------------------------------------*/
function replace_howdy( $wp_admin_bar ) {
    $my_account=$wp_admin_bar->get_node('my-account');
    $newtitle = str_replace( 'こんにちは、', 'お疲れ様です！', $my_account->title );
    $wp_admin_bar->add_node( array(
        'id' => 'my-account',
        'title' => $newtitle,
    ) );
}
add_filter( 'admin_bar_menu', 'replace_howdy',25 );



/*-------------------------------------------*/
/*記事編集ボタン（ログイン時のみ表示）
/*-------------------------------------------*/
function edit($the_content) {
    if (is_single() && is_user_logged_in()) {
        $return  = $the_content;
        $return .= '<a class="editScreen" target="_blank" href="'.get_edit_post_link().'">記事編集ページへ</a>';
        return $return;
    } else {
        return $the_content;
    }
}
add_filter('the_content','edit');




/*-------------------------------------------*/
// プロフィール画面カスタム(可能な限りフィルタで処理すべき)
/*-------------------------------------------*/
function add_user_data_form($bool)
{
    global $profileuser;
		echo('<pre>');
		echo('</pre>');
    if ( preg_match('/^(profile\.php|user-edit\.php)/', basename($_SERVER['REQUEST_URI'])) )
    { ?>

<tr>
    <th scope="row">肩書きやスキル等</th>
    <td>
				<textarea id="skill" name="skill"><?php the_author_meta("skill",$profileuser->ID) ?></textarea>
    </td>
</tr>

<?php }
    return $bool;
}
add_action('show_password_fields', 'add_user_data_form');

function update_user_data($user_id, $old_user_data)
{
    if ( isset($_POST['user_data1']) && $old_user_data->user_data1 != $_POST['user_data1'] )
    {
        $user_data1 = sanitize_text_field($_POST['user_data1']);
        $user_data1 = wp_filter_kses($user_data1);
        $user_data1 = _wp_specialchars($user_data1);

        update_user_meta($user_id, 'user_data1', $user_data1);
    }
}
add_action('profile_update', 'update_user_data', 10, 2);

remove_filter( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
remove_filter('show_password_fields', 'show_password_fields');

add_action( 'admin_head-profile.php', 'remove_columns' );     // プロフィール画面でフック
add_action( 'admin_head-user-edit.php', 'remove_columns' );

function remove_columns() {
    global $user_level;
    //get_currentuserinfo();
    wp_get_current_user();
?>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $("h2").each(function() {
            if($(this).text() == "Edit Author Slug")
            {
                var fieldset = $(this).next().next().find("fieldset");
                var meta_value = fieldset.children("#ba_eas_author_slug_custom").val();

                $(this).text("ライタースラッグ");
                $(this).next().text("ライター用のスラッグが設定できます。\n半角英字にて入力してください。");
                fieldset.html("<input type='text' name='ba_eas_author_slug' id='ba_eas_author_slug' class='regular-text' value='"+ meta_value +"'>");
            }
        });

        $("h3").each(function() {
            if($(this).text() == "Avatar") {
                $(this).hide();
                $(this).next().find("tr:eq(0) label").text('アイコン');
                $(this).next().find("tr:eq(1)").hide();
                $(this).next().find("tr:eq(0)").after("<tr><th></th><td colspan=2>ご自身・お子さんのお顔などの写真をお願いします！</td></tr>");
            }
        });

        $(".user-profile-picture").hide();
    });
</script>
<?php
    if ($user_level <= 7) {
?>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $(".user-rich-editing-wrap").hide();
        $(".user-comment-shortcuts-wrap").hide();
        $("#last_name").after("<br><p>姓名はサイトには公開されません・運営管理側で管理したいのでシートと同じお名前をお願いします</p>")
        $(".user-nickname-wrap label").text($(".user-nickname-wrap label").text().replace('ニックネーム','ライター名'));
        $("#nickname").after("<br>※サイトに出る名前です。<br>編集部の方は（【mugyuu編集部】ニックネームという形にして下さい）<br>特集更新の方はご自身のPRも含むのでご自身のサービス名＋本名が宜しいかと思います<br>（もしブログなどお持ちでしたらhttps://mugyuu.jp/もリンクでご紹介お願いします＾＾）");
        $(".user-display-name-wrap").hide();

        $(".user-email-wrap").hide();
        $("#skill").after("<br>編集部の方は　例）２児の子育て中ママなど<br>特集更新の方は　例）○○病院の医院長・○○マッサージ店長など")

        $(".user-description-wrap .description").html("こちらはご自身の特徴を書いて頂く事により閲覧者様がファンになる可能性があるためファンになって頂けそうな要素をご記入下さい<br>例）○歳児と○歳の男の子を育児中の主婦です！特に子供の便秘に悩まされて大変な思いをしたので是非ここでみなさんの役に立つコンテンツをご提供できたらと思います！<br>例）○○病院の院長です。特に子供のスキンケアに特化して診察を行っているので赤ちゃんや子供の肌の事はお任せ下さい！");

        $("h2").each(function() {
            if($(this).text() == "アカウント管理") { $(this).hide(); }
            if($(this).text() == "連絡先情報") { $(this).after("ご自身のサービスURLをプロフィールページで紹介頂けます。"); }
        });

        $("h3").each(function() {
            if($(this).text() == "Additional Capabilities")
            {
                $(this).hide();
                $(this).next().hide();
            }
        });

        $(".user-pass1-wrap").hide();
        $(".user-sessions-wrap.hide-if-no-js").hide();
        $("tr.user-role-wrap").hide();
    });
</script>
<?php
    }
}

/*-------------------------------------------*/
// 表示名を強制的にニックネーム(ライター名)にする
/*-------------------------------------------*/
function tml_user_register( $user_id ) {
    $nickname = $_POST['nickname'];
    unset($_POST['nickname']);
    if ( !empty( $nickname ) ) {
        $args = array(
            'ID' => $user_id,
            'display_name' => $nickname
        );
        wp_update_user( $args );
    }
}
add_action('profile_update', 'tml_user_register');



/*-------------------------------------------*/
// wp ログイン画面の画像変更
/*-------------------------------------------*/
function custom_login_logo() { ?>
<style>
    .login #login h1 a {
        width: 150px;
        height: 160px;
        background: url(<?php echo get_stylesheet_directory_uri();
            ?>/images/wp_logo.png) no-repeat center;
        background-size: 150px;
    }
</style>
<?php }
add_action( 'login_enqueue_scripts', 'custom_login_logo' );

function custom_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'custom_login_logo_url' );

function custom_login_logo_title() {
    return get_option( 'blogname' );
}
add_filter( 'login_headertitle', 'custom_login_logo_title' );

/*-------------------------------------------*/
// 管理画面に表示される記事一覧を権限によって制限する
/*-------------------------------------------*/
function filter_other_post( $wp_query ) {
    global $pagenow, $current_user, $post;

    if($pagenow != 'admin-ajax.php' && $pagenow != "edit.php" && $pagenow != 'post.php') { return; }

    if($current_user->roles[0] == "administrator") { return; }//管理者はすべて閲覧可能

    $args = array(
        'meta_query' => array(
            array(
                'key' => 'belongs_to_editor',
                'value' => $current_user->ID,
                'compare' => 'LIKE'
            )
        )
    );
    $users = get_users($args);
    $id_list = array($current_user->ID);
    foreach($users as $user) { $id_list[] = $user->ID;}
    // 記事編集画面
    if($pagenow == 'post.php') {
        if(!empty($post->post_author) && !in_array($post->post_author,$id_list)) { wp_redirect(admin_url());exit; }
    }

    // 絞り込み条件に権限のないユーザが含まれていた場合
    // 絞り込み条件がなかった場合
    if(empty($_GET['author']) || !in_array($_GET['author'], $id_list)) { $wp_query->query_vars['author__in'] = $id_list; }
}
add_action( 'pre_get_posts', 'filter_other_post' );


function add_filter_author() {
    global $current_user;

    $option = array(
        'name' => 'author',
        'show_option_none' => '',
    );

    // 管理者でない場合、表示できるユーザを絞る
    if($current_user->roles[0] !== "administrator") {
        $args = array(
            'meta_query' => array(
                array(
                    'key' => 'belongs_to_editor',
                    'value' => $current_user->ID,
                    'compare' => 'LIKE'
                )
            )
        );
        $users = get_users($args);
        $id_list = array($current_user->ID);
        foreach($users as $user) {
            $id_list[] = $user->ID;
        }
        $option += array('include'=>implode(',',$id_list));
    }

    $current_author = (isset($_GET['author'])) ?$_GET['author'] :'';

    global $post_type, $wpdb;
    if($post_type == 'post') { wp_dropdown_users($option); }
}
// 絞り込み検索に追加するフック
add_action('restrict_manage_posts', 'add_filter_author');


/*-------------------------------------------*/
// 所属する編集者の項目を追加
/*-------------------------------------------*/
function wpq_show_extra_profile_fields ( $user ) {
    global $current_user;
    if($current_user->roles[0] == "administrator") {
        $users = get_users( array('orderby'=>'ID','order'=>'ASC','role'=>'editor') );
?>
<h3>
    <?php _e( '所属する編集者'); ?>
</h3>
<table class="form-table">
    <tr>
        <th><label for="belongs_to_editor">
            <?php _e( '編集者名' ); ?>
            </label></th>
        <td><?php $value = get_the_author_meta( 'belongs_to_editor', $user->ID ); ?>
            <select name="belongs_to_editor" id="belongs_to_editor">
                <option value="">--未選択--</option>
                <?php foreach($users as $single_user): ?>
                <option value=<?php echo($single_user->ID)?> <?php echo $value == $single_user->ID?'selected':''?>><?php echo($single_user->data->display_name) ?></option>
                <?php endforeach; ?>
            </select></td>
    </tr>
</table>
<?php
    }
}
add_action ( 'show_user_profile', 'wpq_show_extra_profile_fields' );
add_action ( 'edit_user_profile', 'wpq_show_extra_profile_fields' );

/*-------------------------------------------*/
// 追加した項目の値を保存(編集)
/*-------------------------------------------*/
function wpq_save_extra_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ){ return false; }
    if(!empty($_POST['belongs_to_editor'])){
        update_user_meta( $user_id, 'belongs_to_editor', $_POST['belongs_to_editor'] );
    }
		if(!empty($_POST['skill'])){
        update_user_meta( $user_id, 'skill', $_POST['skill'] );
    }
}
add_action ( 'personal_options_update', 'wpq_save_extra_profile_fields' );
add_action ( 'edit_user_profile_update', 'wpq_save_extra_profile_fields' );

/*-------------------------------------------*/
// ユーザ新規作成画面カスタム
/*-------------------------------------------*/
function remove_columns_user_new() {
    global $user_level, $current_user;
    //get_currentuserinfo();
    wp_get_current_user();
		if( $current_user->roles[0] == "movie-editor" ){
?>
<script type="text/javascript">
    jQuery(document).ready(function($){
    	$("#role").val("movie-author");
    	alert($("#role").val());
		});
</script>
<?php
		}

    if ($user_level <= 7) {
?>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $("#createuser tr:last-child").hide();
    });
</script>
<?php
    }

    if($current_user->roles[0] == "editor" || $current_user->roles[0] == "movie-editor") {
?>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $("#createuser").prepend("<input type=\"hidden\" name=\"belongs_to_editor\" value=\"<?php echo($current_user->ID)?>\">");
    });
</script>
<?php
		}
}
add_action( 'admin_head-user-new.php', 'remove_columns_user_new' );

/*-------------------------------------------*/
// 所属する編集者の項目の値を保存(新規)
/*-------------------------------------------*/
function save_belongs_new( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ){ return false; }
    if(!empty($_POST['belongs_to_editor'])){
        update_user_meta( $user_id, 'belongs_to_editor', $_POST['belongs_to_editor'] );
    }
}
add_action ( 'user_register', 'save_belongs_new' );



/*-------------------------------------------*/
// 管理画面に表示されるユーザ一覧を権限によって制限する
/*-------------------------------------------*/
function filter_belongs( $wp_query ) {
    global $pagenow, $current_user, $post;

    if($pagenow != 'admin-ajax.php' && $pagenow != 'users.php' && $pagenow != "user-edit.php") { return; }

    if($current_user->roles[0] == "administrator") { return; }//管理者はすべて閲覧可能

    $wp_query->query_vars['meta_key'] = 'belongs_to_editor';
    $wp_query->query_vars['meta_value'] = $current_user->ID;
    $wp_query->query_vars['meta_compare'] = 'LIKE';
}
add_filter( 'pre_get_users', 'filter_belongs');

/*-------------------------------------------*/
// アンケート作成 メニュー
/*-------------------------------------------*/
add_action( 'admin_menu', 'my_plugin_menu' );

function my_plugin_menu() {
	if ( current_user_can( 'administrator' ) )  {
		add_submenu_page( 'post-new.php','Questionary', 'アンケート作成', 'manage_options', 'questionary-create', 'questionary_tab' );
	}
}

function questionary_tab() {
	if ( !current_user_can( 'administrator' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
	echo '<p>下記URLにてアンケートの作成ができます。</p><a href="https://mugyuu.jp/questionary/board/create">https://mugyuu.jp/questionary/board/create</a>';
	echo '</div>';
}


/*-------------------------------------------*/
// カスタム投稿：動画
/*-------------------------------------------*/
/* カスタム投稿タイプを追加 */
add_action( 'init', 'movingimage_post_type' );
function movingimage_post_type() {
    register_post_type( 'movingimage_post', //カスタム投稿タイプ名を指定
       array(
           'labels' => array(
               'name' => __( '動画投稿' ),
               'singular_name' => __( '動画投稿' ),
               'add_new' => '新規追加',
               'add_new_item' => '動画を新規追加',
               'edit_item' => '動画を編集する',
               'new_item' => '新規サイト',
               'all_items' => '動画一覧',
               'view_item' => '動画の説明を見る',
               'search_items' => '検索する',
               'not_found' => '動画が見つかりませんでした。',
               'not_found_in_trash' => 'ゴミ箱内に動画が見つかりませんでした。'
           ),
           'public' => true,
           'has_archive' => true, /* アーカイブページを持つ */
           'menu_position' =>5, //管理画面のメニュー順位　投稿の下
           'supports' => array( 'title', 'editor', 'thumbnail' ),
       )
      );
    /* カテゴリタクソノミー(カテゴリー分け)を使えるように設定する */
    register_taxonomy(
        'movingimage_cat', /* タクソノミーの名前 */
        'movingimage_post', /* 使用するカスタム投稿タイプ名 */
        array(
            'hierarchical' => true, /* trueだと親子関係が使用可能。falseで使用不可 */
            'update_count_callback' => '_update_post_term_count',
            'label' => '動画カテゴリー',
            'singular_label' => '動画カテゴリー',
            'public' => true,
            'show_ui' => true,
            'sort' => true,
        )
    );
    /* カテゴリタクソノミー、タグを使えるように設定する */
    register_taxonomy(
        'movingimage_tag', /* タクソノミーの名前 */
        'movingimage_post', /* 使用するカスタム投稿タイプ名 */
        array(
            'hierarchical' => false,
            'update_count_callback' => '_update_post_term_count',
            'label' => '動画タグ',
            'singular_label' => '動画タグ',
            'public' => true,
            'show_ui' => true,
            'sort' => true,
        )
    );
    flush_rewrite_rules(false);
}


/*------------------------------------------
// 動画用カスタムフィールド
/*------------------------------------------*/
add_action('admin_init', 'add_movie_field');
add_action('save_post', 'save_movie_field');

function add_movie_field(){
	add_meta_box( 'movie-box', '動画投稿', 'insert_movie_field', 'movingimage_post' );
}

function insert_movie_field($post){
	$movie = get_post_meta($post->ID, 'movie', true);
	echo("<textarea id=\"acf-field-movie\" style=\"width:100%\" name=\"movie\" rows=\"8\">$movie</textarea>");
}

function save_movie_field($post_id){
	$data = !empty($_POST['movie'])?$_POST['movie']:'';
	if( get_post_meta($post_id, 'movie', true) == "" && !empty($data) ){
		add_post_meta($post_id, 'movie', $data, true);
	}elseif( $data != get_post_meta($post_id, 'movie', true) ){
		update_post_meta($post_id, 'movie', $data);
	}elseif( empty($data) ){
		delete_post_meta($post_id, 'movie', get_post_meta($post_id, 'movie', true));
	}
}


/*-------------------------------------------*/
// カスタム投稿：商品
/*-------------------------------------------*/
/* カスタム投稿タイプを追加 */
add_action( 'init', 'item_post_type' );
function item_post_type() {
    register_post_type( 'item_post', //カスタム投稿タイプ名を指定
       array(
           'labels' => array(
               'name' => __( '商品投稿' ),
               'singular_name' => __( '商品投稿' ),
               'add_new' => '新規追加',
               'add_new_item' => '商品を新規追加',
               'edit_item' => '商品を編集する',
               'new_item' => '新規サイト',
               'all_items' => '商品一覧',
               'view_item' => '商品の説明を見る',
               'search_items' => '検索する',
               'not_found' => '商品が見つかりませんでした。',
               'not_found_in_trash' => 'ゴミ箱内に商品が見つかりませんでした。'
           ),
           'public' => true,
           'has_archive' => true, /* アーカイブページを持つ */
           'menu_position' =>5, //管理画面のメニュー順位　投稿の下
           'supports' => array( 'title', 'editor', 'thumbnail' , 'comments'),
       )
      );
    /* カテゴリタクソノミー(カテゴリー分け)を使えるように設定する */
    register_taxonomy(
        'item_cat', /* タクソノミーの名前 */
        'item_post', /* 使用するカスタム投稿タイプ名 */
        array(
            'hierarchical' => true, /* trueだと親子関係が使用可能。falseで使用不可 */
            'update_count_callback' => '_update_post_term_count',
            'label' => '商品カテゴリー',
            'singular_label' => '商品カテゴリー',
            'public' => true,
            'show_ui' => true,
            'sort' => true,
        )
    );
    /* カテゴリタクソノミー、タグを使えるように設定する */
    register_taxonomy(
        'item_tag', /* タクソノミーの名前 */
        'item_post', /* 使用するカスタム投稿タイプ名 */
        array(
            'hierarchical' => false,
            'update_count_callback' => '_update_post_term_count',
            'label' => '商品タグ',
            'singular_label' => '商品タグ',
            'public' => true,
            'show_ui' => true,
            'sort' => true,
        )
    );
    flush_rewrite_rules(false);
}


/*------------------------------------------
// 商品用カスタムフィールド
------------------------------------------*/
//値段
add_action('admin_init', 'add_item_field');
add_action('save_post', 'save_item_field');

function add_item_field(){
    add_meta_box( 'item-box', '値段', 'insert_item_field', 'item_post' );
}

function insert_item_field($post){
    $item = get_post_meta($post->ID, 'item', true);
    echo('<input name="item" type="text" size="30" id="item_price" value="' . $item . '">');
}



function save_item_field($post_id){
    $data = !empty($_POST['item'])?$_POST['item']:'';
    if( empty($data) || $data == ""){
        delete_post_meta($post_id, 'item', get_post_meta($post_id, 'item', true));
    }elseif( get_post_meta($post_id, 'item', true) == "" && !empty($data) ){
        add_post_meta($post_id, 'item', $data, true);
    }elseif( $data != get_post_meta($post_id, 'item', true) ){
        update_post_meta($post_id, 'item', $data);
    }
}


//公式URL
add_action('admin_init', 'add_url_field');
add_action('save_post', 'save_url_field');

function add_url_field(){
    add_meta_box( 'url-box', '公式ページURL', 'insert_url_field', 'item_post' );
}
function insert_url_field($post){
    $url = get_post_meta($post->ID, 'url', true);
    echo('<textarea id="item-url" style="width:100%" name="url" rows="5">' . $url . '</textarea>');
}


function save_url_field($post_id){
    $data = !empty($_POST['url'])?$_POST['url']:'';
    if( empty($data) || $data == ""){
        delete_post_meta($post_id, 'url', get_post_meta($post_id, 'url', true));
    }elseif( get_post_meta($post_id, 'url', true) == "" && !empty($data) ){
        add_post_meta($post_id, 'url', $data, true);
    }elseif( $data != get_post_meta($post_id, 'url', true) ){
        update_post_meta($post_id, 'url', $data);
    }
}


function get_my_bottom_category($categories) {

  $cats = get_the_category();   // 配列を取得
  $count_cat = count($cats);

  $new_cats = array();  // 新しい配列を用意
  for($i = 0; $i < $count_cat; $i++) {
    $ancestors = get_ancestors( $cats[$i]->cat_ID, 'category' );
    $count_anc = count($ancestors);
    $new_cats[$count_anc] = $cats[$i];  // 先祖の数をキーとした要素
  }
  krsort($new_cats);    // キーで逆順ソートする
  $cat = reset($new_cats);  // reset()の戻り値は先頭の要素

  return $cat;
}




    //コメントリスト表示用カスタマイズコード
function mytheme_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    $score = get_comment_meta(get_comment_ID(), 'score', true);
    $title = get_comment_meta(get_comment_ID(), 'title', true);
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
    <div id="comment-<?php comment_ID(); ?>" class="userData">
        <div class="dataArea">
            <p class="name">
                <i class="fa fa-user" aria-hidden="true"></i>
                <?php printf(__('%s'), get_comment_author_link()) ?>
            </p>
            <p class="date">
                <?php echo get_comment_date(('Y/m/d')) ?>
            </p>
        </div>
        <div class="starArea">
            <?php for($i=0;$score>$i;$i++){?>
            <i class="fa fa-star on" aria-hidden="true"></i>
            <?php } ?>
            <?php for($i=5;$score<$i;$i--){?>
            <i class="fa fa-star" aria-hidden="true"></i>
            <?php } ?>
        </div>
    </div>
        <?php if ($comment->comment_approved == '0') : ?>
        <em><?php _e('Your comment is awaiting moderation.') ?></em>
        <br />
        <?php endif; ?>
        <div class="contentArea">
            <p class="title">
                <?php echo($title)?>
            </p>
            <?php comment_text() ?>
        </div>

</li>
    <?php
}
    ?>
<?php
# 商品検索時ajax処理
function itemsearch_callback(){
    $term_id = $_GET['term_id'];
    $children = get_term_children( $term_id, 'item_cat' );
    if( !empty( $children ) ){
        $args = array('include' => $children );
        $terms = get_terms( 'item_cat', $args );
        $html="";
        foreach( $terms as $term ){
            $html .=  '<label><input type="checkbox" name="cat[]" value="' . $term->term_id . '">' . $term->name .'</label>';
        }
        echo ($html);
    }
    die();
}
add_action('wp_ajax_itemsearch','itemsearch_callback');
add_action('wp_ajax_nopriv_itemsearch', 'itemsearch_callback');
?>
<?php
#コメント欄順序入れ替え
function move_comment_field_to_bottom( $fields ) {
$comment_field = $fields['comment'];
unset( $fields['comment'] );
$fields['comment'] = $comment_field;

return $fields;
}
add_filter( 'comment_form_fields', 'move_comment_field_to_bottom' );
?>
<?php
#コメント追加項目保存処理
add_action('comment_post', 'save_comment_meta');
function save_comment_meta($comment_id){
    $score = $_POST['score'];
    $title = $_POST['title'];

    if( !empty($score) ){
       $comment = get_comment($comment_id);
       $post_id = $comment->comment_post_ID;

       $total_score = get_post_meta($post_id, 'total_score', true);
       $total_score += $score;
       $total_num = get_post_meta($post_id, 'total_num', true);
       $total_num++;

       update_post_meta( $post_id, 'total_score', $total_score);
       update_post_meta( $post_id, 'total_num', $total_num);
       update_post_meta( $post_id, 'average_score', round($total_score/$total_num));
    }
    return update_comment_meta( $comment_id, 'score', $score, true) && update_comment_meta( $comment_id, 'title', $title, true);
}
# コメント必須項目追加
function preprocess_comment_author( $commentdata ) {
    if( empty($_POST['title']) ){ wp_die('タイトルを入力して下さい。');}
    if( empty($_POST['score']) ){ wp_die('評価を入力してください。'); }

    return $commentdata;
}
add_filter('preprocess_comment', 'preprocess_comment_author', 2, 1);
?>
