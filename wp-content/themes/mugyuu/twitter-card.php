<!--Twtter Cards-->
<?php
if( !empty($post) ){
	$str = $post->post_content;
}
$searchPattern = '/<img.*?src=(["\'])(.+?)\1.*?>/i';

$image = '';
$imgurl = '';
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
} else {
	if(get_header_image()) {
		$image = get_header_image();
	} else {
		$image = get_template_directory_uri().'/images/logo-ogp.png';
	}
}
?>
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@info_mugyuu">
<?php if(is_single() || is_page()) { ?>
    <meta name="twitter:title" content="<?= the_title() ?>">
    <meta name="twitter:description" content="<?php echo $description ?>">
<?php  }elseif(is_category()) { ?>
    <?php
        $cat = get_queried_object();
        $catName = $cat->cat_name;
        $ttl = 'MUGYUU!カテゴリー一覧：' . $catName;
        $description = $cat->description;
     ?>
     <meta name="twitter:title" content="<?php echo $ttl ?>">
     <meta name="twitter:description" content="<?php echo $description ?>">
 <?php }else{ ?>
<meta name="twitter:title" content="<?php bloginfo('name') ?>">
<meta name="twitter:description" content="<?php bloginfo('description'); ?>">
<?php } ?>
<meta name="twitter:image:src" content="<?php echo $image; ?>">
<meta name="twitter:creator" content="@info_mugyuu">
<meta name="twitter:domain" content="https://column.mugyuu.jp/">
<!--/Twtter Cards-->
