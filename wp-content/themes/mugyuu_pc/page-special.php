<?php
/*
Template Name: 特集記事一覧
*/
?>
<?php get_header(); ?>
<?php breadcrumb(); ?>
        <div class="mainWrap list">
            <div class="mainArea">
                <section class="articleListArea specialArea">
                    <h1 class="heading">
                        <span>S</span><span>P</span><span>E</span><span>C</span><span>I</span><span>A</span><span>L</span>
                    </h1>
                    <p class="ttl">
                        特集一覧
                    </p>
                    <ul class="articleList newList">
                        <?php
                            $query = new WP_Query([
                                'paged' => $paged,
                                'cat' => 1,
                            ]);
                        ?>
                        <?php
                            if ($query -> have_posts()) :
                            while($query -> have_posts()) : $query -> the_post(); ?>
                            <?php
                                $thumbnail_id = get_post_thumbnail_id();
                                $image = wp_get_attachment_image_src( $thumbnail_id, 'pcList_thumbnail' );
                                // print_r($image);
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
                    <?php if (function_exists("pagination")) {
                            pagination($query->max_num_pages);
                        }
                    ?>
                </section>
            </div>
            <?php get_sidebar(); ?>
        </div>
<?php get_footer(); ?>
