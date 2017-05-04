<?php get_header(); ?>
    <div id="sb-site" class="wrapper search">
        <?php breadcrumb(); ?>
        <section class="searchResults">
            <h1>『<?php echo the_search_query(); ?>』の検索結果</h1>
            <p class="all">
                全 <?php echo $wp_query->found_posts; ?>件
            </p>
            <ul class="articleList searchList">
                <?php
                    $args = array(
                        's' => get_search_query(),
                        'post_type' => 'post',
                        'posts_per_page' => 10,
                        'cat' =>-1,
                        'paged' => get_query_var('paged'),
                    );
                ?>
                <?php $query = new WP_Query($args); ?>
                <?php
                    if ($query -> have_posts()) :
                    while($query -> have_posts()) : $query -> the_post();
                ?>
                <?php
                    $postCat = get_the_category();
                    usort( $postCat , '_usort_terms_by_ID');
                    $postCatName = $postCat[2]->cat_name;
                    $author = get_userdata($post->post_author);
        			$authorRoles = $author->roles;
        			usort( $authorRoles , '_usort_terms_by_ID');
        			$author_id = $post->post_author;
                ?>
                <li>
                    <a href="<?php the_permalink(); ?>">
                        <div class="imgArea noImage">
                            <?php the_post_thumbnail('list_thumbnail'); ?>
                        </div>
                        <div class="content">
                            <div class="articleData">
                                <p class="data"><?php the_time('Y/m/d'); ?></p>
                                <p class="cat"><?php echo $postCatName; ?></p>
                            </div>
                            <h2><?php the_title(); ?></h2>
                            <div class="articleData">
                                <?php if($author_id !== '66') { ?>
        						<p class="name">
        							<?php
        								 if  ($authorRoles[0] == 'editor' ) {
        									 echo '<span class="icon-mugyuu"></span>';
        								 }
        							?>
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
                </li>
                <?php endwhile; else: ?>
                <li class="none">該当する記事がありません。</li>
                <?php endif; ?>
            </ul>
            <?php if (function_exists("pagination")) {
                    pagination($query->max_num_pages);
                }
            ?>
            <?php wp_reset_postdata(); ?>
        </section>
    <?php get_footer(); ?>
