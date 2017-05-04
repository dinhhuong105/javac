<?php
$slug_name = $post->post_name;
if(is_single() && $post->post_type === "movingimage_post") {
	$share_url = 'https://mugyuu.jp/movingimage_post/'.$slug_name;
} elseif(is_single() && $post->post_type === "movie_post") {
	$share_url = 'https://mugyuu.jp/movie_post/'.$slug_name;
}else {
	$share_url = 'https://mugyuu.jp/'.$slug_name;
}

$fb_share_url = 'https://www.facebook.com/sharer/sharer.php?u='.rawurlencode($share_url).'&amp;src=sdkpreparse';
?>
<div class="snsArea">
	<div class="fb">
		<a class="fb-xfbml-parse-ignore" target="_blank" href="<?php echo $fb_share_url; ?>" data-href="<?php echo $share_url; ?>" data-layout="link" data-mobile-iframe="true">
			<i class="fa fa-facebook" aria-hidden="true"></i>
		</a>
	</div>
	<div class="tw">
		<a href="http://twitter.com/share?url=<?php the_permalink(); ?>&amp;text=<?php the_title(); ?>" target="_blank">
			<i class="fa fa-twitter" aria-hidden="true"></i>
		</a>
	</div>
	<div class="hb">
		<a href="http://b.hatena.ne.jp/entry/<?php the_permalink(); ?>" class="hatena-bookmark-button" data-hatena-bookmark-layout="simple" title="<?php the_title(); ?>" target="_blank">
			<i class="icon-hatebu" aria-hidden="true"></i>
		</a>
	</div>
	<div class="pk">
		<a href="http://getpocket.com/edit?url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>" target="_blank">
			<i class="fa fa-get-pocket" aria-hidden="true"></i>
		</a>
	</div>
</div>
