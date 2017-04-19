<?php get_header(); ?>
    <div id="sb-site" class="wrapper">
        <div class="slideArea">
            <ul class="slider">
                <?php
                    $args = array(
                        'posts_per_page' => 5,
//                        'cat' => 1,特集記事書き出したら
                        'orderby' => 'rand',
                    );
                ?>
                <?php $special = new WP_Query($args); ?>
                <?php
                    if ($special -> have_posts()) :
                    while($special -> have_posts()) : $special -> the_post(); ?>
                <?php
                    $post_cat = get_the_category();
                    usort( $post_cat , '_usort_terms_by_ID');
                    $catNameGrandson = $post_cat[2]->cat_name;
                    $thumbnail_id = get_post_thumbnail_id();
//                    $image = wp_get_attachment_image_src( $thumbnail_id, 'medium' );
                ?>
                <li>
                    <a href="<?php the_permalink(); ?>">
                        <div class="imgArea" style="background-image: url(<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>)">
                            <img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
                       </div>
                        <p class="title"><?php the_title(); ?></p>
                    </a>
                </li>
                <?php endwhile; else: ?>
                <li class="none">該当する記事がありません。</li>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>
            </ul>
        </div>
        <section class="newArea">
            <h1 class="heading">
                <span>N</span><span>E</span><span>W</span>
            </h1>
            <ul class="articleList newList">
                <?php
                    $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 5,
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
                <li class="none">該当する記事がありません。</li>
                <?php endif; ?>
            </ul>
            <div class="moreBtn">
                <a href="<?php echo home_url('/'); ?>new">もっと読む</a>
            </div>
        </section>
        <?php get_template_part('special'); ?>
        <?php get_template_part('ranking'); ?>
        <?php get_template_part('movie'); ?>
        <?php get_template_part('movie-ranking'); ?>
        <section class="topCat">
            <section class="childArea">
                <h2 class="bigCat">
                    <span class="icon icon-baby"></span>こどものこと
                    <i class="icon fa fa-chevron-down" aria-hidden="true"></i>
                </h2>
                <ul class="catList">
                    <li>
                        教育
                        <ul class="grandsonCatList">
                            <li><a href="<?php echo home_url('/'); ?>kodomo-yomikikase">読み聞かせ</a></li>
                        </ul>
                    </li>
                    <li>
                        肌
                        <ul class="grandsonCatList">
                            <li><a href="<?php echo home_url('/'); ?>akachan-asemo">あせも</a></li>
                        </ul>
                    </li>
                    <li>
                        育児
                        <ul class="grandsonCatList">
                            <li><a href="<?php echo home_url('/'); ?>akachan-haihai">はいはい</a></li>
                        </ul>
                    </li>
                </ul>
            </section>
            <section class="mamaArea">
                <h2 class="bigCat">
                    <span class="icon icon-mama"></span>ママのこと
                    <i class="icon fa fa-chevron-down" aria-hidden="true"></i>
                </h2>
                <ul class="catList">
                    <li>
                        病気
                        <ul class="grandsonCatList">
                            <li><a href="<?php echo home_url('/'); ?>category/child/sick/benpi">便秘</a></li>
                        </ul>
                    </li>
                    <li>
                        病気
                        <ul class="grandsonCatList">
                            <li><a href="<?php echo home_url('/'); ?>category/child/sick/benpi">便秘</a></li>
                        </ul>
                    </li>
                </ul>
            </section>
            <section class="ageArea">
                <h2 class="bigCat">
                    <i class="icon fa fa-heart-o" aria-hidden="true"></i>年齢のこと
                    <i class="icon fa fa-chevron-down" aria-hidden="true"></i>
                </h2>
                <ul class="catList">
                    <li>
                        <a href="<?php echo home_url('/'); ?>category/age/0yearold">
                            0歳
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo home_url('/'); ?>category/age/1-3yearold">
                            1歳〜3歳
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo home_url('/'); ?>category/age/4-6yearold">
                            4歳〜6歳
                        </a>
                    </li>
                </ul>
            </section>
            <section class="movieArea">
                <h2 class="bigCat">
                    <span class="icon icon-play"></span>MUGYUU!動画
                    <i class="icon fa fa-chevron-down" aria-hidden="true"></i>
                </h2>
                <ul class="catList">
                    <li>
                        <a href="">
                            カテゴリ
                        </a>
                    </li>
                    <li>
                        <a href="">
                            カテゴリ
                        </a>
                    </li>
                </ul>
            </section>
            <!-- <section class="qaArea">
                <h2 class="bigCat">
                    <a href="<?php /*echo home_url('/');*/ ?>questionary/">
                        <i class="icon fa fa-pencil-square-o" aria-hidden="true"></i>
                        質問掲示板
                    </a>
                </h2>
            </section> -->
            <section class="itemArea">
                <h2 class="bigCat">
                    <a href="<?php echo home_url('/'); ?>item-search">
                        <i class="icon fa fa-shopping-cart" aria-hidden="true"></i>
                        商品を探す
                    </a>
                </h2>
            </section>
            <?php get_search_form(); ?>
        </section>
<?php get_footer(); ?>
