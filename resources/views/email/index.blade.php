@extends('layout.main')
@section('title', '邮件管理')
@section('content')

<div class="row">
	<div class="col-xs-12">
		<form class="form-horizontal" role="form">
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">选择发送内容</label>

				<div class="col-sm-3">
					<select class="form-control" id="content_id" class="col-xs-10">
						@foreach($contents as $content)
						<option  value="{{$content->id}}">{{$content->title or ''}}</option>
						@endforeach
					</select>
				</div>

				<label class="col-sm-1 control-label no-padding-right"  for="form-field-1-1">发送批次</label>

				<div class="col-sm-3">
					<select class="form-control" id="pici" class="col-xs-10">
						@foreach($picis as $pici)
						<option  value="{{$pici->pici}}">{{$pici->pici or ''}}</option>
						@endforeach
					</select>
				</div>

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

		var contentid = $("#content_id").val();
		var pici = $("#pici").val();

		var postdata = {};
		postdata['contentid'] = contentid;
		postdata['pici'] = pici;
		postdata['_token'] = '{{csrf_token()}}';

        //登录操作
        $.post('/email/addpici', postdata,
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

@stop
