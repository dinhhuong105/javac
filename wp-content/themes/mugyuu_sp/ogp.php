<!-- OGP -->
<?php
if( !empty($post) ){
	$str = $post->post_content;
}
$searchPattern = '/<img.*?src=(["\'])(.+?)\1.*?>/i';

$image = '';
if(is_single()) {
  if(has_post_thumbnail()) {
    $image_id = get_post_thumbnail_id();
    $image = wp_get_attachment_image_src($image_id, 'full');
    $image = $image[0];
  } else if(preg_match($searchPattern, $str, $imgurl) && !is_archive()) {//投稿にサムネイルは無いが画像がある場合の処理
    $image = $imgurl[2];
  } else {//投稿にサムネイルも画像も無い場合の処理
    $image = get_template_directory_uri().'/images/og-image.jpg';
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
		$image = get_template_directory_uri().'/screenshot.png';
	}
}
?>
<?php if(is_single()) { ?>
	<meta property="og:title" content="<?= the_title() ?>">
	<meta property="og:url" content="<?php the_permalink() ?>">
	<meta property="og:description" content="<?= mb_substr(get_the_excerpt(), 0, 100) ?>">
<?php }elseif( preg_match('%^/questionary/.*%',$_SERVER['REQUEST_URI']) ){# questionary?>
	<meta property="og:title" content="<?php echo($title) ?>">
	<meta property="og:description" content="<?php echo(mb_strimwidth(str_replace("\r\n", " ", $description), 0, 100, '...', 'utf-8')) ?>">
<?php } else { ?>
	<meta property="og:title" content="<?= bloginfo('name') ?>">
	<meta property="og:url" content="<?php bloginfo('url') ?>">
	<meta property="og:description" content="<?= bloginfo('description') ?>">
<?php } ?>
<meta property="og:type" content="article">
<meta property="og:image" content="<?= $image ?>">
<meta property="og:locale" content="ja_JP">
<meta property="fb:app_id" content="241263802926024">
<!-- /OGP -->
