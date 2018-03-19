@extends('layouts.login')
@section('content')
{{Form::open(['url' => action('Front\AccountController@postResetPassword'), 'class' => 'login-form'])}}
		<h3 class="form-title">Yeni şifre talebi</h3>
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

		@if(Session::get('messages')['status'] == "success")
			<div class="form-group">
				<a href="{{URL::to('/login')}}">Giriş Yap</a>
			</div>
		@else
			<div class="form-group">
				{{Form::label('email', 'E-posta', ['class' => 'control-label visible-ie8 visible-ie9'])}}
				{{Form::text('email',Input::old('email'),['class' => 'form-control form-control-solid placeholder-no-fix', 'placeholder' => 'E-posta'])}}
			</div>
			<div class="form-actions">
				{{Form::button('Şifre iste',['class' => 'btn btn-success uppercase', "type" => "submit"])}}
				<label class="rememberme check">
			</div>
			<div class="form-group">
				<a href="{{URL::to('/login')}}">Giriş Yap</a>
			</div>
		@endif
{{Form::close()}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script>
	jQuery(document).ready(function($) {
		
$("select[name='language']").change(function(event) {
	event.preventDefault();
	var href = $("select[name='language']").val();
	//alert(href);
window.location.href= href;
})
	});

</script>
@stop