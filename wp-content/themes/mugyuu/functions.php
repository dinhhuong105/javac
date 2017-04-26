<?php
/*------------------------------------------
//ユーザーエージェント判定
------------------------------------------*/
function cf_is_mobile() {
	$cf_is_mobile = isset($_SERVER['HTTP_CLOUDFRONT_IS_MOBILE_VIEWER']) ? $_SERVER['HTTP_CLOUDFRONT_IS_MOBILE_VIEWER'] : null;
	$cf_is_tablet = isset($_SERVER['HTTP_CLOUD_FRONT_IS_TABLET_VIEWER']) ? $_SERVER['HTTP_CLOUD_FRONT_IS_TABLET_VIEWER'] : null;
	return wp_is_mobile() || $cf_is_mobile === 'true'|| $cf_is_tablet === 'true';
}

/*------------------------------------------
//　is_mobile設定
------------------------------------------*/
function is_mobile()
{
    $useragents = array(
        'iPhone', // iPhone
        'iPod', // iPod touch
        'Android.*Mobile', // 1.5+ Android
        'Windows.*Phone', // Windows Phone
        'dream', // Pre 1.5 Android
        'CUPCAKE', // 1.5+ Android
        'blackberry9500', // Storm
        'blackberry9530', // Storm
        'blackberry9520', // Storm v2
        'blackberry9550', // Storm v2
        'blackberry9800', // Torch
        'webOS', // Palm Pre Experimental
        'incognito', // Other iPhone browser
        'webmate', // Other iPhone browser
    );
    $pattern = '/'.implode('|', $useragents).'/i';

    return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
}



/*-------------------------------------------*/
/* canonicalを吐き出さないようにする
/*-------------------------------------------*/
remove_action('wp_head', 'rel_canonical');



/*-------------------------------------------*/
/* リダイレクト処理
/*-------------------------------------------*/
function custom_handle_404() {
    $url = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $exclude = [
        site_url().'/page', // トップのパジネーションを除外
        // site_url().'/test'  // 除外ページを追加したい場合
    ];

    foreach($exclude as $e) {
        if(strpos($url, $e) !== false) {
            wp_redirect(site_url());    // トップページにリダイレクト
        }
    }

}
add_action('template_redirect', 'custom_handle_404');

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

//sp
add_image_size('list_thumbnail', 150, 150, true); //一覧サムネイル
add_image_size('300_thumbnail', 300, 300, true); //動画用サムネイル
add_image_size( '600_thumbnail', 600, 400, true ); //商品single
//pc
add_image_size( '900_thumbnail', 900, 400,true ); //スライド
add_image_size( 'pcList_thumbnail', 336, 210, true ); //一覧用325px
add_image_size( '200_thumbnail', 200, 150, true ); //一覧用200px topランキング部分
add_image_size( '320_thumbnail', 320, 320, true ); //動画用



/*-------------------------------------------*/
/* パンくずリスト
/*-------------------------------------------*/
function breadcrumb(){
    global $post;
    $str ='';
    if(!is_home()&&!is_admin()){ /* !is_admin は管理ページ以外という条件分岐 */
        $str.= '<div id="breadcrumb">';
        $str.= '<ul class="breadcrumbList">';
        $str.= '<li><a href="' . home_url('/') .'">トップ</a></li>';

        /* 投稿のページ */
        if(is_single() || $post->post_type === "thread_post" || $post->post_type === "question_post"){
                if( $post->post_type === "movingimage_post" || $post->post_type === "movie_post"){//動画、レシピ
					 if($post->post_type === "movingimage_post") {
                         $str.='<li><i class="fa fa-angle-right arrowIcon"></i><a href="'. home_url('/') .'recipe-list"><span>レシピ</span></a></li>';
						 $cats = get_the_terms($post->ID,"movingimage_cat");
					 }elseif($post->post_type === "movie_post") {
						  $cats = get_the_terms($post->ID,"movie_cat");
					 }
				usort( $cats , '_usort_terms_by_ID');
                // var_dump($cats);
                //    $cats = get_the_terms($post->ID, 'movingimage_cat');
				// 	$taxonomy = $cats->taxonomy;
				//    $count_cat = is_array($cats)?count($cats):0;
                //    $new_cats = array();
                //    for($i = 0; $i < $count_cat; $i++) {
                //             $ancestors = get_ancestors( $cats[$i]->term_id, $taxonomy );
                //             $count_anc = count($ancestors);
                //             $new_cats[$count_anc] = $cats[$i];  // 先祖の数をキーとした要素
                //    }
				//     var_dump($new_cats);
                //    ksort($new_cats);    // キーでソートする
                   foreach($cats as $cat){
                            $str.='<li><i class="fa fa-angle-right arrowIcon"></i><a href="'.get_category_link($cat->term_id). '"><span>'. $cat->name . '</span></a></li>';
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
                        $str.='<li><i class="fa fa-angle-right arrowIcon"></i><a href="'.get_category_link($cat->term_id). '"><span>'. $cat->name . '</span></a></li>';
                        // if( $cat->term_id != $end_term_id ){$str .= '<i class="fa fa-angle-right arrowIcon"></i>';}
                        // $str .= '</a></li>';
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
                $str.='<li><i class="fa fa-angle-right arrowIcon"></i><a href="'. get_category_link($cat[0]->term_id). '"><span>'. $cat[0]-> cat_name . '</span></a></li>';
            }else {
                $count = 0;
                foreach($ancestors as $ancestor){
                    $count += 1;
                    $str;
                }
                if($count === 4 ){
                    $str.='<li><i class="fa fa-angle-right arrowIcon"></i><a href="'. get_category_link($cat[1]->term_id). '"><span>'. $cat[1]->cat_name . '</span></a></li>';
                    $str.= '<li class="top"><i class="fa fa-angle-right arrowIcon"></i><span>'. $cat[2]->cat_name .'</span></li>';
                }elseif($count === 3) {
                    $str.='<li><i class="fa fa-angle-right arrowIcon"></i><a href="'. get_category_link($cat[1]->term_id). '"><span>'. $cat[1]->cat_name . '</span></a></li>';
                    $str.= '<li><i class="fa fa-angle-right arrowIcon"></i><a href="'. get_category_link($cat[2]->term_id). '"><span>'. $cat[2]->cat_name .'</span></a></li>';
                }elseif($count === 2){
                    $str.='<li><i class="fa fa-angle-right arrowIcon"></i><a href="'. get_category_link($cat[1]->term_id). '"><span>'. $cat[1]->cat_name . '</span></a></li>';
                    // $str.= '<li><i class="fa fa-angle-right arrowIcon"></i><a href="'. get_category_link($cat[2]->term_id). '"><span>'. $cat[2]->cat_name .'</span></a></li>';
                }else{
                    $str.='<li><i class="fa fa-angle-right arrowIcon"></i><a href="'. get_category_link($cat[0]->term_id). '"><span>'. $cat[0]->cat_name . '</span></a></li>';
                }
                // $str.='<li><i class="fa fa-angle-right arrowIcon"></i><a href="'. get_category_link($cat[1]->term_id). '"><span>'. $cat[1]->cat_name . '</span></a></li>';
                // $str.= '<li><i class="fa fa-angle-right arrowIcon"></i><a href="'. get_category_link($cat[2]->term_id). '"><span>'. $cat[2]->cat_name .'</span></a></li>';
                }
            }
        }
        /* 固定ページ ライター個人ページ*/
        elseif( is_page('author-more') ) {
            $author_id = $_GET['uID'];
            $author = get_userdata($author_id);
            $str.= '<li class="fixPage"><i class="fa fa-angle-right arrowIcon"></i><span>'. $author->display_name .'</span></li>';
        }
        /* 固定ページ */
        elseif(is_page()){
            if($post -> post_parent != 0 ){
                $ancestors = array_reverse(get_post_ancestors( $post->ID ));
                foreach($ancestors as $ancestor){
                    $str.='<li><i class="fa fa-angle-right arrowIcon"></i><a href="'. get_permalink($ancestor).'"><span>'. get_the_title($ancestor) .'</span></a></li>';
                }
            }
            $str.= '<li><i class="fa fa-angle-right arrowIcon"></i><span>'. $post->post_title .'</span></li>';
        }

        /* カテゴリページ */
        elseif(is_category()) {
            $cat = get_queried_object();
            $parent = get_category($cat->category_parent);
            $str.='<li><i class="fa fa-angle-right arrowIcon"></i><span>' . $cat->name . '</span></li>';
        }

        /* タグページ */
        elseif(is_tag()){
            $str.='<li><i class="fa fa-angle-right arrowIcon"></i><span>'. single_tag_title( '' , false ). '</span></li>';
        }

				/* レシピカテゴリーページ */
				elseif(is_tax('movingimage_cat')){
					$tax = get_queried_object();
                    $str.='<li><i class="fa fa-angle-right arrowIcon"></i><a href="'. home_url('/') .'recipe-list"><span>レシピ</span></a></li>';
					$breadcrumb = '<li><i class="fa fa-angle-right arrowIcon"></i><a href="'.get_category_link($tax->term_id).
						'"><span>'. $tax->name . '</span></a></li>';
					$tax_list = get_ancestors( $tax->term_id, 'movingimage_cat' );
					foreach( $tax_list as $tax_id ){
						$tax = get_term_by( 'id', $tax_id, 'movingimage_cat');
						$breadcrumb = '<li><i class="fa fa-angle-right arrowIcon"></i><a href="'.get_category_link($tax->term_id).
							'"><span>'. $tax->name . '</span></a></li>'.$breadcrumb;
					}
					$str .= $breadcrumb;
				}

				/* 動画カテゴリーページ */
				elseif(is_tax('movie_cat')){
					$tax = get_queried_object();
					$breadcrumb = '<li><i class="fa fa-angle-right arrowIcon"></i><a href="'.get_category_link($tax->term_id).
						'"><span>'. $tax->name . '</span></a></li>';

					$tax_list = get_ancestors( $tax->term_id, 'movingimage_cat' );
					foreach( $tax_list as $tax_id ){
						$tax = get_term_by( 'id', $tax_id, 'movingimage_cat');
						$breadcrumb = '<li><i class="fa fa-angle-right arrowIcon"></i><a href="'.get_category_link($tax->term_id).
							'"><span>'. $tax->name . '</span></a></li>'.$breadcrumb;
					}
					$str .= $breadcrumb;
				}

                /* 商品カテゴリーページ */
				elseif(is_tax('item_cat')){
					$tax = get_queried_object();
					$breadcrumb = '<li><i class="fa fa-angle-right arrowIcon"></i><a href="'.get_category_link($tax->term_id).
						'"><span>'. $tax->name . '</span></a></li>';

					$tax_list = get_ancestors( $tax->term_id, 'item_cat' );
					foreach( $tax_list as $tax_id ){
						$tax = get_term_by( 'id', $tax_id, 'item_cat');
						$breadcrumb = '<li><i class="fa fa-angle-right arrowIcon"></i><a href="'.get_category_link($tax->term_id).
							'"><span>'. $tax->name . '</span></a></li>'.$breadcrumb;
					}
					$str .= $breadcrumb;
				}

        /* 時系列アーカイブページ */
        elseif(is_date()){
            if(get_query_var('day') != 0){
                $str.='<li itemtype="http://data-vocabulary.org/"><a href="'. get_year_link(get_query_var('year')). '"><span>' . get_query_var('year'). '年</span></a></li>';
                $str.='<li><a href="'. get_month_link(get_query_var('year'), get_query_var('monthnum')). '"><span>'. get_query_var('monthnum') .'月</span></a></li>';
                $str.='<li><span>'. get_query_var('day'). '</span>日</li>';
            } elseif(get_query_var('monthnum') != 0){
                $str.='<li><a href="'. get_year_link(get_query_var('year')) .'"><span>'. get_query_var('year') .'年</span.</a></li>';
                $str.='<li><span>'. get_query_var('monthnum'). '</span>月</li>';
            } else {
                $str.='<li><span>'. get_query_var('year') .'年</span></li>';
            }
        }

        /* 投稿者ページ */
        elseif(is_author()){
            $str .='<li class="fixPage"><i class="fa fa-angle-right arrowIcon"></i><span>'. get_the_author_meta('display_name', get_query_var('author')).'</span></li>';
        }

        /* 添付ファイルページ */
        elseif(is_attachment()){
            if($post -> post_parent != 0 ){
                $str.= '<li><a href="'. get_permalink($post -> post_parent).'"><span>'. get_the_title($post -> post_parent) .'</span></a></li>';
            }
            $str.= '<li><span>' . $post -> post_title . '</span></li>';
        }

        /* 検索結果ページ */
        elseif(is_search()){
            $str.='<li class="fixPage"><i class="fa fa-angle-right arrowIcon"></i><span>「'. get_search_query() .'」の検索結果</span></li>';
        }

        /* 404 Not Found ページ */
        elseif(is_404()){
            $str.='<li class="fixPage"><i class="fa fa-angle-right arrowIcon"></i><span>お探しのページが見つかりません</span></li>';
        }

        /* その他のページ */
        else{
            $str.='<li><i class="fa fa-angle-right arrowIcon"></i><span>'. wp_title('', false) .'</span></li>';
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

    // if(empty($paged)) $paged = 2;//デフォルトのページ
	if(empty($paged)) $paged = 1;//デフォルトのページ  サーバー戻ったらこっちに直す

    if($pages == '')
    {
        global $wp_query;
        $pages = $wp_query->max_num_pages;//全ページ数を取得
        if(!$pages)//全ページ数が空の場合は、１とする
        {
            // $pages = 2;
			$pages = 1; //サーバー戻ったらこっちに直す
        }
    }

    if(1 != $pages)//全ページが１でない場合はページネーションを表示する
    {
        echo "<div class=\"pagination\">\n";
        echo "<ul>\n";
        //Prev：現在のページ値が１より大きい場合は表示
        // if($paged > 2) echo "<li class=\"prev\"><a href='".get_pagenum_link($paged - 1)."'><i class=\"fa fa-angle-left\"></i></a></li>\n";
		if($paged > 1) echo "<li class=\"prev\"><a href='".get_pagenum_link($paged - 1)."'><i class=\"fa fa-angle-left\"></i></a></li>\n"; //サーバー戻ったらこっちに直す

		// for ($i=2; $i <= $pages; $i++)
		for ($i=1; $i <= $pages; $i++)
        {
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
            {
                //三項演算子での条件分岐
                echo ($paged == $i)? "<li class=\"active\">".$i."</li>\n":"<li><a href='".get_pagenum_link($i)."'>".$i."</a></li>\n";
            }
        }
        //Next：総ページ数より現在のページ値が小さい場合は表示
        if ($paged < $pages) echo "<li class=\"next\"><a href=\"".get_pagenum_link($paged + 1)."\"><i class=\"fa fa-angle-right\"></i></a></li>\n";
        echo "</ul>\n";
        echo "</div>\n";
    }
}

/*-------------------------------------------*/
/* WordPress Popular Postsのカスタマイズ
/* ランキング部分
/*-------------------------------------------*/

function my_custom_popular_posts_html_list( $mostpopular, $instance ){

    $output = '';
    $postType = get_post($mostpopular[0]->id);

    if ( cf_is_mobile() ) { //spかどうか
        if ($postType->post_type === "movie_post") { //動画かどうか
            foreach( $mostpopular as $popular ) {
                // URL
                $url = get_the_permalink( $popular->id );
                // ページビュー
                $views = number_format_i18n($popular->pageviews);
                // タイトル
                $title = $popular->title;
                // 日付
                $date = date_i18n($instance['stats_tag']['date']['format'], strtotime($popular->date));
                // サムネイル
                $thumbnail_id = get_post_thumbnail_id($popular->id);
                $thumbnail = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );
                // カテゴリーネーム
                $category_name = '';
                // 投稿者
                $author = get_the_author_meta('display_name', $popular->uid);

				//動画投稿
 				$mv_cat = get_the_terms($popular->id, 'movie_cat');

                if( is_array($mv_cat) ){
                	usort( $mv_cat , '_usort_terms_by_ID');
                	$category_name = end($mv_cat)->name;
                  }else{
                        $category_name = "";
                  }

                $tmp_post = get_post($popular->id);

                $output .= '<li>';
                $output .=      '<a href="'. $url .'">';
                $output .=         '<div class="imgArea" style="background-image: url(' . $thumbnail[0] . ');">' ;
                $output .=                  '<img src="data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw==">';
                $output .=         '</div>';
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
        }elseif($postType->post_type === "movingimage_post") { //レシピかどうか
            foreach( $mostpopular as $popular ) {
                // URL
                $url = get_the_permalink( $popular->id );
                // ページビュー
                $views = number_format_i18n($popular->pageviews);
                // タイトル
                $title = $popular->title;
                // 日付
                $date = date_i18n($instance['stats_tag']['date']['format'], strtotime($popular->date));
                // サムネイル
                $thumbnail_id = get_post_thumbnail_id($popular->id);
                $thumbnail = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );
                // カテゴリーネーム
                $category_name = '';
                // 投稿者
                $author = get_the_author_meta('display_name', $popular->uid);

				//レシピ投稿
 				$mv_cat = get_the_terms($popular->id, 'movingimage_cat');

                $tmp_post = get_post($popular->id);

                $output .= '<li>';
                $output .=      '<a href="'. $url .'">';
                $output .=         '<div class="imgArea" style="background-image: url(' . $thumbnail[0] . ');">' ;
                $output .=                  '<img src="data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw==">';
                $output .=         '</div>';
                $output .=         '<h2>' . $title . '</h2>';
                $output .=      '</a>';
                $output .= '</li>';
            }
        }else {
            foreach( $mostpopular as $popular ) {
                // URL
                $url = get_the_permalink( $popular->id );
                // ページビュー
                $views = number_format_i18n($popular->pageviews);
                // タイトル
                $title = $popular->title;
                // 日付
                $date = date_i18n($instance['stats_tag']['date']['format'], strtotime($popular->date));
                // サムネイル
                $thumbnail_id = get_post_thumbnail_id($popular->id);
                $thumbnail = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );
                // 投稿者
                $author = get_the_author_meta('display_name', $popular->uid);
				$author_roles = get_the_author_meta('roles', $popular->uid);
				usort( $author_roles , '_usort_terms_by_ID');
				$author_id = $popular->uid;

                $category = get_the_category($popular->id);
                usort( $category , '_usort_terms_by_ID');//タームID順に取得
                $category_name = end($category)->cat_name;
                $category_id = $category[0]->cat_ID;

                $tmp_post = get_post($popular->id);

                $output .= '<li>';
                $output .=      '<a href="'. $url .'">';
                $output .=         '<div class="imgArea" style="background-image: url(' . $thumbnail[0] . ');">' ;
                $output .=                  '<img src="data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw==">';
                $output .=         '</div>';
                $output .=         '<div class="content">';
                $output .=             '<div class="articleData">';
                $output .=                 '<p class="data">'. $date .'</p>';
                $output .=                 '<p class="cat">'. $category_name . "</p>";
                $output .=             '</div>';
                $output .=             '<h2>' . $title . '</h2>';
                $output .=             '<div class="articleData">';
				if($author_id !== '66') {
					$output .=                 '<p class="name">';
					if($author_roles[0] === 'editor' || $author_roles[0] === 'movie-editor') {
						$output .=                '<span class="icon-mugyuu"></span>';
					}
					$output .=                      $author . '</p>';
				}
                $output .=                 '<p class="pv"><i class="fa fa-heart" aria-hidden="true"></i> '. $views . "</p>";
                $output .=             '</div>';
                $output .=         '</div>';
                $output .=      '</a>';
                $output .= '</li>';
            }
        }

    }else{//pcかどうか
        $postType = get_post($mostpopular[0]->id);
        if ($postType->post_type === "movie_post"){//pcで現在のsingleページが動画postの場合
               foreach( $mostpopular as $popular ) {
               // URL
               $url = get_the_permalink( $popular->id );
               // ページビュー
               $views = number_format_i18n($popular->pageviews);
               // タイトル
               $title = $popular->title;
               // 日付
               $date = date_i18n($instance['stats_tag']['date']['format'], strtotime($popular->date));
               // サムネイル
               $thumbnail_id = get_post_thumbnail_id($popular->id);
               $thumbnail = wp_get_attachment_image_src( $thumbnail_id, '300_thumbnail' );

               // カテゴリーネーム
               $category_name = '';
               // 投稿者
               $author = '';

				$mv_cat = get_the_terms($popular->id, 'movie_cat');

                if( is_array($mv_cat) ){
                	usort( $mv_cat , '_usort_terms_by_ID');
                	$category_name = end($mv_cat)->name;
                  }else{
                        $category_name = "";
                  }

                $output .= '<li>';
                $output .=      '<a href="'. $url .'">';
                $output .=          '<div class="content">';
                $output .=              '<div class="imgArea" style="background-image: url(' . $thumbnail[0] . ');">' ;
                $output .=                  '<img src="data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw==">';
                $output .=              '</div>';
                $output .=              '<div class="overlay">';
                $output .=                  '<div class="ovWrap">';
                $output .=                          '<div class="ttlArea">';
				$output .=                        	'<i class="icon fa fa-video-camera" aria-hidden="true"></i>';
                $output .=                              '<p>WATCH MORE</p>';
                $output .=                          '</div>';
                $output .=                          '<div class="contentData">';
                $output .=                              '<div class="articleData">';
                $output .=                                  '<p class="data">'. $date .'</p></p>';
                $output .=                                  '<p class="cat"> ' . $category_name . '</p>';
                $output .=                              '</div>';
                $output .=                              '<h2>' . $title . '</h2>';
                $output .=                              '<p class="pv"><i class="fa fa-heart" aria-hidden="true"></i> '. $views . "</p>";
                $output .=                          '</div>';
                $output .=                          '<div class="bd bdT"></div>';
                $output .=                          '<div class="bd bdB"></div>';
                $output .=                          '<div class="bd bdR"></div>';
                $output .=                          '<div class="bd bdL"></div>';
                $output .=                      '</div>';
                $output .=                  '</div>';
                $output .=            '</div>';
                $output .=         '</a>';
                $output .= '</li>';
            }
        }elseif ($postType->post_type === "movingimage_post"){//pcで現在のsingleページがレシピpostの場合
               foreach( $mostpopular as $popular ) {
               // URL
               $url = get_the_permalink( $popular->id );

               // タイトル
               $title = $popular->title;

               // サムネイル
               $thumbnail_id = get_post_thumbnail_id($popular->id);
               $thumbnail = wp_get_attachment_image_src( $thumbnail_id, '300_thumbnail' );

               // カテゴリーネーム
               $category_name = '';
               // 投稿者
               $author = '';

                $output .= '<li>';
                $output .=      '<a href="'. $url .'">';
                $output .=              '<div class="imgArea" style="background-image: url(' . $thumbnail[0] . ');">' ;
                $output .=                  '<img src="data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw==">';
                $output .=              '</div>';
				$output .=              '<h2>' . $title . '</h2>';
				$output .=				'<div class="overlay">';
				$output .=					'<div class="ovWrap">';
				$output .=						'<div class="ttlArea">';
				$output .=							'<span class="icon icon-recipe"></span>';
				$output .=							'<p>LET\'S TRY</p>';
				$output .=						'</div>';
				$output .=					'</div>';
				$output .=				'</div>';
                $output .=         '</a>';
                $output .= '</li>';
            }
        }else{
            foreach( $mostpopular as $popular ) {//pcで現在のsingleページが記事の場合
                // URL
                $url = get_the_permalink( $popular->id );
                // ページビュー
                $views = number_format_i18n($popular->pageviews);
                // タイトル
                $title = $popular->title;
                // 日付
                $date = date_i18n($instance['stats_tag']['date']['format'], strtotime($popular->date));
                // サムネイル
                $thumbnail_id = get_post_thumbnail_id($popular->id);
                $thumbnail = wp_get_attachment_image_src( $thumbnail_id, '200_thumbnail' );
                // 投稿者
                $author = get_the_author_meta('display_name', $popular->uid);
				$author_roles = get_the_author_meta('roles', $popular->uid);
				usort( $author_roles , '_usort_terms_by_ID');
				$author_id = $popular->uid;

                $category = get_the_category($popular->id);
                usort( $category , '_usort_terms_by_ID');//タームID順に取得
                $category_name = end($category)->cat_name;
                $category_id = $category[0]->cat_ID;

                $output .= '<li>';
                $output .=      '<a href="'. $url .'">';
                $output .=         '<div class="imgArea" style="background-image: url(' . $thumbnail[0] . ');">' ;
                $output .=             '<img src="data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw==">';
                $output .=             '<div class="overlay">';
                $output .=                  '<div class="ovWrap">';
                $output .=                      '<i class="icon-book2"></i>';
                $output .=                      '<p>READ MORE</p>';
                $output .=                      '<div class="bd bdT"></div>';
                $output .=                      '<div class="bd bdB"></div>';
                $output .=                      '<div class="bd bdR"></div>';
                $output .=                      '<div class="bd bdL"></div>';
                $output .=                  '</div>';
                $output .=             '</div>';
                $output .=         '</div>';
                $output .=         '<div class="content">';
                $output .=             '<div class="articleData">';
                $output .=                 '<p class="data">'. $date .'</p>';
                if($category_id !== 1) {
                    $output .=                 '<p class="cat">'. $category_name . "</p>";
                }
                $output .=             '</div>';
                $output .=             '<h2>' . $title . '</h2>';
                $output .=             '<div class="articleData">';
				if($author_id !== '66') {
					$output .=               '<p class="name">';
					if($author_roles[0] === 'editor' || $author_roles[0] === 'movie-editor') {
						$output .= '<span class="icon-mugyuu"></span>';
					}
					$output .=                 $author . '</p>';
				}
                $output .=                 '<p class="pv"><i class="fa fa-heart" aria-hidden="true"></i> '. $views . "</p>";
                $output .=             '</div>';
                $output .=         '</div>';
                $output .=      '</a>';
                $output .= '</li>';
            }
        }
    }

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
          $('#post_type').val() == 'movingimage_post'){ // post_type 判定。例は投稿ページ。固定ページ、カスタム投稿タイプは適宜追加
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

                if($('#post_type').val() == 'movie_post') {
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
    if ( 'post' == get_current_screen()->post_type ){ // 投稿のみ
        $columns['top'] = 'TOP';
    }

    echo '<style type="text/css">
	.fixed .column-thumbnail {width: 90px;}
	.fixed .column-slug, .fixed .column-count {width: 10%;}
    .fixed .column-top {width: 5%;}
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
    } elseif( 'top' == $column_name ) {
        $meta_array = get_post_meta($post_id);
        $top = $meta_array['_myplg_toppage'][0];
        if( $top === 'on'){
            echo 'TOP';
        }
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
/*	投稿画面　メディアを追加文言
/*-------------------------------------------*/
add_action( 'admin_head-post-new.php', 'add_media_comment' ); // 新規投稿画面でフック
add_action( 'admin_head-post.php', 'add_media_comment' );     // 投稿編集画面でフック
function add_media_comment() {
?>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $("#wp-content-editor-tools").after("<div class='postbox'><div class='inside'>画像素材はサイト構築表の中にある<a href='https://docs.google.com/spreadsheets/d/1aZYUJgjmFiNSU0Qka9HekY0zmWlIhVHUV7UpvpEBjcs/edit#gid=1494244059 プレビュー' target='_brank'>素材集のシート</a>から拾って下さい<br>サイズは横が900px以上のみを選んで下さい</div></div>");
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
	add_meta_box( 'my_sectionid', 'メタ入力', 'my_custom_fields', 'movingimage_post'); //レシピ投稿
	add_meta_box( 'my_sectionid', 'メタ入力', 'my_custom_fields', 'movie_post'); //動画投稿
	add_meta_box( 'my_sectionid', 'メタ入力', 'my_custom_fields', 'item_post'); //商品投稿
	// Update 2017.03.27 Hung Nguyen start
	add_meta_box( 'my_sectionid', 'メタ入力', 'my_custom_fields', 'thread_post'); //thread
	// Update 2017.03.27 Hung Nguyen end
    add_meta_box( 'my_sectionid', 'メタ入力', 'my_custom_fields', 'page');
}

function my_custom_fields() {
    global $post;
    $keywords = get_post_meta($post->ID,'keywords',true);
    $description = get_post_meta($post->ID,'description',true);

    echo '<p>キーワード（半角カンマ区切り）<br>';
    echo '<input type="text" name="keywords" value="'.esc_html($keywords).'" size="60" /></p>';

    echo '<p>ページの説明（description）・124文字以内　・上位表示させたいキーワードを入れる　・他ページと一緒の文言はNG！<br>';
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
	// global $post;
	// $my_nonce = isset($_POST['my_nonce']) ? $_POST['my_nonce'] : null;
	// if(!wp_verify_nonce($my_nonce, wp_create_nonce(__FILE__))) {
	// 	return $post_id;
	// }
	// if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $post_id; }
	// if(!current_user_can('edit_post', $post->ID)) { return $post_id; }

	if(!empty($_POST['keywords'])) {
        update_post_meta($post_id, 'keywords', $_POST['keywords'] );
	}
	if(!empty($_POST['description'])) {
        update_post_meta($post_id, 'description', $_POST['description'] );
	}
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
        $post = get_post_type();
        if(is_page('author-more')) {//ライター個人ページ
            $author_id = $_GET['uID'];
            $author = get_userdata($author_id);
            $description = $author->display_name . 'の記事一覧';
            $title = $author->display_name . 'の記事一覧です｜';
            $custom = get_post_custom();
            $keywords = !empty($custom['keywords']) && is_array($custom['keywords'])?current($custom['keywords']):"";
            if( !empty($paged) ){
                $title = $author->display_name . 'の記事一覧'.$paged.'ページ目｜';
                $description = $author->display_name . 'の記事一覧'.$paged.'ページ目です。';
            }
            $title .= get_bloginfo('name');
        }
        elseif(is_author()){ //author
            $author_id = $_GET['uID'];
            $author = get_userdata($author_id);
            $description = $author->display_name . 'のページです。';
            $title = $author->display_name . 'のページ｜'. get_bloginfo('name');
        }
		elseif( is_single() || is_page() ){
			$custom = get_post_custom(); #カスタムフィールドの値を読み込む
			$keywords = !empty($custom['keywords']) && is_array($custom['keywords'])?current($custom['keywords']):"";
			$description = !empty($custom['description']) && is_array($custom['description'])?current($custom['description']):"";
			if( is_page() ){// 固定ページ
                $title = get_the_title().'｜';
				if( !empty($paged) ){
                    $title .= $paged.'ページ目｜';
                    $description .= $paged.'ページ目';
                }
				$title .= get_bloginfo('name');
			} elseif($post === 'movingimage_post') {
                $title = 'レシピ『' .get_the_title().'』｜'.get_bloginfo('name');// レシピページ
            } else {// 記事ページ
				$title = get_the_title().'｜'.get_bloginfo('name');
			}
		} elseif( is_home() ) {// トップページ
			$title = get_bloginfo('name');
			$keywords = "子育て,育児,妊娠,出産";
			$description = get_bloginfo('description');
		}elseif( is_category() ){// カテゴリーページ
			$title = single_cat_title("",false)."の記事一覧";
            $description = single_cat_title("",false)."の記事一覧";
			if( !empty($paged) ){
                $title .= '/'.$paged.'ページ目';
                $description .= '/'.$paged.'ページ目';
            }
			$title .= get_bloginfo('name');
		}
        elseif( is_tax('movingimage_cat') ){//レシピ一覧ページ
            $tax = get_queried_object();
            if($tax->name === 'レシピ') {
                $title = '『' .$tax->name. '』一覧｜';
                $description = 'MUGYUU!『' .$tax->name. '』一覧です。';
                if( !empty($paged) ) {
                    $title = '『' .$tax->name. '』一覧'.$paged.'ページ目｜';
                    $description = 'MUGYUU!『' .$tax->name. '』一覧'.$paged.'ページ目です。';
                }
            }else{
                $title = '『' .$tax->name. '』のレシピ一覧｜';
                $description = 'MUGYUU!『' .$tax->name. '』のレシピ一覧です。';
                if( !empty($paged) ) {
                    $title = '『' .$tax->name. '』一覧'.$paged.'ページ目｜';
                    $description = 'MUGYUU!『' .$tax->name. '』のレシピ一覧'.$paged.'ページ目です。';
                }
            }
            $title .= get_bloginfo('name');
		}
        elseif( is_tax('movie_cat') ){//動画一覧ページ
            $tax = get_queried_object();
            $title = '『' . $tax->name. '』の動画一覧｜';
            $description = 'MUGYUU!『' .$tax->name. '』の動画一覧です';
            if( !empty($paged) ) {
                $title = '『' . $tax->name. '』の動画一覧'.$paged.'ページ目｜';
                $description = 'MUGYUU!『' .$tax->name. '』の動画一覧'.$paged.'ページ目です。';
            }
            $title .= get_bloginfo('name');
		}
        elseif( is_tag() ){// タグページ
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
		// if( !current_user_can('movie-editor') && !current_user_can('movie-author') ){
		// 	// 動画系消す
		// 	remove_menu_page('edit.php?post_type=movingimage_post');
		// } else {
		// 	// 通常投稿系消す
		// 	remove_menu_page('edit.php');
		// }
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
        $("#nickname").after("<br>※サイトに出る名前です。<br>特集更新の方はご自身のPRも含むのでご自身のサービス名＋本名が宜しいかと思います<br>（もしブログなどお持ちでしたらhttps://mugyuu.jp/もリンクでご紹介お願いします＾＾）");
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


/*-------------------------------------------*/
// 投稿一覧でユーザーの絞り込み検索追加
/*-------------------------------------------*/
function add_filter_author() {
    global $current_user;

    $option = array(
        'name' => 'author',
        'show_option_none' => '',
        'show_option_all' => 'すべてのユーザー',
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
    if($post_type == 'post' || $post_type == 'movingimage_post' || $post_type == 'movie_post' || $post_type == 'item_post' || $post_type == 'thread_post') {
		wp_dropdown_users($option);
	}
}
// 絞り込み検索に追加するフック
add_action('restrict_manage_posts', 'add_filter_author');


/*-------------------------------------------*/
// カスタム投稿の一覧でカテゴリ、タグの絞り込み検索を追加
/*-------------------------------------------*/

function todo_restrict_manage_posts() {
	global $typenow;
	$args=array( 'public' => true, '_builtin' => false );
	$post_types = get_post_types($args);
	if ( in_array($typenow, $post_types) ) {
	$filters = get_object_taxonomies($typenow);
		foreach ($filters as $tax_slug) {
			$tax_obj = get_taxonomy($tax_slug);
			wp_dropdown_categories(array(
				'show_option_all' => __($tax_obj->label),
				'taxonomy' => $tax_slug,
				'name' => $tax_obj->name,
				'orderby' => 'term_order',
				'hierarchical' => $tax_obj->hierarchical,
				'show_count' => true,
				'hide_empty' => true,
				'hide_if_empty' => true,
			));
		}
	}
}
function todo_convert_restrict($query) {
	global $pagenow;
	global $typenow;
	if ($pagenow=='edit.php') {
		$filters = get_object_taxonomies($typenow);
		foreach ($filters as $tax_slug) {
		$var = &$query->query_vars[$tax_slug];
		if ( isset($var) && $var>0)  {
			$term = get_term_by('id',$var,$tax_slug);
			$var = $term->slug;
			}
		}
	}
	return $query;
}
add_action( 'restrict_manage_posts', 'todo_restrict_manage_posts' );
add_filter('parse_query','todo_convert_restrict');


/*-------------------------------------------*/
// カスタム投稿の一覧でトップ記事の絞込検索
/*-------------------------------------------*/
function restrict_manage_posts_custom_field() {
	// 投稿タイプが投稿の場合 (カスタム投稿タイプのみに適用したい場合は 'post' をカスタム投稿タイプの内部名に変更してください)
	if ( 'post' == get_current_screen()->post_type ) {
		// カスタムフィールドのキー(名称例)
		$meta_key = '_myplg_toppage';

		// カスタムフィールドの値の一覧(例。「=>」の左側が保存されている値、右側がプルダウンに表示する名称です。)
		$items = array( '' => '全ての記事(top)', 'on' => 'トップ', 'off' => 'トップ以外' );
		// Advanced Custom Fields を導入してフィールドタイプをセレクトボックスなど
		// 選択肢のあるタイプにしている場合は下記のような形でも可です。
		// $field = get_field_object($meta_key);
		// $items = array_merge( array( '' => 'すべての色' ), $field['choices'] );

		// 選択されている値
		$selected_value = filter_input( INPUT_GET, $meta_key );

		// プルダウンのHTML
		$output = '';
		$output .= '<select name="' . esc_attr($meta_key) . '">';
		foreach ( $items as $value => $text ) {
			$selected = selected( $selected_value, $value, false );
			$output .= '<option value="' . esc_attr($value) . '"' . $selected . '>' . esc_html($text) . '</option>';
		}
		$output .= '</select>';

		echo $output;
	}
}
add_action( 'restrict_manage_posts', 'restrict_manage_posts_custom_field' );

//管理画面の投稿一覧に追加したカスタムフィールドの絞り込みの選択値を反映
function pre_get_posts_admin_custom_field( $query ) {
	// 管理画面 / 投稿タイプが投稿 / メインクエリ、のすべての条件を満たす場合
	// (カスタム投稿タイプのみに適用したい場合は 'post' をカスタム投稿タイプの内部名に変更してください)
	if ( is_admin() && 'post' == get_current_screen()->post_type && $query->is_main_query() ) {
		// カスタムフィールドのキー(名称例)
		$meta_key = '_myplg_toppage';
		// 選択されている値
		$meta_value = filter_input( INPUT_GET, $meta_key );

		// クエリの検索条件に追加
		// (すでに他のカスタムフィールドの条件がセットされている場合は条件を引き継いで新しい条件を追加する形になります)
		if ( strlen( $meta_value ) ) {
			$meta_query = $query->get( 'meta_query' );
			if ( ! is_array( $meta_query ) ) $meta_query = array();

			$meta_query[] = array(
				'key' => $meta_key,
				'value' => $meta_value
			);

			$query->set( 'meta_query', $meta_query );
		}
	}
}
add_action( 'pre_get_posts', 'pre_get_posts_admin_custom_field' );






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
        <td>
        <?php $values = get_the_author_meta( 'belongs_to_editor', $user->ID );?>
        <?php foreach($users as $single_user): ?>
          <input type="checkbox" name="belongs_to_editor[]" value="<?php echo($single_user->ID)?>" <?php echo in_array($single_user->ID, $values)?'checked':''?>><?php echo($single_user->data->display_name) ?>
					<br>
        <?php endforeach; ?>
        </td>
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
    get_currentuserinfo();

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
        $("#createuser").prepend("<input type=\"hidden\" name=\"belongs_to_editor[]\" value=\"<?php echo($current_user->ID)?>\">");
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
// カスタム投稿：レシピ
/*-------------------------------------------*/
/* カスタム投稿タイプを追加 */
add_action( 'init', 'movingimage_post_type' );
function movingimage_post_type() {
    register_post_type( 'movingimage_post', //カスタム投稿タイプ名を指定
       array(
           'labels' => array(
               'name' => __( 'レシピ投稿' ),
               'singular_name' => __( 'レシピ投稿' ),
               'add_new' => '新規追加',
               'add_new_item' => 'レシピを新規追加',
               'edit_item' => 'レシピを編集する',
               'new_item' => '新規サイト',
               'all_items' => 'レシピ一覧',
               'view_item' => 'レシピの説明を見る',
               'search_items' => '検索する',
               'not_found' => 'レシピが見つかりませんでした。',
               'not_found_in_trash' => 'ゴミ箱内にレシピが見つかりませんでした。'
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
            'label' => 'レシピカテゴリー',
            'singular_label' => 'レシピカテゴリー',
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
            'label' => 'レシピタグ',
            'singular_label' => 'レシピタグ',
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
add_action('admin_menu', 'add_movie_field');//
add_action('save_post', 'save_movie_field');

function add_movie_field(){
	add_meta_box( 'movie-box', '動画投稿', 'insert_movie_field', 'movingimage_post' );
	add_meta_box( 'movie-box2', '動画投稿', 'insert_movie_field', 'movie_post' );
}

function insert_movie_field($post){
	$movie = get_post_meta($post->ID, 'movie', true);
	echo("<textarea id=\"acf-field-movie\" style=\"width:100%\" name=\"movie\" rows=\"8\">$movie</textarea>");
}

function save_movie_field($post_id){
	$movie = isset($_POST['movie'])?$_POST['movie']:'';
	if(!empty($_POST['movie'])) {
		update_post_meta($post_id, 'movie', $movie);
	}elseif( empty($movie) ){
		delete_post_meta($post_id, 'movie', get_post_meta($post_id, 'movie', true));
	}

	// global $post;
	// $my_nonce = isset($_POST['my_nonce']) ? $_POST['my_nonce'] : null;
	// if(!wp_verify_nonce($my_nonce, wp_create_nonce(__FILE__))) {
	// 	return $post_id;
	// }
	// if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $post_id; }
	// if(!current_user_can('edit_post', $post->ID)) { return $post_id; }
	// if($_POST['post_type'] == 'movingimage_post') {
	// 	update_post_meta($post->ID, 'movie', $_POST['movie']);
	// }

	// $movie = isset($_POST['movie'])?$_POST['movie']:'';
	// update_post_meta($post_id, 'movie', $movie);


	// $data = !empty($_POST['movie'])?$_POST['movie']:'';
	// $data = $_POST['movie'];
	// if( get_post_meta($post_id, 'movie', true) == "" && !empty($data) ){
	// 	add_post_meta($post_id, 'movie', $data, true);
	// }
	// elseif( $data != get_post_meta($post_id, 'movie', true) ){
	// 	update_post_meta($post_id, 'movie', $data);
	// }
	// elseif( empty($movie) ){
	// 	delete_post_meta($post_id, 'movie', get_post_meta($post_id, 'movie', true));
	// }
}



/*------------------------------------------
// カスタム投稿タイプの記事編集画面にメタボックス（作成者変更）を表示する
/*------------------------------------------*/

/* admin_menu アクションフックでカスタムボックスを定義 */
add_action('admin_menu', 'myplugin_add_custom_box');

/* 投稿ページの "advanced" 画面にカスタムセクションを追加 */
function myplugin_add_custom_box() {
  if( function_exists( 'add_meta_box' )) {
    add_meta_box( 'myplugin_sectionid', __( '作成者', 'myplugin_textdomain' ), 'post_author_meta_box', 'movingimage_post', 'advanced' );
	add_meta_box( 'myplugin_sectionid', __( '作成者', 'myplugin_textdomain' ), 'post_author_meta_box', 'movie_post', 'advanced' );
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


/*-------------------------------------------*/
// カスタム投稿：動画
/*-------------------------------------------*/
/* カスタム投稿タイプを追加 */
add_action( 'init', 'movie_post_type' );
function movie_post_type() {
    register_post_type( 'movie_post', //カスタム投稿タイプ名を指定
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
        'movie_cat', /* タクソノミーの名前 */
        'movie_post', /* 使用するカスタム投稿タイプ名 */
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
        'movie_tag', /* タクソノミーの名前 */
        'movie_post', /* 使用するカスタム投稿タイプ名 */
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

/**
 * Initial for function Thread
 * @author Hung Nguyen
 */

add_action( 'init', 'thread_post_type' );
function thread_post_type() {
    register_post_type( 'thread_post', //カスタム投稿タイプ名を指定
            array(
                    'labels' => array(
                           'name' => __( 'スレッド投稿' ),
                           'singular_name' => __( 'スレッド投稿' ),
                           'add_new' => '新規追加',
                           'add_new_item' => 'スレッドを新規追加',
                           'edit_item' => 'スレッドを編集する',
                           'new_item' => '新規サイト',
                           'all_items' => 'スレッド一覧',
                           'view_item' => 'スレッドの説明を見る',
                           'search_items' => '検索する',
                           'not_found' => 'スレッドが見つかりませんでした。',
                           'not_found_in_trash' => 'ゴミ箱内にスレッドが見つかりませんでした。'
                    ),
                    'taxonomies' => array( 'post', "category"),
                    'public' => true,
                    'has_archive' => true, /* アーカイブページを持つ */
                    'menu_position' =>5, //管理画面のメニュー順位　投稿の下
                    'supports' => array( 'title', 'editor', 'thumbnail', 'comments' ),
            )
            );
    flush_rewrite_rules(false);
}

/*------------------------------------------
//コメントリスト表示用カスタマイズコード
------------------------------------------*/

function mytheme_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
    <div id="comment-<?php comment_ID(); ?>" class="userData">
        <div class="dataArea">
            <p class="date">
                <?php echo get_comment_date(('Y/m/d')) ?>
            </p>
            <p class="name">
                <i class="fa fa-user" aria-hidden="true"></i>
                <?php printf(__('%s'), get_comment_author_link()) ?>
            </p>
        </div>
        <div class="starArea">
			<?php
				$comment_ID = get_comment_ID();
				$commnent_score = get_comment_meta($comment_ID , 'score' ,true);
			 ?>
			 <?php for($i = 0;$i < $commnent_score; $i++){ ?>
			    <i class="fa fa-star on" aria-hidden="true"></i>
			 <?php } ?>
			 <?php for($i = 5; $commnent_score < $i; $i--){ ?>
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
                口コミのタイトル
            </p>
            <?php comment_text() ?>
        </div>

</li>
    <?php
}

/**
 * Theme comment on Thread post
 * @author Hung Nguyen
 */

function noticetheme_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
    <div id="comment-<?php comment_ID(); ?>" class="commentData">
        <p class="data">
            <?php echo get_comment_date(('Y/m/d H:i:s')) ?>
            <?php printf(__('%s'), get_comment_author_link()) ?>
        </p>
        <div class="report modal">
            <input id="modal-trigger-<?php comment_ID() ?>" type="checkbox">
            <label for="modal-trigger-<?php comment_ID() ?>"><?php wprc_report_submission_form(); ?></label>
            <div class="modal-overlay">
                <div class="modal-wrap">
                    <label for="modal-trigger-<?php comment_ID() ?>">✖</label>
                    <h3>これコメントを通報</h3>
                    <p>これコメントを削除すべき不適切なコメントとして通報しますか？</p>
                    <div class="btnArea">
                        <button type="button" class="reportBtn">通報
                        </button>
                        <button type="button" class="cancelBtn">やめる
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if( cf_is_mobile()) : ?>
    <p class="userCommentArea">
    <?php else : ?>
    <p class="comment">
    <?php endif; ?>
		<?php comment_text() ?>
    </p>
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
        //if( empty($_POST['title']) ){ wp_die('タイトルを入力して下さい。');}
        //if( empty($_POST['score']) ){ wp_die('評価を入力してください。'); }

        return $commentdata;
    }
    add_filter('preprocess_comment', 'preprocess_comment_author', 2, 1);

/*------------------------------------------
//コメントリスト表示用カスタマイズコード
------------------------------------------*/

    function exclude_cpt_from_search_result( $query ) {
      if ( !is_admin() ) {
        if (is_search() ) {
          $query->set('post_type', 'post');
        }
      }
    }
    add_action( 'pre_get_posts', 'exclude_cpt_from_search_result' );

/*------------------------------------------
//AddQuicktagプラグイン　カスタム投稿でも有効にする
------------------------------------------*/
add_filter( 'addquicktag_post_types', 'my_addquicktag_post_types' );
function my_addquicktag_post_types( $post_types ) {
    $post_types[] = 'movingimage_post';
	$post_types[] = 'movie_post';
    return $post_types;
}

/*------------------------------------------
//内部リンクのサムネイル取得
------------------------------------------*/
function get_the_custom_excerpt($content, $length) {
  $length = ($length ? $length : 78);//デフォルトの長さを指定する
  $content =  preg_replace('/<!--more-->.+/is',"",$content); //moreタグ以降削除
  $content =  strip_shortcodes($content);//ショートコード削除
  $content =  strip_tags($content);//タグの除去
  $content =  str_replace("&nbsp;","",$content);//特殊文字の削除（今回はスペースのみ）
  $content =  mb_substr($content,0,$length);//文字列を指定した長さで切り取る
  return $content.'…';
}

//内部リンクをはてなカード風にするショートコード
function toplink_scode($atts) {
  extract(shortcode_atts(array(
    'url'=>"",
    'title'=>"",
    'excerpt'=>""
    ),$atts));

  $id = url_to_postid($url);//URLから投稿IDを取得
  $post = get_post($id);//IDから投稿情報の取得
  $date = mysql2date('Y/m/d', $post->post_date);//投稿日の取得
  $author = get_userdata($post->post_author);
  $author_name = $author->display_name;
  $authorRoles = $author->roles;
  usort( $authorRoles , '_usort_terms_by_ID');
  $post_cat = get_the_category($post->ID);
  usort( $post_cat , '_usort_terms_by_ID');
  $catNameGrandson = $post_cat[2]->cat_name;
  $view = wpp_get_views ($id);

  $img_width ="240";//画像サイズの幅指定
  $img_height = "240";//画像サイズの高さ指定
  $no_image = get_template_directory_uri().'/images/no-img.png';//アイキャッチ画像がない場合の画像を指定


  //抜粋を取得
  if(empty($excerpt)){
  if($post->post_excerpt){
      $excerpt = get_the_custom_excerpt($post->post_excerpt , 78);
  }else{
      $excerpt = get_the_custom_excerpt($post->post_content , 78);
  	}
  }
  //タイトルを取得
  if(empty($title)){
        $title = esc_html(get_the_title($id));
    }

  //アイキャッチ画像を取得
  if(has_post_thumbnail($id)) {
        $img = wp_get_attachment_image_src(get_post_thumbnail_id($id));
        $img_tag = "<img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>";
        }
		// else { $img_tag ='<img src="'.$no_image.'" alt="" width="'.$img_width.'" height="'.$img_height.'" />';
    // }
	$toplink = '';
	if ( cf_is_mobile() ) { //spかどうか
        $toplink .='<div class="blog-card">';
		$toplink .=	'<a href="'. $url .'">';
		$toplink .=		'<div class="blog-card-thumbnail" style="background-image: url(' .$img[0]. ')">'. $img_tag .'</div>';
		$toplink .=		'<div class="blog-card-content">';
		$toplink .=			'<div class="dateArea"><span class="date">' . $date . '</span><span class="cat">' . $catNameGrandson . '</span></div>';
		$toplink .=			'<p class="blog-card-title">'. $title .'</p>';
		$toplink .=			'<div class="dateAreaBottom">';
		if  ($authorRoles[0] == 'editor' ) {
			$toplink .= '<p class="author"><span class="icon-mugyuu"></span>'. $author_name .'</p>';
		}else {
			$toplink .=			'<p class="author">'. $author_name .'</p>';
		}
		$toplink .=				'<p class="pv"><i class="fa fa-heart icon" aria-hidden="true"></i>' . $view . '</p>';
		$toplink .=			'</div>';
		$toplink .=		'</div>';
		$toplink .=	'</a>';
		$toplink .='</div>';
	}else{
        $toplink .='<div class="blog-card">';
		$toplink .=	'<a href="'. $url .'">';
		$toplink .=		'<div class="blog-card-thumbnail" style="background-image: url(' .$img[0]. ')">'. $img_tag .'</div>';
		$toplink .=		'<div class="blog-card-content">';
		$toplink .=			'<div class="dateArea"><span class="date">' . $date . '</span><span class="cat">' . $catNameGrandson . '</span></div>';
		$toplink .=			'<p class="blog-card-title">'. $title .'</p>';
		$toplink .=			'<p class="excerpt">' . $excerpt . '</p>';
		$toplink .=			'<div class="dateAreaBottom">';
		if  ($authorRoles[0] == 'editor' ) {
			$toplink .= '<p class="author"><span class="icon-mugyuu"></span>'. $author_name .'</p>';
		}else {
			$toplink .=			'<p class="author">'. $author_name .'</p>';
		}
		$toplink .=				'<p class="pv"><i class="fa fa-heart icon" aria-hidden="true"></i>' . $view . '</p>';
		$toplink .=			'</div>';
		$toplink .=		'</div>';
		$toplink .=	'</a>';
		$toplink .='</div>';
	}
        return $toplink;
      }

add_shortcode("toplink", "toplink_scode");




// 再帰処理関連↓↓↓↓↓↓↓↓↓

/*------------------------------------------
// topページ用　チェックボックス
/*------------------------------------------*/
//
add_action( 'add_meta_boxes', 'myplg_meta_box_init' );
function myplg_meta_box_init() {
  add_meta_box( 'myplg-meta', 'トップ記事用',
    'myplg_meta_box', 'post', 'side', 'default' );
}
function myplg_meta_box( $post, $box ) {
  //カスタムメタボックスの値を取得
  $myplg_toppage = get_post_meta( $post->ID, '_myplg_toppage', true );
  wp_nonce_field( plugin_basename( __FILE__ ),'myplg_save_meta_box' );
	  echo '<p>トップページ記事: <input type="checkbox" name="myplg_toppage" '. (($myplg_toppage === 'on') ? 'checked':'') .'></p>';
}

add_action( 'save_post', 'myplg_save_meta_box' );
function myplg_save_meta_box( $post_id ) {
    //自動保存の場合はスキップ
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
      return;
    wp_verify_nonce( plugin_basename( __FILE__ ),
      'myplg_save_meta_box' );

	$checked = (isset($_POST['myplg_toppage']) && $_POST['myplg_toppage'] === 'on') ? 'on' : 'off';
    update_post_meta( $post_id, '_myplg_toppage',sanitize_text_field($checked));
}



/*------------------------------------------
//カテゴリメニュー処理
------------------------------------------*/
// function category_transform2 ($cats)
// {
// 	$transformed_cats = [];
//
// 	for($i = 0; $i < count($cats) - 1; $i++) {
// 		if($i === count($cats) - 2) {
// 			$transformed_cats[$cats[$i]->name][] = $cats[$i + 1]->name;
// 		} else {
// 			$cat_parent = array_shift($cats);
// 			$transformed_cats[$cat_parent->name] = category_transform($cats);
// 		}
// 	}
// 	return $transformed_cats;
// }
//
// function category_transform($posts) {
// 	$result = [];
// 	foreach ($posts as $post) {
// 		$cats = get_the_category($post->ID);
// 		usort($cats , '_usort_terms_by_ID');
// 		$result = arrayarray_merge_recursive($result, category_recursive($post, $cats));
// 	}
//
// 	var_dump($result);
// }
// function category_recursive($post, $cats) {
// 	$firstCat = array_shift($cats);
//
// 	$result = [];
//
// 	$category = [];
// 	$category['name'] = $firstCat->name;
//
// 	if(count($cats) === 0) {
// 		$category['post'] = $post->post_title;
// 		$category['children'] = [];
// 	} else {
// 		$category['post'] = null;
// 		$category['children'] = category_recursive($post, $cats);
// 	}
// 	$result[$firstCat->name] = $category;
//
// 	return $result;
// }
// function category_recursive($post, $cats, $result) {
// 	$category = [];
// 	$firstCat = array_shift($cats);
//
// 	$category['category'] = $firstCat->name;
// 	$category['children'] = [];
//
// 	if(count($cats) === 0) {
// 		// var_dump('孫'. $firstCat->name);
// 		$category['post'] = $post->post_title;
// 	} else {
// 		// var_dump($firstCat->name);
// 		$category['post'] = null;
// 		$category['children'] = array_merge($result, category_recursive($post, $cats, $result));
// 	}
//
// 	return $category['children'];
// }

/**
 * Submit add Thread post on front
 * @author Hung Nguyen
 */

function add_thread_front(){
    if (isset( $_POST['submitted'] )) {
        $user_guest = get_user_by( 'login', 'guest' );
        $post_information = array(
                'post_title' => wp_strip_all_tags( $_POST['thread_title'] ),
                'post_name' => wp_strip_all_tags( $_POST['thread_title'] ),
                'post_content' => $_POST['thread_content'],
                'post_type' => 'thread_post',
                'post_author' => $user_guest->ID,//default guest for author
                'post_status' => 'publish'
        );
        
        $post_id = wp_insert_post( $post_information );
        
        // Categories
        $category_ids = [];
        if($_POST['parent_cat'] > 0){
            array_push($category_ids, $_POST['parent_cat']);
        }
        if($_POST['child_cat'] > 0){
            array_push($category_ids, $_POST['child_cat']);
        }
        if($_POST['grandchild_cat'] > 0){
            array_push($category_ids, $_POST['grandchild_cat']);
        }
        
        if ( $post_id ) {
            // set thumbnail
            if(isset($_FILES)){
                $file = 'thread_thumb';
            
                $attach_id = media_handle_upload( $file, $post_id );
                if($attach_id){
                    update_post_meta($post_id, '_thumbnail_id', $attach_id);
                }
            }
            
            // set category
            if(count($category_ids) > 0){
                wp_set_post_categories( $post_id, $category_ids );
            }
            wp_redirect( home_url() );
            exit;
        }
    }
}

/**
 * Submit comment on Thread post
 * @author Hung Nguyen
 */

function add_comment_on_notice($post_id) {

    if (isset( $_POST['submitted'] )) {
        $current_user = $_POST['name'];
        $comment = $_POST['comment'];

        $time = current_time('mysql');

        $data = array(
            'comment_post_ID' => $post_id,
            'comment_author' => $current_user,
            'comment_content' => $comment,
            'comment_date' => $time,
            'comment_approved' => 1
        );
        wp_insert_comment($data);
        
        wp_redirect( get_post_permalink($post_id) );
        exit;
    }
}

/**
 * Function for call ajax upload image when add thread on front
 * @author Hung Nguyen
 */

function upload_image_thread() {
    $file = 'content_image';
    $attach_id = media_handle_upload( $file );
    $post_image = get_post($attach_id);
    $image_link = $post_image->guid;
    $image_title = $post_image->post_title;
    $return = array(
            'status' => 'OK',
            'id'    => $attach_id,
            'image_link' => $image_link,
            'image_title' => $image_title
    );
    wp_send_json($return);
}

add_action('wp_ajax_upload_image_thread', 'upload_image_thread');
add_action('wp_ajax_nopriv_upload_image_thread', 'upload_image_thread');

/**
 * Function for call ajax change category
 * @author Hung Nguyen
 */

function thread_change_category() {
    $id = $_POST['id'];
    if($id > 0){
        $child_categories = get_categories( array( 'parent' => $id, 'hide_empty'=>false ) );
    }else{
        $child_categories = [];
    }
    wp_send_json($child_categories);
}

add_action('wp_ajax_thread_change_category', 'thread_change_category');
add_action('wp_ajax_nopriv_thread_change_category', 'thread_change_category');

/**
 * SPC Thread, Questionnaire
 * @author Edward
 */

/** Add menu */
add_action('admin_menu','spc_setting_menu');
function spc_setting_menu() {
    add_options_page('設定', 'MUGYUU!の設定', 'manage_options', 'spc_setting','spc_setting_options');
}
function spc_setting_options() {
    
    // save MUGYUU! Options
    if(strtolower($_SERVER['REQUEST_METHOD'])=='post'){
        if(isset($_POST['spc_options'])) {
            if(get_option('spc_options')!==false) {
                update_option('spc_options', $_POST['spc_options']);
            } else {
                add_option('spc_options', $_POST['spc_options']);
            }
        }
    }
    
    $spc_option = get_option('spc_options');
    include_once "spc_setting.php";
}

/**
 * Change status of report when unpublish thread
 * @author Hung Nguyen
 */
add_action( 'transition_post_status', 'post_unpublished', 10, 3 );
function post_unpublished( $new_status, $old_status, $post ) {
    if($post->post_type == 'thread_post' || $post->post_type == 'question_post')
        if ( $old_status == 'publish'  &&  $new_status != 'publish' ) {
            if ( function_exists ( 'wprc_table_name' ) ){
                global $wpdb;
                $table_name = wprc_table_name();
                $query = "UPDATE $table_name SET status='processed' WHERE post_id = $post->ID";
                
                $wpdb->query($query);
        }
    }
}

/**
* Save questionnaire, Comment post 
* @author UNOTRUNG
*/
function add_comment_on_questions($post_id) {

    if (isset( $_POST['submitted'] )) {
        unset($_POST['submitted']);

        $current_user = $_POST['name'];
        $comment = $_POST['comment'];

        $time = current_time('mysql');

        $data = array(
            'comment_post_ID' => $post_id,
            'comment_author' => $current_user,
            'comment_content' => $comment,
            'comment_date' => $time,
            'comment_approved' => 1
        );
        $count_comment =  wp_count_comments( $post_id );
        $limited = get_post_meta( $post_id, '_limited_answer', true );

        if(($count_comment->approved < $limited && $limited > 0) || empty($limited)){
            $comment_id = wp_insert_comment($data);
            add_comment_meta( $comment_id, '_question_comment', $_POST['answer'] );
        }
        wp_redirect( get_post_permalink($post_id) );
        exit;
    }
}

function question_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; 
    global $questions;
    ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
            <div id="comment-<?php comment_ID(); ?>" class="commentData">
                <p class="data">
                    <?php echo get_comment_date(('Y/m/d H:i:s')) ?>
                    <?php printf(__('%s'), get_comment_author_link()) ?>
                </p>
                <div class="report modal">
                    <input id="modal-trigger-1" type="checkbox">
                    <label for="modal-trigger-1"><?php wprc_report_submission_form(); ?></label>
                    <div class="modal-overlay">
                        <div class="modal-wrap">
                            <label for="modal-trigger-1">✖</label>
                            <h3>これコメントを通報</h3>
                            <p>これコメントを削除すべき不適切なコメントとして通報しますか？</p>
                            <div class="btnArea">
                                <button type="button" class="reportBtn">通報
                                </button>
                                <button type="button" class="cancelBtn">やめる
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="userCommentArea answerArea">
                <ul class="answerList">
                    <?php 
                        $answers = get_comment_meta($comment->comment_ID,'_question_comment',true);
                        $GLOBALS['answers'] = $answers; 
                        foreach ($answers as $queskey => $answer) {
                            echo "<li>".($queskey+1).'. ';
                            foreach ($answer as $las_ans) {
                                ?>
                                <label class="<?=(count($answer)>1)?'check':''?>"><?=($questions[key($questions)][$queskey]['answer'][$las_ans] != '')?$questions[key($questions)][$queskey]['answer'][$las_ans]:$las_ans ?></label>
                                <?php
                            }
                            echo "</li>";
                        }
                    ?>
                </ul>
                <p class="<?=( cf_is_mobile())?'userCommentArea':'comment'?>">
                    <?php comment_text() ?>
                </p>
            </div>
        </li>
    <?php
}

/**
 * Do not show category submenu in Thread menu
 * @author Hung Nguyen
 */
add_action( 'admin_menu', 'remove_thread_category_menu', 999 );
function remove_thread_category_menu(){
    remove_submenu_page( 'edit.php?post_type=thread_post', 'edit-tags.php?taxonomy=category&amp;post_type=thread_post' );
}
/*add_action( 'admin_menu', 'remove_comment_menu', 999 );
function remove_comment_menu(){
    remove_menu_page( 'edit-comments.php' );
}*/

/**
 * Sort list comment by like count
 * @author Hung Nguyen
 */
function comment_comparator($a, $b)
{
    $compared = 0;
    $a_count = get_comment_meta( $a->comment_ID, 'cld_like_count', true );
    $b_count = get_comment_meta( $b->comment_ID, 'cld_like_count', true );
    if($a_count != $b_count)
    {
        $compared = $a_count > $b_count ? -1:1;
    }
    return $compared;
}

/**
 * Detect is tablet
 * @author Hung Nguyen
 */
function cf_is_tablet() {
    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
        return true;
    }
    return false;
}

/**
 * Change report status when unapprove comment
 * @author Hung Nguyen
 */
add_action('transition_comment_status', 'unapprove_comment_callback', 10, 3);
function unapprove_comment_callback($new_status, $old_status, $comment) {
    if ( $old_status == 'approved'  &&  $new_status != 'approved' ) {
        if ( function_exists ( 'wprc_table_name' ) ){
            global $wpdb;
            $table_name = wprc_table_name();
            $query = "UPDATE $table_name SET status='processed' WHERE comment_id = $comment->comment_ID";
            
            $wpdb->query($query);
        }
    }
}

add_action( 'edit_form_after_title', 'add_content_before_editor' );
function add_content_before_editor() {
    if(isset($_GET['comment_id_scroll'])){
        echo "<input class='comment_id_scroll' type='hidden' value=".$_GET['comment_id_scroll'].">";
    }
}