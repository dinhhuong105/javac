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
    .editFrom input{
        width: auto!important; 
        height: auto!important;
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
           <option value="new" <?php if($_GET['comment_order_by'] == 'new') echo 'selected' ?>>新着順</option>
            <option value="old" <?php if($_GET['comment_order_by'] == 'old') echo 'selected' ?>>古い順</option>
            <option value="like_count" <?php if($_GET['comment_order_by'] == 'like_count') echo 'selected' ?>>共感順</option>
       </select>
   </label>
	<?php if(have_comments()): ?>
   　<ul class="commentList">
	   <?php 
            $args = array('type' =>'comment','callback' => 'question_comment');
            $resource = null;
            if (isset($_GET['comment_order_by']) && $_GET['comment_order_by'] == 'new' )
                { $args['reverse_top_level'] = true; }
            elseif (isset($_GET['comment_order_by']) && $_GET['comment_order_by'] == 'old' )
               { $args['reverse_top_level'] = false; }
            else {
                global $wp_query;
                $comment_arr = $wp_query->comments;
                usort($comment_arr, 'comment_comparator');
                $resource = $comment_arr;
            }
            wp_list_comments($args,$resource); 
        ?>
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
    	<h1>アンケートに答える</h1>
        <p class="notes"><sup class="red">※</sup>は必須項目になります。</p>
    	<form action="" id="formComment" method="POST">
            <ul class="answerList">
                <li>
                    <h3>ニックネーム<span class="red">※</span></h3>
                    <input type="text" name="name" required placeholder="ニックネームを入力してください">
                </li>
                <?php 
                    
                    foreach ($questions[$post->ID] as $qkey => $question) {
                        if($question['type'] == 'checkbox'){
                            ?>
                            <li class="editFrom">
                                <h3><?=$question['question']?><span class="red">※</span></h3>
                                <div class="checkArea">
                                    <?php foreach ($question['answer'] as $anskey => $ansval) {
                                        ?>
                                    <label>
                                        <input value="<?=$anskey?>" name="answer[<?=$qkey?>][]" type="checkbox" id="<?=$anskey?>" required="required"><?=$ansval?>
                                    </label>
                                        <?php
                                    } ?>
                                </div>
                            </li>
                            <?php
                        }elseif($question['type'] == 'radio'){
                            ?>
                            <li class="editFrom">
                                <h3><?=$question['question']?><span class="red">※</span></h3>
                                <?php foreach ($question['answer'] as $anskey => $ansval) {
                                    ?>
                                    <label >
                                        <input value="<?=$anskey?>" name="answer[<?=$qkey?>][]" type="radio" required="required"><?=$ansval?>
                                    </label>
                                <?php
                                } ?>
                            </li>
                            <?php
                        }elseif($question['type'] == 'pulldown'){
                            ?>
                            <li class="editFrom">
                                <h3><?=$question['question']?><span class="red">※</span></h3>
                                <label for="select" class="selectArea">
                                    <select name="answer[<?=$qkey?>][]" id="select" required="required" class="selectArea">
                                    <?php foreach ($question['answer'] as $anskey => $ansval) {
                                        ?>
                                        <option value="<?=$anskey?>"><?=$ansval?></option>
                                        <?php
                                    } ?>
                                    </select>
                                </label>
                            </li>
                            <?php
                        }elseif($question['type'] == 'textbox'){
                            ?>
                            <li>
                                <h3><?=$question['question']?><span class="red">※</span></h3>
                                <input name="answer[<?=$qkey?>][textbox]" type="text" placeholder="回答を入力してください" required="required">
                            </li>
                            <?php
                        }elseif($question['type'] == 'textarea'){
                            ?>
                            <li>
                                <h3><?=$question['question']?><span class="red">※</span></h3>
                                <textarea name="answer[<?=$qkey?>][textarea]" placeholder="回答を入力してください" required="required"></textarea>
                            </li>
                            <?php
                        }
                    }
                 ?>
                <li>
                    <h3>コメント<span class="red">※</span></h3>
                    <p>参考になるような意見を書いてね！誹謗中傷コメントは消しちゃうよ！的な注意コメント入れる</p>
                    <div class="textArea">
                        <textarea name="comment" required cols="30" rows="10" required="required"></textarea>
                    </div>
                </li>
                <li>
                	<input type="hidden" name="submitted" id="submitted" value="true" />
                    <button type="submit" name="action" value="send" class="sendBtn">コメントを投稿</button>
                </li>
            </ul>
        </form>
</section>
<?php add_comment_on_notice(get_the_ID()) ?>