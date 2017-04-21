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
// echo "<pre>";print_r($post_metas);echo "</pre>";
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
	}
	.page-title-action:hover {
	    border-color: #008EC2;
	    background: #00a0d2;
	    color: #fff;
	}
	.postbox{
		padding: 20px;
		margin-top: 20px;
	}
</style>
<?php if($post_metas): ?>
<div class="row postbox" id="revisionsdiv">
<button>Limit Answer</button>
<button>Publishing</button>
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
					?>
					<?php foreach ($report_ans[$key] as $answer => $count): 
						$csv[$key][$answer] = $count;
					?>
						<li><?=$answer?> ... <?=$count?></li>
					<?php endforeach ?>
				<?php
				endif
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


