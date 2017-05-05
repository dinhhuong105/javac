<?php get_header();?>
<?php add_thread_front();?>
    <div id="sb-site" class="mainWrap single addthread wrapper">
        <div id="breadcrumb">
    		<ul class="breadcrumbList">
    			<li><a href="<?php echo home_url('/'); ?>">トップ</a></li>
    			<li><i class="fa fa-angle-right arrowIcon"></i><a href="<?php echo home_url('/'); ?>notice"><span>質問掲示板</span></a></li>
    			<li><i class="fa fa-angle-right arrowIcon"></i><span>新規スレッド作成</span></li>
    		</ul>
    	</div>
    	<section class="threadFormArea">
            <h1 class="heading">新規スレッド作成</h1>
            <form action="" id="threadAddForm" method="POST" enctype="multipart/form-data">
                <ul class="threadList">
                    <li>
                        <div class="imgArea">
                            <img src="<?php bloginfo('template_directory'); ?>/images/noimage.png" id="no_image" alt="画像" width="80" height="80">
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
                <!--<ul class="answerInpotList">
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
                </ul>-->
                <!--<ul class="categoryArea">
                	<li>
                    	<label for="select" class="selectArea">
                    	<select name="parent_cat" id="parent_cat"> 
                            <option value="0">親カテゴリー</option> 
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
                    		<option value="0">子カテゴリー</option>
                    	</select>
                    	<select name="grandchild_cat" id="grandchild_cat" class="cd-select">
                    		<option value="0">孫カテゴリー</option>
                    	</select>
                    	</label>
                	</li>
                </ul>-->
                <input type="hidden" name="submitted" id="submitted" value="true" />
                <button type="submit" name="action" value="send" class="sendBtn">スレッドを作成</button>
            </form>
        </section>
    </div>
<?php get_footer(); ?>
<script>
	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	var max_upload_picture = "<?php echo get_option('spc_options')['thread_img_no']; ?>";
</script>
<script src="<?php bloginfo('template_directory'); ?>/js/notice-board.js"></script>