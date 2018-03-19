<div class="row">
	<div class="form-group @if($errors->has('smtp_server')) has-error @endif">
		{{Form::label('smtp_server', 'Mail Sunucusu', ['class' => 'col-md-3 control-label'])}}
		<div class="col-md-4">
		{{Form::text('smtp_server',Helper::optionValue('smtp_server'))}}
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group @if($errors->has('smtp_username')) has-error @endif">
		{{Form::label('smtp_username', 'Mail Kullanıcı Adı', ['class' => 'col-md-3 control-label'])}}
		<div class="col-md-4">
		{{Form::text('smtp_username',Helper::optionValue('smtp_username'))}}
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group @if($errors->has('smtp_password')) has-error @endif">
		{{Form::label('smtp_password', 'Mail Şifresi', ['class' => 'col-md-3 control-label'])}}
		<div class="col-md-4">
		{{Form::password('smtp_password')}}
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group @if($errors->has('smtp_port')) has-error @endif">
		{{Form::label('smtp_port', 'Mail Portu', ['class' => 'col-md-3 control-label'])}}
		<div class="col-md-4">
		{{Form::text('smtp_port',Helper::optionValue('smtp_port'))}}
		</div>
	</div>
</div>