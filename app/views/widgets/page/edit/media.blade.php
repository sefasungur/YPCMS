<div class="row">
	<div class="col-md-12">
	{{Form::open(['url' => action('Back\PagesController@postMediaUpload'),'id' => 'formDropzone','class' => "dropzone", 'files' => true])}}
	{{Form::hidden('page_id', $data->id)}}
	{{Form::close()}}
	</div>
	<div class="clearfix"></div>
	<div class="col-md-12">
		<table class="table table-striped" style="margin-top:20px">
			<tbody id="mediaFiles">
				@foreach($data->media as $media)
				<tr class="template-upload" id="sort-{{$media->id}}" data-sorting="{{$media->id}}">
					<td class="col-md-2" style="float:left">
						<span class="preview">
						@if($media->type == "pdf")
							<a href="{{Helper::pdfCover($media->filename)}}" class="fancybox-button">
								<img src="{{Helper::pdfCover($media->filename)}}">
							</a>
						@else
							<a href="{{asset($media->full_url)}}" class="fancybox-button">
								<img src="{{Helper::thumb('100x80',$media->full_url)}}">
							</a>
						@endif
						</span>
					</td>
					<td class="col-md-10" style="float:left">
						<div class="col-md-12" style="    margin-bottom: 10px;">
							<span class="edit-title" data-pk="{{$media->id}}">
								{{$media->title ?: "Resim başlığını değiştir"}}
							</span>
						</div>
						<div class="col-md-12">
							{{Form::checkbox('is_gallery', 1, $media->is_gallery ? true : false,[
							'class' => "make-switch edit",
							'data-on-text' => 'Galeri',
							'data-off-text' =>  'Galeri',
							'data-id' => $media->id
						])}}
						{{Form::checkbox('is_cover', 1, $media->is_cover ? true : false,[
							'class' => "make-switch edit",
							'data-on-text' => 'Kapak',
							'data-off-text' =>  'Kapak',
							'data-id' => $media->id
						])}}
						{{Form::checkbox('is_slider', 1, $media->is_slider ? true : false,[
							'class' => "make-switch edit",
							'data-on-text' => 'Slide',
							'data-off-text' =>  'Slide',
							'data-id' => $media->id
						])}}
                                                {{Form::checkbox('facebook_share', 1, $media->facebook_share ? true : false,[
							'class' => "make-switch edit",
							'data-on-text' => 'Facebook',
							'data-off-text' =>  'Facebook',
							'data-id' => $media->id
						])}}
                                                {{Form::checkbox('twitter_share', 1, $media->twitter_share ? true : false,[
							'class' => "make-switch edit",
							'data-on-text' => 'Twitter',
							'data-off-text' =>  'Twitter',
							'data-id' => $media->id
						])}}
                                                
                                                {{Form::checkbox('is_background', 1, $media->is_background ? true : false,[
							'class' => "make-switch edit",
							'data-on-text' => 'Arkaplan',
							'data-off-text' =>  'Arkaplan',
							'data-id' => $media->id
						])}}

						</div>
					</td>
					<td>
						{{HTML::link("#", 'Sil', [
							"class"=>"btn btn-danger delete-media",
							"data-id" => $media->id
						])}}
					</td>
					<td class="sortable">
						<i class="fa fa-arrows fa-lg"></i>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>


