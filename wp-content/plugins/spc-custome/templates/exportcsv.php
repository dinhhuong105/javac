<?php
global $post;
$id = isset($post->ID)?$post->ID:$_GET['post'];
$param = array(
    'post_id'=> $id
);

$comments = get_comments($param);
$answer = array();
$comment_metas = array();
$question = array();
$number_answer = 0;
foreach ($comments as $comment) {
	$comment_metas[] = get_comment_meta($comment->comment_ID,'_question_comment',true);
}

foreach ($comment_metas as $key => $answ) {
	
	if($answ){
		$number_answer +=1;
		foreach ($answ as $id_ques => $ans_detail) {
			if(isset($question[$id_ques])){
				array_push($question[$id_ques],$ans_detail);
			}else{
				$question[$id_ques][0] = $ans_detail;
			}
		}
	}
}
$report_ans = array();
foreach ($question as $key => $value) {
	$_ans = array();
	foreach ($value as $v) {
		// if()
		foreach ($v as $type => $id_ans) {
			array_push($_ans,$id_ans);
		}
		
	}
	$report_ans[$key] = array_count_values($_ans);
}
// global $post_metas;
$post_metas = get_post_meta($id, '_question_type', TRUE);
$_limited_answer = get_metadata('post', $id, '_limited_answer');
$csv = array();
?>
<style type="text/css">
	.report{
	    padding: 20px;
    	border: 1px solid #ccc;
	}
	.report ul li{
		padding-left: 20px;
		list-style-type: decimal;
	}
	.page-title-action{
	    margin-left: 4px;
	    padding: 4px 8px;
	    position: relative;
	    top: -3px;
	    text-decoration: none;
	    border: none;
	    border: 1px solid #ccc;
	    -webkit-border-radius: 2px;
	    border-radius: 2px;
	    background: #f7f7f7;
	    text-shadow: none;
	    font-weight: 600;
	    font-size: 13px;
	    cursor: pointer;
	}
	.page-title-action:hover {
	    border-color: #008EC2;
	    background: #00a0d2;
	    color: #fff;
	}
	.postbox{
		padding: 20px;
		margin-top: 20px;
		position:relative;
	}
	.btn{
		position: absolute;
		right: 20px;
	}
</style>
<?php if($post_metas): ?>
<div class="row postbox" id="revisionsdiv">
	<div class="btn">
		<span id="loading"></span>
		<button class="btn-limit  page-title-action" data-post="<?=$id?>" data-status="<?=$_limited_answer[0]?>"><?=($_limited_answer[0] > 0)?'回答受付中':'停止中'?></button>
		<button class="btn-public page-title-action" data-post="<?=$id?>" data-status="<?=get_post_status($id)?>" ><?=get_post_status($id) == 'publish'?'publish':'private'?>Publishing</button>
	</div>
<h2 class="hndle ui-sortable-handle"><span>アンケート詳細</span></h2>
	<ul>
		<li class="report">
			<label>回答数</label><br/><b><?=$number_answer?></b>件
		</li>
		<?php 
		
		foreach ($post_metas[$id] as $key => $value): 
			$csv[$key]['question'] = $value['question'];
		?>
			<li class="report">
				<label>設問 <?=$key+1?></label><br/>
				<h2 class="hndle ui-sortable-handle"><?=$value['question']?></h2><br/>
				<ul>
				<?php 
				if(isset($value['answer'])) :
					foreach ($value['answer'] as $k_ques => $ans): 
						$csv[$key][$ans] = $report_ans[$key][$k_ques];
						?>
						<li><?=$ans?> ... <?=$report_ans[$key][$k_ques]?></li>
				<?php endforeach;
				else: 
					if($report_ans[$key]):
					 foreach ($report_ans[$key] as $answer => $count): 
						$csv[$key][$answer] = $count;
					?>
						<li><?=$answer?> ... <?=$count?></li>
					<?php endforeach; 
					endif;
				endif;
				?>
				</ul>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
<div class="exportCSV"> 
	<a class="page-title-action" href="/wp-admin/admin-post.php?action=exportcsv&post=<?=$id?>"> CSV出力 </a>
</div>
<?php endif;
?>
<script type="text/javascript">
jQuery(document).ready(function($){
	$('.btn-limit').on('click',function(e){
		e.preventDefault();
		var post_id = $(this).attr('data-post');
		var status = $(this).attr('data-status');
		var $button = $(this);
		$button.parent().find('#loading').append('処理...');
		$button.attr("disabled", true);
		$.ajax({
			type: 'POST',
			url : ajaxurl,
			data:{
				'action' : 'limited_comment',
				'post_ID' : post_id,
				'status' : status
			},
			success:function(res){
				console.log(res);
				if(res['status'] < 0){
					$button.html('停止中');
				}else{
					$button.html('回答受付中');
				}
				$button.attr('data-status',res['status']);
				$button.attr("disabled", false);
				$button.parent().find('#loading').empty();
			}
		});
	});
	$('.btn-public').on('click',function(e){
		// return;
		e.preventDefault();
		var post_id = $(this).attr('data-post');
		var status = $(this).attr('data-status');
		var $button = $(this);
		$button.parent().find('#loading').append('処理...');
		$button.attr("disabled", true);
		$.ajax({
			type: 'POST',
			url : ajaxurl,
			data:{
				'action' : 'post_status',
				'post_ID' : post_id,
				'status' : status
			},
			success:function(res){
				console.log(res);
				if(res['status'] == 'publish'){
					$button.html('publish');
				}else{
					$button.html('private');
				}
				$button.attr('data-status',res['status']);
				$button.attr("disabled", false);
				$button.parent().find('#loading').empty();
			}
		});
	});

	// Scroll to comment
	var comment_id_scroll = <?php if(isset($_GET['comment_id_scroll'])) echo $_GET['comment_id_scroll']; else echo 0?>;
	if(comment_id_scroll > 0){
		$('html, body').animate({
		        scrollTop: $("#comment_"+comment_id_scroll).offset().top - 32
		    }, 2000);
	}
});
</script>

