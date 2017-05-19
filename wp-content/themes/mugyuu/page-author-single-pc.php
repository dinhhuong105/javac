<?php get_header(); ?>
<?php breadcrumb(); ?>
<?php
	$author_name = $_GET['uNAME'];
	$author_id = $_GET['uID'];
    $tab = isset($_GET['tab']) ? $_GET['tab'] : null;
    $current_page = (get_query_var('paged')) ? get_query_var('paged'):1;
    global $paged;
?>
<div class="mainWrap author">
            <div class="mainArea">
				<section class="profileArea">
					<?php
	                    $user_data = get_userdata($author_id);
	                    $author_name = $user_data->display_name;
	                    $userLebel = $user_data->roles;
                        usort( $userLebel , '_usort_terms_by_ID');
                	?>
                    <div class="dataArea">
                        <?php
                             if  ($userLebel[0] == 'author' ) {
                                 echo '<div class="imgArea author">';
                             } else {
                                 echo '<div class="imgArea">';
                             }
                         ?>
                            <?php echo get_avatar($author_id, 200); ?>
                        </div>
                        <div class="profile">
                            <h1 class="heading">
                                <?php
                                    if($userLebel[0] === 'editor' || $userLebel[0] === 'movie-editor') {
                                        echo '<span class="icon-mugyuu"></span>';
                                    }
                                ?>
                                <?php echo $author_name; ?>
                            </h1>
                            <p class="skill">
                                <?php echo nl2br(get_the_author_meta('skill', $author_id)); ?>
                            </p>
                        </div>
                        <p class="profileText">
                            <?php echo nl2br(get_the_author_meta('user_description', $user_data->ID)); ?>
                        </p>
                        <div class="snsArea">
                            <?php if(get_the_author_meta('url') != ""): ?>
                                <div class="iconArea pc">
                                    <a href="<?php the_author_meta('url'); ?>" target="_blank">
                                        <i class="fa fa-desktop" aria-hidden="true"></i>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if(get_the_author_meta('facebook') != ""): ?>
                                <div class="iconArea fb">
                                    <a href="<?php the_author_meta('facebook'); ?>" target="_blank">
                                        <i class="icon fa fa-facebook-square" aria-hidden="true"></i>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if(get_the_author_meta('twitter') != ""): ?>
                                <div class="iconArea tw">
                                    <a href="<?php the_author_meta('twitter'); ?>" target="_blank">
                                        <i class="icon fa fa-twitter" aria-hidden="true"></i>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if(get_the_author_meta('instagram') != ""): ?>
                                <div class="iconArea inst">
                                    <a href="<?php the_author_meta('instagram'); ?>" target="_blank">
                                        <i class="fa fa-instagram" aria-hidden="true"></i>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
                <section class="articleListArea">
                    <p class="ttl">
                        <?php echo $author_name; ?>の記事一覧
                    </p>
                    <div class="tabs">
                        <ul class="postTypeList">
                            <li data-tab-content="post-type-column" class="<?php echo ($tab == 'column' || $tab == null) ? 'active' : '' ?>"><a href="#" class="noscroll"><i class="icon icon-book2"></i></a></li>
                            <li data-tab-content="post-type-recipe" class="<?php echo ($tab == 'recipe') ? 'active' : '' ?>"><a href="#" class="noscroll"><span class="icon icon-recipe"></span></a></li>
                            <li data-tab-content="post-type-movie" class="<?php echo ($tab == 'movie') ? 'active' : '' ?>"><a href="#" class="noscroll"><i class="icon fa fa-video-camera camera" aria-hidden="true"></i></a></li>
                        </ul>
                        <div class="tabContentArea">
                            <div id="post-type-column" class="postContent <?php echo ($tab === 'column' || $tab === null) ? 'selected' : '' ; ?>">
                                <ul class="articleList authorList">
                                    <?php
                                        $posts_per_page = 10;
                                        $paged = $current_page;
                                        $col_maxpage = new WP_Query([
                                            'posts_per_page' => $posts_per_page,
                                            'author' => $author_id,
                                            'post_type' => array('post', 'thread_post', 'question_post'),
                                        ]);
                						$col_query = new WP_Query([
                							'post_type' => array('post', 'thread_post', 'question_post'),
                							'posts_per_page' => $posts_per_page,
                							'author' => $author_id,
                                            'paged' => ($current_page > $col_maxpage->max_num_pages) ? $col_maxpage->max_num_pages : $current_page,
                						]);
                                        if ($col_query->have_posts()) :
                                        while($col_query->have_posts()) : $col_query->the_post();
                                    ?>
                                    <?php
                                        $post_cat = get_the_category();
                                        usort( $post_cat , '_usort_terms_by_ID');
                                        $catId = current($post_cat)->cat_ID == 1 ? 1 :end($post_cat)->cat_ID;
                                        $catNameGrandson = '';
                                        if( $catId !== 1) { $catNameGrandson = end($post_cat)->cat_name; }
                						$thumbnail_id = get_post_thumbnail_id();
                	                    $image = wp_get_attachment_image_src( $thumbnail_id, 'pcList_thumbnail' );
                	                    if($post->post_type == 'thread_post' && !$image[0]){
                	                        $image[0] = get_template_directory_uri()."/images/noimage-thumbnail.png";
                	                    }
                                    ?>
                						<li>
                                            <a href="<?php the_permalink(); ?>">
                                                <div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
                                                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw==">
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
                                                        <p class="name"><?php the_author(); ?></p>
                                                        <p class="pv">
                											<i class="fa fa-heart" aria-hidden="true"></i>
                                                            <?php
                                                                echo wpp_get_views ( get_the_ID() );
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
                                <?php
                                    if($col_maxpage->max_num_pages !== 0) {
                                        echo pagination($col_maxpage->max_num_pages);
                                    }
                    			?>
                            </div>
                            <div id="post-type-recipe" class="postContent <?php echo $tab === 'recipe' ? 'selected' : '' ; ?>">
                                <ul class="recipeList authorList">
                                    <?php
                                        $posts_per_page = 10;
                                        $paged = $current_page;
                                        $re_maxpage = new WP_Query([
                                            'posts_per_page' => $posts_per_page,
                                            'author' => $author_id,
                                            'post_type' => 'movingimage_post',
                                        ]);
                						$re_query = new WP_Query([
                                            'post_type' => 'movingimage_post',
                                            'posts_per_page' => $posts_per_page,
                                            'author' => $author_id,
                                            'paged' => ($current_page > $re_maxpage->max_num_pages) ? $re_maxpage->max_num_pages : $current_page,
                                        ]);
                                        if ($re_query->have_posts()) :
                                        while($re_query->have_posts()) : $re_query->the_post();
                                    ?>
                                    <?php
                                        $thumbnail_id = get_post_thumbnail_id();
                                        $image = wp_get_attachment_image_src( $thumbnail_id, '320_thumbnail' );
                                    ?>
                                    <li>
                                        <a href="<?php the_permalink(); ?>">
                                            <div class="content">
                                                <div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
                                                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw==">
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
                					<?php endwhile; else: ?>
                						<li class="none">該当する記事がありません。</li>
                					<?php endif; ?>
                                    <?php wp_reset_postdata(); ?>
                                </ul>
                                <?php
                                    if($re_maxpage->max_num_pages !== 0) {
                                        echo pagination($re_maxpage->max_num_pages);
                                    }
                    			?>
                            </div>
                            <div id="post-type-movie" class="postContent <?php echo $tab === 'movie' ? 'selected' : '' ; ?>">
                                <ul class="movieList authorList">
                                    <?php
                                        $posts_per_page = 10;
                                        $paged = $current_page;
                                        $mv_maxpage = new WP_Query([
                							'posts_per_page' => $posts_per_page,
                                            'author' => $author_id,
                                            'post_type' => 'movie_post',
                						]);
                						$mv_query = new WP_Query([
                                            'posts_per_page' => $posts_per_page,
                                            'author' => $author_id,
                                            'post_type' => 'movie_post',
                                            'paged' => ($current_page > $mv_maxpage->max_num_pages) ? $mv_maxpage->max_num_pages : $current_page,
                                        ]);
                                        if ($mv_query->have_posts()) :
                                        while($mv_query->have_posts()) : $mv_query->the_post();
                                    ?>
                                    <?php
                                        $thumbnail_id = get_post_thumbnail_id();
                                        $image = wp_get_attachment_image_src( $thumbnail_id, '320_thumbnail' );
                                        $cat = get_queried_object();
                        				$catName = $cat->name;
                        				$catDiscription = $cat->description;
                        				$catId = $cat->cat_ID;
                        				$taxonomySlug = $cat->slug;
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
                					<?php endwhile; else: ?>
                						<li class="none">該当する記事がありません。</li>
                					<?php endif; ?>
                                    <?php wp_reset_postdata(); ?>
                                </ul>
                                <?php
                                    if($mv_maxpage->max_num_pages !== 0) {
                                        echo pagination($mv_maxpage->max_num_pages);
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
			<?php get_sidebar(); ?>
        </div>
		<?php get_footer(); ?>
