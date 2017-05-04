<<<<<<< HEAD
<?php get_header(); ?>
<?php breadcrumb(); ?>
<div class="mainWrap list qa">
    <div class="mainArea">
        <section class="articleListArea qaListAreaWrap categoryArea">
            <h1 class="heading">
				質問掲示板
            </h1>
            <p class="ttl">
 				子育て奮闘中のママさん達が感じた疑問質問やお役立ち情報まで自由に語り合おう♪
            </p>
            <section class="qaListArea">
                <ul class="articleList qaList">
                    <?php
                        $query = new WP_Query([
                            'cat' =>array(-1, -281),
                            'post_type' => array('thread_post', 'question_post'),
                            'paged' => $paged,
                            'posts_per_page' => 10,
                        ]);
                    ?>
                    <?php
                        if ($query -> have_posts()) :
                        while($query -> have_posts()) : $query -> the_post(); ?>
                    <?php
                        $post_cat = get_the_category();
                        usort( $post_cat , '_usort_terms_by_ID');
                        $count = count($post_cat);
                        if($count === 3) {//カテが3
                            $catNameGrandson = $post_cat[2]->cat_name;
                        }elseif($count === 2){//カテが2
                            $catNameGrandson = $post_cat[1]->cat_name;
                        }else{
                            $catNameGrandson = $post_cat[0]->cat_name;
                        }
                        $thumbnail_id = get_post_thumbnail_id();
                        $image = wp_get_attachment_image_src( $thumbnail_id, 'pcList_thumbnail' );
                        $author = get_userdata($post->post_author);
                        $authorRoles = $author->roles;
                        usort( $authorRoles , '_usort_terms_by_ID');
                        $author_id = $post->post_author;
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
                                <div class="articleData">
                                    <p class="data"><?php the_time('Y/m/d'); ?></p>
                                    <p class="cat"><?php echo $catNameGrandson; ?></p>
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
                                        <i class="fa fa-comments" aria-hidden="true"></i>
                                        <?php echo wp_count_comments( get_the_ID() )->total_comments; ?>
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
            </section>
            <?php if (function_exists("pagination")) {
                    pagination($query->max_num_pages);
                }
            ?>
            <?php $spc_option = get_option('spc_options'); ?>
			<?php if( $spc_option['allowpost']) :?>
            <div class="btnArea">
                <a href="/add-thread">
					新規スレッドを立てる
                </a>
            </div>
            <?php endif; ?>
        </section>
    </div>
    <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
=======
<?php get_header(); ?>
<?php breadcrumb(); ?>
<div class="mainWrap list">
    <div class="mainArea">
        <section class="articleListArea newArea">
            <h1 class="heading">
                <span>N</span><span>E</span><span>W</span>
            </h1>
            <p class="ttl">
                新着一覧
            </p>
            <ul class="articleList newList">
                <?php
                    $query = new WP_Query([
                        'cat' =>array(-1, -281),
                        'post_type' => array('thread_post', 'question_post'),
                        'paged' => $paged,
                        'posts_per_page' => 10,
                    ]);
                ?>
                <?php
                    if ($query -> have_posts()) :
                    while($query -> have_posts()) : $query -> the_post(); ?>
                <?php
                    $post_cat = get_the_category();
                    usort( $post_cat , '_usort_terms_by_ID');
                    $count = count($post_cat);
                    if($count === 3) {//カテが3
                        $catNameGrandson = $post_cat[2]->cat_name;
                    }elseif($count === 2){//カテが2
                        $catNameGrandson = $post_cat[1]->cat_name;
                    }else{
                        $catNameGrandson = $post_cat[0]->cat_name;
                    }
                    $thumbnail_id = get_post_thumbnail_id();
                    $image = wp_get_attachment_image_src( $thumbnail_id, 'pcList_thumbnail' );
                    $author = get_userdata($post->post_author);
                    $authorRoles = $author->roles;
                    usort( $authorRoles , '_usort_terms_by_ID');
                    $author_id = $post->post_author;
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
                            <div class="articleData">
                                <p class="data"><?php the_time('Y/m/d'); ?></p>
                                <p class="cat"><?php echo $catNameGrandson; ?></p>
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
>>>>>>> d90299a2ce2df74863ee25d65da90af9a610ec07
