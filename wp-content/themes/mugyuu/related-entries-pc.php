<?php
      global $post;
      // アンケート公開ディレクトリまでのURL
      $questionary_url = home_url()."/questionary/public/";
      $recommend_class = "articleList plusList";

      if($post->post_type === "movie_post"){
               $recommend_class = "movieList";
            //    if($post->post_type === "movingimage_post") {
                //    $cat = get_the_terms($post->ID,"movingimage_cat");
            //    }elseif($post->post_type === "movie_post") {
                    $cat = get_the_terms($post->ID,"movie_cat");
            //    }

            //    $cat = get_the_terms($post->ID,"movingimage_cat");
               $cat = current($cat);
               $taxonomy = $cat->taxonomy;
               $catNameGrandson = $cat->name;
               $catId = $cat->term_id;
               $args = array (
                    'post_type' => $post->post_type, #投稿種別を絞る
                    'posts_per_page' => 4,
                    'tax_query' => array(
                        array(
                                'taxonomy' => $taxonomy,
                                'field' => 'id',
                                'terms' => $catId,
                            ),
                    ),
               );
      }elseif($post->post_type === "movingimage_post") {
             $recommend_class = "recipeList";
             $cat = get_the_terms($post->ID,"movingimage_cat");
             $cat = current($cat);
             $taxonomy = $cat->taxonomy;
             $catId = $cat->term_id;
             $args = array (
                  'post_type' => $post->post_type, #投稿種別を絞る
                  'posts_per_page' => 4,
                  'tax_query' => array(
                      array(
                              'taxonomy' => $taxonomy,
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
              'posts_per_page' => 6,
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
                $count = count($postCat);
                // $catId = $count > 2 ? $postCat[2]->cat_ID : $postCat[1]->cat_ID;
                // $catId = $postCat[0]->cat_ID == 1 ? 1 :$postCat[2]->cat_ID;
                $catId = '';
                $catNameGrandson = '';

          if( $count === 3) {//カテが3
              $catNameGrandson = $postCat[2]->cat_name;
              $catId = $postCat[2]->cat_ID;
          } elseif( $count === 2) {//カテが2
              $catNameGrandson = $postCat[1]->cat_name;
              $catId = $postCat[1]->cat_ID;
          }else{
               $catId = $postCat[0]->cat_ID;
              $catNameGrandson = $postCat[0]->cat_name;
              $catIdGrandson = $postCat[0]->cat_ID;
          }
            $args = array (
                    'posts_per_page' => 6,
                    'post_type' => $post->post_type, #投稿種別を絞る
                    'cat' => $catId,
            );
      }

      // 検索条件の共通項を追加
      $args += array(
               'orderby' => 'rand',
      );
      $query = new WP_Query($args);
?>
<?php
    if( $post->post_type === "movingimage_post" ){
        echo '<section class="pulsArea recipeArea">';
    }elseif( $post->post_type === "movie_post" ){
        echo '<section class="pulsArea movieArea">';
    }
    else{
        echo '<section class="pulsArea">';
    }
?>
	<?php
        if( $post->post_type === "item_post" ){
            echo '<h2 class="heading">関連商品</h2>';
        }else{
            echo '<h2 class="heading"><span>あ</span><span>わ</span><span>せ</span><span>て</span><span>読</span><span>み</span><span>た</span><span>い</span></h2>';
        }
    ?>
	<ul class="<?php echo($recommend_class)?>">
	<?php if( $query -> have_posts() ): ?>
     <?php while ($query -> have_posts()) : $query -> the_post(); ?>
		  <?php if( $post->post_type === "item_post" ): ?>
			 <?php
	  			$thumbnail_id = get_post_thumbnail_id();
	  			$image = wp_get_attachment_image_src( $thumbnail_id, '180_thumbnail' );
	  		?>
			  <li>
				  <a href="<?php the_permalink(); ?>">
					  <div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
						  <img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
					  </div>
					  <div class="starArea">
                          <?php  $score = get_post_meta($post->ID, 'average_score', true);?>
                          <?php  for($i=0;$i<$score;$i++){ ?>
                             <i class="fa fa-star on" aria-hidden="true"></i>
                          <?php } ?>
                          <?php for($i=5;$score<$i;$i--){?>
                              <i class="fa fa-star" aria-hidden="true"></i>
                          <?php } ?>
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
		<?php elseif($post->post_type === "movie_post"): ?>
            <?php
                $post_type = $post->post_type;
                $post_cat = get_the_terms($post->ID, 'movie_cat');
                usort( $post_cat , '_usort_terms_by_ID');
                $catName = $post_cat[1]->name;
                $thumbnail_id = get_post_thumbnail_id();
                $image = wp_get_attachment_image_src( $thumbnail_id, '320_thumbnail' );
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
                                    <i class="icon fa fa-video-camera" aria-hidden="true"></i>
                                    <p>WATCH MORE</p>
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
        <?php elseif($post->post_type === "movingimage_post"): ?>
            <?php
                // $post_type = $post->post_type;
                // $post_cat = get_the_terms($post->ID, 'movingimage_cat');
                // usort( $post_cat , '_usort_terms_by_ID');
                $thumbnail_id = get_post_thumbnail_id();
                $image = wp_get_attachment_image_src( $thumbnail_id, '320_thumbnail' );
            ?>
            <li>
                <a href="<?php the_permalink(); ?>">
                    <div class="content">
                        <div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
                            <img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
                        </div>
                        <h2><?php the_title(); ?></h2>
                        <div class="overlay">
                            <div class="ovWrap">
                                <div class="ttlArea">
                                    <span class="icon icon-recipe"></span>
                                    <p>LET'S TRY</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
        <?php else: ?>
    		<?php
    			$thumbnail_id = get_post_thumbnail_id();
    			$image = wp_get_attachment_image_src( $thumbnail_id, 'pcList_thumbnail' );
    			if($post->post_type == 'thread_post' && !$image[0]){
    			    $image[0] = get_template_directory_uri()."/images/noimage-thumbnail.png";
    			}
                $author = get_userdata($post->post_author);
                $authorRoles = $author->roles;
                usort( $authorRoles , '_usort_terms_by_ID');
                $author_id = $post->post_author;
                $cats = get_the_category();
                usort($cats, '_usort_terms_by_ID');
                $count = count($cats);
                if( $count === 3) {//カテが3
                    $catNameGrandson = $cats[2]->cat_name;
                    $catId = $cats[2]->cat_ID;
                } elseif( $count === 2) {//カテが2
                    $catNameGrandson = $cats[1]->cat_name;
                    $catId = $cats[1]->cat_ID;
                }else{
                     $catId = $cats[0]->cat_ID;
                    $catNameGrandson = $cats[0]->cat_name;
                    $catIdGrandson = $cats[0]->cat_ID;
                }
    		?>
			<li>
				<a href="<?php the_permalink(); ?>">
					<div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
						<img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
						<div class="overlay">
							<div class="ovWrap">
								<i class="icon-book2"></i>
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
                            <?php if($author_id !== '66') { ?>
    							<p class="name">
                                    <?php
        								 if  ($authorRoles[0] == 'editor' ) {
        									 echo '<span class="icon-mugyuu"></span>';
        								 }
        							?>
                                    <?php the_author(); ?>
                                </p>
                            <?php } ?>
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



<?php
// 関連アンケートの表示。投稿種別によっては非表示
// if( $post->post_type !== "movingimage_post" && $post->post_type !== "item_post"):
//     global $wpdb;
//
//     // dbからデータを取得する
//     $query = "
//         SELECT
//                *
//         FROM
//                `boards`
//         WHERE
//                `term_id` LIKE {$catId} AND
//                AND `status` LIKE 0
//         ORDER BY
//                RAND() ASC
//         LIMIT
//                4
//     ";
//     $results = $wpdb->get_results( $query, OBJECT );

    ?>
    <?php //if($catId !== 1):?>
    <!-- <section class="plusArea">
        <h1 class="heading">
            <span>関</span><span>連</span><span>の</span><span>あ</span><span>る</span><span>ア</span><span>ン</span><span>ケ</span><span>ー</span><span>ト</span>
        </h1>
       <ul class="articleList plusList">
            <?php //foreach($results as $board):?>
            <?php
                // $img_dir = $questionary_url.'/assets/img/';
                // $thumb_dir = $img_dir.'uploads/list/';
                //
                // if(  is_file($thumb_dir.$board->image) )
                // {
                //     $img_class = "imgArea";
				// 	$img_path = $thumb_dir.$board->image;
                //     $img_html = "<img src=\"{$img_path}\">";
                // }
                // else
                // {
                //     $img_class = "imgArea noImage";
                //
                //     $cat = get_category($board->term_id);
                //     $cat_list = get_ancestors( $board->term_id, 'category' );
                //     $term_id = !empty($cat) && $cat->parent ? end($cat_list) : $board->term_id;
                //
                //     switch($term_id)
                //     {
                //         case 2: //こどものこと
				// 			$img_path = "{$img_dir}babyBig.png";
                //             $img_html = "<img src=\"{$img_path}\" class=\"catChild\">";
                //             break;
                //
                //         case 3: //ままのこと
				// 			$img_path = "{$img_dir}mamaBig.png";
                //             $img_html = "<img src=\"{$img_path}\" class=\"catMama\">";
                //             break;
                //
                //         default:
                //             $img_path = "{$img_dir}mamaBig.png";
                //             $img_html = "<img src=\"{$img_path}\" class=\"catMama\">";
                //     }
                //  }

            ?>
                <li>
                    <a href="<?php// echo(home_url()."/questionary/board/view/{$board->id}")?>">
                        <div class="<?php //echo( $img_class ) ?>" style="background-image: url(<?php //echo $image[0]; ?>);">
                            <img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
							<div class="overlay">
								<div class="ovWrap">
									<i class="icon-book2"></i>
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
                                <p class="data"><?php //echo(date('Y/m/d',$board->created_at)); ?></p>
                                <p class="cat"><?php //echo $cat->cat_name; ?></p>
                            </div>
                            <h2><?php //echo( $board->title ); ?></h2>
                            <div class="articleData">
                                <p class="name"></p>
                                <p class="pv">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                    <?php //echo( $board->count ); ?>
                                </p>
                            </div>
                        </div>
                    </a>
                </li>
                <?php //endforeach;?>
                <?php //if( empty($results) ): ?>
                    <li class="none">該当するアンケートがありません。</li>
                <?php //endif;?>
       </ul>
    </section> -->
    <?php //endif ?>
<?php //endif ?>
