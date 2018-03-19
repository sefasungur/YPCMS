{{Form::open(['url' => action('Back\PagesController@postEditPrice'),'send' => 'ajax','class' => 'form-horizontal form-bordered'])}}
{{Form::hidden('page_id', $data->id)}}
  <div class="row">
    <div class="col-md-12 col-xs-4">
       <div class="form-body">
        <div class="form-group">
          <label class="control-label col-md-4">Fiyatı</label>
          <div class="col-md-8">
            {{Form::text('price', $data->translation->price ,['class' => 'form-control', 'placeholder' => 'Ücret'])}}
          </div>
        </div>
           
        <div class="form-group">
          <label class="control-label col-md-4">Detay 1</label>
          <div class="col-md-8">
            {{Form::text('price_detail_1', $data->translation->price_detail_1 ,['class' => 'form-control'])}}
          </div>
        </div>
           
        <div class="form-group">
          <label class="control-label col-md-4">Detay 2</label>
          <div class="col-md-8">
            {{Form::text('price_detail_2', $data->translation->price_detail_2 ,['class' => 'form-control'])}}
          </div>
        </div>
           
        <div class="form-group">
          <label class="control-label col-md-4">Detay 3</label>
          <div class="col-md-8">
            {{Form::text('price_detail_3', $data->translation->price_detail_3 ,['class' => 'form-control'])}}
          </div>
        </div>
           
        <div class="form-group">
          <label class="control-label col-md-4">Detay 4</label>
          <div class="col-md-8">
            {{Form::text('price_detail_4', $data->translation->price_detail_4 ,['class' => 'form-control'])}}
          </div>
        </div>
           
        <div class="form-group">
          <label class="control-label col-md-4">Detay 5</label>
          <div class="col-md-8">
            {{Form::text('price_detail_5', $data->translation->price_detail_5 ,['class' => 'form-control'])}}
          </div>
        </div>
           
          <button type="submit" class="btn btn-success" js="update-btn"> 
    <i class="icon-reload"></i>
    <span>Güncelle</span>
  </button>
        </div>
    </div>
  </div>
  {{Form::close()}}


