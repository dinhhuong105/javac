<?php get_header(); ?>
<div id="sb-site" class="wrapper authorAll">
    <?php breadcrumb(); ?>
    <section class="authorArea">
        <h1>ライター紹介</h1>
        <p class="detail">
            <?php
                $page_info = get_page_by_path('author-list-sp');
                $page = get_post($page_info);
                echo $page->post_content;
            ?>
        </p>
        <h2>
            ライター一覧
        </h2>
        <!-- <div class="writerType">
            <p class="mg">MUGYUU!ライター</p>
            <p class="sp">スペシャルライター</p>
        </div> -->
        <?php
            $total_users = count_users();
            $total_users = $total_users['total_users'];
            $paged = get_query_var('paged');
            $number = 10; // 1ページに表示したいユーザー数
            // $number = 50; // 1ページに表示したいユーザー数 ページャー直ったら10にする
            $args = array(
                'role'=>'author',
                'order'=>'ASC',
                'offset' => $paged ? ( ($paged - 1) * $number) : 0,
                'number' => $number
            );
			$users = new WP_User_Query($args);

			$users_count = (int) $users->get_total();

            echo '<ul class="authorList paged-'.$paged.'">';
            foreach($users->results as $user):
            $uid = $user->ID;
            $userData = get_userdata($uid);

                echo '<li class="author">';
                echo '<a href="'.home_url('/').'author/'.$userData->user_nicename .'?uID='. $userData->ID .'&uNAME=' . $userData->display_name . '">';
                echo '<div class="imgArea">'.get_avatar( $uid, 280 ).'</div>';
                echo '<p class="name">'.$user->display_name.'</p>';
                echo '</a>';
                echo '</li>';

            endforeach;
        ?>
        </ul>
        <div class="pagination">
            <?php
                if($users_count > $number){
                    $pl_args = array(
                        'base'     => add_query_arg('paged','%#%'),
                        'format'   => '',
                        'type' => 'list',
                        'total'    => ceil($users_count / $number),
                        'current'  => max(1, $paged),
                        'prev_text' => __('<i class="fa fa-chevron-left arrowIcon"></i>'),//前へ
                        'next_text' => __('<i class="fa fa-chevron-right arrowIcon"></i>'),//次へ
                        'end_size' => 1,//最初のページと最終のページ部の表示件数（1以上）前後何ページまでのリンク
                        'mid_size' => 1,//現在のページから前後何ページまでのリンクの表示件数（0以上）
                    );
                    // for ".../page/n"
                    if($GLOBALS['wp_rewrite']->using_permalinks())
                        $pl_args['base'] = user_trailingslashit(trailingslashit(get_pagenum_link(1)).'page/%#%/', 'paged');
                    echo paginate_links($pl_args);
                }
            ?>
        </div>
    </section>
<?php get_footer(); ?>
