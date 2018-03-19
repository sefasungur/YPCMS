<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

\Route::group(['before' => 'auth.manager', 'prefix' => 'panel'], function(){
	\Route::get('ads/list', 'Back\AdsController@getIndex');
	\Route::post('ads/create', 'Back\AdsController@postCreate');
	\Route::post('ads/ajaxads', 'Back\AdsController@postAjaxAds');
	\Route::post('ads/sortable', 'Back\AdsController@postAjaxAdsSortable');
	
	\Route::get('ad/update', 'Back\AdsController@getEditAd');

	\Route::post('ad/update/ajax', 'Back\AdsController@postAjaxAdUpdate');
	\Route::post('ad/update/information/ajax', 'Back\AdsController@postAjaxEditAdInformation');
	\Route::post('ad/update/content/ajax', 'Back\AdsController@postAjaxEditAdContent');
	

	\Route::get('elfinder', 'Barryvdh\Elfinder\ElfinderController@showIndex');
	
	\Route::get('elfinder/ckeditor4', 'Barryvdh\Elfinder\ElfinderController@showCKeditor4');
	
	\Route::any('elfinder/connector', 'Barryvdh\Elfinder\ElfinderController@showConnector');
	\Route::post('postpopup','Back\PagesController@sendPop');
\Route::get('postpopup','Back\PagesController@deletePop');
	\Route::controller('ajax', 'Back\AjaxController');
	
	\Route::controller('category', 'Back\CategoryController');
	
	\Route::controller('pages', 'Back\PagesController');
	
	\Route::controller('settings', 'Back\SettingsController');
	
	\Route::controller('user', 'Back\UserController');
	
	\Route::controller('/', 'Back\BackController');

	
	
});

\Route::group(array('before' => 'auth'), function(){

	\Route::controller('user', 'Front\UserController');
	
	\Route::get('logout', function(){
		
		\Auth::logout();
		return 	\Redirect::action('Front\AccountController@getLogin')
				->withMessages(['status' => 'success', 'text' => 'Çıkış yapıldı']);
	});

});


\Route::group(array('before' => 'guest'), function(){
	
	/*
	-	CSRF POST
	*/
	\Route::group(['before' => 'csrf'],function(){
			
		\Route::post('login', 'Front\AccountController@postLogin');		

	});

	\Route::get('reset-password', 'Front\AccountController@getResetPassword');
	\Route::post('reset-password', 'Front\AccountController@postResetPassword');
    
    \Route::get('login', 'Front\AccountController@getLogin');
    
    \Route::get('register', 'Front\AccountController@getRegister');
});









\Route::post('add-basket', 'Front\BasketController@postAdd');
\Route::post('send-order', 'Front\OrderController@postSend');
\Route::post('remove-basket', 'Front\BasketController@postRemove');


\Route::controller('ajax', 'Front\AjaxController');

\Route::controller('eposta', 'Front\MailController');

\Route::get('thumbnails', 'Front\FrontController@getThumb');

//\Route::get('/{page}', 'Front\FrontController@getMain');



/*Ömer*/
\Route::get('/','Front\PageController@Home');
\Route::get('/{page}','Front\PageController@Get');
\Route::get('search/{page}', 'Front\SearchController@getPage');
\Route::get('lang/{lang}', 'Front\UserController@getSetLang');
\Route::get('siparis/{code}', 'Front\OrderController@getStatus');
\Route::post('survey/vote', 'Front\AjaxController@postSurveyVote');