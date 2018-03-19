<?php namespace Back;

	/**
	* 
	*/
	class UserController extends \BaseController
	{

		public function getIndex()
		{
			if (\Auth::user()->group == 1) {
				return \View::make('views.user.list',['users' => \User::get()]);
			}
			return \App::abort(403);
		}

		public function getCreate()
		{
			if (\Auth::user()->group == 1) {
				return \View::make('views.user.create');
			}
			return \App::abort(403);
		}

		public function postCreate()
		{
			$messages = array();
			$rules = [
				'username' => 'required|unique:users',
				'firstname' => 'required',
				'lastname' => 'required',
				'email'		=> 'required|email|unique:users',
				'password' => 'required|alpha_num|min:6|confirmed',
				'password_confirmation' => 'required',
			];

			$validator = \Validator::make(\Input::all(), $rules);
			if ($validator->passes()) {

				$user = new \User();

				$user->username = \Input::get('username');
				$user->group = \Input::get('group');
				$user->password = \Hash::make(\Input::get('password'));
				$user->email = \Input::get('email');
				$user->status = 1;
				$user->save();

				$profile = new \Profile();
				$profile->user_id = $user->id;
				$profile->firstname = \Input::get('firstname');
				$profile->lastname = \Input::get('lastname');
				$profile->save();

				$messages = ['status' => 'success', 'text' => 'Kullanıcı oluşturuldu'];
				
				return 	\Redirect::back()
						->withMessages($messages);
			}

			return \Redirect::back()
					->withErrors($validator)
					->withInput();

		}
		
		public function getProfile($user = 0)
		{
			$user = \User::findOrFail($user ? $user : \Auth::user()->id);
			return \View::make('views.user.profile',['user' => $user]);
		}

		public function postProfile()
		{
			$messages = array();
			
			$profile = \Profile::findOrFail(\Input::get('user_id'));
			$profile->firstname = \Input::get('firstname');
			$profile->lastname = \Input::get('lastname');
			$profile->about = \Input::get('about');
			if (\Input::get('group')) {
				$profile->user->username = \Input::get('username');
				$profile->user->group = \Input::get('group');
				$profile->user->save();
			}
			
			if ($profile->save()) {
				$messages = ['status' => 'success', 'text' => 'Güncelleme işlemi gerçekleşti.'];
			}else{
				$messages = ['status' => 'danger', 'text' => 'Güncelleme işlemi gerçekleşmedi. Tekrar deneyin.'];
			}
			return 	\Redirect::back()
					->withMessages($messages);
		}

		public function postChangePassword()
		{
			$messages = array();
			$rules = [
				'password' => 'required|alpha_num|min:4|confirmed',
				'password_confirmation' => 'required',
			];
			$validator = \Validator::make(\Input::all(), $rules);
			if ($validator->passes()) {
				$user = \User::findOrFail(\Input::get('user_id'));
				$user->password = \Hash::make(\Input::get('password'));
				$user->save();
				
				$messages = ['status' => 'success', 'text' => 'Şifre değiştirildi'];
				return 	\Redirect::back()
						->withMessages($messages);
			}
			return \Redirect::back()
					->withErrors($validator)
					->withInput();
		}

		public function getDelete($id)
		{
			$page = \User::find($id);
			$message = null;
			if($page->delete())
				$message = ['status' => 'success', 'text' => 'İşlem yapıldı.' , "action" => true];
			else
				$message = ['status' => 'danger', 'text' => 'İşlem yapılamadı.', "action" => false];
			return \Redirect::back()->withMessages($message);
		}
	}