<?php get_header(); ?>
<?php breadcrumb(); ?>
<div class="mainWrap author">
            <div class="mainArea">
                <section class="profileArea">
					<?php
	                    $user_data = get_userdata($author);
	                    $author_id = $user_data->ID;
	                    $author_name = $user_data->display_name;
	                    $userLebel = $user_data->roles;
                        usort( $userLebel , '_usort_terms_by_ID');
                	?>
                    <h1 class="heading">
                        <?php echo $author_name; ?>
                    </h1>
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
                            <p class="skill">
                                <?php echo nl2br(get_the_author_meta('skill', $author_id)); ?>
                            </p>
                            <p class="profileText">
                                <?php echo nl2br(get_the_author_meta('user_description', $user_data->ID)); ?>
                            </p>
                            <div class="snsArea">
								<?php if(get_the_author_meta('url') != ""): ?>
			                        <div class="iconArea pc">
			                            <a href="<?php the_author_meta('url'); ?>">
			                                <i class="fa fa-desktop" aria-hidden="true"></i>
			                            </a>
			                        </div>
			                    <?php endif; ?>
								<?php if(get_the_author_meta('facebook') != ""): ?>
			                        <div class="iconArea fb">
			                            <a href="<?php the_author_meta('facebook'); ?>">
			                                <i class="icon fa fa-facebook-square" aria-hidden="true"></i>
			                            </a>
			                        </div>
			                    <?php endif; ?>
								<?php if(get_the_author_meta('twitter') != ""): ?>
									<div class="iconArea tw">
										<a href="<?php the_author_meta('twitter'); ?>">
											<i class="icon fa fa-twitter-square" aria-hidden="true"></i>
										</a>
									</div>
								<?php endif; ?>
								<?php if(get_the_author_meta('instagram') != ""): ?>
			                        <div class="iconArea inst">
			                            <a href="<?php the_author_meta('instagram'); ?>">
			                                <i class="fa fa-instagram" aria-hidden="true"></i>
			                            </a>
			                        </div>
			                    <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="articleListArea">
                    <p class="ttl">
                        <?php echo $author_name; ?>の記事一覧
                    </p>
					<?php
	                    if( $userLebel[0] == 'movie-editor' ){
	                        echo '<ul class="movieList">';
	                    }else {
	                        echo '<ul class="articleList authorList">';
	                    }
	                ?>
					<?php
	                   if( $userLebel[0] == 'movie-editor' ){
	                            $args = array(
	                              'posts_per_page' => 3,
	                              'post_type' => 'movingimage_post',
	                              'author' => $author_id,
								  'paged' => $paged,
	                            );
	                        $query = new WP_Query($args);
	                        if ($query->have_posts()) :
	                        while($query->have_posts()) : $query->the_post();
	                             $post_cat = get_the_terms(get_the_ID(), 'movingimage_cat');
	                             $catNameGrandson = '';
								 $thumbnail_id = get_post_thumbnail_id();
					             $image = wp_get_attachment_image_src( $thumbnail_id, '320_thumbnail' );
	                             if( !empty($post_cat) && is_array($post_cat) ){
	                                  usort( $post_cat , '_usort_terms_by_ID');
	                                  $catId = current($post_cat)->term_id == 1 ? 1 :end($post_cat)->term_id;
	                                  $catNameGrandson = $catId !== 1?end($post_cat)->name:"";
	                             }
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
				                                    <p class="cat"><?php echo $catNameGrandson; ?></p>
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
						<?php
                        endwhile;
                        else:
                                 echo("<li class=\"none\">該当する記事がありません。</li>");
                        endif;
                        wp_reset_postdata();
               }else{
                      ?>
					<?php
						$query = new WP_Query([
							'post_type' => 'post',
							'posts_per_page' => 1,
							'author' => $author_id,
							'paged' => $paged,
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
					<?php endwhile; else: ?>
						<li class="none">該当する記事がありません。</li>
						<?php endif; ?>
					<?php } ?>
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
