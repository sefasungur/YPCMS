@extends('layouts.master')
@section('styleFile')
{{HTML::style('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}
{{HTML::style('assets/admin/pages/css/profile.css')}}
{{HTML::style('assets/admin/pages/css/tasks.css')}}
@append

@section('scriptCodes')
<script type="text/javascript">
jQuery(document).ready(function($) {
	Profile.init();
});
</script>
@append
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title tabbable-line">
				<div class="caption caption-md">
					<i class="icon-globe theme-font hide"></i>
					<span class="caption-subject font-blue-madison bold uppercase">Kullanıcılar</span>
				</div>
			</div>
			<div class="portlet-body">
				<table class="table table-bordered">
					<thead>
						<th>#</th>
						<th>Kullanıcı Adı</th>
						<th>Ad Soyad</th>
						<th>e Posta</th>
						<th>Oluşturulma Tarihi</th>
						<th>İşlemler</th>
					</thead>
					<tbody>
						@foreach($users as $user)
						<tr>
							<td>{{$user->id}}</td>
							<td>{{$user->username}}</td>
							<td>{{$user->fullname()}}</td>
							<td>{{$user->email}}</td>
							<td>{{$user->created_at}}</td>
							<td>
								<a href="{{action('Back\UserController@getProfile',$user->id)}}" data-toggle="tooltip" title="Düzenle">
									<i class="fa fa-edit"></i>
								</a>
								<a href="{{action('Back\UserController@getDelete',$user->id)}}" data-toggle="tooltip" title="Sil">
									<i class="fa fa-remove"></i>
								</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@stop