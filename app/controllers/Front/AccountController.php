<?php namespace Front;

class AccountController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getLogin()
	{
		//
		\Auth::logout();
		return \View::make('views.account.login')
				->withMessages(['text' => 'Bu alana giriş yapabilmek için yetkiniz bulunmamaktadır', 'status' => 'danger']);
	}

	public function postLogin()
	{
		$rules = [
			'username' => 'required|alpha_num|exists:users,username',
			'password' => 'required'
		];

			$validator = \Validator::make(\Input::all(),$rules);
			if ($validator->passes()) {
				$user = \User::whereUsername(\Input::get('username'))->firstOrFail();
				$message = array();
				
				if ($user->status !== 0) {
					if (\Auth::attempt(['username' => \Input::get('username'), 'password' => \Input::get('password')], \Input::get('remember') ? true : false))
					{
						return \Redirect::action('Back\BackController@getIndex');
					}else{
						$message = ['text' => 'Kullanıcı adı/şifre hatalı', 'status' => 'danger'];
					}		
				}else{
					$message = ['text' => 'Kullanıcı aktif değil', 'status' => 'info'];
				}
			
				return \Redirect::back()->withMessages($message);
			
			}

			return 	\Redirect::back()
					->withErrors($validator)
					->withInput();
	}

	
	public function getResetPassword(){
		return \View::make('views.account.resetPassword');
	}
	public function postResetPassword(){
		$user = \User::where("email",\Input::get('email'));
		if($user->count()){
			$user = $user->get()->first();
			if(!empty($user->email)){
				$pass = rand(10000,90000);
				$passHash = \Hash::make($pass);
				$settings = \DB::table('options')->select('name','value')
				->where('name','smtp_port')
				->orWhere('name','smtp_username')
				->orWhere('name','smtp_password')
				->orWhere('name','smtp_server')
				->get();
				foreach ($settings as $key => $s){ $settings[$s->name] = $s->value; unset($settings[$key]); }
				\Config::set('mail.port',$settings["smtp_port"]);
				\Config::set('mail.username',$settings["smtp_username"]);
				\Config::set('mail.password',$settings["smtp_password"]);
				\Config::set('mail.host',$settings["smtp_server"]);
				\Config::set('mail.encryption', '');
				\Config::set('mail.driver', 'smtp');

				\Mail::send('views.emails.newsletter', ['data' => array("Yeni Şifreniz"=>$pass)], function($message){
					$message->from(\Helper::optionValue('smtp_username'),"ArtSanart");
					$message->to(\Input::get('email'),'Yeni Şifreniz');
					$message->subject('Şifre Talebi');
				});
				
				$user = \User::findOrFail($user->id);
				$user->password = $passHash;
				if($user->save()){
					$message = ['status' => 'success' , 'text' => 'Şifreniz eposta adresinize gönderildi'];
				}else{
					$message = ['status' => 'error' , 'text' => 'Şifreniz gönderilemedi'];
				}
				return 	\Redirect::back()
						->withMessages($message)
						->withInput();
			}
		}else{
			$message = ['status' => 'error' , 'text' => 'Eposta Geçersiz'];
			return 	\Redirect::back()
						->withMessages($message)
						->withInput();
		}

		return \View::make('views.account.resetPassword');
		//destek@birboluiki.com
	}


	public function getRegister()
	{
		return \View::make('views.account.register');
	}

}
