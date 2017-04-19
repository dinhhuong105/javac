
<section class="articleListArea recipeArea top">
    <h2 class="heading">
        <span>R</span><span>E</span><span>C</span><span>I</span><span>P</span><span>E</span>
    </h2>
    <ul class="recipeList">
        <?php
            $args = array(
                'posts_per_page' => 8,
                'post_type' => 'movingimage_post',
            );
        ?>
        <?php $movie = new WP_Query($args); ?>
        <?php
            if ($movie->have_posts()) :
            while($movie->have_posts()) : $movie->the_post(); ?>
        <?php
            $post_cat = get_the_terms($post->ID, 'movingimage_cat');
            usort( $post_cat , '_usort_terms_by_ID');
            $catName = $post_cat[1]->name;
            $thumbnail_id = get_post_thumbnail_id();
            $image = wp_get_attachment_image_src( $thumbnail_id, '320_thumbnail' );
        ?>
        <li>
            <a href="<?php the_permalink(); ?>">
                <div class="content">
                    <div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
                        <img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
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
    <div class="moreBtn">
        <a href="<?php echo home_url('/'); ?>recipe-list">もっと読む</a>
    </div>
</section>
