<style type="text/css">
    .answerList label.check:before{
        content: "✓";
    }
    .pagination .page-numbers {
        display: inline-block;  
        border: solid 1px #fc8c96;
        border-radius: 3px;
        min-width: 42px;
        min-height: 42px;
        box-sizing: border-box;
        margin-right: 10px;
        vertical-align: middle;
        line-height: 40px;
        display: inline-block;
        margin-right: 10px;
    }
    .pagination span.current {
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
<section id="send" class="commentFormArea">
    <div class="commentFormWrap">
        <div class="ttlArea">
            <h1>アンケートに答える</h1>
            <p>
                <span class="red">※</span>は必須項目になります。
            </p>
        </div>
        <form action="" id="formComment" method="POST">
            <ul class="answerInpotList" >
                <li>
                    <h3>ニックネーム<span class="red">※</span></h3>
                    <input type="text" name="name" placeholder="ニックネームを入力してください">
                </li>
                <?php 
                    
                    foreach ($questions[$post->ID] as $qkey => $question) {
                        if($question['type'] == 'checkbox'){
                            ?>
                            <li>
                                <h3><?=$question['question']?><span class="red">※</span></h3>
                                <div class="checkArea">
                                    <?php foreach ($question['answer'] as $anskey => $ansval) {
                                        ?>
                                    <label>
                                        <input value="<?=$anskey?>" name="answer[<?=$qkey?>][]" type="checkbox" id="<?=$anskey?>"><?=$ansval?>
                                    </label>
                                        <?php
                                    } ?>
                                </div>
                            </li>
                            <?php
                        }elseif($question['type'] == 'radio'){
                            ?>
                            <li>
                                <h3><?=$question['question']?><span class="red">※</span></h3>
                                <?php foreach ($question['answer'] as $anskey => $ansval) {
                                    ?>
                                    <label >
                                        <input value="<?=$anskey?>" name="answer[<?=$qkey?>][]" type="radio" ><?=$ansval?>
                                    </label>
                                <?php
                                } ?>
                            </li>
                            <?php
                        }elseif($question['type'] == 'pulldown'){
                            ?>
                            <li>
                                <h3><?=$question['question']?><span class="red">※</span></h3>
                                <label for="select" class="selectArea">
                                    <select name="answer[<?=$qkey?>][]" id="select">
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
                                <input name="answer[<?=$qkey?>][textbox]" type="text" placeholder="回答を入力してください" >
                            </li>
                            <?php
                        }elseif($question['type'] == 'textarea'){
                            ?>
                            <li>
                                <h3><?=$question['question']?><span class="red">※</span></h3>
                                <textarea name="answer[<?=$qkey?>][textarea]" placeholder="回答を入力してください"></textarea>
                            </li>
                            <?php
                        }
                    }
                 ?>
                <li>
                    <h3>コメント<span class="red">※</span></h3>
                    <p class="notes">
                        参考になるような意見を書いてね！誹謗中傷コメントは消しちゃうよ！的な注意コメント入れる
                    </p>
                    <div class="textArea">
                        <textarea cols="30" rows="10" name="comment"></textarea>
                        <label class="imgBtn">
                            <i class="fa fa-camera" aria-hidden="true"></i>画像を選択する
                            <input type="file">
                        </label>
                    </div>
                </li>
                <li>
                    <?php 
                        if(count($answers) < $limited){
                         ?>
                        <button type="submit" name="submitted" value="send" class="sendBtn">アンケートに回答する</button>
                    <?php } ?>
                </li>
            </ul>
        </form>
    </div>
</section>


<?php add_comment_on_questions(get_the_ID()) ?>