{{Form::open(['url' => action('Back\PagesController@postEditInformation'),'send' => 'ajax','class' => 'form-horizontal form-bordered'])}}
{{Form::hidden('page_id', $data->id)}}
  <div class="row">
    <div class="col-md-12 col-xs-4">
       <div class="form-body">
          <div class="form-group">
            <label class="control-label col-md-4">Sayfa adı</label>
            <div class="col-md-8">
              {{Form::text('title', $data->translation->title ,['class' => 'form-control', 'placeholder' => 'Sayfa Adı'])}}
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-4">Üst Menü</label>
            <div class="col-md-8">
              {{Form::select('parent', Helper::getSelectListMenu($data->lang) , $data->parent, ['class' => 'select2-me'])}}
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-4">Dış Bağlantı Menü (Link)</label>
            <div class="col-md-8">
              {{Form::text('target', $data->target ,['class' => 'form-control', 'placeholder' => 'Link'])}}
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-4">Sayfa Şablonu</label>
            <div class="col-md-8">
               {{Form::select('template',BackTemplate::TemplateListArray(),$data->template,['class' => 'select2-me'])}}
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-4">Sayfa Dili</label>
            <div class="col-md-8">
               {{Form::select('lang',BackLang::getLangs(), ['class' => 'select2-me','value'=>$data->lang])}}
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-4">Başlangıç / Bitiş Tarihi</label>
            <div class="col-md-8">
              <div class="input-group input-large " data-date="10/11/2012" data-date-format="mm/dd/yyyy">
                {{Form::date('started_at', $data->started_at)}}
                <span class="input-group-addon">/</span>
                {{Form::date('expired_at', $data->expired_at)}}
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-4">Aktif</label>
            <div class="col-md-8">
              {{Form::checkbox('status', 1, $data->status ? true : false,[
                'class' => "make-switch",
                'data-on-text' => 'I',
                'data-off-text' =>  '0'
              ])}}
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-4">Menüde görülebilir</label>
            <div class="col-md-8">
              {{Form::checkbox('visible', 1, $data->visible ? true : false,[
                'class' => "make-switch",
                'data-on-text' => 'I',
                'data-off-text' =>  '0'
              ])}}
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-4">Alt sayfaları göster</label>
            <div class="col-md-8">
              {{Form::checkbox('visible_sub', 1, $data->visible_sub ? true : false,[
                'class' => "make-switch",
                'data-on-text' => 'I',
                'data-off-text' =>  '0'
              ])}}
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-4">Slider Sayfası</label>
            <div class="col-md-8">
              {{Form::checkbox('is_slider', 1, $data->is_slider ? true : false,[
                'class' => "make-switch",
                'data-on-text' => 'I',
                'data-off-text' =>  '0'
              ])}}
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-4">Anasayfa'da Göster</label>
            <div class="col-md-8">
              {{Form::checkbox('featured', 1, $data->featured ? true : false,[
                'class' => "make-switch",
                'data-on-text' => 'I',
                'data-off-text' =>  '0'
              ])}}
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


