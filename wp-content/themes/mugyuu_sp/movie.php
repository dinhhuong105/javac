
<section class="movieArea">
    <h1 class="heading">
        <span>M</span><span>O</span><span>V</span><span>I</span><span>E</span>
    </h1>
    <ul class="movieList">
        <?php
            $args = array(
                'posts_per_page' => 6,
                'post_type' => 'movingimage_post',
            );
        ?>
        <?php $movie = new WP_Query($args); ?>
        <?php
            if ($movie->have_posts()) :
            while($movie->have_posts()) : $movie->the_post(); ?>
        <?php 
            $post_cat = get_the_terms($post->ID, 'movingimage_cat');
            if( !empty($post_cat) ){
                usort( $post_cat , '_usort_terms_by_ID');
                $catName = $post_cat[1]->name;
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
        <li class="none">該当する記事がありません。</li>
        <?php endif; ?>
    </ul>
    <div class="moreBtn">
        <a href="<?php echo home_url('/'); ?>movie-list">もっと読む</a>
    </div>
</section>