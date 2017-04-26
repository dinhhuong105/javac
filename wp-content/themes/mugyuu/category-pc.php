<?php get_header(); ?>
<?php breadcrumb(); ?>
    <div class="mainWrap list">
        <div class="mainArea">
            <section class="articleListArea categoryArea">
				<?php
                    $cat = get_queried_object();
                    $catName = $cat->cat_name;
                    $catDiscription = $cat->category_description;
                    $catId = $cat->cat_ID;
            	?>
                <h1 class="heading">
                    <?php echo $catName; ?>
                </h1>
                <p class="ttl">
                    <?php echo $catDiscription; ?>
                </p>
                <ul class="articleList newList">
                    <?php
    				   $args = array(
    					   'posts_per_page' => 10,
    					   'paged' => $paged,
                           'cat' => $catId,
				           'post_type' => array('post', 'thread_post', 'question_post'),
    				   );
    				   $query = new WP_Query($args);
    			   ?>
					<?php
                        if ($query -> have_posts()) :
                        while($query -> have_posts()) : $query -> the_post(); ?>
                    <?php
                        $postCat = get_the_category();
                            usort( $postCat , '_usort_terms_by_ID');
                        $count = count($postCat);
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
						$thumbnail_id = get_post_thumbnail_id();
	                    $image = wp_get_attachment_image_src( $thumbnail_id, 'pcList_thumbnail' );
                        $author_id = $post->post_author;
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
									<p class="name"><?php the_author(); ?></p>
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
				<?php endwhile; else: ?>
					<li class="none">該当する記事がありません。</li>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
                </ul>
				<?php if (function_exists("pagination")) {
                    pagination($query->max_num_pages);
                	}
            	?>
            </section>
        </div>
		<?php get_sidebar(); ?>
    </div>
<?php get_footer(); ?>
