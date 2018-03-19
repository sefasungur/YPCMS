<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8"/>
	<title>Giriş Yap</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta content="" name="description"/>
	<meta content="" name="author"/>
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
	{{HTML::style('assets/global/plugins/font-awesome/css/font-awesome.min.css')}}
	{{HTML::style('assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}
	{{HTML::style('assets/global/plugins/bootstrap/css/bootstrap.min.css')}}
	{{HTML::style('assets/global/plugins/uniform/css/uniform.default.css')}}
	{{HTML::style('assets/admin/pages/css/login.css')}}
	{{HTML::style('assets/global/css/components.css')}}
	{{HTML::style('assets/global/css/plugins.css')}}
	{{HTML::style('assets/admin/layout/css/layout.css')}}
	{{HTML::style('assets/admin/layout/css/themes/default.css')}}
	{{HTML::style('assets/admin/layout/css/custom.css')}}
</head>
<body class="login">
	<div class="logo">
		<a href="{{action('Back\BackController@getIndex')}}">
			<img src="{{asset('assets/global/img/logo-login.png')}}" alt="" style="max-width: 300px;">
		</a>
	</div>
	<div class="content">
		@yield('content')
	</div>

	<div class="copyright">Version 1 {{date("Y")}} © <a href="http://birboluiki/">Birbölüiki</a></div>

	{{HTML::script('assets/global/plugins/jquery.min.js')}}
	{{HTML::script('assets/global/plugins/jquery-migrate.min.js')}}
	{{HTML::script('assets/global/plugins/bootstrap/js/bootstrap.min.js')}}
	{{HTML::script('assets/global/plugins/jquery.blockui.min.js')}}
	{{HTML::script('assets/global/plugins/uniform/jquery.uniform.min.js')}}
	{{HTML::script('assets/global/plugins/jquery.cokie.min.js')}}
	{{HTML::script('assets/global/scripts/metronic.js')}}
	{{HTML::script('assets/admin/layout/scripts/layout.js')}}
	{{HTML::script('assets/admin/layout/scripts/demo.js')}}
	{{HTML::script('assets/admin/pages/scripts/login.js')}}
	<script>
	jQuery(document).ready(function() {     
		Metronic.init(); // init metronic core components
		Layout.init(); // init current layout
		Demo.init();
	});
	</script>
</body>