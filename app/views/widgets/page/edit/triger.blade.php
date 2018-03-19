{{Form::open(['url' => action('Back\PagesController@postCopy'),'send' => 'ajax','class' => 'form-horizontal form-bordered'])}}
{{Form::hidden('page_id', $data->id)}}
  <div class="row">
    <div class="col-md-12 col-xs-4">
       <div class="form-body">
           
           <fieldset>
                <legend>Sayfayı Kopyalayıcı</legend>
                <div class="form-group">
                    <div class="col-md-2">
                       {{Form::select('lang',BackLang::getLangs(), ['class' => 'select2-me','value'=>$data->lang])}}
                    </div>
                    <label class="control-label col-md-3">Alt sayfalarını da kopyala</label>
                    <div class="col-md-2">
                      {{Form::checkbox('parent', 1,0,[
                        'class' => "make-switch",
                        'data-on-text' => 'I',
                        'data-off-text' =>  '0'
                      ])}}
                    </div>
                    <div class="col-md-5">
                      <button type="submit" class="btn btn-success" js="update-btn">
                        <i class="icon-reload"></i>
                        <span>Kopyala</span>
                      </button>
                    </div>
                </div>
               
            </fieldset>           
           
        </div>
    </div>
  </div>
  {{Form::close()}}
