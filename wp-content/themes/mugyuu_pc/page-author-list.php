<?php
/*
Template Name: ライター一覧
*/
?>
<?php get_header(); ?>
<?php breadcrumb(); ?>
        <div class="mainWrap list authorListWrap">
            <div class="mainArea">
                <section class="articleListArea author">
                    <h1 class="heading">
                        <span>W</span><span>R</span><span>I</span><span>T</span><span>E</span><span>R</span>
                    </h1>
                    <p class="ttl">
                        ライター一覧
                    </p>
                    <div class="authorTypeArea">
                        <p class="author">
                            MUGYUU!ライター
                        </p>
                        <p class="special">
                            スペシャルライター
                        </p>
                    </div>
					<?php
                            $paged = get_query_var('paged');
                            $number = 12; // 1ページに表示したいユーザー数
				            $args = array(
				                'role'=>'author',
				                'orderby'=>'rand',
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
				                echo '<a href="'.home_url('/').'author/'.$userData->user_nicename .'">';
				                echo '<div class="imgArea">'.get_avatar( $uid, 125 ).'</div>';
				                echo '<p class="name">'.$user->display_name.'</p>';
				                echo '</a>';
				                echo '</li>';
				            //}
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
			                        'prev_text' => __('<i class="fa fa-angle-left arrowIcon"></i>'),//前へ
			                        'next_text' => __('<i class="fa fa-angle-right arrowIcon"></i>'),//次へ
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
            </div>
			<?php get_sidebar(); ?>
        </div>
<?php get_footer(); ?>
