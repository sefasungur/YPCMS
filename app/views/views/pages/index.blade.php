@extends('layouts.master')
@section('styleFile')
    {{HTML::style('assets/global/plugins/jquery-nestable/jquery.nestable.css')}}
    {{HTML::style("assets/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css")}}
@append
@section('scriptFile')
    {{HTML::script('assets/global/plugins/jquery-nestable/jquery.nestable.js')}}
    {{HTML::script('assets/global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.js')}}
@append


@section('styleFile')
{{HTML::style('assets/global/plugins/dropzone/css/dropzone.css')}}
{{HTML::style('assets/global/plugins/fancybox/source/jquery.fancybox.css')}}
@append  
@section('scriptFile')
{{HTML::script('assets/global/plugins/jquery-touch-punch/jquery.ui.touch-punch.min.js')}}
{{HTML::script('assets/global/plugins/dropzone/dropzone.js')}}
{{HTML::script('assets/global/plugins/fancybox/source/jquery.fancybox.pack.js')}}
@append 


@section('styleFile')
{{HTML::style("assets/global/plugins/typeahead/typeahead.css")}}
@append  
@section('scriptFile')
{{HTML::script('assets/global/plugins/typeahead/handlebars.min.js')}}
{{HTML::script('assets/global/plugins/typeahead/typeahead.bundle.min.js')}}
@append 


@section('styleFile')
{{HTML::style("assets/global/plugins/jquery-multi-select/css/multi-select.css")}}
{{HTML::style("assets/global/plugins/jquery-tags-input/jquery.tagsinput.css")}}
@append
@section('scriptFile')
{{HTML::script("assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js")}}
{{HTML::script("assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js")}}
@append 

@section('styleFile')
{{HTML::style("assets/global/plugins/select2/select2.css")}}
{{HTML::style("assets/global/plugins/bootstrap-datepicker/css/datepicker3.css")}}
@append  
@section('scriptFile')
{{HTML::script("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js")}}
{{HTML::script("assets/global/plugins/select2/select2.min.js")}}
@append 

@section('styleCodes')
    <style type="text/css">
        .editableform > .form-group > div{
            padding: 0!important;
            border: none;
        }
        .editable-input > .input-medium{
            width: 220px!important;
        }
    </style>
@append

@section('scriptCodes')
<script type="text/javascript">
    jQuery(document).ready(function($) {

        var ajaxEditPage = $('#page');
        var mediaSorting = $('#mediaFiles');
        var pk = $(this).attr('data-pk');
        var sortable   = $("#pageMenu .dd");
        var sortableElements   = $("#pageMenu .dd ol");
        var sortableSelectBox = $('select[name="sortable-template-filter"]');
        var langSelectBox = $('select[name="sortable-lang"]');
        var sortableRefresh = $('#sortable-refresh');

        
        setTimeout(function(){
            $('#pageMenu li a:eq(0)').click();
        },100);

        $('.dd').nestable({
            group: 1,
            maxDepth:10,
            dropCallback: function(details) {
                    
            }
        }).off('submit').on('change', function(event) { 
            var el = $(this).parents('.portlet-body');
            Metronic.blockUI({
                target: el,
                animate: true,
                overlayColor: '#000'
            });
            var data = window.JSON.stringify($(this).nestable('serialize'));

            $.ajax({
                url: '{{action("Back\AjaxController@postSortable")}}',
                type: 'POST',
                data: {data: data,sorting:sortableSelectBox.attr("sorting")},
                success: function(response){ 
                    UIToastr.show(response.text,response.status);
                    sortable.html(response.html);
                }
            });
            Metronic.unblockUI(el);
        }).nestable('collapseAll');


        /*icerik guncelleme sayfası çağrılduığında başlar*/
        var ContentInit = function(){
            CKEDITOR.replace( 'content', {
                filebrowserBrowseUrl : '{{asset("panel/elfinder/ckeditor4")}}',
                extraPlugins : 'oembed',
                pasteFromWordRemoveStyles : false,
                pasteFromWordPromptCleanup : false,
                pasteFromWordRemoveFontStyles: false,
                allowedContent : true,
                extraAllowedContent : 'td{background}',
                removePlugins : 'elementspath, save, iframe, forms, smiley, templates, a11yhelp, about'
            });

            $('.add-tag').click(function(event) {
                $('.tag-area').fadeToggle();
                event.preventDefault();
            });
            $('.multi-select').multiSelect();
            $('.tags').tagsInput({
                width: 'auto',
                removeWithBackspace: true,
                defaultText:'etiket ekleyin',
                onAddTag: function(tag){
                    $('#tags').multiSelect(
                        'addOption',{ 
                            value: tag, 
                            text: tag
                    });
                    $('.tags').removeTag(tag);
                }
            });
        };
        /*Bitiş*/ 



        //New Page

        $('form[name="newpage"]').submit(function(event) {
            me = $(this);
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
                        $('#new-page').modal('hide');
                        $('#sortable-refresh').click();
                        $(me)[0].reset();
                        $.ajax({
                            url: '{{action("Back\AjaxController@getEditPage")}}',
                            type: 'Get',
                            dataType: 'JSON',
                            data: {id: response.id,type:'content'},
                            success:function (res) {
                                var element = $('#page');
                                element.fadeOut().fadeIn().html(res.html);
                                $.pageSettings();
                                Metronic.init();
                                Layout.init();
                                Metronic.unblockUI(el);
                                Metronic.scrollTop();
                                ContentInit();
                            }
                        });
                    }
                }
            });
            event.preventDefault();
        });
       


        var MetaInit = function(){

            $('.meta_add').off('click').click(function(event){
                var page_id = $(this).attr('page-id'); 
                $.ajax({
                    url: "{{action('Back\AjaxController@postPageMeta')}}",
                    type: "POST",
                    data: {_token: '{{csrf_token()}}', page_id: page_id, meta_name: $('#meta_name').val(), meta_value: $('#meta_value').val()},
                    success:function (response) {       
                        if (response.action) {
                             $('#meta-form').append('<div class="form-group"><label class="control-label">'+response.name+'</label><div class="input-group"><input type="text" name="'+response.name+'" class="form-control" value="'+response.value+'"><span class="input-group-btn"><button class="delete-meta btn btn-danger" data-pk="'+response.meta_id+'">Sil</button></span></div></div>');
                             $('#meta_name').val("");
                             $('#meta_value').val("");
                             MetaInit();
                        };
                        UIToastr.show(response.text,response.status)
                    }
                })          
                event.preventDefault();
            });

            $('.delete-meta').off('click').click(function(event) {
                var el = $(this);
                $.ajax({
                    url: "{{action('Back\AjaxController@postPageMetaDelete')}}",
                    type: "POST",
                    data: {_token: '{{csrf_token()}}', id: el.attr('data-pk')},
                    success:function (response) {       
                        if (response.action) {
                            UIToastr.show(response.text,response.status)
                            el.parents('.form-group').slideUp();
                        };
                    }
                });
                event.preventDefault();
            });
        };


        var MediaInit = function(ref){  
            var myDropzone = new Dropzone(".dropzone",{
                acceptedFiles: "image/*,audio/*,video/*, application/pdf,application/msword,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.wordprocessingml.template,application/vnd.ms-word.document.macroEnabled.12,application/vnd.ms-word.template.macroEnabled.12,application/vnd.ms-excel,application/vnd.ms-excel,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.openxmlformats-officedocument.spreadsheetml.template,application/vnd.ms-excel.sheet.macroEnabled.12,application/vnd.ms-excel.template.macroEnabled.12,application/vnd.ms-excel.addin.macroEnabled.12,application/vnd.ms-excel.sheet.binary.macroEnabled.12,application/vnd.ms-powerpoint,application/vnd.ms-powerpoint,application/vnd.ms-powerpoint,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/vnd.openxmlformats-officedocument.presentationml.template,application/vnd.openxmlformats-officedocument.presentationml.slideshow,application/vnd.ms-powerpoint.addin.macroEnabled.12,application/vnd.ms-powerpoint.presentation.macroEnabled.12,application/vnd.ms-powerpoint.template.macroEnabled.12,application/vnd.ms-powerpoint.slideshow.macroEnabled.12",
                uploadMultiple: false,
            parallelUploads: 1,
                init: function() { 
                    this.on("success", function(file, response) { 
                        /*var mediaInner = '<tr class="template-upload fade in">
                        <td><span class="preview">
                            <a href="'+response.full_url+'" class="fancybox-button">
                                <img src="'+response.full_url+'">
    </a></span></td><td><span class="edit-title" data-pk="'+response.fileid+'">Resim başlığını değiştir
    </span></td><td>
        <input class="make-switch edit" data-id="'+response.fileid+'" data-on-text="Galeri" data-off-text="Galeri" name="is_gallery" type="checkbox" value="1" checked><input class="make-switch edit" data-id="'+response.fileid+'" data-on-text="Kapak" data-off-text="Kapak" name="is_cover" type="checkbox" value="1"></td><td><input class="make-switch edit" data-id="'+response.fileid+'" data-on-text="Facebook" data-off-text="Facebook" name="facebook_share" type="checkbox" value="1" checked><input class="make-switch edit" data-id="'+response.fileid+'" data-on-text="Twitter" data-off-text="Twitter" name="twitter_share" type="checkbox" value="1"></td><td><a href="#" class="btn btn-danger delete-media" data-id="'+response.fileid+'">Sil</a></td><td class="sortable"><i class="fa fa-arrows fa-lg"></i></td></tr>';
                        */  
                        var mediaInner = '<tr class="template-upload">'+
                            '<td class="col-md-2" style="float:left">'+
                                '<span class="preview">'+
                                    '<a href="'+response.full_url+'" class="fancybox-button">'+
                                        '<img src="'+response.full_url+'">'+
                                    '</a>'+
                                '</span>'+
                            '</td>'+
                            '<td class="col-md-10" style="float:left">'+
                                '<div class="col-md-12" style="    margin-bottom: 10px;">'+
                                    '<span class="edit-title" data-pk="'+response.fileid+'">'+
                                        'Resim başlığını değiştir'+
                                    '</span>'+
                                '</div>'+
                                '<div class="col-md-12">'+
                                    '<input class="make-switch edit" data-id="'+response.fileid+'" data-on-text="Galeri" data-off-text="Galeri" name="is_gallery" type="checkbox" value="1" checked>'+
                                    '<input class="make-switch edit" data-id="'+response.fileid+'" data-on-text="Kapak" data-off-text="Kapak" name="is_cover" type="checkbox" value="1">'+
                                    '<input class="make-switch edit" data-id="'+response.fileid+'" data-on-text="Slide" data-off-text="Slide" name="is_slider" type="checkbox" value="1">'+
                                    '<input class="make-switch edit" data-id="'+response.fileid+'" data-on-text="Facebook" data-off-text="Facebook" name="facebook_share" type="checkbox" value="1">'+
                                    '<input class="make-switch edit" data-id="'+response.fileid+'" data-on-text="Twitter" data-off-text="Twitter" name="twitter_share" type="checkbox" value="1">'+
                                    '<input class="make-switch edit" data-id="'+response.fileid+'" data-on-text="Arkaplan" data-off-text="Arkaplan" name="is_background" type="checkbox" value="1">'+
                                '</div>'+
                            '</td>'+
                            '<td>'+
                                '<a href="#" class="btn btn-danger delete-media" data-id="'+response.fileid+'">Sil</a>'+
                            '</td>'+
                            '<td class="sortable">'+
                                '<i class="fa fa-arrows fa-lg"></i>'+
                            '</td>'+
                        '</tr>';
                        $('#mediaFiles').append(mediaInner); 
                        $.pageSettings(); 
                        if (!response.action) { 
                            toastr[response.status](response.text);
                        };
                    });
                },
                error: function(file, response){ 
                    toastr[file.status](response.error.message);
                }
            });
        };



        var getPagesWithOption = function(){
            $.post('{{action('Back\AjaxController@postGetPagesWithOption')}}',{lang:langSelectBox.val()},function(response){
                $('.modal select[name="parent"]').html(response.html);
            });
        }

        
        getPagesWithOption();

        $.pageSettings = function(){ 
            Metronic.init();
            Layout.init();
            $('[data-toggle="tooltip"]').tooltip();

            $('select[name="lang"]').val($('select[name="sortable-lang"]').val());
            $('input[name="lang"]').val($('select[name="sortable-lang"]').val());
            $('.modal select[name="lang"]').prop('disabled', 'disabled');

            $('.page-trash').off('click').click(function(event) {
                var atag = $(this);
                $.post('{{action('Back\AjaxController@postTrashPage')}}',{page_id:atag.attr("page-id")},function(response){
                    $('#deletePageModal').hide();
                    UIToastr.show(response.text,response.status);
                    $('#page-'+atag.attr("page-id")).remove();
                    $('#page').html(" ");
                    $('#pageMenu li a:eq(0)').click();
                });
                return false;
            });
            

            sortableSelectBox.off('change').change(function(event){
                ajaxSortable();
            });

            langSelectBox.off('change').change(function(event){
                ajaxSortable();
            });

            
            sortableRefresh.off('click').click(function(event){
                ajaxSortable();
            });

            $('li button[data-action="expand"]',sortable).off('click').click(function(e) {  
                var template = sortableSelectBox.val();
                var slider   = "none";
                var menu     = "none";
                var soritng  = "sorting";
                var notice   = "none";
                var featured = "none";
                var elem     = $(this);
                var parli    = elem.parent('li');
                var parent   = parli.attr('data-id');

                var el = $('#pageMenu');
                Metronic.blockUI({
                    target: el,
                    animate: true,
                    overlayColor: '#000'
                });

                if(template == "pages"){
                    template = "none";
                    sorting  = "sorting";
                }else if(template == "slider"){
                    parent = "none";
                    template = "none";
                    slider   = 1;
                    sorting  = "slider_sorting";
                }else if(template == "menu"){
                    template = "none";
                    menu     = 1;
                    sorting  = "menu_sorting";
                }else if(template == "news"){
                    parent = "none";
                    sorting  = "template_sorting";
                }else if(template == "arsive"){
                    parent = "none";
                    sorting  = "template_sorting";
                }else{
                    sorting  = "template_sorting";
                }
                var lang = langSelectBox.val();

                sortableSelectBox.attr("sorting",sorting);
                
                $.post('{{action('Back\AjaxController@postSortableFilterPages')}}',{parent:parent,lang:lang,template:template,slider:slider,menu:menu,sorting:sorting,notice:notice,featured:featured},function(response){
                    $('.dd-list',parli).remove();
                    $(parli).append(response.html);
                    $.pageSettings(); 
                    Metronic.unblockUI(el);
                });
            });
               
            ajaxSortable = function() {
                var template = sortableSelectBox.val();
                var slider   = "none";
                var notice   = "none";
                var featured = "none";
                var menu     = "none";
                var soritng  = "sorting";
                var parent   = 0;

                var el = $('#pageMenu');
                Metronic.blockUI({
                    target: el,
                    animate: true,
                    overlayColor: '#000'
                });

                if(template == "pages"){
                    template = "none";
                    sorting  = "sorting";
                }else if(template == "slider"){
                    parent = "none";
                    template = "none";
                    slider   = 1;
                    sorting  = "slider_sorting";
                }else if(template == "notice"){
                    parent = "none";
                    template = "none";
                    notice   = 1;
                    sorting  = "notice_sorting";
                }else if(template == "featured"){
                    parent = "none";
                    template = "none";
                    featured = 1;
                    sorting  = "featured_sorting";
                }else if(template == "menu"){
                    template = "none";
                    menu     = 1;
                    sorting  = "menu_sorting";
                }else if(template == "news"){
                    parent = "none";
                    sorting  = "template_sorting";
                }else if(template == "arsive"){
                    parent = "none";
                    sorting  = "template_sorting";
                }else{
                    sorting  = "template_sorting";
                }
                var lang = langSelectBox.val();

                sortableSelectBox.attr("sorting",sorting);
                
                $.post('{{action('Back\AjaxController@postSortableFilterPages')}}',{parent:parent,lang:lang,template:template,slider:slider,menu:menu,sorting:sorting,notice:notice,featured:featured},function(response){
                    sortable.html(response.html);
                    UIToastr.show(response.text,response.status); 
                    $.pageSettings(); 
                    Metronic.unblockUI(el);
                });

                $.post('{{action('Back\AjaxController@postGetPagesWithOption')}}',{lang:lang},function(response){
                    $('.modal select[name="parent"]').html(response.html);
                    $.pageSettings(); 
                });
                getPagesWithOption();
            };


            $('input[name="search"]').keyup(function(e) {
                var code = e.which; 
                if(code==13)e.preventDefault();
                if(code==32||code==13||code==188||code==186){
                    var el = $(this).parents('.portlet');
                    var lang = langSelectBox.val();
                    var search = $(this).val();
                    Metronic.blockUI({
                        target: el,
                        animate: true,
                        overlayColor: '#000'
                    });
                    $.post('{{action('Back\AjaxController@postSearchPage')}}',{_token: '{{csrf_token()}}',lang:lang,search:search},function(response){
                        sortable.html(response); 
                        Metronic.unblockUI(el);
                        getPagesWithOption();
                        $.pageSettings(); 
                    });
                }
            }); 

            
            $('#update-page-button').off('click').click(function(){
                $('button[js="update-btn"]').click();
            });
            $('#page').off('submit').on('submit', 'form[send="ajax"]',function(event){
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
                        $.pageSettings(); 
                    }
                });
                event.preventDefault();
            });

            $('#page').off('click').on('click', '.nav-tabs li a',function(event){ 
                Metronic.blockUI({
                    target: ajaxEditPage,
                    animate: true,
                    overlayColor: '#000'
                });

                var atag = this;
                $.ajax({
                    url: $(atag).attr("href"),
                    type: 'Get',
                    dataType: 'JSON',
                    data: {pk: pk, _token:'{{csrf_token()}}'},
                    success:function (response) { 
                        var element = $('#page');
                        element.fadeOut().fadeIn().html(response.html);
                        Metronic.unblockUI(ajaxEditPage);
                        
                        str = $(atag).attr("href");
                        var query = str.split('?')[1];
                        var myParam = query.split('type=')[1];
                        
                        if(myParam == "meta"){
                            MetaInit();
                        }
                        if(myParam == "content"){
                            ContentInit();
                        }
                        if(myParam == "media"){
                            MediaInit();
                        }
                        $.pageSettings(); 
                    }
                });
                return false; 
            });

            $('#get-next-page').click(function(event) {
                var lang = langSelectBox.val();
                var pk = $(this).attr('data-pk');
                var el = $(this).parents('.page-content');
                Metronic.blockUI({
                    target: el,
                    animate: true,
                    overlayColor: '#000'
                });

                $.ajax({
                    url: '{{action("Back\AjaxController@getNextEditPage")}}',
                    type: 'Get',
                    dataType: 'JSON',
                    data: {lang:lang, id: pk,type:'information'},
                    success:function (response) {
                        var element = $('#page');
                        element.fadeOut().fadeIn().html(response.html);
                        $.pageSettings();
                        Metronic.init();
                        Layout.init();
                        Metronic.unblockUI(el);
                        Metronic.scrollTop();
                        ContentInit();
                    }
                });
                event.preventDefault();
            });


            $('#get-previous-page').click(function(event) {
                var lang = langSelectBox.val();
                var pk = $(this).attr('data-pk');
                var el = $(this).parents('.page-content');
                Metronic.blockUI({
                    target: el,
                    animate: true,
                    overlayColor: '#000'
                });

                $.ajax({
                    url: '{{action("Back\AjaxController@getPreviousEditPage")}}',
                    type: 'Get',
                    dataType: 'JSON',
                    data: {lang:lang, id: pk,type:'information'},
                    success:function (response) {
                        var element = $('#page');
                        element.fadeOut().fadeIn().html(response.html);
                        $.pageSettings();
                        Metronic.init();
                        Layout.init();
                        Metronic.unblockUI(el);
                        Metronic.scrollTop();
                        ContentInit();
                    }
                });
                event.preventDefault();
            });

            $('body').off('click').on('click', '.showPageSettings',function(event){
                var pk = $(this).attr('data-pk');
                var el = $(this).parents('.portlet-body');
                Metronic.blockUI({
                    target: el,
                    animate: true,
                    overlayColor: '#000'
                });

                $.ajax({
                    url: '{{action("Back\AjaxController@getEditPage")}}',
                    type: 'Get',
                    dataType: 'JSON',
                    data: {id: pk,type:'content'},
                    success:function (response) {
                        var element = $('#page');
                        element.fadeOut().fadeIn().html(response.html);
                        $.pageSettings();
                        Metronic.init();
                        Layout.init();
                        Metronic.unblockUI(el);
                        Metronic.scrollTop();
                        ContentInit();
                    }
                });
                event.preventDefault();
            });
       
            $('.delete-media').click(function(event) {
                var el = $('#mediaFiles');
                var id = $(this).attr('data-id'),
                element = $(this);
                $.ajax({
                    url: '{{action("Back\AjaxController@postMediaDelete")}}',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {id: id},
                    success: function(response){
                        Metronic.blockUI({
                            target: el,
                            animate: true,
                            overlayColor: '#000'
                        });
                        if (response.action) {
                            element.parents('tr.template-upload').fadeOut(function(){
                                element.empty();
                                Metronic.unblockUI(el);
                            });
                        };
                        toastr[response.status](response.text);
                    }
                });
                event.preventDefault();
            });
            $('input.edit').on('switchChange.bootstrapSwitch',function(event,state){
                var el = $(this).parents('tr');
                Metronic.blockUI({
                     target: el,
                    animate: true,
                    overlayColor: '#000'
                });
                var name = $(this).attr('name'); 
                var id = $(this).attr('data-id');
                $.post('{{action("Back\AjaxController@postMediaUpdate")}}', {name: name, id: id, value: state} ,function(argument){
                    Metronic.unblockUI(el);
                });
            });

            var mediaFileSorting = $('#mediaFiles');
            mediaFileSorting.sortable({
                opacity: 0.3,
                axis : "y",
                handle: '.sortable',
                placeholder: "ui-sortable-placeholder",
                cursor: "move",
                containment : "#mediaFiles",
                update: function(event){
                    Metronic.blockUI({
                        target: mediaFileSorting,
                        animate: true,
                        overlayColor: '#000'
                    });
                    var data = $(this).sortable("serialize");
                    $.get('{{action("Back\AjaxController@getMediaSorting")}}', data);
                    Metronic.unblockUI(mediaFileSorting);
                }
            });

            $('.edit-title').editable({
                type: 'text',
                ajaxOptions : {
                    type: 'post',
                    dataType: 'json'
                },
                url: '{{action("Back\AjaxController@postMediaTitleEdit")}}',
                title: 'Resim başlığını düzenle',
                success: function(response, event){
                    toastr[response.status](response.text);
                },
                inputclass: 'form-control input-medium'
            });


            $('.date-picker').datepicker({
                orientation: "left",
                autoclose: true,
                format: "dd-mm-yyyy"
            });
            $('.select2-me').select2();
        }
        $.pageSettings(); 
    });
</script>









@append
@section('modals')
    @include('widgets.modal.page.new')
@append
@section('content')


<div class="row">
    <div class="col-md-4">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            {{Form::select('sortable-lang',BackLang::getLangs(),['value'=>1])}}
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            {{Form::select('sortable-template-filter',BackTemplate::TemplateListArray(array("pages"=>"Tümü"),array("pages"=>"Tümü")) ,"pages", ['class' => 'select2-me','sorting'=>'sorting'])}}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="btn-group btn-group-sm" role="group" aria-label="Small button group" style='text-align: right'>
                            <button style="padding: 6px 10px; margin-right:8px" type="button" id="sortable-refresh" class="btn btn-default"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
                            <button style="padding: 7px 10px;" type="button" data-toggle="modal" data-target="#new-page" class="btn btn-default">Yeni</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {{Form::text('search',"",['placeholder' => 'Birşeyler Ara'])}}
                    </div>
                </div>
            </div>
            <div id="pageMenu" class="portlet-body">
                <div class="dd" style="    overflow-y: scroll;overflow-x: hidden;height: 715px;">              
                    {{BackSortable::GetSortable(0)}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div id="page" class="display-none"></div>
    </div>
</div>



@stop


