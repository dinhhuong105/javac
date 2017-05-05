<?php get_header(); ?>
<div id="sb-site" class="wrapper movie">
    <?php breadcrumb(); ?>
    <section class="movieArea">
        <h1 class="heading">
            <span>R</span><span>E</span><span>C</span><span>I</span><span>P</span><span>E</span>
        </h1>
        <ul class="articleList recipeList">
            <?php
                $args = array(
                    'posts_per_page' => 10,
                    'post_type' => array('movingimage_post', 'thread_post', 'question_post'),
                    'paged' => $paged,
                );
            ?>
            <?php $query = new WP_Query($args); ?>
            <?php
                if ($query->have_posts()) :
                while($query->have_posts()) : $query->the_post(); ?>
            <?php
                //$post_cat = get_the_terms($post->ID, 'movingimage_cat');
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
        </ul>
        <?php
            if(function_exists("pagination")) {
                pagination($query->max_num_pages);
            }
        ?>
    </section>
    <?php get_footer(); ?>
