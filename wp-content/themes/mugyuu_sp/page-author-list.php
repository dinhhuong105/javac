<?php
/*
Template Name: ライター一覧
*/
?>
<?php get_header(); ?>

<div id="sb-site" class="wrapper authorAll">
    <?php breadcrumb(); ?>
    <section class="authorArea">
        <h1>ライター紹介</h1>
        <p class="detail">
            ライター紹介テキストライター紹介テキストライター紹介テキストライター紹介テキストライター紹介テキストライター紹介テキストライター紹介テキストライター紹介
        </p>
        <h2>
            ライター一覧
        </h2>
        <div class="writerType">
            <p class="mg">MUGYUU!ライター</p>
            <p class="sp">スペシャルライター</p>
        </div>
        <?php 
            $total_users = count_users();
            $total_users = $total_users['total_users'];
            $paged = get_query_var('paged');
            $number = 10; // 1ページに表示したいユーザー数
            $args = array(
                'role'=>'author',
                'orderby'=>'ID',
                'order'=>'ASC',
                'offset' => $paged ? ( ($paged - 1) * $number) : 0,
                'number' => $number
            );
            $users = get_users( $args );

            //$users =get_users( array('orderby'=>ID,'order'=>ASC,'number'=>3) );
            echo '<ul class="authorList paged-'.$paged.'">';
            foreach($users as $user):
            $uid = $user->ID;
            $userData = get_userdata($uid);
            $userLevel = $userData -> roles;//ユーザー権限取得
            //if ($userLevel[0] !== 'administrator' && $userLevel[0] !== 'editor' && $userLevel[0] !== 'movie-editor' && $userLevel[0] !=='item-author') {
                if ($userLevel[0] == 'author' ) {
                    echo '<li class="author">';
                } else {
                    echo '<li>';
                }
                echo '<a href="'.home_url('/').'author/'.$userData->user_nicename .'">';
                echo '<div class="imgArea">'.get_avatar( $uid, 280 ).'</div>';
                echo '<p class="name">'.$user->display_name.'</p>';
                echo '</a>';
                echo '</li>';
            //}
            endforeach;
        ?>
        </ul>
        <div class="pagination">
            <?php 
                if($total_users > $number){
                    $pl_args = array(
                        'base'     => add_query_arg('paged','%#%'),
                        'format'   => '',
                        'type' => 'list',
                        'total'    => ceil($total_users / $number),
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

