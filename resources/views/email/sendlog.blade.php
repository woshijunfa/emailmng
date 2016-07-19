@extends('layout.main')
@section('title', '邮件管理')
@section('content')

<div class="row">
	<div class="col-xs-12">
		<a href="/content/add" class="btn btn-white btn-primary">新加文章</a>
		<hr>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<table id="simple-table" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>id</th>
					<th>pici</th>
					<th>发送标题</th>
					<th>创建时间</th>
					<th>发送时间</th>
					<th>发送结束时间</th>
					<th>总数量</th>
					<th>成功数量</th>
					<th>状态</th>
					<th>操作</th>
				</tr>
			</thead>

			<tbody>

				@foreach($logs as $log)
				<tr>
					<td>{{ $log->id or 0 }}</td>
					<td>{{ $log->pici or '' }}</td>
					<td>{{ $log->title or '' }}</td>
					<td>{{ $log->created_at or '' }}</td>
					<td>{{ $log->send_time or '' }}</td>
					<td>{{ $log->end_time or '' }}</td>
					<td>{{ $log->total_count or '' }}</td>
					<td>{{ $log->success_count or '' }}</td>
					<td>{{ $log->getStatus() }}</td>
					<td>
						@if($log->status == 'init')
						<button onclick="javascript:beginSend({{$log->id}})" class="btn btn-white btn-sm btn-primary">开始发送</button>
						@endif
						@if($log->status == 'sending')
						<button onclick="javascript:endSend({{$log->id}})" class="btn btn-white btn-sm btn-primary">停止发送</button>
						@endif
					</td>
				</tr>
				@endforeach
				
			</tbody>
		</table>
	</div><!-- /.span -->
</div>

<script type="text/javascript">
	
	function beginSend(id)
	{
		var postdata = {};
		postdata['id'] = id;
		postdata['_token'] = '{{csrf_token()}}';

        //登录操作
        $.post('/email/pici/beginsend', postdata,
        function(data){
            if (data.code !=0) {
            	alert(data.message);
            }else{
            	alert("操作成功");
            	window.location.href=window.location.href;
            }

        });
	}

	function endSend(id)
	{
		var postdata = {};
		postdata['id'] = id;
		postdata['_token'] = '{{csrf_token()}}';

        //登录操作
        $.post('/email/pici/endsend', postdata,
        function(data){
            if (data.code !=0) {
            	alert(data.message);
            }else{
            	alert("操作成功");
            	window.location.href=window.location.href;
            }

        });
	}

</script>
@stop
