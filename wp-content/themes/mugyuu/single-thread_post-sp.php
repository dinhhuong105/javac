<?php get_header(); ?>
       <?php
            $postCat = get_the_category();
            usort( $postCat , '_usort_terms_by_ID');
            $catId = $postCat[0]->cat_ID;
            $author_id = $post->post_author;
            $author = get_userdata($post->post_author);
        ?>
        <div id="sb-site" class="wrapper single qaSingle">
            <?php breadcrumb(); ?>
            <article class="singleArea qaSingleArea">
                <section>
                    <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                    <?php
                        $postCat = get_the_category();
                        usort( $postCat , '_usort_terms_by_ID');
                        $catId = $postCat[0]->cat_ID;
                        $parentCat = $postCat[0]->cat_name;
                        $childCat = '';
                        $catNameGrandson = '';
                        $catIdGrandson = '';
                        $count = count($postCat);
                        if($count === 3) {//カテが3
                            $childCat = $postCat[1]->cat_name;
                            $catNameGrandson = $postCat[2]->cat_name;
                            $catIdGrandson = $postCat[2]->cat_ID;
                        }elseif($count === 2){//カテが2
                            $catNameGrandson = $postCat[1]->cat_name;
                            $catIdGrandson = $postCat[1]->cat_ID;
                        }else{
                            $catNameGrandson = $postCat[0]->cat_name;
                            $catIdGrandson = $postCat[0]->cat_ID;
                        }
                        $author_id = $post->post_author;
                        $author = get_userdata($post->post_author);
                        $userLebel = $author -> roles;
                        usort( $userLebel , '_usort_terms_by_ID');
                        $slug_name = $post->post_name;
                        $thumbnail_id = get_post_thumbnail_id();
                        $image = wp_get_attachment_image_src( $thumbnail_id, 'medium' );
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
                    <div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
                        <img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
                    </div>
                    <div class="content">
                        <?php the_content(); ?>
                        <div class="articleData">
                            <p class="commentCount"><i class="fa fa-comments" aria-hidden="true"></i><?php echo wp_count_comments( get_the_ID() )->total_comments; ?></p>
                        </div>
                        <div class="buttonReport">
                    		<div class="report modal">
                                <input id="modal-trigger-thread" type="checkbox">
                                <label for="modal-trigger-thread">
                                	<?php 
                                	   $GLOBALS['comment'] = null;
                                	   wprc_report_submission_form();
                                	?>
                                </label>
                                <div class="modal-overlay">
                                    <div class="modal-wrap">
                                        <label for="modal-trigger-thread">✖</label>
                                        <h3>このスレッドを通報</h3>
                                        <p>このスレッドを不適切な内容として通報しますか？</p>
                                        <div class="btnArea">
                                            <button type="button" class="reportBtn">通報
                                            </button>
                                            <button type="button" class="cancelBtn">やめる
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    	</div>
                    </div>
                    <br>
                    <div class="btnArea">
                        <a href="#send">コメントする
                        </a>
                	</div>
                    <?php endwhile; ?>
                    <?php else : ?>
                    <p class="none">記事が見つかりませんでした。</p>
                    <?php endif; ?>
                </section>
            </article>
            <?php comments_template('/notice_comments.php'); ?>
            <?php get_template_part('toppost'); ?>
            <?php get_template_part('related-entries'); ?>
            <section class="rankingArea">
                <h1 class="heading">
                    <span>R</span><span>A</span><span>N</span><span>K</span><span>I</span><span>N</span><span>G</span>
                </h1>
                <div class="tabs">
                    <ul class="tabMenuList horizontal">
                        <li id="tab-1" data-tab-content="content-tab-1">本日</li>
                        <li id="tab-2" data-tab-content="content-tab-2" class="active">週間</li>
                        <li id="tab-3" data-tab-content="content-tab-3">月間</li>
                    </ul>
                    <div class="tabContentArea">
                        <div id="content-tab-1" class="tabContent">
                            <?php if ($catId == 1): ?>
                            <ul class="articleList rankingList">
                                <?php if (function_exists('wpp_get_mostpopular')): ?>
                                <?php
                                    // オプションの設定
                                    $args = array(
                                        'limit' => 5, // 表示する記事数
                                        'thumbnail_width' => 75,
                                        'thumbnail_height' => 75,
                                        'range' => 'daily', // 期間(1日daily,1週間weekly,1ヶ月monthly,全期間all)
                                        'order_by' => 'views', // ソート順（これは閲覧数）
                                        'post_type' => 'post', // 投稿タイプ（カスタム投稿タイプを表示したくない場合など）
                                        'stats_views' => 1, // 閲覧数を表示する(1)/表示しない(0)
                                        'stats_date' => 1, // 日付を表示する(1)/表示しない(0)
                                        'stats_date_format' => 'Y/m/d', // 日付のフォーマット
                                        'stats_category' => 1, // カテゴリを表示する(1)/表示しない(0)
                                        'stats_author' => 1,// ライター名の表示　1が表示 0が非表示。デフォルトは0
                                        'cat' => 1,
                                    );
                                    // 関数の実行
                                    wpp_get_mostpopular($args);
                                ?>
                                <?php else: ?>
                                <li class="none">該当する記事がありません。</li>
                                <?php endif; ?>
                                <?php wp_reset_query(); ?>
                            </ul>
                            <?php else: ?>
                            <ul class="articleList rankingList">
                                <?php if (function_exists('wpp_get_mostpopular')): ?>
                                <?php
                                    $args = array(
                                        'limit' => 5,
                                        'thumbnail_width' => 75,
                                        'thumbnail_height' => 75,
                                        'range' => 'daily',
                                        'order_by' => 'views',
                                        'post_type' => 'post',
                                        'stats_views' => 1,
                                        'stats_date' => 1,
                                        'stats_date_format' => 'Y/m/d',
                                        'stats_category' => 1,
                                        'stats_author' => 1,
                                        'cat' => $catIdGrandson,
                                    );

                                    wpp_get_mostpopular($args);
                                ?>
                                <?php else: ?>
                                <li class="none">該当する記事がありません。</li>
                                <?php endif; ?>
                                <?php wp_reset_query(); ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div id="content-tab-2" class="tabContent tabSelected">
                            <?php if ($catId == 1): ?>
                            <ul class="articleList rankingList">
                                <?php if (function_exists('wpp_get_mostpopular')): ?>
                                <?php
                                    $args = array(
                                        'limit' => 5,
                                        'thumbnail_width' => 75,
                                        'thumbnail_height' => 75,
                                        'range' => 'weekly',
                                        'order_by' => 'views',
                                        'post_type' => 'post',
                                        'stats_views' => 1,
                                        'stats_date' => 1,
                                        'stats_date_format' => 'Y/m/d',
                                        'stats_category' => 1,
                                        'stats_author' => 1,
                                        'cat' => 1,
                                    );

                                    wpp_get_mostpopular($args);
                                ?>
                                <?php else: ?>
                                <li class="none">該当する記事がありません。</li>
                                <?php endif; ?>
                                <?php wp_reset_query(); ?>
                            </ul>
                            <?php else: ?>
                            <ul class="articleList rankingList">
                                <?php if (function_exists('wpp_get_mostpopular')): ?>
                                <?php
                                    $args = array(
                                        'limit' => 5,
                                        'thumbnail_width' => 75,
                                        'thumbnail_height' => 75,
                                        'range' => 'weekly',
                                        'order_by' => 'views',
                                        'post_type' => 'post',
                                        'stats_views' => 1,
                                        'stats_date' => 1,
                                        'stats_date_format' => 'Y/m/d',
                                        'stats_category' => 1,
                                        'stats_author' => 1,
                                        'cat' => $catIdGrandson,
                                    );
                                    wpp_get_mostpopular($args);
                                ?>
                                <?php else: ?>
                                <li class="none">該当する記事がありません。</li>
                                <?php endif; ?>
                                <?php wp_reset_query(); ?>
                            </ul>
                            <?php endif; ?>
                        </div>
                        <div id="content-tab-3" class="tabContent">
                            <?php if ($catId == 1): ?>
                            <ul class="articleList rankingList">
                                <?php if (function_exists('wpp_get_mostpopular')): ?>
                                <?php
                                    $args = array(
                                        'limit' => 5,
                                        'thumbnail_width' => 75,
                                        'thumbnail_height' => 75,
                                        'range' => 'monthly',
                                        'order_by' => 'views',
                                        'post_type' => 'post',
                                        'stats_views' => 1,
                                        'stats_date' => 1,
                                        'stats_date_format' => 'Y/m/d',
                                        'stats_category' => 1,
                                        'stats_author' => 1,
                                        'cat' => 1,
                                    );
                                    wpp_get_mostpopular($args);
                                ?>
                                <?php else: ?>
                                <li class="none">該当する記事がありません。</li>
                                <?php endif; ?>
                                <?php wp_reset_query(); ?>
                            </ul>
                            <?php else: ?>
                            <ul class="articleList rankingList">
                                <?php if (function_exists('wpp_get_mostpopular')): ?>
                                <?php
                                    $args = array(
                                        'limit' => 5,
                                        'thumbnail_width' => 75,
                                        'thumbnail_height' => 75,
                                        'range' => 'monthly',
                                        'order_by' => 'views',
                                        'post_type' => 'post',
                                        'stats_views' => 1,
                                        'stats_date' => 1,
                                        'stats_date_format' => 'Y/m/d',
                                        'stats_category' => 1,
                                        'stats_author' => 1,
                                        'cat' => $catIdGrandson,
                                    );
                                    wpp_get_mostpopular($args);
                                ?>
                                <?php else: ?>
                                    <li class="none">該当する記事がありません。</li>
                                <?php endif; ?>
                                <?php wp_reset_query(); ?>
                            </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
    <?php get_footer(); ?>
