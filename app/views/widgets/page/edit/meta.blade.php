<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label for="meta_name" class="control-label">Özellik Adı</label>
			<input type="text" id="meta_name" name="name" class="form-control autocomplete">
		</div>
	</div>		
	<div class="col-md-6">
		<div class="form-group">
			<label for="meta_value" class="control-label">Değer</label>
			<input type="text" id="meta_value" class="form-control">
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<button page-id="{{$data->id}}" class="btn btn-primary meta_add" style="margin-top:25px">Ekle</button>
		</div>
	</div>
	<div class="col-md-8">
		{{Form::open(['url' => action('Back\PagesController@postPageMeta'), 'send' => 'ajax'])}}
		{{Form::hidden('page_id', $data->id)}}
			<div id="meta-form">
				@foreach($data->metas as $meta)
				<div class="form-group">
					<label for="" class="control-label">{{$meta->name}}</label>
					<div class="input-group">
						<input type="text" name="{{$meta->name}}" class="form-control" value="{{$meta->value}}">
						<span class="input-group-btn">
							<button class="delete-meta btn btn-danger" data-pk="{{$meta->id}}">Sil</button>
						</span>
					</div>
				</div>
			@endforeach
			</div>
			<button type="submit" class="btn btn-success" js="update-btn"> 
		<i class="icon-reload"></i>
		<span>Güncelle</span>
	</button>
		{{Form::close()}}
	</div>
</div>




