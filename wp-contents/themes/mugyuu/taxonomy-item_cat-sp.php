<?php get_header(); ?>
        <div id="sb-site" class="wrapper category">
            <?php breadcrumb(); ?>
            <section class="categoryArea">
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
                <ul class="itemList">
                    <?php
    				   $args = array(
    					   'item_cat' => $taxonomySlug,
    					   'posts_per_page' => 6,
    					   'post_type' => 'item_post',
    					   'paged' => $paged,
    				   );
    				   $query = new WP_Query($args);
    			   ?>
    			   <?php
    					if ($query->have_posts()) :
    					while($query->have_posts()) : $query->the_post(); ?>
    				<?php
    					$thumbnail_id = get_post_thumbnail_id();
    					$image = wp_get_attachment_image_src( $thumbnail_id, '300_thumbnail' );
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
