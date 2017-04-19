<?php
/*
Template Name: 新着一覧
*/
?>
       <?php get_header(); ?>
        <div id="sb-site" class="wrapper new">
            <?php breadcrumb(); ?>
            <section class="newArea">
                <h1 class="heading">
                    <span>N</span><span>E</span><span>W</span>
                </h1>
                <ul class="articleList newList">
                    <?php
                        $posts_per_page = 10;
                        $val = new WP_Query([
                            'posts_per_page' => $posts_per_page,
                        ]);
                        $query = new WP_Query([
                            'cat' =>-1,
                            'post_type' => 'post',
                            'posts_per_page' => $posts_per_page,
                            'paged' => ($paged > $val->max_num_pages) ? $val->max_num_pages : $paged,
                        ]);
                    ?>
                    <?php
                        if ($query -> have_posts()) :
                        while($query -> have_posts()) : $query -> the_post(); ?>
                        <?php 
                            $post_cat = get_the_category();
                                usort( $post_cat , '_usort_terms_by_ID');
                            $catNameGrandson = $post_cat[2]->cat_name;
                        ?>
                    <li>
                        <a href="<?php the_permalink(); ?>">
                            <div class="imgArea">
                                <?php the_post_thumbnail('list_thumbnail'); ?>
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
                    <p class="none">該当する記事がありません。</p>
                    <?php endif; ?>
                </ul>
                <?php
                    if(function_exists("pagination")) {
                        pagination($val->max_num_pages);
                    }
                ?>
                <?php wp_reset_postdata(); ?>
            </section>
    <?php get_footer(); ?>