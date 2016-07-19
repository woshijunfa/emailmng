@extends('layout.main')
@section('title', '添加文章')
@section('content')

<div class="row">
	<div class="col-xs-12">
		<form class="form-horizontal" role="form">
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">标题</label>

				<div class="col-sm-9">
					<input type="text" id="title" value="@if(!empty($content)) {{$content->title}} @endif" placeholder="title" class="col-xs-10 col-sm-5">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right"  for="form-field-1-1"> 是否有效</label>

				<div class="col-sm-9">
					<input type="text" id="is_valid" placeholder="0 or 1" value='@if(!empty($content)){{$content->is_valid}}@endif' class="col-xs-10  col-sm-5">
				</div>
			</div>

				<div class="wysiwyg-editor"  style="max-height:600px;height:500px;" id="editor">

				@if(!empty($content)) {!! $content->h_content !!} @endif
				</div>

			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<button id="addcontent" class="btn btn-info" type="button">
						<i class="ace-icon fa fa-check bigger-110"></i>
						提交
					</button>
				</div>
			</div>

		</form>
	</div><!-- /.span -->
</div>

<script type="text/javascript">
	$("#addcontent").click(function(){

		var title = $("#title").val();
		var is_valid = $("#is_valid").val();
		var content = $('#editor').html();

		if (title.length < 1 || is_valid.length < 1 || content.length < 1) {
			alert("请检查内容");
			return false;
		}

		var postdata = {};
		postdata['title'] = title;
		postdata['is_valid'] = is_valid;
		postdata['content'] = content;
		postdata['id'] = @if(empty($content))''@else {{$content->id}}@endif;
		postdata['_token'] = '{{csrf_token()}}';

        //登录操作
        $.post('/content/addpost', postdata,
        function(data){
            if (data.code !=0) {
            	alert(data.message);
            }else{
            	alert("添加成功");
            	window.location.href=window.location.href;
            }

        });


	});

</script>

<!-- page specific plugin scripts -->

<!-- <script src="../assets/js/markdown/markdown.js"></script> 
<script src="../assets/js/markdown/bootstrap-markdown.js"></script>
<script src="../assets/js/jquery.hotkeys.js"></script>
<script src="../assets/js/bootstrap-wysiwyg.js"></script>
<script src="../assets/js/bootbox.js"></script>-->

<!-- ace scripts -->
<script type="text/javascript">
	jQuery(function($){

		function showErrorAlert (reason, detail) {
			var msg='';
			if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
			else {
				//console.log("error uploading file", reason, detail);
			}
			$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
			 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
		}

		$('#editor').ace_wysiwyg({
		toolbar:
		[
			'font',
			null,
			'fontSize',
			null,
			{name:'bold', className:'btn-info'},
			{name:'italic', className:'btn-info'},
			{name:'strikethrough', className:'btn-info'},
			{name:'underline', className:'btn-info'},
			null,
			{name:'insertunorderedlist', className:'btn-success'},
			{name:'insertorderedlist', className:'btn-success'},
			{name:'outdent', className:'btn-purple'},
			{name:'indent', className:'btn-purple'},
			null,
			{name:'justifyleft', className:'btn-primary'},
			{name:'justifycenter', className:'btn-primary'},
			{name:'justifyright', className:'btn-primary'},
			{name:'justifyfull', className:'btn-inverse'},
			null,
			{name:'createLink', className:'btn-pink'},
			{name:'unlink', className:'btn-pink'},
			null,
			{name:'insertImage', className:'btn-success'},
			null,
			'foreColor',
			null,
			{name:'undo', className:'btn-grey'},
			{name:'redo', className:'btn-grey'}
		],
		'wysiwyg': {
			fileUploadError: showErrorAlert
		}
	}).prev().addClass('wysiwyg-style2');

	});

</script>
@stop
