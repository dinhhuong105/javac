// Check max upload image
//var count_upload = 1;
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#no_image').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#thread_thumb").change(function(){
    readURL(this);
});

var image_nums = 0;
$('#thread_content').bind('input propertychange', function() {
	var content_html = $("<div></div>");
	content_html.html($(this).val());
	image_nums = content_html.find('img').length;
});

$("#contentArea .imgBtn").click(function(e){
	if(image_nums >= max_upload_picture){
		alert("写真の添付可能枚数は"+max_upload_picture+"枚です。");
		e.preventDefault();
		return false;
	}
});

$("#content_image").change(function(e){
	e.preventDefault();
	if(image_nums >= max_upload_picture){
		alert("写真の添付可能枚数は"+max_upload_picture+"枚です。");
		return false;
	}
    var target = this;

    var form_data = new FormData();
    var file_data = $('#content_image').prop("files")[0];
    form_data.append('content_image', file_data);
    form_data.append('action', 'upload_image_thread');
    $("form :input").prop("disabled", true);
    $.ajax({
        type: 'POST',
        url: ajaxurl,
        data: form_data,
        cache: false,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(response){
            $("form :input").prop("disabled",false);
			if(response['status'] == 'OK'){
            	var html_image = '<img src="'+response['image_link']+'" alt="'+response['image_title']+'" width="960" height="1280" class="alignnone size-full wp-image-'+response['id']+'" />';
            	//$('#thread_content').append(html_image);
                // $('#thread_content').val( $('#thread_content').val() + " " + html_image );
            	$('#textareaEditor').html( $('#textareaEditor').html() + " " + html_image );
            	$('#thread_content').trigger('input');
            	//count_upload ++;
            }
        }
    });
});

// drag image
$(function () {
	// Drag and drop file
	$('#contentArea').on({
        dragenter: function(e) {
            //$(this).css('background-color', 'lightBlue');
        },
        dragleave: function(e) {
            $(this).css('background-color', 'white');
        },
        drop: function(e) {
            e.stopPropagation();
            e.preventDefault();
            if(image_nums >= max_upload_picture){
    			alert("写真の添付可能枚数は"+max_upload_picture+"枚です。");
    			return false;
        	}
            $("#content_image").prop("files", e.originalEvent.dataTransfer.files);
        }
    });

    // Change categories
    // change parent
    $('#parent_cat').on("change", function(e){
		var category_id = $(this).val();
		var result = $('#child_cat');
		result.find('option:not(:first)').remove();
		$('#grandchild_cat').find('option:not(:first)').remove();
    	$.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
				action: 'thread_change_category',
				id: category_id,
			},
            cache: false,
            dataType: 'json',
            success: function(response){
                for(var i in response){
					var option_html = '<option value="'+ response[i]['cat_ID'] + '">' + response[i]['cat_name'] + '</option>';
					result.append(option_html);
                }
            }
        });
    });

    // change child
    $('#child_cat').on("change", function(e){
		var category_id = $(this).val();
		var result = $('#grandchild_cat');
		result.find('option:not(:first)').remove();
    	$.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
				action: 'thread_change_category',
				id: category_id,
			},
            cache: false,
            dataType: 'json',
            success: function(response){
                for(var i in response){
					var option_html = '<option value="'+ response[i]['cat_ID'] + '">' + response[i]['cat_name'] + '</option>';
					result.append(option_html);
                }
            }
        });
    });

    /**
    * Confirm layout 
    * By : Mr.Uno
    */
    $("#preview").on('click',function(e){
        e.preventDefault();
        if($('#thread_title').val() == ""){
            $('#thread_title').addClass('error');
            $('#thread_title').focus();
            return false;
        }else{
            $('#thread_title').removeClass('error');
        }

        if($('#textareaEditor').html() == ""){
            $('.textArea').addClass('error');
            $('#textareaEditor').focus();
            return false;
        }else{
            $('.textArea').removeClass('error');
        }
        $('#confirm_no_image').attr('src',$('#no_image').attr('src'));
        $('#confirm_thread_title').html($('#thread_title').val());
        $('#confirm_thread_content').html($('#textareaEditor').html());
        $('#thread_content').val($('#textareaEditor').html());
        $('.inputForm').hide();
        $('.confirm').show();
    });

    $("#backBtn").on('click',function(e){
        e.preventDefault();
        $('.confirm').hide();
        $('.inputForm').show();
        var body = $("html, body");
        body.stop().animate({scrollTop:0}, 500, 'swing', function(){ });
        return false;
    });

    $("#threadAddForm").submit(function(e){
        e.preventDefault();
        $('.confirm').html('<div align="center"><img class="loading-img" src="/wp-content/plugins/report-content/static/img/loading.gif"/> 投稿中です。。。</div>');
        var body = $("html, body");
        body.stop().animate({scrollTop:0}, 500, 'swing', function(){ });
        var data = new FormData(this);
        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (res) {
                if(res.result == 'success'){
                    $('.confirm').hide();
                    $('.inputForm').hide();
                    $('.addthread-result').show();
                }else{
                	$('.addthread-result div h1').html('FAIL!');
                	$('.confirm').hide();
                    $('.inputForm').hide();
                    $('.addthread-result').show();
                }
            },
            error: function(res){
            	$('.addthread-result div h1').html('ERROR!');
            	$('.confirm').hide();
                $('.inputForm').hide();
                $('.addthread-result').show();
            }
        });
        return false;
    });
    $('#formComment').submit(function(){
        $('#thread_content').val($('#textareaEditor').html());
    });

    $('#textareaEditor').bind('paste',function(e){
        var pasteData = e.originalEvent.clipboardData.getData('text');
        var htmlConverter = $.parseHTML(pasteData);
        if(pasteData !== ""){
            $.each(htmlConverter, function(key, el) {
                console.log(el.nodeName);
                if(el.nodeName == 'IMG' || el.nodeName == '#text'){
                    // $('#textareaEditor').append(pasteData);
                    pasteHtmlAtCaret(pasteData);
                }
                return false;
            });
            return false;
        }
        
    });

    function pasteHtmlAtCaret(html) {
    var sel, range;
    if (window.getSelection) {
        // IE9 and non-IE
        sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            range = sel.getRangeAt(0);
            range.deleteContents();

            // Range.createContextualFragment() would be useful here but is
            // only relatively recently standardized and is not supported in
            // some browsers (IE9, for one)
            var el = document.createElement("div");
            el.innerHTML = html;
            var frag = document.createDocumentFragment(), node, lastNode;
            while ( (node = el.firstChild) ) {
                lastNode = frag.appendChild(node);
            }
            range.insertNode(frag);

            // Preserve the selection
            if (lastNode) {
                range = range.cloneRange();
                range.setStartAfter(lastNode);
                range.collapse(true);
                sel.removeAllRanges();
                sel.addRange(range);
            }
        }
    } else if (document.selection && document.selection.type != "Control") {
        // IE < 9
        document.selection.createRange().pasteHTML(html);
    }
}
});
