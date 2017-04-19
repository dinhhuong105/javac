
<section class="articleListArea specialArea">
    <h2 class="heading">
        <span>S</span><span>P</span><span>E</span><span>C</span><span>I</span><span>A</span><span>L</span>
    </h2>
    <ul class="articleList specialList">
        <?php
            $args = array(
                'posts_per_page' => 3,
                'cat' => 1,
            );
        ?>
        <?php $special = new WP_Query($args); ?>
        <?php
            if ($special -> have_posts()) :
            while($special -> have_posts()) : $special -> the_post(); ?>
            <?php
                $thumbnail_id = get_post_thumbnail_id();
                $image = wp_get_attachment_image_src( $thumbnail_id, 'pcList_thumbnail' );
            ?>
        <li>
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
        <?php wp_reset_postdata(); ?>
    </ul>
    <div class="moreBtn">
        <a href="<?php echo home_url('/'); ?>special">もっと読む</a>
    </div>
</section>
