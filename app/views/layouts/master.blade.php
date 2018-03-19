<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
	<meta charset="utf-8"/>
	<title>Yönetim Paneli - {{Helper::optionValue('site_description')}}</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport"/>
	<meta content="" name="description"/>
	<meta content="" name="author"/>
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
	{{HTML::style('assets/global/plugins/font-awesome/css/font-awesome.min.css')}}
	{{HTML::style('assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}
	{{HTML::style('assets/global/plugins/bootstrap/css/bootstrap.min.css')}}
	{{HTML::style('assets/global/plugins/uniform/css/uniform.default.css')}}
	{{HTML::style('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}
	{{HTML::style('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}
		@section('styleFile')
			@parent
		@show
	{{HTML::style('assets/global/css/components.css')}}
	{{HTML::style('assets/global/css/plugins.css')}}
	{{HTML::style('assets/admin/layout/css/layout.css')}}
	{{HTML::style('assets/admin/layout/css/themes/default.css')}}
	{{HTML::style('assets/admin/layout/css/custom.css')}}
	@section('styleCodes')
		@parent
	@show

	{{HTML::script("assets/global/plugins/ckeditor/ckeditor.js")}}
</head>
<body class="page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-closed-hide-logo page-boxed page-header-fixed page-sidebar-menu-closed page-sidebar-closed">
	@include('partials.header')
	<div class="clearfix"></div>
	<div class="container-fluid" style="padding:0px">
		<div class="page-container">
			<div class="page-sidebar-wrapper">
				@include('partials.sidebar')
			</div>
			<div class="page-content-wrapper">
				<div class="page-content">
					@yield('content')
				</div>
			</div>
			<div class="page-footer">
				@include('partials.footer')
			</div>
		</div>
	</div>
	@section('modals')
		@parent
	@show
	{{HTML::script('assets/global/plugins/jquery.min.js')}}
	{{HTML::script('assets/global/plugins/jquery-migrate.min.js')}}
	{{HTML::script('assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js')}}
	{{HTML::script('assets/global/plugins/bootstrap/js/bootstrap.min.js')}}
	{{HTML::script('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')}}
	{{HTML::script('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}
	{{HTML::script('assets/global/plugins/jquery.blockui.min.js')}}
	{{HTML::script('assets/global/plugins/jquery.cokie.min.js')}}
	{{HTML::script('assets/global/plugins/uniform/jquery.uniform.min.js')}}
	{{HTML::script('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}
	{{HTML::script('assets/global/plugins/bootstrap-toastr/toastr.min.js')}}
	@section('scriptFile')
		@parent
	@show
	{{HTML::script('assets/admin/pages/scripts/ui-toastr.js')}}
	{{HTML::script('assets/global/scripts/metronic.js')}}
	{{HTML::script('assets/admin/layout/scripts/layout.js')}}
	{{HTML::script('assets/admin/pages/scripts/index.js')}}


   @section('scriptCodes')
   		@parent
   @show


	</body>
</html>
