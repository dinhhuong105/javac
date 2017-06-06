       <?php get_header(); ?>
        <div id="sb-site" class="wrapper new">
            <?php breadcrumb(); ?>
            <section class="newArea">
                <h1 class="heading">
                    <span>N</span><span>E</span><span>W</span>
                </h1>
                <ul class="articleList newList">
                    <?php
                        $posts_per_page = 5;
                        $val = new WP_Query([
                            'posts_per_page' => $posts_per_page,
                        ]);
                        $query = new WP_Query([
                            'cat' =>array(-1, -281),
                            'post_type' => 'post',//array('post', 'thread_post', 'question_post'),
                            'posts_per_page' => $posts_per_page,
                            'paged' => ($paged > $val->max_num_pages) ? $val->max_num_pages : $paged,
                        ]);
                    ?>
                    <?php
                        if ($query -> have_posts()) :
                        while($query -> have_posts()) : $query -> the_post(); ?>
                        <?php
                            $post_cat = get_the_category();
                                usort( $post_cat , '_usort_terms_by_ID');
                            $count = count($post_cat);
                            if($count === 3) {//カテが3
                                $catNameGrandson = $post_cat[2]->cat_name;
                            }elseif($count === 2){//カテが2
                                $catNameGrandson = $post_cat[1]->cat_name;
                            }else{
                                $catNameGrandson = $post_cat[0]->cat_name;
                            }
							$thumbnail_id = get_post_thumbnail_id();
							$image = wp_get_attachment_image_src( $thumbnail_id, 'list_thumbnail' );
							if($post->post_type == 'thread_post' && !$image[0]){
							    $image[0] = get_template_directory_uri()."/images/noimage-thumbnail-sp.png";
							}
                            $author = get_userdata($post->post_author);
                            $authorRoles = $author->roles;
                            usort( $authorRoles , '_usort_terms_by_ID');
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
                    <?php endwhile; else: ?>
                    <p class="none">該当する記事がありません。</p>
                    <?php endif; ?>
                </ul>
                <?php
                    if(function_exists("pagination")) {
                        pagination($val->max_num_pages);
                    }
                ?>
                <?php wp_reset_postdata(); ?>
            </section>
    <?php get_footer(); ?>
