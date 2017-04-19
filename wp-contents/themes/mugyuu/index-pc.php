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
                    $thumbnail_id = get_post_thumbnail_id();
                    $image = wp_get_attachment_image_src( $thumbnail_id, '900_thumbnail' );
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
            <?php //get_template_part('special'); ?>
            <div class="mainArea">
                <?php get_template_part('new'); ?>
                <?php get_template_part('ranking'); ?>
            </div>
            <?php get_sidebar(); ?>
        </div>
        <?php get_template_part('recipe'); ?>
        <?php get_template_part('movie'); ?>
        <div class="topCatArea">
            <div class="topCatWrap">
                <div class="catContentWrap">
                    <div class="catIcon childCat" data-catName="cat-child"><span class="icon icon-baby child"></span></div>
                    <div class="catIcon mamaCat" data-catName="cat-mama"><span class="icon icon-mama mama"></span></div>
                    <div class="catIcon ageCat" data-catName="cat-age"><i class="icon fa fa-heart age" aria-hidden="true"></i></div>
                    <div class="catIcon movieCat" data-catName="cat-movie"><i class="icon fa fa-video-camera movie" aria-hidden="true"></i></div>
                    <div class="catIcon recipeCat" data-catName="cat-recipe"><span class="icon icon-recipe recipe"></span></div>
                </div>
                <section class="catContent">
                    <div class="listWrap">
                        <ul class="catList" id="cat-child">
                            <?php
                                $args = array(
                                    'post_type' => 'post',
                                    'parent' => 2, //こどものこと
                                    'hide_empty' => 1,
                                );
                                $cats = get_categories($args);
                            ?>
                            <?php foreach ($cats as $cat) { ?>
                            <?php
                                $slug = $cat->slug;
                             ?>
                                <?php if($slug !== 'episode'){ //エピソード以外 ?>
                                    <li>
                                        <?php
                                            $cat_ID = $cat->cat_ID;
                                            $postargs = array(
                                                'category' => $cat_ID,
                                                // 'meta_value' => 'on',
                                            );
                                            $on_posts = get_posts($postargs);
                                            foreach ($on_posts as $on_post) {
                                                $on_post_cat = get_the_category($on_post);
                                                    usort($on_post_cat,'_usort_terms_by_ID');
                                                $cat_id = $on_post_cat[1]->cat_ID;
                                                $postid = $on_post->ID;
                                                // $meta = get_post_meta( $postid, '_myplg_toppage' ,true);
                                            }
                                        ?>
                                        <h3><?php echo $cat->name; ?></h3>
                                        <ul class="grandsonCatList">
                                             <?php
                                                 $cat_children_args = array(
                                                     'parent' => $cat->cat_ID,
                                                     'post_type' => 'post',
                                                     'hide_empty' => 1,
                                                 );
                                                 $cat_children = get_categories($cat_children_args);
                                                 ?>
                                            <?php foreach ($cat_children as $cat_child) { ?>
                                                <?php
                                                    $cat_child_id = $cat_child->cat_ID;
                                                    $args = array(
                                                        'category' => $cat_child_id,
                                                        'hide_empty' => 1,
                                                        'posts_per_page' => 1,
                                                        'meta_value' => 'on',
                                                    );
                                                    $cat_posts = get_posts($args);
                                                ?>
                                                <?php foreach ($cat_posts as $cat_post) { ?>
                                                    <?php
                                                        $postid = $cat_post->ID;
                                                        // $meta = get_post_meta($postid , '_myplg_toppage' ,true);
                                                        $cats = get_the_category($cat_post);
                                                            usort($cats, '_usort_terms_by_ID');
                                                        $cat_id = $cats[2]->cat_ID;
                                                        $cat_name = $cats[2]->name;
                                                        // $link = $cat_post->guid;
                                                        $post_name = $cat_post->post_name;
                                                     ?>
                                                        <?php if($cat_id === $cat_child_id ) { ?>
                                                            <li>
                                                                <a href="<?php echo home_url('/').$post_name; ?>"><?php echo $cat_name; ?> </a>
                                                            </li>
                                                        <?php } ?>
                                                 <?php } ?>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                        <ul class="catList" id="cat-mama">
                            <?php
                                $args = array(
                                    'post_type' => 'post',
                                    'parent' => 3, //ママのこと
                                    'hide_empty' => 1,
                                );
                                $cats = get_categories($args);
                            ?>
                            <?php foreach ($cats as $cat) { ?>
                                <li>
                                    <h3><?php echo $cat->name; ?></h3>
                                    <ul class="grandsonCatList">
                                         <?php
                                             $cat_children_args = array(
                                                 'parent' => $cat->cat_ID,
                                                 'post_type' => 'post',
                                                 'hide_empty' => 1,
                                             );
                                             $cat_children = get_categories($cat_children_args);
                                        ?>
                                        <?php foreach ($cat_children as $cat_child) { ?>
                                            <?php
                                                $cat_child_id = $cat_child->cat_ID;
                                                $args = array(
                                                    'category' => $cat_child_id,
                                                    'hide_empty' => 1,
                                                    'posts_per_page' => 1,
                                                    'meta_value' => 'on',
                                                );
                                                $cat_posts = get_posts($args);
                                            ?>
                                            <?php foreach ($cat_posts as $cat_post) { ?>
                                                <?php
                                                    $postid = $cat_post->ID;
                                                    // $meta = get_post_meta($postid , '_myplg_toppage' ,true);
                                                    $cats = get_the_category($cat_post);
                                                        usort($cats, '_usort_terms_by_ID');
                                                    $cat_id = $cats[2]->cat_ID;
                                                    $cat_name = $cats[2]->name;
                                                    // $link = $cat_post->guid;
                                                    $post_name = $cat_post->post_name;
                                                 ?>
                                                <?php if($cat_id === $cat_child_id) { ?>
                                                    <li>
                                                        <a href="<?php echo home_url('/').$post_name; ?>"><?php echo $cat_name; ?></a>
                                                    </li>
                                                <?php } ?>
                                             <?php } ?>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php } ?>
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
                        <ul class="catList" id="cat-recipe">
                            <?php
                                $args = array(
                                    'post_type' => 'movingimage_post',
                                    'taxonomy' => 'movingimage_cat',
                                    'parent' => 0,
                                    'hide_empty' => 1,
                                );
                                $cats = get_categories($args);
                            ?>
                            <?php foreach ($cats as $cat ) { ?>
                                <li>
                                    <h3><?php echo $cat->name;?></h3>
                                    <?php
                                        $child_cat_num = get_term_children($cat->cat_ID,'category');
                                        $child_count = count($child_cat_num);
                                        if($child_cat_num > 0) {
                                     ?>
                                    <ul class="grandsonCatList">
                                        <?php
                                            $cat_children_args = array(
                                                'parent' => $cat->cat_ID,
                                                'post_type' => 'movingimage_post',
                                                'taxonomy' => 'movingimage_cat',
                                            );
                                            $cat_children = get_categories($cat_children_args);
                                            foreach ($cat_children as $cat_child) {
                                                $cat_link = get_category_link($cat_child->cat_ID);
                                        ?>
                                            <li>
                                                <a href="<?php echo $cat_link; ?>"><?php echo $cat_child->name;?></a>
                                            </li>
                                            <?php } ?>
                                    </ul>
                                <?php } ?>
                                </li>
                            <?php } ?>
                        </ul>
                        <ul class="catList" id="cat-movie">
                            <?php
                                $args = array(
                                    'post_type' => 'movie_post',
                                    'taxonomy' => 'movie_cat',
                                    'parent' => 0,
                                    'hide_empty' => 1,
                                );
                                $cats = get_categories($args);
                            ?>
                            <?php foreach ($cats as $cat ) { ?>
                                <li>
                                    <h3><?php echo $cat->name;?></h3>
                                    <?php
                                        $child_cat_num = get_term_children($cat->cat_ID,'category');
                                        $child_count = count($child_cat_num);
                                        if($child_cat_num > 0) {
                                     ?>
                                    <ul class="grandsonCatList">
                                        <?php
                                            $cat_children_args = array(
                                                'parent' => $cat->cat_ID,
                                                'post_type' => 'movie_post',
                                                'taxonomy' => 'movie_cat',
                                            );
                                            $cat_children = get_categories($cat_children_args);
                                            foreach ($cat_children as $cat_child) {
                                                $cat_link = get_category_link($cat_child->cat_ID);
                                        ?>
                                            <li>
                                                <a href="<?php echo $cat_link; ?>"><?php echo $cat_child->name;?></a>
                                            </li>
                                            <?php } ?>
                                    </ul>
                                <?php } ?>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </section>
            </div>
        </div>
<?php get_footer(); ?>
