<?php get_header(); ?>
        <div class="mainWrap">
            <section class="slideArea slider">
                <?php
                    $args = array(
                        'posts_per_page' => 5,
//                        'cat' => 1,特集記事書き出したら
                        'orderby' => 'rand',
                    );
                ?>
                <?php $slidePost = new WP_Query($args); ?>
                <?php
                    if ($slidePost -> have_posts()) :
                    while($slidePost -> have_posts()) : $slidePost -> the_post(); ?>
                <?php
                    $post_cat = get_the_category();
                    usort( $post_cat , '_usort_terms_by_ID');
//                    $catNameGrandson = $post_cat[2]->cat_name;
                    $thumbnail_id = get_post_thumbnail_id();
                    $image = wp_get_attachment_image_src( $thumbnail_id, '900_thumbnail' );
                    // $image = wp_get_attachment_url( get_post_thumbnail_id() );
                ?>
                <div class="article">
                    <a href="<?php the_permalink(); ?>">
                        <div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
                            <img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
                        </div>
                        <h2 class="title"><?php the_title(); ?></h2>
                    </a>
                </div>
                <?php endwhile; else: ?>
                <div class="none">該当する記事がありません。</div>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>
            </section>
            <?php get_template_part('special'); ?>
            <div class="mainArea">
                <?php get_template_part('ranking'); ?>
                <?php get_template_part('new'); ?>
                <?php get_template_part('movie'); ?>
            </div>
            <?php get_sidebar(); ?>
        </div>
        <div class="topCatArea">
            <div class="topCatWrap">
                <div class="catContentWrap">
                    <div class="catIcon childCat" data-catName="cat-child"><span class="icon icon-baby child"></span></div>
                    <div class="catIcon mamaCat" data-catName="cat-mama"><span class="icon icon-mama mama"></span></div>
                    <div class="catIcon ageCat" data-catName="cat-age"><i class="icon fa fa-heart age" aria-hidden="true"></i></div>
                </div>
                <section class="catContent">
                    <div class="listWrap">
                        <ul class="catList" id="cat-child">
                            <li>
                                <h3>教育</h3>
                                <ul class="grandsonCatList">
                                    <li><a href="<?php echo home_url('/'); ?>kodomo-yomikikase">読み聞かせ</a></li>
                                </ul>
                            </li>
                            <li>
                                <h3>肌</h3>
                                <ul class="grandsonCatList">
                                    <li><a href="<?php echo home_url('/'); ?>akachan-asemo">あせも</a></li>
                                </ul>
                            </li>
                            <li>
                                <h3>育児</h3>
                                <ul class="grandsonCatList">
                                    <li><a href="<?php echo home_url('/'); ?>akachan-haihai">はいはい</a></li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="catList" id="cat-mama">
                            <li>
                                該当の記事がありません。
                            </li>
                        </ul>
                        <ul class="catList" id="cat-age">
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
                    </div>
                </section>
            </div>
        </div>
<?php get_footer(); ?>
