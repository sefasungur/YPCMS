@extends('layouts.master')
@section('content')

<script type="text/javascript">
	$(function(){
		$('form[send="ajax"]').submit(function(event) {
            var el = $(this).parents('.portlet');
            Metronic.blockUI({
                target: el,
                animate: true,
                overlayColor: '#000'
            });

            $.ajax({
                url: $(this).context.action,
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'JSON',
                success: function(response){ 
                    Metronic.unblockUI(el);
                    UIToastr.show(response.text,response.status);
                    if(response.status == "success"){
                        $("#pageMenu .dd ol").html($("#pageMenu .dd ol").html()+response.html);
                        $('.modal').hide();
                    }
                }
            });
            event.preventDefault();
        });
	})
</script>

<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption caption-md">
					<i class="icon-settings theme-font"></i>
					<span class="caption-subject font-blue-madison bold">Ayarlar</span>
				</div>
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
				{{Form::open(['url' => action('Back\AjaxController@postSettingsUpdate'), 'class' => 'edit-page-form form-horizontal','send'=>'ajax'])}}
					@include($type)
					<div class="margiv-top-10">
						{{Form::submit('Güncelle',['class' => 'btn green-haze'])}}
					</div>
				{{Form::close()}}
			</div>
		</div>
	</div>
</div>
@stop