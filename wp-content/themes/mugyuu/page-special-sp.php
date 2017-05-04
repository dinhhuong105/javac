<?php get_header(); ?>
<div id="sb-site" class="wrapper special">
    <?php breadcrumb(); ?>
    <section class="specialArea">
        <h1 class="heading">
            <span>S</span><span>P</span><span>E</span><span>C</span><span>I</span><span>A</span><span>L</span>
        </h1>
        <ul class="articleList specialList">
            <?php
                $cat = 1;
                $posts_per_page = 10;
                $val = new WP_Query([
                    'posts_per_page' => $posts_per_page,
                    'cat' => $cat,
                ]);
                $query = new WP_Query([
                    'posts_per_page' => $posts_per_page,
                    'paged' => ($paged > $val->max_num_pages) ? $val->max_num_pages : $paged,
                    'cat' => $cat,
                ]);
            ?>
            <?php
                if ($query -> have_posts()) :
                while($query -> have_posts()) : $query -> the_post(); ?>
				<?php
					$thumbnail_id = get_post_thumbnail_id();
					$image = wp_get_attachment_image_src( $thumbnail_id, 'list_thumbnail' );
				?>
            <li>
                <a href="<?php the_permalink(); ?>">
					<div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
						<img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
					</div>
                    <div class="content">
                        <p class="data"><?php the_time('Y/m/d'); ?></p>
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
        </ul>
        <?php
            if(function_exists("pagination")) {
                pagination($val->max_num_pages);
            }
        ?>
        <?php wp_reset_postdata(); ?>
    </section>
<?php get_footer(); ?>
