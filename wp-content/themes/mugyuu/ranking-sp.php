<section class="rankingArea">
    <h2 class="heading">
        <span>R</span><span>A</span><span>N</span><span>K</span><span>I</span><span>N</span><span>G</span>
    </h2>
    <div class="tabs">
        <ul class="tabMenuList horizontal">
            <li id="tab-1" data-tab-content="content-tab-1">本日</li>
            <li id="tab-2" data-tab-content="content-tab-2" class="active">週間</li>
            <li id="tab-3" data-tab-content="content-tab-3">月間</li>
        </ul>
        <div class="tabContentArea">
            <div id="content-tab-1" class="tabContent">
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
                            'post_type' => 'post,thread_post,question_post', // 投稿タイプ（カスタム投稿タイプを表示したくない場合など）
                            'stats_views' => 1, // 閲覧数を表示する(1)/表示しない(0)
                            'stats_date' => 1, // 日付を表示する(1)/表示しない(0)
                            'stats_date_format' => 'Y/m/d', // 日付のフォーマット
                            'stats_category' => 1, // カテゴリを表示する(1)/表示しない(0)
                            'stats_author' => 1,// ライター名の表示　1が表示 0が非表示。デフォルトは0
                        );
                        // 関数の実行
                        wpp_get_mostpopular($args);
                    ?>
                <?php else: ?>
                <li class="none">該当する記事がありません。</li>
                <?php endif; ?>
                    <?php wp_reset_query(); ?>
                </ul>
                <div class="moreBtn">
                    <a href="<?php echo home_url('/'); ?>ranking?t=1">もっと読む</a>
                </div>
            </div>
            <div id="content-tab-2" class="tabContent tabSelected">
                <ul class="articleList rankingList">
                    <?php if (function_exists('wpp_get_mostpopular')): ?>
                    <?php
                        $args = array(
                            'limit' => 5,
                            'thumbnail_width' => 75,
                            'thumbnail_height' => 75,
                            'range' => 'weekly',
                            'order_by' => 'views',
                            'post_type' => 'post,thread_post,question_post',
                            'stats_views' => 1,
                            'stats_date' => 1,
                            'stats_date_format' => 'Y/m/d',
                            'stats_category' => 1,
                            'stats_author' => 1,
                        );
                        wpp_get_mostpopular($args);
                    ?>
                    <?php else: ?>
                    <li class="none">該当する記事がありません。</li>
                    <?php endif; ?>
                    <?php wp_reset_query(); ?>
                </ul>
                <div class="moreBtn">
                    <a href="<?php echo home_url('/'); ?>ranking?t=2">もっと読む</a>
                </div>
            </div>
            <div id="content-tab-3" class="tabContent">
                <ul class="articleList rankingList">
                    <?php if (function_exists('wpp_get_mostpopular')): ?>
                    <?php
                        $args = array(
                            'limit' => 5,
                            'thumbnail_width' => 75,
                            'thumbnail_height' => 75,
                            'range' => 'monthly',
                            'order_by' => 'views',
                            'post_type' => 'post,thread_post,question_post',
                            'stats_views' => 1,
                            'stats_date' => 1,
                            'stats_date_format' => 'Y/m/d',
                            'stats_category' => 1,
                            'stats_author' => 1,
                        );
                        wpp_get_mostpopular($args);
                    ?>
                    <?php else: ?>
                    <li class="none">該当する記事がありません。</li>
                    <?php endif; ?>
                    <?php wp_reset_query(); ?>
                </ul>
                <div class="moreBtn">
                    <a href="<?php echo home_url('/'); ?>ranking?t=3">もっと読む</a>
                </div>
            </div>
        </div>
    </div>
</section>
