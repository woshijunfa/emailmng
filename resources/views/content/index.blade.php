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
					<th>title</th>
					<th>创建时间</th>
					<th>操作</th>
				</tr>
			</thead>

			<tbody>

				@foreach($contents as $ar)
				<tr>
					<td>{{ $ar->id or 0 }}</td>
					<td>{{ $ar->title or '' }}</td>
					<td>{{ $ar->created_at or '' }}</td>
					<td>
						<a href="/content/add?id={{$ar->id}}" class="btn btn-white btn-sm btn-primary">编辑</a>
						<a href="/content/show/{{$ar->id}}" class="btn btn-white btn-sm btn-primary">预览</a>
					</td>
				</tr>
				@endforeach
				
			</tbody>
		</table>
	</div><!-- /.span -->
</div>
@stop
