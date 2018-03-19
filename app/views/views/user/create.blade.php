@extends('layouts.master')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption caption-md">
					<i class="icon-globe theme-font hide"></i>
					<span class="caption-subject font-blue-madison bold uppercase">Yeni Kullanıcı</span>
				</div>
			</div>
			<div class="portlet-body">
				<div class="row">
					<div class="col-md-8">
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
							{{Form::open(['url' => action('Back\UserController@postCreate')])}}
								<div class="form-group @if($errors->has('username')) has-error @endif">
									{{Form::label('username', 'Kullanıcı Adı', ['class' => 'control-label'])}}
									{{Form::text('username', \Input::old('username'))}}
								</div>
								<div class="form-group @if($errors->has('firstname')) has-error @endif">
									{{Form::label('firstname', 'Ad', ['class' => 'control-label'])}}
									{{Form::text('firstname', \Input::old('firstname'))}}
								</div>
								<div class="form-group @if($errors->has('lastname')) has-error @endif">
									{{Form::label('lastname', 'Soyad', ['class' => 'control-label'])}}
									{{Form::text('lastname', \Input::old('lastname'))}}
								</div>
								<div class="form-group @if($errors->has('email')) has-error @endif">
									{{Form::label('email', 'e-Posta', ['class' => 'control-label'])}}
									{{Form::email('email', \Input::old('email'))}}
								</div>
								<div class="form-group">
									{{Form::label('group', 'Kullanıcı Grubu', ['class' => 'control-label'])}}
									{{Form::select('group', \Helper::groups(), \Input::old('group'))}}
								</div>
								<div class="form-group @if($errors->has('password')) has-error @endif">
									{{Form::label('password', 'Şifre', ['class' => 'control-label'])}}
									{{Form::password('password')}}
								</div>
								<div class="form-group @if($errors->has('password_confirmation')) has-error @endif">
									{{Form::label('password_confirmation', 'Şifre (Tekrar)', ['class' => 'control-label'])}}
									{{Form::password('password_confirmation')}}
								</div>
								<div class="margiv-top-10">
									{{Form::submit('Oluştur',['class' => 'btn green-haze'])}}
								</div>
							{{Form::close()}}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop