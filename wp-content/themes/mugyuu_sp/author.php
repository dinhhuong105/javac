<?php get_header(); ?>
        <div id="sb-site" class="wrapper author">
            <?php breadcrumb(); ?>
            <section class="authorProfileArea">
                <?php
                    $user_data = get_userdata($author);
                    $author_id = $user_data->ID;
                    $author_name = $user_data->display_name;
                    $userLebel = $user_data->roles;
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
                            <a href="<?php the_author_meta('url'); ?>">
                                <i class="fa fa-desktop" aria-hidden="true"></i>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(get_the_author_meta('facebook') != ""): ?>
                        <div class="sns fb">
                            <a href="<?php the_author_meta('facebook'); ?>">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(get_the_author_meta('twitter') != ""): ?>
                        <div class="sns tw">
                            <a href="<?php the_author_meta('twitter'); ?>">
                                <i class="fa fa-twitter" aria-hidden="true"></i>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(get_the_author_meta('instagram') != ""): ?>
                        <div class="sns inst">
                            <a href="<?php the_author_meta('instagram'); ?>">
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
                <?php 
                    if( $userLebel[0] == 'movie-editor' ){
                        echo '<ul class="movieList">';
                    }else {
                        echo '<ul class="articleList authorArticleList">';
                    }
                ?>
                <?php
                   if( $userLebel[0] == 'movie-editor' ){
                            $args = array(
                              'posts_per_page' => 6,
                              'post_type' => 'movingimage_post',
                              'author' => $user_data->ID
                            );
                        $query = new WP_Query($args);
                        if ($query->have_posts()) :
                        while($query->have_posts()) : $query->the_post(); 
                             $post_cat = get_the_terms(get_the_ID(), 'movingimage_cat');
                             $catNameGrandson = '';
                             if( !empty($post_cat) && is_array($post_cat) ){
                                  usort( $post_cat , '_usort_terms_by_ID');
                                  $catId = current($post_cat)->term_id == 1 ? 1 :end($post_cat)->term_id;
                                  $catNameGrandson = $catId !== 1?end($post_cat)->name:"";
                             }
                        ?>
                        <li>
                              <a href="<?php the_permalink(); ?>">
                                    <div class="imgArea">
                                        <?php the_post_thumbnail('list_thumbnail'); ?>
                                    </div>
                                    <div class="content">
                                          <div class="articleData">
                                                <p class="data"><?php the_time('Y/m/d'); ?></p>
                                                <p class="cat"><?php echo $catNameGrandson; ?></p>
                                          </div>
                                          <h2><?php the_title(); ?></h2>
                                          <div class="articleData">
                                              <?php 
                                                   if( $userLebel[0] != 'movie-editor' ){
                                                       echo '<p class="name"><?php the_author(); ?></p>';
                                                   }
                                              ?>
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
                        <?php
                        endwhile;
                        else:
                                 echo("<li class=\"none\">該当する記事がありません。</li>");
                        endif;
               }else{

                      ?>
                    <?php 
                        if (have_posts()) :
                        while(have_posts()) : the_post(); 
                    ?>
                    <?php 
                        $post_cat = get_the_category();
                        usort( $post_cat , '_usort_terms_by_ID');
                        $catId = current($post_cat)->cat_ID == 1 ? 1 :end($post_cat)->cat_ID;
                        $catNameGrandson = '';
                        if( $catId !== 1) { $catNameGrandson = end($post_cat)->cat_name; }	
                    ?>
                    <li>
                        <a href="<?php the_permalink(); ?>">
                            <div class="imgArea">
                                <?php the_post_thumbnail('list_thumbnail'); ?>
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

                </ul>
                <?php if(function_exists("pagination")) { pagination($wp_query->max_num_pages); } ?>
                <?php wp_reset_postdata(); ?>
            </section>
            <?php get_footer(); ?>