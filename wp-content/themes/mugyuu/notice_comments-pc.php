<section class="commentArea">
	<label for="qaSort" class="sortWrap">
		<select id="qaSort" name="qaSort" class="sort">
			<option value="old" <?php if($_GET['comment_order_by'] == 'old' || (!isset($_GET['comment_order_by']) && get_option('comment_order') != 'desc')) echo 'selected' ?>>古い順</option>
			<option value="new" <?php if($_GET['comment_order_by'] == 'new' || (!isset($_GET['comment_order_by']) && get_option('comment_order') == 'desc')) echo 'selected' ?>>新着順</option>
			<option value="like_count" <?php if($_GET['comment_order_by'] == 'like_count') echo 'selected' ?>>共感順</option>
		</select>
	</label>
	<?php if(have_comments()): ?>
   　<ul class="commentList">
	   <?php
	       if(isset($_GET['comment_order_by'])){
	           if($_GET['comment_order_by'] == 'like_count'){
	               global $wp_query;
                   $comment_arr = $wp_query->comments;
                   usort($comment_arr, 'comment_comparator');
                   wp_list_comments('callback=noticetheme_comment', $comment_arr);
	           }else{
	               if($_GET['comment_order_by'] == 'old'){
	                   $order = false;
    	           }else{
    	               $order = true;
        	       }
        	       $arg = array(
        	               'type' => 'comment',
        	               'callback' => 'noticetheme_comment',
        	               'reverse_top_level' => $order,
        	       );
        	       wp_list_comments($arg);
	           }
	       }else{
	           $arg = array(
	                   'type' => 'comment',
	                   'callback' => 'noticetheme_comment',
	           );
	           wp_list_comments($arg);
	       }
	   ?>
	</ul>
	 <?php endif; ?>
	 <?php
	     if(get_comment_pages_count() > 1){
	         echo '<div style="margin-top:15px; text-align:center;" class="notice_pagination">';
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
            <h2>コメントを投稿する</h2>
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
                    <div class="textArea" id="contentArea">
                        <textarea name="comment" id="thread_content" required cols="30" rows="10"></textarea>
                        <label class="imgBtn">
                            <i class="fa fa-camera" aria-hidden="true"></i>画像を選択する
                            <input type="file" id="content_image" name="content_image">
                        </label>
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
<script>
	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	var max_upload_picture = "<?php echo get_option('spc_options')['less_img_no']; ?>";
</script>
<script src="<?php bloginfo('template_directory'); ?>/js/notice-board.js"></script>
<?php add_comment_on_notice(get_the_ID()) ?>