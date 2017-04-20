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

$(".imgBtn").click(function(e){
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
            	$('#thread_content').val( $('#thread_content').val() + " " + html_image );
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
            $(this).css('background-color', 'lightBlue');
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
    
    // Sort list comment
    $('#qaSort').on("change", function(e){
		var target = $(this);
		var current_link = window.location.origin + window.location.pathname;
		window.location = current_link + '?comment_order_by=' + target.val();
    });
})