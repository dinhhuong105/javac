<?php 
	$_question_description = get_post_meta($post->ID, '_question_description', TRUE);
	$_limited_answer = get_metadata('post', $post->ID, '_limited_answer');
	$post_metas = get_metadata('post', $post->ID, '_question_type');
	$GLOBALS['post_metas'] = $post_metas[0];
?>
<style type="text/css">
	.box-question{
		padding: 20px;
		border: 1px solid #ccc;
		margin: 10px 0; 
		position: relative;
		min-height: 90px;
	}
	.btn-group{
		position: absolute;
		right: 5px;
		top: 5px;
		display: none;
		cursor: pointer;
	}
	li.ui-state-default:hover .btn-group{
		display: block;
	}
	.btn-group a{
		display: block;
	    padding: 1px 3px;
	    border: 1px solid #f1f1f1;
	}
	.row{
		padding: 10px 0;
	}
	.dragged {
	  position: absolute;
	  opacity: 0.5;
	  z-index: 2000;
	}
	div#ui-sortabl div.box-question {
	  position: relative;
	  /** More li styles **/
	}
</style>
<div class="row">
	<label> コメント説明欄 :  <input type="text" name="ques_description" value="<?=$_question_description?>" style="width: 70%"></label>
</div>
<hr>
<div id="frm_question" class="meta-box-sortables ui-sortable">
	<ul id="sortable">
	<?php 
		if($post_metas[0]){
			foreach ($post_metas[0] as $key => $post_meta) {
				foreach ($post_meta as $id => $meta) {
					$check = isset($meta['required'])?"checked='checked'":"";
					if($meta['type'] == 'checkbox'){
						echo '<li class="ui-state-default">';
						echo '<div class="box-question holddiv" id="ques'.$id.'">
						<div class="btn-group">
							<a class="btn_first btn"><span class="dashicons dashicons-arrow-up-alt2"></span></a>
							<a class="btn_up btn"><span class="dashicons dashicons-arrow-up"></span></a>
							<a class="btn_remove"><span class="dashicons dashicons-no-alt"></span></a>
							<a class="btn_down btn"><span class="dashicons dashicons-arrow-down"></span></a>
							<a class="btn_last btn"><span class="dashicons dashicons-arrow-down-alt2"></span></a>
							<input type="hidden" name="_sort_question[]" value="'.$id.'"/>
						</div>';
						echo '<input type="hidden" name="question['. $key .']['. $id .'][type]" value="'.$meta['type'].'">';
						echo '<label for="posid_'. $key .'_question_' . $id . '">アンケート項目 </label>';
						echo '<input id="posid_'. $key .'_question_' . $id . '" type="text" name="question['. $key .']['. $id .'][question]" value="'.$meta['question'].'" required><label> 必須 :  <input type="checkbox" name="question['. $key .']['. $id .'][required]" '.$check.' ></label><br/>';
						$i=0;
						foreach ($meta['answer'] as $answer) {
							echo '<input type="checkbox" name="posid_'. $key .'_answer_'. $id .'_' . $i . '"> 
							<input type="text" name="question['. $key .']['. $id .'][answer]['.$i.']" value="'.$answer.'"><br/>';
							$i++;
						}
						echo '</div></li>';
					}elseif($meta['type'] == 'radio'){
						echo '<li class="ui-state-default">';
						echo '<div class="box-question holddiv" id="ques'.$id.'">
						<div class="btn-group">
							<a class="btn_first btn"><span class="dashicons dashicons-arrow-up-alt2"></span></a>
							<a class="btn_up btn"><span class="dashicons dashicons-arrow-up"></span></a>
							<a class="btn_remove"><span class="dashicons dashicons-no-alt"></span></a>
							<a class="btn_down btn"><span class="dashicons dashicons-arrow-down"></span></a>
							<a class="btn_last btn"><span class="dashicons dashicons-arrow-down-alt2"></span></a>
							<input type="hidden" name="_sort_question[]" value="'.$id.'"/>
						</div>';
						echo '<input type="hidden" name="question['. $key .']['. $id .'][type]" value="'.$meta['type'].'">';
						echo '<label for="posid_'. $key .'_question_' . $id . '">アンケート項目</label>';
						echo '<input id="posid_'. $key .'_question_' . $id . '" type="text" name="question['. $key .']['. $id .'][question]" value="'.$meta['question'].'" required><label> 必須 :  <input type="checkbox" name="question['. $key .']['. $id .'][required]" '.$check.' ></label><br/>';
						$i=0;
						foreach ($meta['answer'] as $answer) {
							echo '<input type="radio" name="posid_'. $key .'_answer_'. $id .'"> 
							<input type="text" name="question['. $key .']['. $id .'][answer]['.$i.']" value="'.$answer.'"><br/>';
							$i++;
						}
						echo '</div></li>';
					}elseif($meta['type'] == 'pulldown'){
						echo '<li class="ui-state-default">';
						echo '<div class="box-question holddiv" id="ques'.$id.'">
						<div class="btn-group">
							<a class="btn_first btn"><span class="dashicons dashicons-arrow-up-alt2"></span></a>
							<a class="btn_up btn"><span class="dashicons dashicons-arrow-up"></span></a>
							<a class="btn_remove"><span class="dashicons dashicons-no-alt"></span></a>
							<a class="btn_down btn"><span class="dashicons dashicons-arrow-down"></span></a>
							<a class="btn_last btn"><span class="dashicons dashicons-arrow-down-alt2"></span></a>
							<input type="hidden" name="_sort_question[]" value="'.$id.'"/>
						</div>';
						echo '<input type="hidden" name="question['. $key .']['. $id .'][type]" value="'.$meta['type'].'">';
						echo '<label for="posid_'. $key .'_question_' . $id . '">アンケート項目</label>';
						echo '<input id="posid_'. $key .'_question_' . $id . '" type="text" name="question['. $key .']['. $id .'][question]" value="'.$meta['question'].'" required><label> 必須 :  <input type="checkbox" name="question['. $key .']['. $id .'][required]" '.$check.' ></label><br/>';
						$i=0;
						foreach ($meta['answer'] as $answer) {
							echo '<input type="text" name="question['. $key .']['. $id .'][answer]['.$i.']" value="'.$answer.'"><br/>';
							$i++;
						}
						echo '</div></li>';
					}elseif($meta['type'] == 'textbox'){
						echo '<li class="ui-state-default">';
						echo '<div class="box-question holddiv" id="ques'.$id.'">
						<div class="btn-group">
							<a class="btn_first btn"><span class="dashicons dashicons-arrow-up-alt2"></span></a>
							<a class="btn_up btn"><span class="dashicons dashicons-arrow-up"></span></a>
							<a class="btn_remove"><span class="dashicons dashicons-no-alt"></span></a>
							<a class="btn_down btn"><span class="dashicons dashicons-arrow-down"></span></a>
							<a class="btn_last btn"><span class="dashicons dashicons-arrow-down-alt2"></span></a>
							<input type="hidden" name="_sort_question[]" value="'.$id.'"/>
						</div>';
						echo '<input type="hidden" name="question['. $key .']['. $id .'][type]" value="'.$meta['type'].'">';
						echo '<label for="posid_'. $key .'_question_' . $id . '">アンケート項目</label>';
						echo '<input id="posid_'. $key .'_question_' . $id . '" type="text" name="question['. $key .']['. $id .'][question]" value="'.$meta['question'].'" required><label> 必須 :  <input type="checkbox" name="question['. $key .']['. $id .'][required]" '.$check.' ></label><br/>';
						echo '</div></li>';
					}elseif($meta['type'] == 'textarea'){
						echo '<li class="ui-state-default">';
						echo '<div class="box-question holddiv" id="ques'.$id.'">
						<div class="btn-group">
							<a class="btn_first btn"><span class="dashicons dashicons-arrow-up-alt2"></span></a>
							<a class="btn_up btn"><span class="dashicons dashicons-arrow-up"></span></a>
							<a class="btn_remove"><span class="dashicons dashicons-no-alt"></span></a>
							<a class="btn_down btn"><span class="dashicons dashicons-arrow-down"></span></a>
							<a class="btn_last btn"><span class="dashicons dashicons-arrow-down-alt2"></span></a>
							<input type="hidden" name="_sort_question[]" value="'.$id.'"/>
						</div>';
						echo '<input type="hidden" name="question['. $key .']['. $id .'][type]" value="'.$meta['type'].'">';
						echo '<label for="posid_'. $key .'_question_' . $id . '">アンケート項目</label>';
						echo '<input id="posid_'. $key .'_question_' . $id . '" type="text" name="question['. $key .']['. $id .'][question]" value="'.$meta['question'].'" required><label> 必須 :  <input type="checkbox" name="question['. $key .']['. $id .'][required]" '.$check.' ></label><br/>';
						echo '</div></li>';
					}
					
				}
			}
		}
	?>
	</ul>
<?php wp_enqueue_script( array(">jquery", "jquery-ui-core", "interface", "jquery-ui-sortable", "wp-lists", "jquery-ui-sortable") ); ?>
	
</div>
<label for="link_download">アンケート項目 </label>
<select name="question_type">
	<option value="">設問タイプ</option>
	<option value="radio">ラジオボタン</option>
	<option value="checkbox">チェックボックス</option>
	<option value="pulldown">プルダウン</option>
	<option value="textbox">テキストボックス</option>
	<option value="textarea">テキストエリア</option>
</select>
<input type="number" name="no_of_item" value="2" placeholder="（項目数）">
<button class="btn_create">作成</button>
<hr>
<label for="limited_answer">リミット回答数 ></label>
<input type="number" name="limited_answer" id="limited_answer" value="<?php echo $_limited_answer[0]; ?>" placeholder="回答数を入力"><label> 件</label>
<?php 
	wp_enqueue_script('jquery'); 
?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
var post_id = <?=$post->ID?>;
jQuery(document).ready(function($){
	var id_frm = $('.box-question').length;

	$('.btn_create').on('click',function(e){
		e.preventDefault();
		var id = id_frm++;
		var number_question = $('input[name=no_of_item]').val();

		var str = '';
			str += '<div class="box-question">';
			str += '<div class="btn-group"><a class="btn_first btn"><span class="dashicons dashicons-arrow-up-alt2"></span></a><a class="btn_up btn"><span class="dashicons dashicons-arrow-up"></span></a><a class="btn_remove"><span class="dashicons dashicons-no-alt"></span></a><a class="btn_down btn"><span class="dashicons dashicons-arrow-down"></span></a><a class="btn_last btn"><span class="dashicons dashicons-arrow-down-alt2"></span></a><input type="hidden" name="_sort_question[]" value="'+id+'"/></div>';
			str += hidden($('select[name=question_type] :selected').val(),id);
			str += question_input(id,1);
			str += "<br/><br/>"
		if($('select[name=question_type] :selected').val() == 'checkbox'){
			str += checkbox( id,number_question );
		}else if($('select[name=question_type] :selected').val() == 'radio'){
			str += radio( id,number_question );
		}else if($('select[name=question_type] :selected').val() == 'pulldown'){
			str += pulldown( id,number_question );
		}else if($('select[name=question_type] :selected').val() == 'textbox'){
			// str += pulldown( id,1 );
		}else if($('select[name=question_type] :selected').val() == 'textarea'){

		}else{
			return;
		}
		str += '</div>';
		$('#frm_question ul').append('<li class="ui-state-default">'+str+'</li>');

	});

	$('select[name=question_type]').on('change',function(){
		if($(this).val() == 'textbox' || $(this).val() == 'textarea'){
			$('input[name=no_of_item]').attr('disabled','disabled');
		}else{
			$('input[name=no_of_item]').removeAttr('disabled');
		}
	});

	$( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();

    $('#frm_question').on('click','li a.btn_up',function(){
	  var current = $(this).closest('li.ui-state-default');
	  console.log(current);
	  current.prev().before(current);
	});

	$('#frm_question').on('click','li a.btn_first',function(){
	  var current = $(this).parents('li');
	  var prevli = current.prev();
	  while(prevli.length > 0){
	 	current.prev().before(current);
	  	prevli = current.prev();
	  }
	  $('html, body').animate({ scrollTop: $("#frm_question").offset().top - 200 }, 200);
	});

	$('#frm_question').on('click','li a.btn_down',function(){
	  var current = $(this).closest('li.ui-state-default');
	  current.next().after(current);
	});

	$('#frm_question').on('click','li a.btn_last',function(){
	  var current = $(this).parents('li');
	  var nextli = current.next();
	  while(nextli.length > 0){
	 	current.next().after(current);
	  	nextli = current.next();
	  }
	  $('html, body').animate({ scrollTop: $("#frm_question").offset().top + $("#frm_question").outerHeight(true)-200  }, 200);
	});

});
jQuery(document).on('click', '.btn_remove', function($){
	var res = confirm('あなたはそれを削除したいですか？');
		if(res) jQuery(this).closest('li').remove();
		
});

function question_input($id,$multi = 1){
	var $str = '';
	//posid_'+ post_id +'_question_' + $id + '
	for(var i=0; i<$multi; i++){
		$str += '<label for="posid_'+ post_id +'_question_' + $id + '">アンケート項目 </label><input id="posid_'+ post_id +'_question_' + $id + '" type="text" name="question['+ post_id +']['+ $id +'][question]" required> <label> 必須 :  <input type="checkbox" name="question['+post_id+']['+ $id +'][required]" checked="checked" ></label>';
	}
	return $str;
}

function checkbox($id,$multi){
	var $str = '';
	for(var i=0; i<$multi; i++){
		$str += '<input type="checkbox" name="posid_'+ post_id +'_answer_'+ $id +'_' + i + '"> <input type="text" name="question['+ post_id +']['+ $id +'][answer]['+i+']"><br/>';
	}
	return $str;
}

function radio($id,$multi){
	var $str = '';
	for(var i=0; i<$multi; i++){
		$str += '<input type="radio" name="posid_'+ post_id +'_answer_'+ $id +'"> <input type="text" name="question['+ post_id +']['+ $id +'][answer]['+i+']"><br/>';
	}
	return $str;
}

function pulldown($id, $multi){
	var $str = '';
	for(var i=0; i<$multi; i++){
		$str += '<input id="posid_'+ post_id +'_answer_' + $id + '" type="text" name="question['+ post_id +']['+ $id +'][answer]['+i+']"><br>';
	}
	return $str;
}

function textbox($id, $multi = 1){
	return;
}

function textarea($id, $multi = 1){
	return '<textarea name="question['+ post_id +']['+ $id +'][answer]['+i+']"></textarea><br>';
}

function hidden($type,$id){
	return '<input type="hidden" name="question['+ post_id +']['+ $id +'][type]" value="'+$type+'">';
}
</script>
