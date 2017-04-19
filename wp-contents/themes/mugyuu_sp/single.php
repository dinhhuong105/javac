<?php get_header(); ?>
       <?php  
            $postCat = get_the_category();
            usort( $postCat , '_usort_terms_by_ID');
            $catId = $postCat[0]->cat_ID;
//            $childCat = $postCat[1]->cat_name;
//            $catNameGrandson = $postCat[2]->cat_name;
//            $catIdGrandson = $postCat[2]->cat_ID;
            $author_id = $post->post_author;
            $author = get_userdata($post->post_author);
        ?>
        <div id="sb-site" class="wrapper single">
            <?php breadcrumb(); ?>
            <article class="singleArea">
                <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                <?php  
                    $postCat = get_the_category();
                    usort( $postCat , '_usort_terms_by_ID');
                    $catId = $postCat[0]->cat_ID;
                    $parentCat = $postCat[0]->cat_name;
//                    $childCat = $postCat[1]->cat_name;
//                    $catNameGrandson = $postCat[2]->cat_name;
                    $childCat = '';
                    $catNameGrandson = '';
                    $catIdGrandson = '';
                    if($catId !== 1) {
                        $childCat = $postCat[1]->cat_name;
                        $catNameGrandson = $postCat[2]->cat_name;
                        $catIdGrandson = $postCat[2]->cat_ID;
                    }
                    $author_id = $post->post_author;
                    $author = get_userdata($post->post_author);
                    $userLebel = $author -> roles;
                    $slug_name = $post->post_name;
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
                <div class="imgArea">
                    <?php the_post_thumbnail('medium'); ?>
                </div>
                <?php get_template_part('single-sns'); ?>
                <div class="content">
                    <?php the_content(); ?>
                </div>
                <?php get_template_part('single-sns'); ?>
                <div class="writerArea">
                    <a href="<?php echo home_url('/'); ?>author/<?php echo $author->user_nicename; ?>">
                        <?php
                            if  ($userLebel[0] == 'editor' ) {
                                echo '<div class="imgArea editor">';
                            } else {
                                echo '<div class="imgArea">';
                            }
                        ?>
                        <?php echo get_avatar($author_id,150); ?>
                        </div>
                       <div class="dataArea">
                           <p class="name"><?php echo $author->display_name; ?></p>
                           <p class="type">
                               <?php echo nl2br(get_the_author_meta('skill')); ?>
                           </p>
                           <p class="profile">
                               <?php the_author_meta('user_description'); ?>
                           </p>
                       </div>
                   </a>
                </div>
                <?php endwhile; ?>
                <?php else : ?>
                <p class="none">記事が見つかりませんでした。</p>
                <?php endif; ?>
            </article>
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
                                        'cat' => $catIdGrandson,
                                    );
                                    // 関数の実行
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
                                    // オプションの設定
                                    $args = array(
                                        'limit' => 5, // 表示する記事数
                                        'thumbnail_width' => 75,
                                        'thumbnail_height' => 75,
                                        'range' => 'weekly', // 期間(1日daily,1週間weekly,1ヶ月monthly,全期間all)    
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
                                    // オプションの設定
                                    $args = array(
                                        'limit' => 5, // 表示する記事数
                                        'thumbnail_width' => 75,
                                        'thumbnail_height' => 75,
                                        'range' => 'weekly', // 期間(1日daily,1週間weekly,1ヶ月monthly,全期間all)    
                                        'order_by' => 'views', // ソート順（これは閲覧数）
                                        'post_type' => 'post', // 投稿タイプ（カスタム投稿タイプを表示したくない場合など）
                                        'stats_views' => 1, // 閲覧数を表示する(1)/表示しない(0)
                                        'stats_date' => 1, // 日付を表示する(1)/表示しない(0)
                                        'stats_date_format' => 'Y/m/d', // 日付のフォーマット
                                        'stats_category' => 1, // カテゴリを表示する(1)/表示しない(0)
                                        'stats_author' => 1,// ライター名の表示　1が表示 0が非表示。デフォルトは0
                                        'cat' => $catIdGrandson,
                                    );
                                    // 関数の実行
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
                                    // オプションの設定
                                    $args = array(
                                        'limit' => 5, // 表示する記事数
                                        'thumbnail_width' => 75,
                                        'thumbnail_height' => 75,
                                        'range' => 'monthly', // 期間(1日daily,1週間weekly,1ヶ月monthly,全期間all)    
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
                                    // オプションの設定
                                    $args = array(
                                        'limit' => 5, // 表示する記事数
                                        'thumbnail_width' => 75,
                                        'thumbnail_height' => 75,
                                        'range' => 'monthly', // 期間(1日daily,1週間weekly,1ヶ月monthly,全期間all)    
                                        'order_by' => 'views', // ソート順（これは閲覧数）
                                        'post_type' => 'post', // 投稿タイプ（カスタム投稿タイプを表示したくない場合など）
                                        'stats_views' => 1, // 閲覧数を表示する(1)/表示しない(0)
                                        'stats_date' => 1, // 日付を表示する(1)/表示しない(0)
                                        'stats_date_format' => 'Y/m/d', // 日付のフォーマット
                                        'stats_category' => 1, // カテゴリを表示する(1)/表示しない(0)
                                        'stats_author' => 1,// ライター名の表示　1が表示 0が非表示。デフォルトは0
                                        'cat' => $catIdGrandson,
                                    );
                                    // 関数の実行
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