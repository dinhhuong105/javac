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
                    ?>
                    <?php
                        if (have_posts()) :
                        while(have_posts()) : the_post(); ?>
                        <li>
                            <a href="<?php the_permalink(); ?>">
                               <div class="imgArea">
                                   <?php the_post_thumbnail('movie_thumbnail'); ?>
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
                        pagination($wp_query->max_num_pages);
                    }
                ?>
                <?php wp_reset_postdata(); ?>
            </section>
    <?php get_footer(); ?>
