<?php get_header(); ?>
        <div id="sb-site" class="wrapper category">
            <?php breadcrumb(); ?>
            <section class="categoryArea">
                <?php
                    $cat = get_queried_object();
                    $catName = $cat->cat_name;
                    $catDiscription = $cat->category_description;
                    $catCount = $cat->count;
                    $catId = $cat->cat_ID;
                ?>
                <h1><?php echo $catName; ?></h1>
                <p class="detail">
                    <?php echo $catDiscription; ?>
                </p>
                <p class="all">
                    全<?php echo $catCount; ?>件
                </p>
                <ul class="articleList categoryList">
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
                                    $postCatName = $postCat[2]->cat_name;
                                } elseif( $count === 2) {//カテが2
                                    $postCatName = $postCat[1]->cat_name;
                                }else{
                                    $postCatName = $postCat[0]->cat_name;
                                }
                            // $postCatName = $postCat[2]->cat_name;
							$thumbnail_id = get_post_thumbnail_id();
		                    $image = wp_get_attachment_image_src( $thumbnail_id, 'list_thumbnail' );
                            $author_id = $post->post_author;
                        ?>
                    <li>
                        <a href="<?php the_permalink(); ?>">
							<div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
								<img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
                            </div>
                            <div class="content">
                                <div class="articleData">
                                    <p class="data"><?php the_time('Y/m/d'); ?></p>
                                    <p class="cat"><?php echo $postCatName; ?></p>
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
                </ul>
                <?php if (function_exists("pagination")) {
                        pagination($query->max_num_pages);
                    }
                ?>
                <?php wp_reset_postdata(); ?>
            </section>
    <?php get_footer(); ?>
