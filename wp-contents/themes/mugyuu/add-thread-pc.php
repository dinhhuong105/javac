<?php get_header();?>
<?php addThreadFront();?>
<?php breadcrumb(); ?>
    <div class="mainWrap single addthread">
        <div class="mainArea">
        	<section class="threadFormArea">
                <h1 class="heading">新規スレッド作成</h1>
                <div class="formArea">
                    <form action="" id="threadAddForm" method="POST" enctype="multipart/form-data">
                        <ul class="threadList">
                            <li>
                                <div class="imgArea">
                                    <img src="<?php bloginfo('template_directory'); ?>/images/noimage.png" id="no_image" alt="画像" width="130" height="130">
                                    <label class="imgBtn">
                                        <i class="fa fa-camera" aria-hidden="true"></i>画像を選択
                                        <input id="thread_thumb" name="thread_thumb" type="file">
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="ttl">
                                    <input type="text" name="thread_title" id="thread_title" required placeholder="スレッドタイトルを入力してください">
                                </div>
                                <div class="content" id="contentArea">
                            		<div class="textArea">
                                    	<textarea name="thread_content" id="thread_content" required cols="30" rows="10" placeholder="本文を入力してください"></textarea>
                                    	<label class="imgBtn">
                                            <i class="fa fa-camera" aria-hidden="true"></i>画像を選択
                                            <input type="file" id="content_image" name="content_image">
                                        </label>
                                	</div>
                                </div>
                            </li>
                        </ul>
                        <ul class="answerInpotList">
                        	<li>
                        		<div class="checkArea">
                                    <label for="anonymous">
                                        <input style="-webkit-appearance: checkbox;" type="checkbox" id="anonymous" name="anonymous">匿名を投稿
                                    </label>
                                    <label for="displayID">
                                        <input style="-webkit-appearance: checkbox;" type="checkbox" id="displayID" name="displayID">IDを表示してなりまし防止
                                    </label>
                                </div>
                        	</li>
                        </ul>
                        <ul class="categoryArea">
                        	<li>
                            	<label for="select" class="selectArea">
                            	<select name="parent_cat" id="parent_cat"> 
                                    <option value="0"><?php echo esc_attr_e( 'The parent category', 'textdomain' ); ?></option> 
                                    <?php 
                                    $categories = get_categories( array( 'parent' => 0, 'hide_empty'=>false ) );
                                    foreach ( $categories as $category ) {
                                        printf( '<option value="%1$s">%2$s</option>',
                                            esc_attr( $category->term_id ),
                                            esc_html( $category->cat_name )
                                        );
                                    }
                                    ?>
                                </select>
                            	<select name="child_cat" id="child_cat">
                            		<option value="0"><?php echo esc_attr_e( 'Child category', 'textdomain' ); ?></option>
                            	</select>
                            	<select name="grandchild_cat" id="grandchild_cat" class="cd-select">
                            		<option value="0"><?php echo esc_attr_e( 'Grandchild category', 'textdomain' ); ?></option>
                            	</select>
                            	</label>
                        	</li>
                        </ul>
                        <input type="hidden" name="submitted" id="submitted" value="true" />
                        <button type="submit" name="action" value="send" class="sendBtn">スレッドを作成</button>
                    </form>
                </div>
            </section>
        </div>
		<?php get_sidebar(); ?>
    </div>
<?php get_footer(); ?>
<style>
li .selectArea select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    padding: 5px 30px 5px 10px;
    border: solid 1px #c9c9c9;
    border-radius: 5px;
}
.categoryArea {
    margin-bottom: 5%;
    text-align: center;
    margin-left: 2%;
}
.answerInpotList {
    margin-bottom: 5%;
    text-align: center;
}
.categoryArea li select {
    width: 30%;
    margin-right: 2%;
    background-color: #DCDCDC;
}
.answerInpotList li div label{
    width: 40%;
    margin-right: 5%;
}
.answerInpotList li div label input{
    margin-right: 5px;
}
</style>
<script>
	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	var max_upload_picture = "<?php echo get_option('spc_options')['thread_img_no']; ?>";
</script>
<script src="<?php bloginfo('template_directory'); ?>/js/notice-board.js"></script>