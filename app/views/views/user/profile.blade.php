@extends('layouts.master')
@section('styleFile')
{{HTML::style('assets/admin/pages/css/profile.css')}}
{{HTML::style('assets/admin/pages/css/tasks.css')}}
@append
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="profile-sidebar">
			<div class="portlet light profile-sidebar-portlet">
				<div class="profile-userpic">
					<img src="{{Gravatar::src($user->email,250)}}" class="img-responsive" alt="">
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">
						 {{$user->fullname()}}
					</div>
				</div>
				<div class="profile-usermenu"></div>
				<!-- END MENU -->
			</div>
			<!-- END PORTLET MAIN -->
			<!-- PORTLET MAIN -->
			<div class="portlet light">
				<div>
					<h4 class="profile-desc-title">Kullanıcı Hakkında</h4>
					@if($user->profile->about)
					<span class="profile-desc-text">{{$user->profile->about}}</span>
					@else
					<span class="profile-desc-text">İçerik eklenmedi.</span>
					@endif
				</div>
			</div>
			<!-- END PORTLET MAIN -->
		</div>
		<!-- END BEGIN PROFILE SIDEBAR -->
		<!-- BEGIN PROFILE CONTENT -->
		<div class="profile-content">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title tabbable-line">
							<div class="caption caption-md">
								<i class="icon-globe theme-font hide"></i>
								<span class="caption-subject font-blue-madison bold uppercase">Kullanıcı Hesabı</span>
							</div>
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#personal-info" data-toggle="tab">Kişisel Bilgiler</a>
								</li>
								<li>
									<a href="#change-password" data-toggle="tab">Şifre Değiştir</a>
								</li>
							</ul>
						</div>
						<div class="portlet-body">
							@if($errors->has())
							<div class="alert alert-danger">
								<button class="close" data-close="alert"></button>
								@foreach($errors->all() as $error)
									<div class="help-block">{{$error}}</div>
								@endforeach
							</div>
							@endif
							@if(Session::has('messages'))
								<div class="alert alert-{{Session::get('messages')['status']}}">
									<button class="close" data-close="alert"></button>
									<div class="help-block">{{Session::get('messages')['text']}}</div>
								</div>
							@endif
							<div class="tab-content">
								<div class="tab-pane active" id="personal-info">
									{{Form::open(['url' => action('Back\UserController@postProfile')])}}
										{{Form::hidden('user_id', $user->id)}}
										@if(Auth::user()->group == 1)
											<div class="form-group">
												{{Form::label('group', 'Kullanıcı Adı', ['class' => 'control-label'])}}
												{{Form::text('username',$user->username)}}
											</div>
										@endif
										<div class="form-group @if($errors->has('firstname')) has-error @endif">
											{{Form::label('firstname', 'Ad', ['class' => 'control-label'])}}
											{{Form::text('firstname',$user->profile->firstname)}}
										</div>
										<div class="form-group @if($errors->has('lastname')) has-error @endif">
											{{Form::label('lastname', 'Soyad', ['class' => 'control-label'])}}
											{{Form::text('lastname',$user->profile->lastname)}}
										</div>
										@if(Auth::user()->group == 1)
											<div class="form-group">
												{{Form::label('group', 'Kullanıcı Grubu', ['class' => 'control-label'])}}
												{{Form::select('group', \Helper::groups(), $user->group)}}
											</div>
										@endif
										<div class="form-group">
											{{Form::label('about', 'Hakkında', ['class' => 'control-label'])}}
											{{Form::textarea('about',$user->profile->about, ['rows' => 3])}}
										</div>
										<div class="margiv-top-10">
											{{Form::submit('Güncelle',['class' => 'btn green-haze'])}}
										</div>
									{{Form::close()}}
								</div>
								<div class="tab-pane" id="change-password">
									{{Form::open(['url' => action('Back\UserController@postChangePassword')])}}
										{{Form::hidden('user_id', $user->id)}}
										<div class="form-group @if($errors->has('password')) has-error @endif">
											{{Form::label('password', 'Yeni Şifre', ['class' => 'control-label'])}}
											{{Form::password('password')}}
										</div>
										<div class="form-group @if($errors->has('password_confirmation')) has-error @endif">
											{{Form::label('password_confirmation', 'Yeni Şifre (Tekrar)', ['class' => 'control-label'])}}
											{{Form::password('password_confirmation')}}
										</div>
										<div class="margiv-top-10">
											{{Form::submit('Güncelle',['class' => 'btn green-haze'])}}
										</div>
									{{Form::close()}}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END PROFILE CONTENT -->
	</div>
</div>
@stop