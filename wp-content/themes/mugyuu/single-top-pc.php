<?php get_header(); ?>
<?php breadcrumb(); ?>
<div class="mainWrap single top">
    <div class="mainArea">
        <section class="postArea">
            <?php
                $postCat = get_the_category();
                usort( $postCat , '_usort_terms_by_ID');
                $catId = $postCat[0]->cat_ID;
                $author_id = $post->post_author;
                $author = get_userdata($post->post_author);
                $thumbnail_id = get_post_thumbnail_id();
                $image = wp_get_attachment_image_src( $thumbnail_id, '900_thumbnail' );
                $childCat = '';
                $catNameGrandson = '';
                $catIdGrandson = '';
                $count = count($postCat);
                // if($catId !== 1) {
                if($count === 3) {//カテが3
                    $childCat = $postCat[1]->cat_name;
                    $catNameGrandson = $postCat[2]->cat_name;
                    $catIdGrandson = $postCat[2]->cat_ID;
                }elseif($count === 2){//カテが2
                    $catNameGrandson = $postCat[1]->cat_name;
                    $catIdGrandson = $postCat[1]->cat_ID;
                }else{
                    $catNameGrandson = $postCat[0]->cat_name;
                    $catIdGrandson = $postCat[0]->cat_ID;
                }
                $author_id = $post->post_author;
                $author = get_userdata($post->post_author);
                $userLebel = $author -> roles;
                usort( $userLebel , '_usort_terms_by_ID');
                $slug_name = $post->post_name;
            ?>
            <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
            <h1 class="topheading">
                <?php the_title(); ?>
            </h1>

            <div class="contentArea">
                <?php the_content(); ?>
            </div>
            <?php endwhile; ?>
            <?php else : ?>
            <p class="none">記事が見つかりませんでした。</p>
            <?php endif; ?>
        </section>
    </div>
    <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
