<section class="topCat">
	<section class="catArea childArea">
		<h2 class="bigCat">
			<span class="icon icon-baby"></span>こどものこと
			<i class="icon fa fa-angle-down" aria-hidden="true"></i>
		</h2>
		<ul class="catList">
			<?php
				$args = array(
					'post_type' => 'post',
					'parent' => 2, //こどものこと
					'hide_empty' => 1,
				);
				$cats = get_categories($args);
			?>
			<?php foreach ($cats as $cat) { ?>
				<?php
					$slug = $cat->slug;
				?>
				 <?php if($slug !== 'episode'){ //エピソード以外 ?>
					<li>
						<?php
							$cat_ID = $cat->cat_ID;
							$postargs = array(
								'category' => $cat_ID,
								// 'meta_value' => 'on',
							);
							$on_posts = get_posts($postargs);
							foreach ($on_posts as $on_post) {
								$on_post_cat = get_the_category($on_post);
									usort($on_post_cat,'_usort_terms_by_ID');
								$cat_id = $on_post_cat[1]->cat_ID;
								$postid = $on_post->ID;
								// $meta = get_post_meta( $postid, '_myplg_toppage' ,true);
							}
						?>
						<h3><?php echo $cat->name; ?></h3>
						<ul class="grandsonCatList">
							 <?php
								 $cat_children_args = array(
									 'parent' => $cat->cat_ID,
									 'post_type' => 'post',
									 'hide_empty' => 1,
								 );
								 $cat_children = get_categories($cat_children_args);
								 ?>
							<?php foreach ($cat_children as $cat_child) { ?>
								<?php
									$cat_child_id = $cat_child->cat_ID;
									$args = array(
										'category' => $cat_child_id,
										'hide_empty' => 1,
										'posts_per_page' => 1,
										'meta_value' => 'on',
									);
									$cat_posts = get_posts($args);
								?>
								<?php foreach ($cat_posts as $cat_post) { ?>
									<?php
										$postid = $cat_post->ID;
										// $meta = get_post_meta($postid , '_myplg_toppage' ,true);
										$cats = get_the_category($cat_post);
											usort($cats, '_usort_terms_by_ID');
										$cat_id = $cats[2]->cat_ID;
										$cat_name = $cats[2]->name;
										// $link = $cat_post->guid;
										$post_name = $cat_post->post_name;
									 ?>
									<?php if($cat_id === $cat_child_id ) { ?>
										<li>
											<a href="<?php echo home_url('/').$post_name; ?>"><?php echo $cat_name; ?> </a>
										</li>
									<?php } ?>
								 <?php } ?>
							<?php } ?>
						</ul>
				</li>
				<?php }elseif($slug == 'episode') { ?>
					<li class="ep">
						<h3>
							<a href="<?php echo home_url('/'); ?>category/child/episode">エピソード</a>
						</h3>
					</li>
				<?php } ?>
			<?php } ?>
		</ul>
	</section>
	<section class="catArea mamaArea">
		<h2 class="bigCat">
			<span class="icon icon-mama"></span>ママのこと
			<i class="icon fa fa-angle-down" aria-hidden="true"></i>
		</h2>
		<ul class="catList">
			<?php
				$args = array(
					'post_type' => 'post',
					'parent' => 3, //ママのこと
					'hide_empty' => 1,
				);
				$cats = get_categories($args);
			?>
			<?php foreach ($cats as $cat) { ?>
				<li>
					<h3><?php echo $cat->name; ?></h3>
					<ul class="grandsonCatList">
						 <?php
							 $cat_children_args = array(
								 'parent' => $cat->cat_ID,
								 'post_type' => 'post',
								 'hide_empty' => 1,
							 );
							 $cat_children = get_categories($cat_children_args);
						?>
						<?php foreach ($cat_children as $cat_child) { ?>
							<?php
								$cat_child_id = $cat_child->cat_ID;
								$args = array(
									'category' => $cat_child_id,
									'hide_empty' => 1,
									'posts_per_page' => 1,
									'meta_value' => 'on',
								);
								$cat_posts = get_posts($args);
							?>
							<?php foreach ($cat_posts as $cat_post) { ?>
								<?php
									$postid = $cat_post->ID;
									// $meta = get_post_meta($postid , '_myplg_toppage' ,true);
									$cats = get_the_category($cat_post);
										usort($cats, '_usort_terms_by_ID');
									$cat_id = $cats[2]->cat_ID;
									$cat_name = $cats[2]->name;
									// $link = $cat_post->guid;
									$post_name = $cat_post->post_name;
								 ?>
								<?php if($cat_id === $cat_child_id ) { ?>
									<li>
										<a href="<?php echo home_url('/').$post_name; ?>"><?php echo $cat_name; ?> </a>
									</li>
								<?php }else{ ?>
										<li>該当する記事がありません</li>
								<?php } ?>
							 <?php } ?>
						<?php } ?>
					</ul>
				</li>
			<?php } ?>
		</ul>
	</section>
	<section class="catArea ageArea">
		<h2 class="bigCat">
			<i class="icon fa fa-heart-o" aria-hidden="true"></i>年齢のこと
			<i class="icon fa fa-angle-down" aria-hidden="true"></i>
		</h2>
		<ul class="catList">
			<li>
				<a href="<?php echo home_url('/'); ?>category/age/0yearold">
					0歳
				</a>
			</li>
			<li>
				<a href="<?php echo home_url('/'); ?>category/age/1-3yearold">
					1歳〜3歳
				</a>
			</li>
			<li>
				<a href="<?php echo home_url('/'); ?>category/age/4-6yearold">
					4歳〜6歳
				</a>
			</li>
		</ul>
	</section>
	<section class="catArea recipeArea">
		<h2 class="bigCat">
			<span class="icon icon-recipe"></span>レシピ
			<i class="icon fa fa-angle-down" aria-hidden="true"></i>
		</h2>
		<ul class="catList">
			<?php
                $args = array(
                    'post_type' => 'movingimage_post',
                    'taxonomy' => 'movingimage_cat',
                    'parent' => 0,
                    'hide_empty' => 1,
                );
                $cats = get_categories($args);
            ?>
            <?php foreach ($cats as $cat ) { ?>
                <li>
                    <h3><?php echo $cat->name;?></h3>
                    <?php
                        $child_cat_num = get_term_children($cat->cat_ID,'category');
                        $child_count = count($child_cat_num);
                        if($child_cat_num > 0) {
                     ?>
                    <ul class="grandsonCatList">
                        <?php
                            $cat_children_args = array(
                                'parent' => $cat->cat_ID,
                                'post_type' => 'movingimage_post',
                                'taxonomy' => 'movingimage_cat',
                            );
                            $cat_children = get_categories($cat_children_args);
                            foreach ($cat_children as $cat_child) {
                                $cat_link = get_category_link($cat_child->cat_ID);
                        ?>
                            <li>
                                <a href="<?php echo $cat_link; ?>"><?php echo $cat_child->name;?></a>
                            </li>
                            <?php } ?>
                    </ul>
                <?php } ?>
                </li>
            <?php } ?>
		</ul>
	</section>
	<section class="catArea movieArea">
		<h2 class="bigCat">
			<i class="icon fa fa-video-camera" aria-hidden="true"></i></span>MUGYUU!動画
			<i class="icon fa fa-angle-down" aria-hidden="true"></i>
		</h2>
		<ul class="catList">
			<?php
				$args = array(
					'post_type' => 'movie_post',
					'taxonomy' => 'movie_cat',
					'parent' => 0,
					'hide_empty' => 1,
				);
				$cats = get_categories($args);
			?>
			<?php foreach ($cats as $cat ) { ?>
				<li>
					<h3><?php echo $cat->name;?></h3>
					<?php
						$child_cat_num = get_term_children($cat->cat_ID,'category');
						$child_count = count($child_cat_num);
						if($child_cat_num > 0) {
					 ?>
					<ul class="grandsonCatList">
						<?php
							$cat_children_args = array(
								'parent' => $cat->cat_ID,
								'post_type' => 'movie_post',
								'taxonomy' => 'movie_cat',
							);
							$cat_children = get_categories($cat_children_args);
							foreach ($cat_children as $cat_child) {
								$cat_link = get_category_link($cat_child->cat_ID);
						?>
							<li>
								<a href="<?php echo $cat_link; ?>"><?php echo $cat_child->name;?></a>
							</li>
							<?php } ?>
					</ul>
				<?php } ?>
				</li>
			<?php } ?>
		</ul>
	</section>
	<!-- <section class="qaArea">
		<h2 class="bigCat">
			<a href="<?php //echo home_url('/'); ?>questionary/public/">
				<i class="icon fa fa-pencil-square-o" aria-hidden="true"></i>
				質問掲示板
			</a>
		</h2>
	</section> -->
	<section class="catArea itemArea">
		<h2 class="bigCat">
			<a href="<?php echo home_url('/'); ?>item-search">
				<i class="icon fa fa-shopping-cart" aria-hidden="true"></i>
				商品を探す
			</a>
		</h2>
	</section>
	<?php get_search_form(); ?>
</section>
<footer>
	<div class="bnr writerBnr">
		<a href="<?php echo home_url('/'); ?>author-list"><img src="<?php echo bloginfo('template_directory'); ?>/images/bnr.png" width="300" height="100"></a>
	</div>
	<!-- <div class="bnr qaBnr">
		<a href="<?php //echo home_url('/'); ?>questionary/public/"><img src="<?php //echo bloginfo('template_directory'); ?>/images/bnrQa.png" width="300" height="100"></a>
	</div> -->
	<!-- <div class="fb">
		<p><i class="fa fa-facebook-official"></i>Facebook</p>
	</div> -->
	<ul class="infoList">
		<li><a href="<?php echo home_url('/'); ?>about-us">MUGYUU!について</a></li>
		<li><a href="<?php echo home_url('/'); ?>company">運営会社</a></li>
		<li><a href="<?php echo home_url('/'); ?>privacy-policy">プライバシーポリシー</a></li>
		<li><a href="<?php echo home_url('/'); ?>disclaimer">免責事項・知的財産権</a></li>
		<li><a href="<?php echo home_url('/'); ?>contact">お問い合わせ</a></li>
		<!-- <li><a href="<?php //echo home_url('/'); ?>writer-recruit">求人募集</a></li> -->
	</ul>
	<div class="copy">
		<small>
			&copy;2016 MUGYUU!
		</small>
	</div>
</footer>
<div id="page-top">
	<a href="#sb-site">
		<img src="<?php echo bloginfo('template_directory'); ?>/images/balloon.png" alt="TOPへ戻る" width="30" height="83">
	</a>
</div>
</div>


<!-- menu -->
<script>
$(document).ready(function() {
	$.slidebars();
});
</script>

<!-- slider -->
<script>
$('.slider').slick({
	accessibility: true, //左右ボタンで画像の切り替え
	autoplay: true, //自動再生
	autoplaySpeed: 3000, // 自動再生や左右の矢印でスライドするスピード
	speed: 400, // 自動再生や左右の矢印でスライドするスピード
	pauseOnHover: false, // 自動再生時にスライドのエリアにマウスオンで一時停止するかどうか
	cssEase: 'ease',// 切り替えのアニメーション。ease,linear,ease-in,ease-out,ease-in-out
	dots: true, // 画像下にページ送りを表示
	dotsClass: 'dot-class',　//ドットのclass名をつける
	draggable: true,　// ドラッグができるかどうか
	fade: false,　// 切り替え時のフェードイン設定。trueでon
	arrows: false,　// 左右の次へ、前へボタンを表示するかどうか
	infinite: true,  // 無限スクロールにするかどうか。最後の画像の次は最初の画像が表示される。
	initialSlide: 0, // 最初のスライダーの位置
	lazyLoad: 'ondemand', // 画像の遅延表示。‘ondemand’or'progressive'
	pauseOnHover: false, // スライドのエリアにマウスオーバーしている間、自動再生を止めるかどうか。
	slidesToShow: 1, // スライドのエリアに画像がいくつ表示されるかを指定
	slidesToScroll: 1, // 一度にスライドする数
	swipe: true, // タッチスワイプに対応するかどうか
	touchMove: true, //タッチでスライドの有/無
	vertical: false,// 縦方向へのスライド
	centerMode: true, // 表示中の画像を中央へ
	centerPadding: '60px',// 中央のpadding

});
</script>

<!-- tab -->
<script>
$('.tabMenuList li').on("click", function() {
	$(this).siblings().removeClass('active');
	$(this).removeClass('active');
	$(this).addClass('active');
	var tab_content = $(this).attr('data-tab-content');
	$(this).parents('.tabs').find('.tabContent').removeClass('tabSelected');
	$('#' + tab_content).addClass('tabSelected');
	return false;
});
</script>

<!-- topcat sidecat -->
<script>
$('.bigCat').on('click', function() {
	$(this).next().slideToggle();
	$(this).toggleClass('active');
});
$('.catList li h3').on('click', function() {
	$(this).parents('.catList li').find('.grandsonCatList').slideToggle();
	$(this).parents('.catList li').toggleClass('active');
});
</script>

<!-- SCROLL TOP -->
<script>
var topBtn = $('#page-top');
topBtn.hide();
//スクロールが100に達したらボタン表示
$(window).scroll(function () {
	if ($(this).scrollTop() > 100) {
		topBtn.fadeIn();
	} else {
		topBtn.fadeOut();
	}
});
//スクロールしてトップ
topBtn.click(function () {
	$('body,html').animate({
		scrollTop: 0
	}, 500);
	return false;
});
</script>

<!-- 口コミ評価 -->
<script type="text/javascript">
$(function() {
	$.fn.raty.defaults.path = "<?php echo get_template_directory_uri(); ?>/images";
	$('#default').raty({
		number: 5,
		score : 3
	});
});
</script>

<!-- ページ内リンク -->
<script type="text/javascript">
    jQuery(function(){
        jQuery('a[href^=#]:not(.noscroll)').click(function(){
            var speed = 500;
            var href= jQuery(this).attr("href");
            var target = jQuery(href == "#" || href == "" ? 'html' : href);
            var position = target.offset().top;
            jQuery("html, body").animate({scrollTop:position}, speed, "swing");
            return false;
        });
    });
</script>

<!-- author single uri -->
<script>
	var uri = new Uri(location.href).parse();
	$('.postContent').each(function() {
		var tab = $(this).attr('id');
		var index = tab.split('-').pop();
		$(this).find('.pagination a').each(function() {
			var href = new Uri($(this).attr('href')).parse();
			var query = href['query'];
			query['tab'] = index;
			$(this).attr('href', href['without_query'] + '?' + Uri.buildQuery(query));
		});
	});
</script>

<!-- author single tab -->
<script>
    $('.postTypeList li').on("click", function() {
        $(this).siblings().removeClass('active');
        $(this).removeClass('active');
        $(this).addClass('active');
        var tab_content = $(this).attr('data-tab-content');
        $(this).parents('.tabs').find('.postContent').removeClass('selected');
        $('#' + tab_content).addClass('selected');
        return false;
    });
</script>

<?php wp_footer(); ?>
</body>
</html>
