<?php get_header(); ?>
        <div id="sb-site" class="wrapper category">
            <?php breadcrumb(); ?>
            <section class="categoryArea movie">
                <?php
                    $cat = get_queried_object();
                    $catName = $cat->name;
                    $catDiscription = $cat->description;
                    $catCount = $cat->count;
                    $catId = $cat->term_ID;
                    $taxonomySlug = $cat->slug;
                ?>
                <h1><?php echo $catName; ?></h1>
                <p class="detail">
                    <?php echo $catDiscription; ?>
                </p>
                <p class="all">
                    全<?php echo $catCount; ?>件
                </p>
                <ul class="articleList movieList">
                    <?php
    				   $args = array(
    					   'movie_cat' => $taxonomySlug,
    					   'posts_per_page' => 10,
    					   'post_type' => 'movie_post',
    					   'paged' => $paged,
    				   );
    				   $query = new WP_Query($args);
    			   ?>
                   <?php
                       if ($query->have_posts()) :
                       while($query->have_posts()) : $query->the_post(); ?>
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
                </ul>
                <?php if (function_exists("pagination")) {
                        pagination($query->max_num_pages);
                    }
                ?>
                <?php wp_reset_postdata(); ?>
            </section>
    <?php get_footer(); ?>
