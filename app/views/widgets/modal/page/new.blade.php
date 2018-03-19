<div class="modal fade" id="new-page" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  {{Form::open(['url' => action('Back\AjaxController@postCreate') , 'class' => 'new-page-form form-horizontal form-bordered','name' => 'newpage'])}}
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Yeni Birşey</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
             <div class="form-body">
                <div class="form-group">
                  <label class="control-label col-md-4">Adı</label>
                  <div class="col-md-8">
                    {{Form::text('title', \Input::old('title') ,['placeholder' => 'Sayfa Adı'])}}
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-4">Üst Sayfa</label>
                  <div class="col-md-8">
                    {{Form::select('parent', Helper::getSelectListMenu(2) , "default", ['class' => 'select2-me'])}}
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-4">Şablon</label>
                  <div class="col-md-8">
                    {{Form::select('template', BackTemplate::TemplateListArray() , \Input::old('parent'), ['class' => 'select2-me'])}}
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-4">Sayfa Dili</label>
                  <div class="col-md-8">
                      {{Form::select('lang',BackLang::getLangs(), ['class' => 'select2-me','value'=>2])}}
                      <input name="lang" type="hidden">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-4">Durum</label>
                  <div class="col-md-8">
                    {{Form::checkbox('status', 1, true,[
                      'class' => "make-switch",
                      'data-on-text' => 'I',
                      'data-off-text' =>  '0'
                    ])}}
                  </div>
                </div>
                 
                 <div class="form-group">
                  <label class="control-label col-md-4">Menüde Görülebilir</label>
                  <div class="col-md-8">
                    {{Form::checkbox('visible', 1, true,[
                      'class' => "make-switch",
                      'data-on-text' => 'I',
                      'data-off-text' =>  '0'
                    ])}}
                  </div>
                </div>
                 
                 
                 
              </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
        <button type="submit" class="btn btn-primary">Oluştur</button>
      </div>
    </div>
  </div>
  {{Form::close()}}
</div>
@section('styleFile')
{{HTML::style("assets/global/plugins/select2/select2.css")}}
{{HTML::style("assets/global/plugins/bootstrap-datepicker/css/datepicker3.css")}}
@append  
@section('scriptFile')
{{HTML::script("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js")}}
{{HTML::script("assets/global/plugins/select2/select2.min.js")}}
@append 
@section('scriptCodes')
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('.select2-me').select2();
  });
</script>
@append