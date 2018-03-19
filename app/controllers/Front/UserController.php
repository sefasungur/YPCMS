<?php namespace Front;

	/**
	* 
	*/
	use Session;
	class UserController extends \BaseController
	{
		
		public function getProfile(){
			$user = \User::findOrFail(\Auth::user()->id);
			return \View::make('views.user.profile',['user' => $user]);
		}

		public function getSetLang($lang){ 
			if(is_numeric($lang)){
				$lang = \Language::select("*")->where("id",$lang)->get()->first();
				if(!empty($lang)){
					Session::put('lang',$lang->id); 
					if(!empty(\Request::server('HTTP_REFERER'))){
						return \Redirect::back();
					}else{
						header("Location: ".\URL::to('/'));
					}
				}
			}
			
		}

	}