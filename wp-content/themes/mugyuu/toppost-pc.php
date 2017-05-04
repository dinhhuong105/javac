<?php
    $postCat = get_the_category();
    usort( $postCat , '_usort_terms_by_ID');
    $post_id = $post->ID;
    $meta = get_post_meta($post_id);
    $topmeta = $meta['_myplg_toppage'][0];
    $catNameGrandson = '';
    $catIdGrandson = '';
    $cat_count = count($postCat);
    $author_id = $post->post_author;
    if($cat_count === 3) {//カテが3
        $childCat = $postCat[1]->cat_name;
        $catNameGrandson = $postCat[2]->cat_name;
        $catIdGrandson = $postCat[2]->cat_ID;
    }
    $args = array(
        'post_type' => 'post',
        'meta_value' => 'on',
        'cat' => $catIdGrandson,
        'posts_per_page' => 1,
    );
    $query = new WP_Query($args);
?>
<?php if($cat_count === 3 && $topmeta === 'off') { ?>
    <?php if( $query -> have_posts() ): ?>
    <?php while ($query -> have_posts()) : $query -> the_post(); ?>
    <?php
        $thumbnail_id = get_post_thumbnail_id();
        $image = wp_get_attachment_image_src( $thumbnail_id, 'pcList_thumbnail' );
    ?>
        <section class="topPostArea">
            <h2 class="topheading">
                <span>\\  『<?php echo $catNameGrandson; ?>』の全てがわかるまとめ記事  //</span>
            </h2>
            <div class="post">
                <a href="<?php the_permalink(); ?>">
                    <div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
                        <img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
                        <div class="overlay">
                            <div class="ovWrap">
                                <i class="icon-book2"></i>
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
                            <?php if($author_id !== '66') { ?>
                            <p class="name">
                                <?php the_author(); ?>
                            </p>
                            <?php } ?>
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
            </div>
        </section>
    <?php endwhile; else: ?>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
<?php } ?>
