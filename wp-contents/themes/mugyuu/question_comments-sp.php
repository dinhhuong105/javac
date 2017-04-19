<style type="text/css">
    .answerList label.check:before{
        content: "✓";
    }
    .pagination .page-numbers {
        width: 26px;
        height: 26px;
        line-height: 26px;
        border: solid 1px #fc8c96;
        box-sizing: border-box;
        background: #fff;
        color: #fc8c96;
        display: inline-block;
        margin-right: 10px;

        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        -ms-border-radius: 3px;
        -o-border-radius: 3px;
        border-radius: 3px;
    }
    .pagination span.current {
        width: 26px;
        height: 26px;
        line-height: 26px;
        border: solid 1px #fc8c96;
        box-sizing: border-box;
        background: #fc8c96;
        color: #fff;
    }
    .qaSingle .commentFormArea:before{
        top: 0!important;
    }
    .qaSingle .commentFormArea{
        margin-top:0px;
        padding-top: 20px;
    }
</style>
<?php 
    $limited = get_post_meta( $post->ID, '_limited_answer', true );
    $questions = get_post_meta( $post->ID, '_question_type', true );
    $GLOBALS['questions'] = $questions; 
    global $answers;
?>
<section class="commentArea">
	<label for="qaSort" class="sortWrap">
                   <select id="qaSort" name="qaSort" class="sort">
                       <option value="古い順">古い順</option>
                       <option value="新着順">新着順</option>
                       <option value="共感順">共感順</option>
                       <option value="0歳〜1歳">0歳〜1歳</option>
                       <option value="2歳〜3歳">2歳〜3歳</option>
                       <option value="4歳〜">4歳〜</option>
                       <option value="チョコ">チョコ</option>
                       <option value="マカロン">マカロン</option>
                       <option value="アメ">アメ</option>
                       <option value="たまごボーロ">たまごボーロ</option>
                   </select>
               </label>
	<?php if(have_comments()): ?>
   　<ul class="commentList">
	   <?php wp_list_comments('type=comment&callback=question_comment'); ?>
	</ul>
	 <?php endif; ?>
	 <?php
	     if(get_comment_pages_count() > 1){
	         echo '<div style="margin-top:20px; text-align:center;" class="pagination">';
	         //ページナビゲーションの表示
	         paginate_comments_links([
                'next_text'    => __('›'),
                'prev_text'    => __('‹')
                ]);
	         echo '</div>';
	     }
     ?>
</section>
<section class="commentFormArea" id="send">
	<div class="commentFormWrap">
    	<div class="ttlArea">
            <h1>コメントを投稿する</h1>
            <p>
                <span class="red">※</span>は必須項目になります。
            </p>
        </div>
    	<form action="" id="formComment" method="POST">
            <ul>
                <li>
                    <h3>ニックネーム<span class="red">※</span></h3>
                    <input type="text" name="name" required placeholder="ニックネームを入力してください">
                </li>
                <li>
                    <h3>コメント<span class="red">※</span></h3>
                    <p>参考になるような意見を書いてね！誹謗中傷コメントは消しちゃうよ！的な注意コメント入れる</p>
                    <div class="textArea">
                        <textarea name="comment" required cols="30" rows="10"></textarea>
                    </div>
                </li>
                <li>
                	<input type="hidden" name="submitted" id="submitted" value="true" />
                    <button type="submit" name="action" value="send" class="sendBtn">コメントを投稿</button>
                </li>
            </ul>
        </form>
	</div>
</section>
<?php add_comment_on_notice(get_the_ID()) ?>