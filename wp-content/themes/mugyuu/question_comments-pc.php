<style type="text/css">
    .answerList label.check:before{
        content: "✓";
    }
    .qaSingle .commentFormArea:before{
        top: 0!important;
    }
    .qaSingle .commentFormArea{
        margin-top:0px;
        padding-top: 20px;
    }
    .btnDisable:hover{ 
        background-color: #ccc!important;
        color:#fff!important;
    }
    .btnDisable{
        color:#ccc!important;
        border-color: #ccc!important;
    }
    .mainWrap.single.qa .mainArea .commentFormArea form ul li .textArea .imgBtn input{
        font-size: inherit!important;
    }
    
</style>
<?php 
    $limited = get_post_meta( $post->ID, '_limited_answer', true );
    $questions = get_post_meta( $post->ID, '_question_type', true );
    $GLOBALS['questions'] = $questions; 
    $count_comment = wp_count_comments($post->ID);

?>
<section class="commentArea">
    <div class="question_filter">
        <div class="icon_search">
        	<i class="fa fa-search" aria-hidden="true"></i> 絞り込む
        </div>
        <label for="qaFilter" class="sortWrap lbFilter">
            <select id="qaFilter" name="qaFilter" class="sort">
                <option value="" >口コミ時のアンケート項目の内容</option>
            <?php foreach ($questions[$post->ID] as $qkey => $question) { 
                    foreach ($question['answer'] as $anskey => $ansval) {
                        $ansKeys = $qkey.','.$anskey;
                ?>
                <option value="<?=$ansKeys?>" <?=($_GET['comment_filter_by'] == $ansKeys)?'selected':''?> ><?=$ansval?></option>
            <?php } 
            } ?>
            </select>
        </label>
    </div>
    <div class="row">
        <label for="qaSort" class="sortWrap">
            <select id="qaSort" name="qaSort" class="sort">
                <option value="old" <?php if($_GET['comment_order_by'] == 'old' || (!isset($_GET['comment_order_by']) && get_option('comment_order') != 'desc')) echo 'selected' ?>>古い順</option>
                <option value="new" <?php if($_GET['comment_order_by'] == 'new' || (!isset($_GET['comment_order_by']) && get_option('comment_order') == 'desc')) echo 'selected' ?>>新着順</option>
                <option value="like_count" <?php if($_GET['comment_order_by'] == 'like_count') echo 'selected' ?>>共感順</option>
            </select>
        </label>

    </div>
    <?php if(have_comments()): ?>
   　<ul class="commentList">
       <?php 
       $page = intval( get_query_var( 'cpage' ) );
        if ( 0 == $page ) {
            $page = 1;
            set_query_var( 'cpage', $page );
        }
        
        $comments_per_page = get_option( 'comments_per_page' );
        $comment_arr = get_comments( array( 'status' => 'approve', 'post_id' => $post->ID ) );

        if(isset($_GET['comment_filter_by'])){
            $param = explode(',',$_GET['comment_filter_by']);
            $comment_filter = array();
            foreach ($comment_arr as $comment) {
                $comment_meta = get_comment_meta($comment->comment_ID,'_question_comment',true);
                if(@array_key_exists($param[0],$comment_meta)){
                    if(in_array($param[1],$comment_meta[$param[0]])){
                        array_push($comment_filter,$comment);
                    }
                }
            }
            $comment_arr = $comment_filter;
        }

        if(isset($_GET['comment_order_by'])){
           if($_GET['comment_order_by'] == 'like_count'){
               usort($comment_arr, 'comment_compare_like_count');
           }else{
               if($_GET['comment_order_by'] == 'old'){
                   usort($comment_arr, 'comment_compare_old');
               }else{
                   usort($comment_arr, 'comment_compare_new');
               }
           }
       }
           
       wp_list_comments( array (
               'per_page'      => $comments_per_page,
               'page'          => $page,
               'reverse_top_level' => false,
               'callback'      => 'question_comment'
       ), $comment_arr );
       ?>
    </ul>
     <?php endif; ?>
     <?php
     global $wp_query;
        $wp_query->comments = $comment_arr;
         if(get_comment_pages_count($comment_arr,$comments_per_page, true) > 1){
             echo '<div style="margin-top:20px; text-align:center;" class="notice_pagination">';
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
                    <input required type="text" name="name" placeholder="ニックネームを入力してください">
                </li>
                <?php 
                    foreach ($questions[$post->ID] as $qkey => $question) {
                        if($question['type'] == 'checkbox'){
                            ?>
                            <li>
                                <h3><?=$question['question']?><span class="red">※</span></h3>
                                <div class="checkArea" >
                                    <?php foreach ($question['answer'] as $anskey => $ansval) {
                                        ?>
                                    <label>
                                        <input required value="<?=$anskey?>" name="answer[<?=$qkey?>][]" type="checkbox" id="option-<?=$anskey?>"><?=$ansval?>
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
                                        <input required value="<?=$anskey?>" name="answer[<?=$qkey?>][]" type="radio" ><?=$ansval?>
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
                                <input required name="answer[<?=$qkey?>][textbox]" type="text" placeholder="回答を入力してください" >
                            </li>
                            <?php
                        }elseif($question['type'] == 'textarea'){
                            ?>
                            <li>
                                <h3><?=$question['question']?><span class="red">※</span></h3>
                                <textarea required name="answer[<?=$qkey?>][textarea]" placeholder="回答を入力してください"></textarea>
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
                    <div class="textArea" id="contentArea">
                        <textarea name="comment" id="thread_content" required cols="30" rows="10" name="comment"></textarea>
                        <label class="imgBtn">
                            <i class="fa fa-camera" aria-hidden="true"></i>画像を選択する
                            <input type="file" id="content_image" name="content_image">
                        </label>
                    </div>
                </li>
                <li>
                    <?php
                    if( ($count_comment->approved < $limited && $limited > 0) || empty($limited) ): ?>
                        <button type="submit" name="submitted" value="send" class="sendBtn">アンケートに回答する</button>
                    <?php else: ?>
                        <button type="submit" name="submitted" value="send" class="sendBtn btnDisable" disabled="disabled">回答締め切りました。</button>
                    <?php endif; ?> 
                </li>
            </ul>
        </form>
    </div>
   
</section>
<script type="text/javascript">
    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    var max_upload_picture = "<?php echo get_option('spc_options')['a_img_no']; ?>";

    $('button[type=submit]').on('click',function(){
        $cbx_group = $("input:checkbox[id^='option-']"); // name is not always helpful ;)
        $cbx_group.prop('required', true);
        if($cbx_group.is(":checked")){
          $cbx_group.prop('required', false);
        }
    });

    $('#qaFilter').on('change',function(){
        <?php set_query_var( 'cpage', 0 );?>
        var target = $(this);

        var sort = "<?php echo $_GET['comment_order_by']; ?>";

        var get_sort = 'comment_order_by=' + sort;
        var get_filter = 'comment_filter_by=' + target.val();
        
        var listParam = window.location.pathname.split('/');
        var lastParam = listParam[listParam.length-1];
        var path = window.location.pathname;
        if(/^comment-page-[0-9]/g.test(lastParam)){
            path = window.location.pathname.replace('/'+lastParam,'');
        }
        var current_link = window.location.origin + path;
        if(sort.length>0) {
            current_link += '?';
            if(target.val().length>0){
                current_link += get_filter;
                current_link += '&' 
                current_link += get_sort;
            }else{
                current_link += get_sort;
            }
        }else{
            if(target.val().length>0){
                current_link += '?';
                current_link += get_filter;
            }
        }

        window.location = current_link;
    });

    $('#qaSort').on('change',function(){
        var target = $(this);

        var filter = "<?php echo $_GET['comment_filter_by']; ?>";

        var get_filter = 'comment_filter_by=' + filter;
        var get_sort = 'comment_order_by=' + target.val();
        
        var current_link = window.location.origin + window.location.pathname;
        
        if(filter.length>0) {
            current_link += '?';
            if(target.val().length>0){
                current_link += get_sort;
                current_link += '&' 
                current_link += get_filter;
            }else{
                current_link += get_filter;
            }
        }else{
            if(target.val().length>0){
                current_link += '?';
                current_link += get_sort;
            }
        }

        window.location = current_link;
    });
</script>
<script src="<?php bloginfo('template_directory'); ?>/js/notice-board.js"></script>
<?php add_comment_on_questions(get_the_ID()) ?>