
<section class="movieArea">
    <h2 class="heading">
        <span>R</span><span>E</span><span>C</span><span>I</span><span>P</span><span>E</span>
    </h2>
    <ul class="recipeList">
        <?php
            $args = array(
                'posts_per_page' => 6,
                'post_type' => array('movingimage_post', 'thread_post', 'question_post'),
            );
        ?>
        <?php $movie = new WP_Query($args); ?>
        <?php
            if ($movie->have_posts()) :
            while($movie->have_posts()) : $movie->the_post(); ?>
        <?php
            //$post_cat = get_the_terms($post->ID, 'movingimage_cat');
			$thumbnail_id = get_post_thumbnail_id();
            $image = wp_get_attachment_image_src( $thumbnail_id, '300_thumbnail' );
            /*if( !empty($post_cat) ){
                usort( $post_cat , '_usort_terms_by_ID');
                $catName = $post_cat[1]->name;
            }else{
                $catName = "";
            }*/
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
    </ul>
    <div class="moreBtn">
        <a href="<?php echo home_url('/'); ?>recipe-list">もっと読む</a>
    </div>
</section>
