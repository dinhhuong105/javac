<section class="reviewsArea">
    <?php if(have_comments()): ?>
        <h1>口コミ</h1>
        <ul class="reviewList">
            <?php wp_list_comments('type=comment&callback=mytheme_comment'); ?>
        </ul>
    <?php endif; ?>
    <?php
    if(get_comment_pages_count() > 1){
        echo '<div style="margin-top:15px; text-align:center;">';
        //ページナビゲーションの表示
        paginate_comments_links();
        echo '</div>';
    }
    ?>
</section>
<section class="reviewPostingArea" id="send">
    <div class="reviewBox">
        <h1>口コミを投稿する</h1>
        <?php
            $commenter = wp_get_current_commenter();
            $req = get_option( 'require_name_email' );
            $aria_req = ( $req ? "aria-required='true'" : '' );
            $args = array(
                        'fields' => array(
                            'author' => '<p class="comment-form-author">' . '<label for="author">ニックネーム<span class="required">*</span></label> ' .
                            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . 'placeholder="ニックネームを入力してください"/></p>',
                            'email'  => '',
                            'url'    => '',
                            'star' => '<div class="userStar"><p>評価<span class="required">*</span></p><div id="default"></div></div>',
                            'title' => '<label for=“title"><p>タイトル<span class="required">*</span></p><input name="title" type="text" placeholder="タイトルを入力してください" id="title" aria-required="true"></label>'
                        ),
                        'comment_field' => '<p class="comment-form"><label for="comment">コメント<span class="required">*</span></label><textarea id="comment" name="comment" cols="50" rows="6" ' . $aria_req . ' placeholder="コメントを入力してください" /></textarea></p>',

                        'title_reply' => '',
                        'label_submit' => '口コミを投稿',
                        'comment_notes_before' => '<p class="comment-notes"><span class="required">*</span> が付いている欄は必須項目となりますので、必ずご記入をお願いします。</p>',
                    );
        comment_form( $args ); ?>
        <div id="comment-error-area"></div>
    </div>
</section>
