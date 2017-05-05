<?php get_header(); ?>
    <div id="sb-site" class="wrapper">
        <div class="slideArea">
            <div class="slider">
                <?php
                    $args = array(
                        'posts_per_page' => 5,
//                        'cat' => 1,特集記事書き出したら
                        'orderby' => 'rand',
                    );
                ?>
                <?php $special = new WP_Query($args); ?>
                <?php
                    if ($special -> have_posts()) :
                    while($special -> have_posts()) : $special -> the_post(); ?>
                <?php
                    $post_cat = get_the_category();
                    usort( $post_cat , '_usort_terms_by_ID');
                    // $catNameGrandson = $post_cat[2]->cat_name;
					$thumbnail_id = get_post_thumbnail_id();
                    $image = wp_get_attachment_image_src( $thumbnail_id, '900_thumbnail' );
                ?>
                <div class="slideContent">
                    <a href="<?php the_permalink(); ?>">
						<div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
                            <img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
                        </div>
                        <p class="title"><?php the_title(); ?></p>
                    </a>
                </div>
                <?php endwhile; else: ?>
                <li class="none">該当する記事がありません。</li>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
        <?php get_template_part('new'); ?>
        <?php //get_template_part('special'); ?>
        <?php get_template_part('ranking'); ?>
        <?php get_template_part('recipe'); ?>
        <?php get_template_part('movie'); ?>
<?php get_footer(); ?>
