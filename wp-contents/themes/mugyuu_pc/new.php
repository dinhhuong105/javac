<?php get_header(); ?>
<?php breadcrumb(); ?>
<section class="articleListArea newArea">
    <h1 class="heading">
        <span>N</span><span>E</span><span>W</span>
    </h1>
    <ul class="articleList newList">
        <?php
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 4,
                'cat' =>-1,
            );
                    ?>
        <?php $new = new WP_Query($args); ?>
        <?php if ($new -> have_posts()) :
            while($new -> have_posts()) : $new -> the_post(); ?>
        <?php
            $post_cat = get_the_category();
            usort( $post_cat , '_usort_terms_by_ID');
            $catNameGrandson = $post_cat[2]->cat_name;
            $thumbnail_id = get_post_thumbnail_id();
            $image = wp_get_attachment_image_src( $thumbnail_id, 'pcList_thumbnail' );
        ?>
            <li>
                <a href="<?php the_permalink(); ?>">
                    <div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
                        <img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
                        <div class="overlay">
                            <div class="ovWrap">
                                <i class="icon-book"></i>
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
        <?php wp_reset_postdata(); ?>
    </ul>
    <div class="moreBtn">
        <a href="<?php echo home_url('/'); ?>new">もっと読む</a>
    </div>
</section>
