<?php
/*
Template Name: 動画一覧
*/
?>
<?php get_header(); ?>
<div id="sb-site" class="wrapper movie">
    <?php breadcrumb(); ?>
    <section class="movieArea">
        <h1 class="heading">
            <span>M</span><span>O</span><span>V</span><span>I</span><span>E</span>
        </h1>
        <ul class="articleList movieList">
            <?php
                $args = array(
                    'post_type' => 'movingimage_post',
                    'paged' => $paged,
                );
                $query = new WP_Query($args);
            ?>
            <?php
                if ($query -> have_posts()) :
                while($query -> have_posts()) : $query -> the_post(); ?>
            <?php 
                $post_cat = get_the_terms($post->ID, 'movingimage_cat');
                if( !empty($post_cat) ){
                    usort( $post_cat , '_usort_terms_by_ID');
                    $catName = $post_cat[0]->name;
                }else{
                    $catName = "";
                }
            ?>
            <li>
                <a href="<?php the_permalink(); ?>">
                    <div class="imgArea">
                        <?php the_post_thumbnail('movie_thumbnail'); ?>
                    </div>
                    <div class="content">
                        <div class="articleData">
                            <p class="data"><?php the_time('Y/m/d'); ?></p>
                            <p class="cat"><?php echo $catName; ?></p>
                        </div>
                        <h2><?php the_title(); ?></h2>
                        <div class="articleData">
                            
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
//                pagination($val->max_num_pages);
                pagination($query->max_num_pages);
            }
        ?>
        <?php wp_reset_postdata(); ?>
    </section>
    <?php get_footer(); ?>