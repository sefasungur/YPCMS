<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>{{Helper::optionValue('site_title')}}</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>

<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
{{HTML::style('assets/global/plugins/font-awesome/css/font-awesome.min.css')}}
{{HTML::style('assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}
{{HTML::style('assets/global/plugins/bootstrap/css/bootstrap.min.css')}}
{{HTML::style('assets/global/plugins/uniform/css/uniform.default.css')}}
{{HTML::style('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}

{{HTML::style('assets/admin/pages/css/error.css')}}
{{HTML::style('assets/global/css/components.css')}}
{{HTML::style('assets/global/css/plugins.css')}}
{{HTML::style('assets/admin/layout/css/layout.css')}}
{{HTML::style('assets/admin/layout/css/themes/default.css')}}
{{HTML::style('assets/admin/layout/css/custom.css')}}
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
<body class="page-404-3">
	<div class="page-inner">
		<img src="{{asset('assets/admin/pages/media/pages/earth.jpg')}}" class="img-responsive" alt="">
	</div>
	<div class="container error-404">
		@yield('content')
		<p>
			<a href="{{ URL::previous() }}">Geri Dön </a>
			<br>
		</p>
	</div>
</body>
</html>