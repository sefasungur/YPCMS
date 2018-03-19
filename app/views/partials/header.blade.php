<div class="page-header navbar navbar-fixed-top">
	<div class="page-header-inner container-fluid" style="padding:0px">
		<div class="page-logo">
			<a href="{{action('Back\BackController@getIndex')}}">
				<img src="{{asset('assets/global/img/logo.png')}}" alt="logo" class="logo-default"/>
			</a>
			<div class="menu-toggler sidebar-toggler"></div>
		</div>
		<a href="javascript:void(0);" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		</a>
		<div class="page-top">
			<div class="top-menu">
				<ul class="nav navbar-nav pull-right">
					<li>
						<a data-placement="bottom" href="{{action('Front\PageController@Get')}}" target="_blank" data-toggle="tooltip" title="Siteyi gör" style="padding:24px 12px 24px 12px">
							<i class="icon-eye" style="color:#C0CDDC; font-size:19px;"></i>
						</a>
					</li>
					<li class="dropdown dropdown-user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
							<img alt="" class="img-circle" src="{{Gravatar::src(Auth::user()->email,80)}}"/>
							<span class="username username-hide-on-mobile">
								{{Auth::user()->profile->firstname ?: Auth::user()->username}}
							</span>
							<i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							<li>
								<a href="{{action('Front\UserController@getProfile')}}">
								<i class="icon-user"></i> Profil </a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="{{asset('logout')}}">
								<i class="icon-key"></i> Çıkış Yap </a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>