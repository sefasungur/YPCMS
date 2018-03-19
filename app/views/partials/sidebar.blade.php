<div class="page-sidebar navbar-collapse collapse">
	<ul class="page-sidebar-menu page-sidebar-menu-compact page-sidebar-menu-hover-submenu page-sidebar-menu-closed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
		<li>
			<a href="{{action('Back\BackController@getIndex')}}">
			<i class="icon-home"></i>
			<span class="title">Yönetici Paneli</span>
			<span class="selected"></span>
			</a>
		</li>
		<li>
			<a href="{{action('Back\PagesController@getIndex')}}">
				<i class="icon-list"></i>
				<span class="title">Sayfalar</span>
			</a>
		</li>
		@if(Auth::user()->group == 1)
		<li>
			<a href="{{action('Back\UserController@getIndex')}}">
				<i class="icon-user"></i>
				<span class="title">Kullanıcılar</span>
				<span class="arrow "></span>
			</a>
			<ul class="sub-menu">
				<li>
					<a href="{{action('Back\UserController@getCreate')}}">
						Yeni Kullanıcı
					</a>
				</li>
				<li>
					<a href="{{action('Back\UserController@getIndex')}}">
						Tüm Kullanıcılar
					</a>
				</li>
			</ul>
		</li>
		<li>
			<a href="{{action('Back\SettingsController@getIndex')}}?type=main">
				<i class="icon-settings"></i>
				<span class="title">Ayarlar</span>
				<span class="arrow "></span>
			</a>
			<ul class="sub-menu">
				<li>
					<a href="{{action('Back\SettingsController@getIndex')}}?type=main">
						Site Ayarları
					</a>
				</li>
				<li>
					<a href="{{action('Back\SettingsController@getIndex')}}?type=mail">
						Mail Ayarları
					</a>
				</li>
                                <li>
					<a href="{{action('Back\SettingsController@getIndex')}}?type=content">
						İçerik Ayarları
					</a>
				</li>
                                <li>
					<a href="{{action('Back\SettingsController@getIndex')}}?type=contact">
						İletişim Ayarları
					</a>
				</li>
                                <li>
					<a href="{{action('Back\SettingsController@getIndex')}}?type=social">
						Sosyal Medya Ayarları
					</a>
				</li>
			</ul>
		</li>
		@endif
	</ul>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
