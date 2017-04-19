<?php get_header(); ?>
<?php
$author_id = $post->post_author;
$author = get_userdata($post->post_author);
?>
<div id="sb-site" class="wrapper single movie">
    <?php breadcrumb(); ?>
    <article class="singleArea">
        <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
        <?php
            $movie_cat = get_the_terms($post->ID, 'movie_cat');
          if( is_array($movie_cat) ){
               usort( $movie_cat , '_usort_terms_by_ID');
               $catName = current($movie_cat)->name;
          }
            $author_id = $post->post_author;
            $author = get_userdata($post->post_author);
            $userLebel = $author->roles;
            usort( $userLebel , '_usort_terms_by_ID');
        ?>
        <div class="dataArea">
            <p class="data"><?php the_time('Y/m/d'); ?></p>
            <p class="pv">
                <i class="fa fa-heart" aria-hidden="true"></i>
                <?php
                    if ( function_exists ( 'wpp_get_views' ) ) {
                        echo wpp_get_views ( get_the_ID() ); }
                ?>
            </p>
        </div>
        <h1>
            <?php the_title(); ?>
        </h1>
        <div class="fbMovie">
            <?php echo( get_post_meta($post->ID, 'movie', true) ); ?>
        </div>
        <?php get_template_part('single-sns'); ?>
        <div class="content">
            <?php the_content(); ?>
        </div>
        <?php get_template_part('single-sns'); ?>
        <div class="writerArea">
            <a href="<?php echo home_url('/'); ?>author/<?php echo $author->user_nicename; ?>?uID=<?php echo $author->ID; ?>&uNAME=<?php echo $author->display_name; ?>&tab=movie">
                <?php
                    if  ($userLebel[0] == 'editor' ) {
                        echo '<div class="imgArea editor">';
                    } else {
                        echo '<div class="imgArea">';
                    }
                ?>
                <?php echo get_avatar($author_id); ?>
                </div>
            <div class="dataArea">
                <p class="name">
                    <?php
                         if  ($userLebel[0] == 'movie-editor' ) {
                             echo '<span class="icon-mugyuu"></span>';
                         }
                    ?>
                    <?php echo $author->display_name; ?>
                </p>
                <p class="type">
                    <?php the_author_meta('skill'); ?>
                </p>
                <p class="profile">
                    <?php the_author_meta('user_description'); ?>
                </p>
            </div>
            </a>
        </div>
    <?php endwhile; ?>
    <?php else : ?>
    <p class="none">記事が見つかりませんでした。</p>
    <?php endif; ?>
    </article>
    <?php get_template_part('related-entries'); ?>
    <section class="rankingArea movie">
        <h1 class="heading">
            <span>M</span><span>O</span><span>V</span><span>I</span><span>E</span><br><span>R</span><span>A</span><span>N</span><span>K</span><span>I</span><span>N</span><span>G</span>
        </h1>
        <div class="tabs">
            <ul class="tabMenuList horizontal">
                <li id="tab-1" data-tab-content="content-tab-1">本日</li>
                <li id="tab-2" data-tab-content="content-tab-2" class="active">週間</li>
                <li id="tab-3" data-tab-content="content-tab-3">月間</li>
            </ul>
            <div class="tabContentArea">
                <div id="content-tab-1" class="tabContent">
                    <ul class="movieList">
                        <?php if (function_exists('wpp_get_mostpopular')): ?>
                        <?php
                            $args = array(
                                'limit' => 6,
                                'range' => 'daily',
                                'order_by' => 'views',
                                'post_type' => 'movie_post',
                                'stats_views' => 1,
                                'stats_date' => 1,
                                'stats_date_format' => 'Y/m/d',
                                'stats_category' => 1,
                                'stats_author' => 1,
                            );
                            // 関数の実行
                            wpp_get_mostpopular($args);
                        ?>
                        <?php else: ?>
                        <li class="none">該当する記事がありません。</li>
                        <?php endif; ?>
                        <?php wp_reset_query(); ?>
                    </ul>
                </div>
                <div id="content-tab-2" class="tabContent tabSelected">
                    <ul class="movieList">
                        <?php if (function_exists('wpp_get_mostpopular')): ?>
                        <?php
                            $args = array(
                                'limit' => 6,
                                'range' => 'weekly',
                                'order_by' => 'views',
                                'post_type' => 'movie_post',
                                'stats_views' => 1,
                                'stats_date' => 1,
                                'stats_date_format' => 'Y/m/d',
                                'stats_category' => 1,
                                'stats_author' => 1,
                            );
                            wpp_get_mostpopular($args);
                        ?>
                        <?php else: ?>
                            <li class="none">該当する記事がありません。</li>
                        <?php endif; ?>
                        <?php wp_reset_query(); ?>
                    </ul>
                </div>
                <div id="content-tab-3" class="tabContent">
                    <ul class="movieList">
                        <?php if (function_exists('wpp_get_mostpopular')): ?>
                        <?php
                            $args = array(
                                'limit' => 6,
                                'range' => 'monthly',
                                'order_by' => 'views',
                                'post_type' => 'movie_post',
                                'stats_views' => 1,
                                'stats_date' => 1,
                                'stats_date_format' => 'Y/m/d',
                                'stats_category' => 1,
                                'stats_author' => 1,
                            );
                            wpp_get_mostpopular($args);
                        ?>
                        <?php else: ?>
                        <li class="none">該当する記事がありません。</li>
                        <?php endif; ?>
                        <?php wp_reset_query(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
<?php get_footer(); ?>
