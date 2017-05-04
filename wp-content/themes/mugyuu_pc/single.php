<?php get_header(); ?>
<?php breadcrumb(); ?>
    <div class="mainWrap single">
        <div class="mainArea">
            <section class="postArea">
				<?php
		            $postCat = get_the_category();
		            usort( $postCat , '_usort_terms_by_ID');
		            $catId = $postCat[0]->cat_ID;
		            $author_id = $post->post_author;
		            $author = get_userdata($post->post_author);
					$thumbnail_id = get_post_thumbnail_id();
                    $image = wp_get_attachment_image_src( $thumbnail_id, '900_thumbnail' );
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
                    usort( $userLebel , '_usort_terms_by_ID');
                    $slug_name = $post->post_name;
		        ?>
				<?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
               <div class="postDataArea">
                    <p class="postDate"><?php the_time('Y/m/d'); ?></p>
                    <p class="pv">
                        <i class="fa fa-heart" aria-hidden="true"></i>
						<?php
                            if ( function_exists ( 'wpp_get_views' ) ) {
                                echo wpp_get_views ( get_the_ID() ); }
                        ?>
                    </p>
               </div>
                <h1 class="heading">
					<?php the_title(); ?>
                </h1>
				<div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
					<img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
                </div>
                <?php get_template_part('sns'); ?>
                <div class="contentArea">
					<?php the_content(); ?>
                </div>
                <?php get_template_part('sns'); ?>
                <div class="authorDataArea">
                   <a href="<?php echo home_url('/'); ?>author/<?php echo $author->user_nicename; ?>">
					   <?php
                            if  ($userLebel[0] == 'author' ) {
                                echo '<div class="imgArea author">';
                            } else {
                                echo '<div class="imgArea">';
                            }
                        ?>
                        <?php echo get_avatar($author_id,130); ?>
                       </div>
                       <div class="authorData">
                           <p class="name"><?php echo $author->display_name; ?></p>
                           <p class="skill"><?php echo nl2br(get_the_author_meta('skill')); ?></p>
                           <p class="text"><?php the_author_meta('user_description'); ?></p>
                       </div>
                   </a>
                </div>
				<?php endwhile; ?>
				<?php else : ?>
				<p class="none">記事が見つかりませんでした。</p>
				<?php endif; ?>
            </section>
            <?php get_template_part('related-entries'); ?>
            <section class="articleListArea rankingListArea">
                <h1 class="heading">
                    <span>R</span><span>A</span><span>N</span><span>K</span><span>I</span><span>N</span><span>G</span>
                </h1>
                <div class="tabs">
                    <ul class="tabMenuList">
                        <li data-tab-content="content-tab-1" class="<?php echo ($tab == 1) ? 'active' : '' ?>">本日</li>
                        <li data-tab-content="content-tab-2" class="<?php echo ($tab == 2 || $tab == null) ? 'active' : '' ?>">週間</li>
                        <li data-tab-content="content-tab-3" class="<?php echo ($tab == 3) ? 'active' : '' ?>">月間</li>
                    </ul>
                    <div class="tabContentArea">
                        <div id="content-tab-1" class="tabContent">
                            <ul class="articleList rankingList">
                                <?php if (function_exists('wpp_get_mostpopular')): ?>
                                <?php
                                    // オプションの設定
                                    $args = array(
                                        'limit' => 6, // 表示する記事数
                                        'thumbnail_width' => 200,
                                        'thumbnail_height' => 150,
                                        'range' => 'daily', // 期間(1日daily,1週間weekly,1ヶ月monthly,全期間all)
                                        'order_by' => 'views', // ソート順（これは閲覧数）
                                        'post_type' => 'post', // 投稿タイプ（カスタム投稿タイプを表示したくない場合など）
                                        'stats_views' => 1, // 閲覧数を表示する(1)/表示しない(0)
                                        'stats_date' => 1, // 日付を表示する(1)/表示しない(0)
                                        'stats_date_format' => 'Y/m/d', // 日付のフォーマット
                                        'stats_category' => 1, // カテゴリを表示する(1)/表示しない(0)
                                        'stats_author' => 1,// ライター名の表示　1が表示 0が非表示。デフォルトは0
                                        'cat' => $catId === 1 ? 1 : $catIdGrandson,
                                    );
                                    // 関数の実行
                                    wpp_get_mostpopular($args);
                                ?>
                                <?php else: ?>
                                <li class="none">該当する記事がありません。</li>
                                <?php endif; ?>
                                <?php wp_reset_query(); ?>
                            </ul>
                        </div>
                        <div id="content-tab-2" class="tabContent tabSelected">
                            <ul class="articleList rankingList">
                                <?php if (function_exists('wpp_get_mostpopular')): ?>
                                <?php
                                    // オプションの設定
                                    $args = array(
                                        'limit' => 6, // 表示する記事数
                                        'thumbnail_width' => 200,
                                        'thumbnail_height' => 150,
                                        'range' => 'weekly', // 期間(1日daily,1週間weekly,1ヶ月monthly,全期間all)
                                        'order_by' => 'views', // ソート順（これは閲覧数）
                                        'post_type' => 'post', // 投稿タイプ（カスタム投稿タイプを表示したくない場合など）
                                        'stats_views' => 1, // 閲覧数を表示する(1)/表示しない(0)
                                        'stats_date' => 1, // 日付を表示する(1)/表示しない(0)
                                        'stats_date_format' => 'Y/m/d', // 日付のフォーマット
                                        'stats_category' => 1, // カテゴリを表示する(1)/表示しない(0)
                                        'stats_author' => 1,// ライター名の表示　1が表示 0が非表示。デフォルトは0
                                        'cat' => $catId === 1 ? 1 : $catIdGrandson,
                                    );
                                    // 関数の実行
                                    wpp_get_mostpopular($args);
                                ?>
                                <?php else: ?>
                                <li class="none">該当する記事がありません。</li>
                                <?php endif; ?>
                                <?php wp_reset_query(); ?>
                            </ul>
                        </div>
                        <div id="content-tab-3" class="tabContent">
                            <ul class="articleList rankingList">
                                <?php if (function_exists('wpp_get_mostpopular')): ?>
                                <?php
                                    // オプションの設定
                                    $args = array(
                                        'limit' => 6, // 表示する記事数
                                        'thumbnail_width' => 200,
                                        'thumbnail_height' => 150,
                                        'range' => 'monthly', // 期間(1日daily,1週間weekly,1ヶ月monthly,全期間all)
                                        'order_by' => 'views', // ソート順（これは閲覧数）
                                        'post_type' => 'post', // 投稿タイプ（カスタム投稿タイプを表示したくない場合など）
                                        'stats_views' => 1, // 閲覧数を表示する(1)/表示しない(0)
                                        'stats_date' => 1, // 日付を表示する(1)/表示しない(0)
                                        'stats_date_format' => 'Y/m/d', // 日付のフォーマット
                                        'stats_category' => 1, // カテゴリを表示する(1)/表示しない(0)
                                        'stats_author' => 1,// ライター名の表示　1が表示 0が非表示。デフォルトは0
                                        'cat' => $catId === 1 ? 1 : $catIdGrandson,
                                    );
                                    // 関数の実行
                                    wpp_get_mostpopular($args);
                                ?>
                                <?php else: ?>
                                <li class="none">該当する記事がありません。</li>
                                <?php endif; ?>
                                <?php wp_reset_query(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
		<?php get_sidebar(); ?>
    </div>
<?php get_footer(); ?>
