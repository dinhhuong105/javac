<?php get_header(); ?>
<?php
    $tab = isset($_GET['tab']) ? $_GET['tab'] : null;
?>
        <div id="sb-site" class="wrapper author">
            <?php breadcrumb(); ?>
            <section class="authorProfileArea">
                <?php
                    $user_data = get_userdata($author);
                    $author_id = $user_data->ID;
                    $author_name = $user_data->display_name;
                    $userLebel = $user_data->roles;
                    usort( $userLebel , '_usort_terms_by_ID');
                ?>
                <?php
                    if  ($userLebel[0] == 'editor' || $userLebel[0] == 'movie-editor') {
                        echo '<div class="imgArea editor">';
                    } else {
                        echo '<div class="imgArea">';
                    }
                ?>
                <?php echo get_avatar($user_data->ID, 280); ?>
                </div>
                <h1 class="name"><?php echo $author_name; ?></h1>
            <p class="type"><?php echo nl2br(get_the_author_meta('skill', $user_data->ID)); ?></p>
                <p class="profile">
                    <?php echo nl2br(get_the_author_meta('user_description', $user_data->ID)); ?>
                </p>
                <div class="authorSnsArea">
                    <?php if(get_the_author_meta('url') != ""): ?>
                        <div class="sns web">
                            <a href="<?php the_author_meta('url'); ?>" target="_blank">
                                <i class="fa fa-desktop" aria-hidden="true"></i>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if(get_the_author_meta('facebook') != ""): ?>
                        <div class="sns fb">
                            <a href="<?php the_author_meta('facebook'); ?>" target="_blank">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if(get_the_author_meta('twitter') != ""): ?>
                        <div class="sns tw">
                            <a href="<?php the_author_meta('twitter'); ?>" target="_blank">
                                <i class="fa fa-twitter" aria-hidden="true"></i>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if(get_the_author_meta('instagram') != ""): ?>
                        <div class="sns inst">
                            <a href="<?php the_author_meta('instagram'); ?>" target="_blank">
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
            <?php
                if( $userLebel[0] == 'movie-editor' ){
                    echo '<section class="authorArticleArea movie">';
                }else {
                    echo '<section class="authorArticleArea">';
                }
            ?>
                <p class="all">
                    記事一覧
                </p>
                <div class="tabs">
                    <ul class="postTypeList">
                        <li data-tab-content="post-type-column" class="<?php echo ($tab == 'column' || $tab == null) ? 'active' : '' ?>"><a href="#" class="noscroll"><i class="icon icon-book2"></i></a></li>
                        <li data-tab-content="post-type-recipe" class="<?php echo ($tab == 'recipe') ? 'active' : '' ?>"><a href="#" class="noscroll"><span class="icon icon-recipe"></span></a></li>
                        <li data-tab-content="post-type-movie" class="<?php echo ($tab == 'movie') ? 'active' : '' ?>"><a href="#" class="noscroll"><i class="icon fa fa-video-camera camera" aria-hidden="true"></i></a></li>
                    </ul>
                    <div class="tabContentArea">
                        <div id="post-type-column" class="postContent <?php echo ($tab === 'column' || $tab === null) ? 'selected' : '' ; ?>">
                            <ul class="articleList authorArticleList">
                                <?php
                                    $query = new WP_Query([
                                        'post_type' => array('post', 'thread_post', 'question_post'),
                                        'posts_per_page' => 4,
                                        'author' => $author_id,
                                    ]);
                                    if ($query->have_posts()) :
                                    while($query->have_posts()) : $query->the_post();
                                ?>
                                <?php
                                    $post_cat = get_the_category();
                                    usort( $post_cat , '_usort_terms_by_ID');
                                    $catId = current($post_cat)->cat_ID == 1 ? 1 :end($post_cat)->cat_ID;
                                    $catNameGrandson = '';
                                    if( $catId !== 1) { $catNameGrandson = end($post_cat)->cat_name; }
                                    $thumbnail_id = get_post_thumbnail_id();
                                    $image = wp_get_attachment_image_src( $thumbnail_id, 'list_thumbnail' );
                                    if($post->post_type == 'thread_post' && !$image[0]){
                                        $image[0] = get_template_directory_uri()."/images/noimage-thumbnail-sp.png";
                                    }
                                ?>
                                <li>
                                    <a href="<?php the_permalink(); ?>">
                                        <div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw==">
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
                                                        if ("wpp_get_views") {
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
                            <?php if($query->max_num_pages > 1) { ?>
                                <div class="moreBtn">
    								<a href="<?php echo home_url(); ?>/author-more/?uID=<?php echo $author_id; ?>&uNAME=<?php echo $author_name; ?>&tab=column">もっと読む</a>
    							</div>
                            <?php } ?>
                        </div>
                        <div id="post-type-recipe" class="postContent <?php echo $tab === 'recipe' ? 'selected' : '' ; ?>">
                            <ul class="recipeList">
                                <?php
                				   $args = array(
                					   'posts_per_page' => 4,
                					   'post_type' => 'movingimage_post',
                                       'author' => $author_id,
                				   );
                				   $query = new WP_Query($args);
                			   ?>
                               <?php
                                   if ($query->have_posts()) :
                                   while($query->have_posts()) : $query->the_post(); ?>
                               <?php
                                   $post_cat = get_the_terms($post->ID, 'movingimage_cat');
                       				$thumbnail_id = get_post_thumbnail_id();
                       	            $image = wp_get_attachment_image_src( $thumbnail_id, '300_thumbnail' );
                               ?>
                                    <li>
                                        <a href="<?php the_permalink(); ?>">
                                            <div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
                								<img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
                                            </div>
                                            <h2><?php the_title(); ?></h2>
                                        </a>
                                    </li>
                                <?php endwhile; else: ?>
                                <li class="none">該当する記事がありません。</li>
                                <?php endif; ?>
                            <?php wp_reset_postdata(); ?>
                            </ul>
                            <?php if($query->max_num_pages > 1) { ?>
                                <div class="moreBtn">
                                    <a href="<?php echo home_url(); ?>/author-more/?uID=<?php echo $author_id; ?>&uNAME=<?php echo $author_name; ?>&tab=recipe">もっと読む</a>
                                </div>
                            <?php } ?>
                        </div>
                        <div id="post-type-movie" class="postContent <?php echo $tab === 'movie' ? 'selected' : '' ; ?>">
                            <ul class="movieList">
                                <?php
                                    $args = array(
                                        'post_type' => 'movie_post',
                                        'posts_per_page' => 4,
                                        'author' => $author_id,
                                    );
                                    $query = new WP_Query($args);
                                ?>
                                <?php
                                    if ($query -> have_posts()) :
                                    while($query -> have_posts()) : $query -> the_post(); ?>
                                <?php
                                    $post_cat = get_the_terms($post->ID, 'movie_cat');
                    				$thumbnail_id = get_post_thumbnail_id();
                    	            $image = wp_get_attachment_image_src( $thumbnail_id, '300_thumbnail' );
                                    if( !empty($post_cat) ){
                                        usort( $post_cat , '_usort_terms_by_ID');
                                        $catName = $post_cat[0]->name;
                                    }else{
                                        $catName = "";
                                    }
                                ?>
                                <li>
                                    <a href="<?php the_permalink(); ?>">
                    					<div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
                    						<img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
                    					</div>
                                        <div class="content">
                                            <div class="articleData">
                                                <p class="data"><?php the_time('Y/m/d'); ?></p>
                                                <p class="cat"><?php echo $catName; ?></p>
                                            </div>
                                            <h2><?php the_title(); ?></h2>
                                            <div class="articleData">
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
                            <?php if($query->max_num_pages > 1) { ?>
                            <div class="moreBtn">
                                <a href="<?php echo home_url(); ?>/author-more/?uID=<?php echo $author_id; ?>&uNAME=<?php echo $author_name; ?>&tab=movie">もっと読む</a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </section>
            <?php get_footer(); ?>
