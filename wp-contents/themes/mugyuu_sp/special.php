
<section class="specialArea">
    <h1 class="heading">
        <span>S</span><span>P</span><span>E</span><span>C</span><span>I</span><span>A</span><span>L</span>
    </h1>
    <ul class="articleList specialList">
        <?php
            $args = array(
                'posts_per_page' => 5,
                'cat' => 1,
            );
        ?>
        <?php $special = new WP_Query($args); ?>
        <?php
            if ($special -> have_posts()) :
            while($special -> have_posts()) : $special -> the_post(); ?>

            <li>
                <a href="<?php the_permalink(); ?>">
                    <div class="imgArea">
                        <?php the_post_thumbnail('list_thumbnail'); ?>
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
    <div class="moreBtn">
        <a href="<?php echo home_url('/'); ?>special">もっと読む</a>
    </div>
</section>