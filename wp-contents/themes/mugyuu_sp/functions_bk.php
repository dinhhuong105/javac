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
add_theme_support( 'post-thumbnails' ); //アイキャッチ画像を使用する
//set_post_thumbnail_size(75, 75, true); サイズを指定して切り抜き
add_image_size( 'list_thumbnail', 75, 75, true ); //一覧サムネイル
add_image_size( 'slide_thumbnail', 640, 200, true ); //スライドエリア用
add_image_size( 'single_thumbnail', 300, 200, true ); //singleエリア用

//pc
add_image_size( '900_thumbnail', 900, 400,true ); //スライドpc
add_image_size( '320_thumbnail', 320, 200, true ); //pc一覧用320px
add_image_size( '200_thumbnail', 200, 150, true ); //pc一覧用200px topランキング部分
add_image_size( 'ranking_thumbnail', 200, 170, true ); //pc一覧用200px ランキング一覧部分
add_image_size( '670_thumbnail', 670, 450, true ); //pc シングルtop


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
            $categories = get_the_category($post->ID);
            $cat = $categories;
            $catId = $categories[0]->cat_ID;
            usort( $cat , '_usort_terms_by_ID');
            $ancestors = array( $cat -> cat_name );
            if ($catId == 1) {
                    foreach($ancestors as $ancestor){
                        $str;  
                    }
                $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_category_link($cat[0] -> term_id). '" itemprop="url" ><span itemprop="title">'. $cat[0]-> cat_name . '</span></a></li>';
                } else {
                    foreach($ancestors as $ancestor){
                        $str;
                    }
                $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_category_link($cat[1] -> term_id). '" itemprop="url" ><span itemprop="title">'. $cat[1]-> cat_name . '</span><i class="fa fa-chevron-right arrowIcon"></i></a></li>';
                $str.= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_category_link($cat[2] -> term_id). '" itemprop="url" ><span itemprop="title">'. $cat[2]-> cat_name .'</span></a></li>';
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

            $str.='<li class="cat" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">' . $cat -> name . '</span></li>';
        }

        /* タグページ */
        elseif(is_tag()){
            $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. single_tag_title( '' , false ). '</span></li>';
        }

        /* 時系列アーカイブページ */
        elseif(is_date()){
            if(get_query_var('day') != 0){
                $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_year_link(get_query_var('year')). '" itemprop="url" ><span itemprop="title">' . get_query_var('year'). '年</span></a></li>';
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
            $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">お探しの記事は見つかりませんでした。</span></li>';
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

/*-------------------------------------------*/
/* WordPress Popular Postsのカスタマイズ
/* ランキング部分
/*-------------------------------------------*/

function my_custom_popular_posts_html_list( $mostpopular, $instance ){
    $output = '<ul class="articleList rankingList">';

    // 人気記事ランキングのループ処理
    foreach( $mostpopular as $popular ) {

        // URL
        $url = get_the_permalink( $popular->id );
        // サムネイル
        $thumb = get_the_post_thumbnail( $popular->id );
        // カテゴリー
        $category = get_the_category($popular->id);
        usort( $category , '_usort_terms_by_ID');//タームID順に取得
        // ページビュー
        $views = number_format_i18n($popular->pageviews);
        // タイトル
        $title = get_the_title($popular->id);
        // 投稿者
        $author = get_the_author_meta('display_name', $popular->uid);
        // 日付
        $date = date_i18n($instance['stats_tag']['date']['format'], strtotime($popular->date));

        $output .= '<li>';
        $output .=      '<a href="'. $url .'">';
        $output .=         '<div class="imgArea">' . $thumb . '</div>';
        $output .=         '<div class="content">';
        $output .=             '<div class="articleData">';
        $output .=                 '<p class="data">'. $date .'</p>';
        $output .=                 '<p class="cat">'. $category[2]->cat_name . "</p>";
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

    $output .= '</ul>';

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
        if( 'post' == $('#post_type').val() ){ // post_type 判定。例は投稿ページ。固定ページ、カスタム投稿タイプは適宜追加
            $("#post").submit(function(e){ // 更新あるいは下書き保存を押したとき
                if('' == $('#title').val()) { // タイトル欄の場合
                    alert('タイトルを入力してください！');
                    $('.spinner').hide(); // spinnerアイコンを隠す
                    $('#publish').removeClass('button-primary-disabled'); // #publishからクラス削除
                    $('#title').focus(); // 入力欄にフォーカス
                    return false;
                }
                if($("#taxonomy-category input:checked").length < 1 ) { // カテゴリーがチェックされているかどうか。条件を要確認。普通は設定したカテゴリーになるから要らない
                    alert('カテゴリーを選択してください');
                    $('.spinner').hide();
                    $('#publish').removeClass('button-primary-disabled');
                    $('#taxonomy-category').focus();
                    return false;
                }
                if($("#post_name").val() == '') {
                    alert('スラッグを入力してください！');
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
    $contactmethods['skill'] = '肩書きやスキル等';
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
        $("#wp-content-editor-tools").after("<div class='postbox'><div class='inside'>画像素材はサイト構築表の中にある<a href='https://docs.google.com/spreadsheets/d/1aZYUJgjmFiNSU0Qka9HekY0zmWlIhVHUV7UpvpEBjcs/edit#gid=1494244059 プレビュー' target='_brank'>素材集のシート</a>から拾って下さい<br>サイズは横が640以上のみを選んで下さい<br>縦長になるような画像の場合は使用しないでください（見栄えの問題で）</div></div>");
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
    echo '<input type="text" style="width: 600px;height: 40px;" name="description" value="'.esc_html($description).'" maxlength="160" /></p>';

    echo '<div class="inside"><small>メタキーワード、ページの説明は下記項目をクリアしていますか？</small><br><ul><li><input type="checkbox" name="checklists" value="check01">キーワード：ドライブシートと一致したキーワードを入れましょう（最大4つ以内程度）</li><li><input type="checkbox" name="checklists" value="check02">ページの説明：適切に記入できているか？<a href="http://bazubu.com/how-to-optimize-meta-description-26891.html" target="_brank">参照ページ</a></li></ul></div>';
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

    // カスタムフィールドの値を読み込む
    $custom = get_post_custom();
    if(!empty( $custom['keywords'][0])) {
        $keywords = $custom['keywords'][0];
    }
    if(!empty( $custom['description'][0])) {
        $description = $custom['description'][0];
    }
?>
<?php if(is_home()): // トップページ ?>
<meta name="robots" content="index, follow" />
<meta name="keywords" content="赤ちゃん,こども,ママ">
<meta name="description" content="Mugyuu!は妊娠・出産・育児と大変なママさんたちをちょっとでも応援するサイトです" />
<?php elseif(is_single()): // 記事ページ ?>
<meta name="robots" content="index, follow" />
<meta name="keywords" content="<?php echo $keywords ?>">
<meta name="description" content="<?php echo $description ?>">
<?php elseif(is_page()): // 固定ページ ?>
<meta name="robots" content="index, follow" />
<meta name="keywords" content="<?php echo $keywords ?>">
<meta name="description" content="<?php echo $description ?>">
<?php elseif (is_category()): // カテゴリーページ ?>
<meta name="robots" content="index, follow" />
<meta name="description" content="<?php single_cat_title(); ?>の記事一覧" />
<?php elseif (is_tag()): // タグページ ?>
<meta name="robots" content="noindex, follow" />
<meta name="description" content="<?php single_tag_title("", true); ?>の記事一覧" />
<?php elseif(is_404()): // 404ページ ?>
<meta name="robots" content="noindex, follow" />
<title><?php echo 'お探しのページが見つかりませんでした'; ?></title>
<?php else: // その他ページ ?>
<meta name="robots" content="noindex, follow" />
<?php endif; ?>
<?php
}

/*-------------------------------------------*/
/*管理者以外はダッシュボード非表示
/*-------------------------------------------*/
function remove_menus () {
    if (!current_user_can('level_10')) { //level10以下（管理者でない場合）のユーザーの場合ウィジェットをremoveする
        remove_menu_page( 'index.php' );                  // ダッシュボード
        remove_menu_page( 'edit.php?post_type=page' );    // 固定ページ
        remove_menu_page( 'edit-comments.php' );          // コメント
        remove_menu_page( 'themes.php' );                 // 外観
        remove_menu_page( 'plugins.php' );                // プラグイン
        remove_menu_page( 'users.php' );                  // ユーザー
        remove_menu_page( 'tools.php' );                  // ツール
        remove_menu_page( 'options-general.php' );        // 設定
        remove_menu_page('wpcf7');   //Contact Form 7（お問い合わせ）
    }
}
add_action('admin_menu', 'remove_menus');

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
remove_filter( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
remove_filter('show_password_fields', 'show_password_fields');

add_action( 'admin_head-profile.php', 'remove_columns' );     // プロフィール画面でフック
function remove_columns() {
    global $user_level;
    get_currentuserinfo();

    if (10 != $user_level) {
?>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $(".user-rich-editing-wrap").hide();
        $(".user-comment-shortcuts-wrap").hide();
        $("#last_name").after("<br><p>姓名はサイトには公開されません・運営管理側で管理したいのでシートと同じお名前をお願いします</p>")
        $(".user-nickname-wrap label").text($(".user-nickname-wrap label").text().replace('ニックネーム','ライター名'));
        $("#nickname").after("<br>※サイトに出る名前です。<br>編集部の方は（【mugyuu編集部】ニックネームという形にして下さい）<br>特集更新の方はご自身のPRも含むのでご自身のサービス名＋本名が宜しいかと思います");
        $(".user-display-name-wrap").hide();

        $(".user-email-wrap").hide();
        $("#skill").after("<br>編集部の方は　例）２児の子育て中ママなど<br>特集更新の方は　例）○○病院の医院長・○○マッサージ店長など")

        $(".user-description-wrap .description").html("こちらはご自身の特徴を書いて頂く事により閲覧者様がファンになる可能性があるためファンになって頂けそうな要素をご記入下さい<br>例）○歳児と○歳の男の子を育児中の主婦です！特に子供の便秘に悩まされて大変な思いをしたので是非ここでみなさんの役に立つコンテンツをご提供できたらと思います！<br>例）○○病院の院長です。特に子供のスキンケアに特化して診察を行っているので赤ちゃんや子供の肌の事はお任せ下さい！");


        $("h2").each(function() {
            if($(this).text() == "アカウント管理") { $(this).hide(); }
            if($(this).text() == "連絡先情報") { $(this).after("ご自身のサービスURLをプロフィールページで紹介頂けます。"); }
        });
        $("h3").each(function() {
            if($(this).text() == "Avatar") {
                $(this).hide();
                $(this).next().find("tr:eq(0) label").text('アイコン');
                $(this).next().find("tr:eq(1)").hide();
                $(this).next().find("tr:eq(0)").after("<tr><th></th><td colspan=2>ご自身・お子さんのお顔などの写真をお願いします！</td></tr>");
            }
        });

        $(".user-pass1-wrap").hide();
        $(".user-sessions-wrap.hide-if-no-js").hide();

        $(".user-profile-picture").hide();

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
        background: url(<?php echo get_stylesheet_directory_uri(); ?>/images/wp_logo.png) no-repeat center;
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