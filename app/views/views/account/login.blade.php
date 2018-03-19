@extends('layouts.login')
@section('content')
{{Form::open(['url' => action('Front\AccountController@postLogin'), 'class' => 'login-form'])}}
		<h3 class="form-title">Giriş Yap</h3>
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

		<!--<div class="form-group">
		 <label class="col-sm-12 control-label text-success">Dil Seçiminizi Yapınız.. </label>
		<select name="language" class="form-control">
		  <option value="http://abaypharma.net/panel"  selected="selected">Türkçe</option>
		  <option value="http://english.abaypharma.net/panel">İngilizce</option>
		  <option value="http://french.abaypharma.net/panel">Fransızca</option>		  
		  <option value="http://arabic.abaypharma.net/panel">Arapça</option>
		  <option>3</option>
		  <option>4</option>
		  <option>5</option>
		</select>
		</div>-->


		<div class="form-group">
			{{Form::label('username', 'Kullanıcı Adı', ['class' => 'control-label visible-ie8 visible-ie9'])}}
			{{Form::text('username',Input::old('username'),['class' => 'form-control form-control-solid placeholder-no-fix', 'placeholder' => 'Kullanıcı Adı'])}}
		</div>
		<div class="form-group">
			{{Form::label('password', 'Şifre', ['class' => 'control-label visible-ie8 visible-ie9'])}}
			{{Form::password('password',['class' => 'form-control form-control-solid placeholder-no-fix', 'placeholder' => 'Şifreniz'])}}
		</div>
		<div class="form-actions">
			{{Form::button('Giriş Yap',['class' => 'btn btn-success uppercase', "type" => "submit"])}}
			<label class="rememberme check">
			<input type="checkbox" name="remember" value="1"/>Beni Hatırla </label>
		</div>
		<div class="form-group">
			<a href="{{URL::to('/reset-password')}}">Şifremi Unuttum</a>
		</div>
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