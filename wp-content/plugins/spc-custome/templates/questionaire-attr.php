<style type="text/css">
	.box-question{
		padding: 20px;
		border: 1px solid #ccc;
		margin: 10px 0; 
		position: relative;
	}
	.btn_remove{
		position: absolute;
		right: 5px;
		top: 5px;
		padding:1px 6px;
		border-radius: 10px 10px 10px 10px;
		-moz-border-radius: 10px 10px 10px 10px;
		-webkit-border-radius: 10px 10px 10px 10px;
		border: 1px solid #a0a0a0;
		cursor: pointer;
	}
</style>
<div id="frm_question">
	<?php 
		$_limited_answer = get_metadata('post', $post->ID, '_limited_answer');
		$post_metas = get_metadata('post', $post->ID, '_question_type');
		$GLOBALS['post_metas'] = $post_metas[0];
		if($post_metas[0]){
			foreach ($post_metas[0] as $key => $post_meta) {
				foreach ($post_meta as $id => $meta) {
					// print_r($meta);
					if($meta['type'] == 'checkbox'){
						echo '<div class="box-question"><a class="btn_remove">x</a>';
						echo '<input type="hidden" name="question['. $key .']['. $id .'][type]" value="'.$meta['type'].'">';
						echo '<label for="posid_'. $key .'_question_' . $id . '">アンケート項目 </label>';
						echo '<input id="posid_'. $key .'_question_' . $id . '" type="text" name="question['. $key .']['. $id .'][question]" value="'.$meta['question'].'" required><br/>';
						$i=0;
						foreach ($meta['answer'] as $answer) {
							echo '<input type="checkbox" name="posid_'. $key .'_answer_'. $id .'_' . $i . '"> 
							<input type="text" name="question['. $key .']['. $id .'][answer]['.$i.']" value="'.$answer.'"><br/>';
							$i++;
						}
						echo '</div>';
					}elseif($meta['type'] == 'radio'){
						echo '<div class="box-question"><a class="btn_remove">x</a>';
						echo '<input type="hidden" name="question['. $key .']['. $id .'][type]" value="'.$meta['type'].'">';
						echo '<label for="posid_'. $key .'_question_' . $id . '">アンケート項目</label>';
						echo '<input id="posid_'. $key .'_question_' . $id . '" type="text" name="question['. $key .']['. $id .'][question]" value="'.$meta['question'].'" required><br/>';
						$i=0;
						foreach ($meta['answer'] as $answer) {
							echo '<input type="radio" name="posid_'. $key .'_answer_'. $id .'"> 
							<input type="text" name="question['. $key .']['. $id .'][answer]['.$i.']" value="'.$answer.'"><br/>';
							$i++;
						}
						echo '</div>';
					}elseif($meta['type'] == 'pulldown'){
						echo '<div class="box-question"><a class="btn_remove">x</a>';
						echo '<input type="hidden" name="question['. $key .']['. $id .'][type]" value="'.$meta['type'].'">';
						echo '<label for="posid_'. $key .'_question_' . $id . '">アンケート項目</label>';
						echo '<input id="posid_'. $key .'_question_' . $id . '" type="text" name="question['. $key .']['. $id .'][question]" value="'.$meta['question'].'" required><br/>';
						$i=0;
						foreach ($meta['answer'] as $answer) {
							echo '<input type="text" name="question['. $key .']['. $id .'][answer]['.$i.']" value="'.$answer.'"><br/>';
							$i++;
						}
						echo '</div>';
					}elseif($meta['type'] == 'textbox'){
						echo '<div class="box-question"><a class="btn_remove">x</a>';
						echo '<input type="hidden" name="question['. $key .']['. $id .'][type]" value="'.$meta['type'].'">';
						echo '<label for="posid_'. $key .'_question_' . $id . '">アンケート項目</label>';
						echo '<input id="posid_'. $key .'_question_' . $id . '" type="text" name="question['. $key .']['. $id .'][question]" value="'.$meta['question'].'" required><br/>';
						echo '</div>';
					}elseif($meta['type'] == 'textarea'){
						echo '<div class="box-question"><a class="btn_remove">x</a>';
						echo '<input type="hidden" name="question['. $key .']['. $id .'][type]" value="'.$meta['type'].'">';
						echo '<label for="posid_'. $key .'_question_' . $id . '">アンケート項目</label>';
						echo '<input id="posid_'. $key .'_question_' . $id . '" type="text" name="question['. $key .']['. $id .'][question]" value="'.$meta['question'].'" required><br/>';
						echo '</div>';
					}
					
				}
			}
		}
	?>

	
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
<label for="limited_answer">リミット回答数 </label>
<input type="number" name="limited_answer" id="limited_answer" value="<?php echo $_limited_answer[0]; ?>" placeholder="回答数を入力"><label> 件</label>
<?php 
	wp_enqueue_script('jquery'); 
?>
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
			str += '<a class="btn_remove">x</a>';
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
		$('#frm_question').append(str);

	});

	$('select[name=question_type]').on('change',function(){
		if($(this).val() == 'textbox' || $(this).val() == 'textarea'){
			$('input[name=no_of_item]').attr('disabled','disabled');
		}else{
			$('input[name=no_of_item]').removeAttr('disabled');
		}
	});
});
jQuery(document).on('click', '.btn_remove', function($){
	var res = confirm('あなたはそれを削除したいですか？');
		if(res) jQuery(this).parent('div').remove();
		
});

function question_input($id,$multi = 1){
	var $str = '';
	//posid_'+ post_id +'_question_' + $id + '
	for(var i=0; i<$multi; i++){
		$str += '<label for="posid_'+ post_id +'_question_' + $id + '">アンケート項目 </label><input id="posid_'+ post_id +'_question_' + $id + '" type="text" name="question['+ post_id +']['+ $id +'][question]" required>';
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