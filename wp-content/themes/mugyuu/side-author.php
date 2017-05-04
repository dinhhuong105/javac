
<section class="authorArea">
	<h2 class="heading">
		<span>W</span><span>R</span><span>I</span><span>T</span><span>E</span><span>R</span>
	</h2>
	<?php
            $number = 4; // 1ページに表示したいユーザー数
            $args = array(
                'role'=>'author',
                'orderby'=>'rand',
                'number' => $number
            );
            $users = get_users( $args );

            echo '<ul class="authorList paged-'.$paged.'">';
            foreach($users as $user):
            $uid = $user->ID;
            $userData = get_userdata($uid);
                echo '<li class="author">';
                echo '<a href="'.home_url('/').'author/'.$userData->user_nicename.'?uID='. $userData->ID .'&uNAME=' . $userData->display_name . '">';
                echo '<div class="imgArea">'.get_avatar( $uid, 125 ).'</div>';
                echo '<p class="name">'.$user->display_name.'</p>';
                echo '</a>';
                echo '</li>';

            endforeach;
        ?>
	</ul>
	<div class="moreBtn">
		<a href="<?php echo home_url('/'); ?>author-list">もっと読む</a>
	</div>
</section>
