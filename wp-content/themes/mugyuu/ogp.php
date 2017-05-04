<!-- OGP -->
<?php
if( !empty($post) ){
	$str = $post->post_content;
}
$searchPattern = '/<img.*?src=(["\'])(.+?)\1.*?>/i';

$image = '';
$imgurl = '';
$homeurl = ('https://mugyuu.jp/');
$cat = get_queried_object();
$recipe_slug = ('movingimage_post/'.$cat->post_name);
$movie_slug = ('movie_post/'.$cat->post_name);
$custom = get_post_custom();
$description = !empty($custom['description']) && is_array($custom['description'])?current($custom['description']):"";
if(is_single()) {
	  if(has_post_thumbnail()) {
	    $image_id = get_post_thumbnail_id();
	    $image = wp_get_attachment_image_src($image_id, 'full');
	    $image = $image[0];
	  } elseif(preg_match($searchPattern, $str, $imgurl) && !is_archive()) {//投稿にサムネイルは無いが画像がある場合の処理
		$image = $imgurl[2];
	  } else {//投稿にサムネイルも画像も無い場合の処理
	    $image = get_template_directory_uri().'/images/logo-ogp.png';
	  }
}
elseif( preg_match('%^/questionary/.*%',$_SERVER['REQUEST_URI']) ){# questionary
	$questionary_str = "/questionary/";
	$description = "";
	$title = "";
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
		$results = $wpdb->get_results( $query, OBJECT );
		$board = current($results);
		if( !empty($board) )
		{
			$description = $board->overview;
			$title = $board->title.'｜'.get_bloginfo('name');
		}
	}elseif(
		preg_match('%.*'.$questionary_str.'$%',$_SERVER['REQUEST_URI']) ||
		preg_match('%.*'.$questionary_str.'board/$%',$_SERVER['REQUEST_URI'])
	){
	# 質問掲示板TOP
		$title = '質問掲示板｜'.get_bloginfo('name');
	}
} else {
	if(get_header_image()) {
		$image = get_header_image();
	} else {
		$image = get_template_directory_uri().'/images/logo-ogp.png';
	}
}
?>

<?php if(is_single() && $post->post_type === "movingimage_post" ){ ?>
	<meta property="og:title" content="<?= the_title() ?>">
	<meta property="og:url" content="<?php echo $homeurl.$recipe_slug ?>">
	<meta property="og:description" content="<?php echo $description ?>">
<?php }elseif(is_single() && $post->post_type === "movie_post" ){ ?>
	<meta property="og:title" content="<?= the_title() ?>">
	<meta property="og:url" content="<?php echo $homeurl.$movie_slug ?>">
	<meta property="og:description" content="<?php echo $description ?>">
<?php }elseif(is_single() && $post->post_type === "post" ){ ?>
	<meta property="og:title" content="<?= the_title() ?>">
	<meta property="og:url" content="<?php echo esc_url(get_permalink($post->ID)) ?>">
	<meta property="og:description" content="<?php echo $description ?>">
<?php }elseif( preg_match('%^/questionary/.*%',$_SERVER['REQUEST_URI']) ){# questionary?>
	<meta property="og:title" content="<?php echo($title) ?>">
	<meta property="og:description" content="<?php echo(mb_strimwidth(str_replace("\r\n", " ", $description), 0, 100, '...', 'utf-8')) ?>">
<?php }elseif(is_page()){ ?>
    <meta property="og:title" content="<?= the_title() ?>">
    <meta property="og:url" content="<?php echo esc_url(get_permalink($post->ID)) ?>">
    <meta property="og:description" content="<?php echo $description ?>">
<?php }elseif(is_category()){ ?>
    <?php
        $catName = $cat->cat_name;
        $ttl = 'MUGYUU!カテゴリー一覧：' . $catName;
        $description = $cat->description;
     ?>
    <meta property="og:title" content="<?php echo $ttl ?>">
    <meta property="og:url" content="<?php echo esc_url(get_permalink($post->ID)) ?>">
    <meta property="og:description" content="<?php echo $description ?>">
<?php } else { ?>
	<meta property="og:title" content="<?php bloginfo('name') ?>">
	<meta property="og:url" content="<?= urlencode(get_bloginfo('url')) ?>">
	<meta property="og:description" content="<?php bloginfo('description'); ?>">
<?php } ?>
<meta property="og:site_name" content="MUGYUU!">
<meta property="og:type" content="article">
<meta property="og:image" content="<?php echo $image; ?>">
<meta property="og:locale" content="ja_JP">
<meta property="article:publisher" content="https://www.facebook.com/mugyuuuu/">
<meta property="fb:app_id" content="241263802926024">
<!-- /OGP -->
