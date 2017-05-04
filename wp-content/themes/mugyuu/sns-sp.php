<?php
$slug_name = $post->post_name;
$share_url = 'https://mugyuu.jp/'.$slug_name;
$fb_share_url = 'https://www.facebook.com/sharer/sharer.php?u='.rawurlencode($share_url).'&amp;src=sdkpreparse';
?>
<div class="snsArea">
	<div class="fb">
	  <a class="fb-xfbml-parse-ignore" target="_blank" href="<?= $fb_share_url ?>" data-href="<?= $share_url ?>" data-href="https://mugyuu.jp/kodomo-yomikikase-kouka" data-layout="link" data-mobile-iframe="true">
    	<i class="icon fa fa-facebook" aria-hidden="true"></i>
	  </a>
	</div>
	<div class="tw">
	  <a href="http://twitter.com/share?url=<?php the_permalink(); ?>&amp;text=<?php the_title(); ?>" target="_blank">
    	<i class="icon fa fa-twitter" aria-hidden="true"></i>
	  </a>
	</div>
	<div class="hb">
	  <a href="http://b.hatena.ne.jp/entry/<?php the_permalink(); ?>" class="hatena-bookmark-button" data-hatena-bookmark-layout="simple" title="<?php the_title(); ?>" target="_blank">
      <span class="icon icon-hatebu"></span>
	  </a>
	</div>
	<div class="pk">
    <a href="http://getpocket.com/edit?url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>" target="_blank">
      <span class="icon icon-pocket"></span>
    </a>
	</div>
</div>
