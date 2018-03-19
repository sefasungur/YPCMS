{{Form::open(['url' => action('Back\PagesController@postEditContent'),'send'=>'ajax','class' => 'edit-page-form'])}}
{{Form::hidden('page_id', $data->id)}}

<div class="form-body">
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<div class="form-group">
				<!--{{Form::label('content', 'Sayfa İçeriği',['class' => 'control-label'])}}-->
				{{Form::textarea('content',$data->translation->content,['class' => 'ckeditor form-control', 'id' => 'content'])}}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8 col-xs-8">
			<div class="form-group">
			{{Form::label('summary', 'Özet içerik',['class' => 'control-label'])}}
			{{Form::textarea('summary',$data->translation->summary, ['class' => 'form-control', 'rows' =>5])}}
			</div>
		</div>
		<div class="col-md-4 col-xs-4">
			<div class="form-group">
				{{Form::label('tags', 'Etiketler',['class' => 'control-label'])}} <a href="#" class="add-tag">Ekle</a>
				<div class="tag-area display-none">
					{{Form::text(null, null,['class'=>'tags'])}}
				</div>
				{{Form::select('tags[]', Helper::AllTagsList(),explode(',',$data->translation->tags), ['class' => 'multi-select', 'multiple' => 'multiple', 'id' =>'tags'])}}
			</div>
		</div>
	</div>
	<button type="submit" class="btn btn-success" js="update-btn"> 
		<i class="icon-reload"></i>
		<span>Güncelle</span>
	</button>
</div>
{{Form::close()}}






	
