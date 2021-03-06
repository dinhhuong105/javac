<?php get_header(); ?>
<?php if(count(get_the_category())>0):?>
	<?php breadcrumb(); ?>
<?php else: ?>
	<div id="breadcrumb">
		<ul class="breadcrumbList">
			<li><a href="<?php echo home_url('/'); ?>">トップ</a></li>
			<li><i class="fa fa-angle-right arrowIcon"></i><a href="<?php echo home_url('/'); ?>notice"><span>質問掲示板</span></a></li>
		</ul>
	</div>
<?php endif; ?>
    <div class="mainWrap single qa thread">
        <div class="mainArea">
            <section class="postArea">
				<?php
		            $postCat = get_the_category();
		            usort( $postCat , '_usort_terms_by_ID');
		            $catId = $postCat[0]->cat_ID;
		            $author_id = $post->post_author;
		            $author = get_userdata($post->post_author);
					$thumbnail_id = get_post_thumbnail_id();
                    $image = wp_get_attachment_image_src( $thumbnail_id, '900_thumbnail' );
					$childCat = '';
                    $catNameGrandson = '';
                    $catIdGrandson = '';
                    $count = count($postCat);
                    // if($catId !== 1) {
                    if($count === 3) {//カテが3
                        $childCat = $postCat[1]->cat_name;
                        $catNameGrandson = $postCat[2]->cat_name;
                        $catIdGrandson = $postCat[2]->cat_ID;
                    }elseif($count === 2){//カテが2
                        $catNameGrandson = $postCat[1]->cat_name;
                        $catIdGrandson = $postCat[1]->cat_ID;
                    }else{
                        $catNameGrandson = $postCat[0]->cat_name;
                        $catIdGrandson = $postCat[0]->cat_ID;
                    }
                    $author_id = $post->post_author;
                    $author = get_userdata($post->post_author);
                    $userLebel = $author -> roles;
                    usort( $userLebel , '_usort_terms_by_ID');
                    $slug_name = $post->post_name;
		        ?>
				<?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
               <div class="postDataArea">
                    <p class="postDate"><?php the_time('Y/m/d'); ?></p>
                    <p class="pv">
                        <i class="fa fa-heart" aria-hidden="true"></i>
						<?php
//                             $comments = get_comments(array('post_id' => $post->ID, ));
//                                 $countLike = 0;
//                                 foreach($comments as $comment) {
//                                     $countLike += get_comment_meta( $comment->comment_ID, 'cld_like_count', true );
//                                 }
//                                 echo $countLike;
						if ( function_exists ( 'wpp_get_views' ) ) {
						    echo wpp_get_views ( get_the_ID() ); }
                        ?>
                    </p>
               </div>
                <h1 class="heading">
					<?php the_title(); ?>
                </h1>
				<!--<div class="imgArea" style="background-image: url(<?php //echo $image[0]; ?>);">
					<img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
                </div>-->
                <div class="contentArea">
					<?php the_content(); ?>
					<div>
    					<div class="count flr">
                                <i class="fa fa-comments" aria-hidden="true"></i>
                                <?php echo wp_count_comments( get_the_ID() )->total_comments; ?>
                        </div>
                        <?php if(!ip_report_post(get_the_ID(), get_user_IP())):?>
    					<div class="buttonReport">
                    		<div class="report modal">
                                <input id="modal-trigger-thread" type="checkbox">
                                <label for="modal-trigger-thread">
                                	<?php 
                                	   $GLOBALS['comment'] = null;
                                	   wprc_report_submission_form();
                                	?>
                                </label>
                                <div class="modal-overlay">
                                    <div class="modal-wrap">
                                        <label for="modal-trigger-thread">✖</label>
                                        <h3>このスレッドを通報</h3>
                                        <p>このスレッドを不適切な内容として通報しますか？</p>
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
                    	<?php endif; ?>
                	</div>
                </div>
                <br>
                <div class="btnArea">
                    <a href="#send">コメントする
                    </a>
                </div>
				<?php endwhile; ?>
				<?php else : ?>
				<p class="none">記事が見つかりませんでした。</p>
				<?php endif; ?>
            </section>
            <?php comments_template('/notice_comments.php'); ?>
            <?php get_template_part('related-entries'); ?>
        </div>
		<?php get_sidebar(); ?>
    </div>
<?php get_footer(); ?>
