
<section class="authorArea">
	<h1 class="heading">
		<span>W</span><span>R</span><span>I</span><span>T</span><span>E</span><span>R</span>
	</h1>
	<?php
            // $total_users = count_users();
            // $total_users = $total_users['total_users'];
            // $paged = get_query_var('paged');
            $number = 4; // 1ページに表示したいユーザー数
            $args = array(
                'role'=>'author',
                'orderby'=>'rand',
                'order'=>'ASC',
                // 'offset' => $paged ? ( ($paged - 1) * $number) : 0,
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
                echo '<div class="imgArea">'.get_avatar( $uid, 125 ).'</div>';
                echo '<p class="name">'.$user->display_name.'</p>';
                echo '</a>';
                echo '</li>';
            //}
            endforeach;
        ?>
	</ul>
	<div class="moreBtn">
		<a href="<?php echo home_url('/'); ?>author">もっと読む</a>
	</div>
</section>
