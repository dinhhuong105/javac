<?php
      global $post;
      // アンケート公開ディレクトリまでのURL
      $questionary_url = home_url()."/questionary/public/";
      $recommend_class = "articleList plusList";

      if( $post->post_type === "movingimage_post" ){
               $recommend_class = "movieList";
               $cat = get_the_terms($post->ID,"movingimage_cat");
               $cat = current($cat);
               $catNameGrandson = $cat->name;
               $catId = $cat->term_id;
               $args = array (
                    'post_type' => $post->post_type, #投稿種別を絞る
                    'tax_query' => array(
                        array(
                                'taxonomy' => "movingimage_cat",
                                'field' => 'id',
                                'terms' => $catId,
                            ),
                    ),
               );
      }elseif($post->post_type === "item_post") {
          $recommend_class = "itemList";
          $cat = get_the_terms($post->ID,"item_cat");
          $cat = current($cat);
          $catNameGrandson = $cat->name;
          $catId = $cat->term_id;
          $args = array (
              'post_type' => $post->post_type, #投稿種別を絞る
              'tax_query' => array(
                  array(
                      'taxonomy' => "item_cat",
                      'field' => 'id',
                      'terms' => $catId,
                  ),
              ),
          );
      }else{
                // 最遠親カテゴリまたはカテゴリ自身のIDが1かどうか判断し、代入
                $postCat = get_the_category();
                usort( $postCat , '_usort_terms_by_ID');
                $catId = $postCat[0]->cat_ID == 1 ? 1 :$postCat[2]->cat_ID;
                $catNameGrandson = '';
          if( $catId !== 1) {
              $catNameGrandson = $postCat[2]->cat_name;
          }
            $args = array (
                    'post_type' => $post->post_type, #投稿種別を絞る
                    'cat' => $catId,
            );
      }

      // 検索条件の共通項を追加
      $args += array(
               'posts_per_page' => 6,
               'orderby' => 'rand',
      );
      $query = new WP_Query($args);
?>

<section class="pulsArea">
	<?php
        if( $post->post_type === "item_post" ){
            echo '<h1 class="heading">関連商品</h1>';
        }else{
            echo '<h1 class="heading"><span>あ</span><span>わ</span><span>せ</span><span>て</span><span>読</span><span>み</span><span>た</span><span>い</span></h1>';
        }
    ?>
	<ul class="<?php echo($recommend_class)?>">
	<?php if( $query -> have_posts() ): ?>
     <?php while ($query -> have_posts()) : $query -> the_post(); ?>
		  <?php if( $post->post_type === "item_post" ): ?>
			 <?php
	  			$thumbnail_id = get_post_thumbnail_id();
	  			$image = wp_get_attachment_image_src( $thumbnail_id, 'pcList_thumbnail' );
	  		?>
			  <li>
				  <a href="<?php the_permalink(); ?>">
					  <div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
						  <img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
					  </div>
					  <div class="starArea">
						  <i class="fa fa-star on" aria-hidden="true"></i>
						  <i class="fa fa-star" aria-hidden="true"></i>
						  <i class="fa fa-star" aria-hidden="true"></i>
						  <i class="fa fa-star" aria-hidden="true"></i>
						  <i class="fa fa-star" aria-hidden="true"></i>
					  </div>
					  <h2><?php the_title(); ?></h2>
					  <p class="price">
						  ¥<?php echo( get_post_meta($post->ID, 'item', true)); ?>
					  </p>
					  <div class="overlay">
						  <div class="ovWrap">
							  <i class="fa fa-shopping-cart" aria-hidden="true"></i>
							  <p>READ MORE</p>
							  <div class="bd bdT"></div>
							  <div class="bd bdB"></div>
							  <div class="bd bdR"></div>
							  <div class="bd bdL"></div>
						  </div>
					  </div>
				  </a>
			  </li>
		<?php elseif($post->post_type === "movingimage_post"): ?>
            <?php
                $post_cat = get_the_terms($post->ID, 'movingimage_cat');
                usort( $post_cat , '_usort_terms_by_ID');
                $catName = $post_cat[1]->name;
                $thumbnail_id = get_post_thumbnail_id();
                $image = wp_get_attachment_image_src( $thumbnail_id, '900_thumbnail' );
            ?>
            <li>
                <a href="<?php the_permalink(); ?>">
                    <div class="content">
                        <div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
                            <img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
                        </div>
                        <div class="overlay">
                            <div class="ovWrap">
                                <div class="ttlArea">
                                    <i class="fa fa-video-camera" aria-hidden="true"></i>
                                    <p>WHATCH MORE</p>
                                </div>
                                <div class="contentData">
                                    <div class="articleData">
                                        <p class="data"><?php the_time('Y/m/d'); ?></p>
                                        <p class="cat"><?php echo $catName; ?></p>
                                    </div>
                                    <h2><?php the_title(); ?></h2>
                                    <p class="pv">
                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                        <?php
                                            if ( function_exists ( 'wpp_get_views' ) ) {
                                                echo wpp_get_views ( get_the_ID() ); }
                                        ?>
                                    </p>
                                </div>
                                <div class="bd bdT"></div>
                                <div class="bd bdB"></div>
                                <div class="bd bdR"></div>
                                <div class="bd bdL"></div>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
        <?php else: ?>
		<?php
            // $postCat = get_the_category();
            // usort( $postCat , '_usort_terms_by_ID');
            // $catId = $postCat[0]->cat_ID;
            // $catIdGrandson = $postCat[2]->cat_ID;
            // $catNameGrandson = $postCat[2]->cat_name;
			// $args = array (
	        //         'cat' => $catId === 1 ? 1 : $catIdGrandson,
	        //         'posts_per_page' => 6,
	        //         'orderby' => 'rand',
            //     );
            // $query = new WP_Query($args);
        ?>
		<?php //if( $query -> have_posts() ):
              //while ($query -> have_posts()) : $query -> the_post(); ?>
		<?php
			$thumbnail_id = get_post_thumbnail_id();
			$image = wp_get_attachment_image_src( $thumbnail_id, 'pcList_thumbnail' );
		?>
			<li>
				<a href="<?php the_permalink(); ?>">
					<div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
						<img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
						<div class="overlay">
							<div class="ovWrap">
								<i class="icon-book"></i>
								<p>READ MORE</p>
								<div class="bd bdT"></div>
								<div class="bd bdB"></div>
								<div class="bd bdR"></div>
								<div class="bd bdL"></div>
							</div>
						</div>
					</div>
					<div class="content">
						<div class="articleData">
							<p class="data"><?php the_time('Y/m/d'); ?></p>
							<p class="cat"><?php echo $catNameGrandson; ?></p>
						</div>
						<h2><?php the_title(); ?></h2>
						<div class="articleData">
							<p class="name"><?php the_author(); ?></p>
							<p class="pv">
								<i class="fa fa-heart" aria-hidden="true"></i>
								<?php
	                                if ( function_exists ( 'wpp_get_views' ) ) {
	                                    echo wpp_get_views ( get_the_ID() ); }
	                            ?>
							</p>
						</div>
					</div>
				</a>
			</li>
		<?php endif; ?>
		<?php endwhile; else: ?>
		<li class="none">該当する記事がありません。</li>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</ul>
</section>
