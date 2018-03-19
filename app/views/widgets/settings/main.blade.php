<div class="row">
	<div class="form-group @if($errors->has('site_title')) has-error @endif">
		{{Form::label('site_title', 'Site Başlığı', ['class' => 'col-md-3 control-label'])}}
		<div class="col-md-4">
		{{Form::text('site_title',Helper::optionValue('site_title'), ['class' => 'col-md-3 form-control'])}}
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group @if($errors->has('site_description')) has-error @endif">
		{{Form::label('site_description', 'Site Açıklaması', ['class' => 'col-md-3 control-label'])}}
		<div class="col-md-4">
		{{Form::text('site_description',Helper::optionValue('site_description'), ['class' => ' form-control'])}}
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group @if($errors->has('site_keywords')) has-error @endif">
		{{Form::label('site_keywords', 'Anahtar Kelimeler', ['class' => 'col-md-3 control-label'])}}
		<div class="col-md-4">
		{{Form::text('site_keywords',Helper::optionValue('site_keywords'), ['class' => ' form-control'])}}
		</div>
	</div>
</div>
