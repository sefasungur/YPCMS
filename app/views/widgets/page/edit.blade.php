<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="pull-left">
					<a data-pk="{{$data->id}}" href="#" id="get-previous-page" class="btn btn-success"> 
				        <i class="glyphicon glyphicon-chevron-left"></i>
				        <span>Önceki</span>
				    </a>
					<a data-pk="{{$data->id}}" href="javascript:void(0)" id="get-next-page" class="btn btn-success"> 
				        <i class="glyphicon glyphicon-chevron-right"></i>
				        <span>Sonraki</span>
				    </a>
				</div>
				<div class="pull-right">
					<a href="#" id="update-page-button" class="btn btn-success"> 
				        <i class="icon-reload"></i>
				        <span>Güncelle</span>
				    </a>
					<a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deletePageModal">
						<i class="icon-trash"></i>
						<span>Sayfayı Sil</span>
					</a>
				</div>
			</div>
			<div class="portlet-title">
				<div class="caption caption-md">
					<i class="icon-note theme-font font-blue-madison"></i>
					<span class="caption-subject font-blue-madison bold">
						{{$data->translation->title}}
					</span>
				</div>
				<div class="pull-left" style="    padding: 10px;">
					<a data-placement="bottom" href="{{URL::to($data->translation->slug)}}" target="_blank" data-toggle="tooltip" title="" data-original-title="Sitede gör"> <i class="icon-eye" style="color:#C0CDDC; font-size:19px;"></i> </a>
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
				<div class="tabbable-line">
					<?php $menu = [
							[
						        'title' => 'Bilgiler',
						        'link' => action('Back\AjaxController@getEditPage')."?id=$data->id&type=information"
						    ],
						    [
						        'title' => 'İçerik',
						        'link' => action('Back\AjaxController@getEditPage')."?id=$data->id&type=content"
						    ],
						    [
						        'title' => 'Dosyalar',
						        'link' => action('Back\AjaxController@getEditPage')."?id=$data->id&type=media"
						    ],
						    [
						        'title' => 'Sayfa Özellikleri',
						        'link' => action('Back\AjaxController@getEditPage')."?id=$data->id&type=meta"
						    ],[
						        'title' => 'Fonksiyonlar',
						        'link' => action('Back\AjaxController@getEditPage')."?id=$data->id&type=triger"
						    ]
					    ];
                                        
                                        $price_page = \Page::select("*")->where("template","price")->get()->first();
                                        
                                        if(!empty($price_page) and $data->parent == $price_page->id)
                                        {
                                            $menu[] = array("title" => "Fiyat Bilgileri", "link" => action('Back\AjaxController@getEditPage')."?id=$data->id&type=price");
                                        }
					 ?>
					{{Navigation::tabs($menu)}}
					<div class="tab-content">
						<div class="tab-pane active" id="information">
							@include($detail, ['page' => $data])
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>




<div class="modal fade" id="deletePageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Onay İşlemi</h4>
      </div>
      <div class="modal-body">
       Dikkat bu silmek istediğiniz sayfa, silme işlemi onaylandığı takdirde kendisine bağlı tüm alt sayfalar 
       ile birlikte veritabanından kaldırılır  bu işlemi gerçekten onaylıyor musunuz
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">İptal Et</button>
       	<a href="#" page-id="{{$data->id}}" class="btn btn-danger page-trash" >Sayfayı Sil</a>
      </div>
    </div>
  </div>
</div>




