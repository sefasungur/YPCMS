<?php namespace Front;

	/**
	* 
	*/
	use Session;
	class OrderController extends \BaseController{


		
		public function getStatus($code = ""){
			if(!empty($code)){
				$option = \PageMeta::select("*")->where('name','code')->where('value',$code);
				if ($option->count()) {
					$page = \Page::select("*")->where("id",$option->get()->first()->page_id);
					if($page->count()){
						$page = $page->get()->first();
						$pageTranslation = \PageTranslation::select("*")->where("page_id",$page->id); 
						if($pageTranslation->count()){
							$pageTranslation = $pageTranslation->get()->first();
							$data = array(
									"page" 		       => $page,
									"page_translation" => $pageTranslation
							);
							return \View::make('front.'.$page->template,$data);	
							break;
						}
					}
				}
			}
		}
		
		public function postSend(){  
			$rules = [
				'ad_soyad' 	=> 'required',
				'eposta' 	=> 'required|email',
				'telefon'	=> 'required',
				'fatura_adres'	=> 'required',
				'teslimat_adres'	=> 'required',
				'odeme_sekli' => 'required',
				'satis_sozlesmesi' => 'required',
				'lang' => 'required',
				'code' => 'required'
			];

			$validator = \Validator::make(\Input::all(), $rules);

			if ($validator->passes()){


				$basket = Session::get('basket');

				//hesapla
				if(!empty($basket)){
					if(!empty($basket["products"])){
						$page = new \Page();
						$page->user_id = 0;
						$page->parent = 857;
						$page->template = 'orderTracking';
						$page->status = \Input::get('status');
						$page->visible = \Input::get('visible');
						$page->lang = \Input::get('lang');
						$page->save();
						$page->replicate();

						$translation = new \PageTranslation();
						$translation->page_id = $page->id;
						$translation->title   = \Input::get('ad_soyad').' '.date("d-m-Y H:i:s",time()).' sipariş';
						$translation->content = 'Sipariş beklemede';
						if($translation->save()){
							foreach ($basket["products"] as $product){
								$productPage = \Page::select("*")->where("status",1)->where("id",$product["id"])->get()->first();
								if(!empty($productPage)){
									$meta = new \PageMeta();
									$meta->page_id = $page->id;
									$meta->name = 'product';
									$meta->value = $productPage->id;
									$meta->save();
								}
							}

							$meta = new \PageMeta();
							$meta->page_id = $page->id;
							$meta->name = 'total';
							$meta->value = $product["total"];
							$meta->save();

							$meta = new \PageMeta();
							$meta->page_id = $page->id;
							$meta->name = 'ad_soyad';
							$meta->value = \Input::get('ad_soyad');
							$meta->save();

							$meta = new \PageMeta();
							$meta->page_id = $page->id;
							$meta->name = 'eposta';
							$meta->value = \Input::get('eposta');
							$meta->save();

							$meta = new \PageMeta();
							$meta->page_id = $page->id;
							$meta->name = 'telefon';
							$meta->value = \Input::get('telefon');
							$meta->save();

							$meta = new \PageMeta();
							$meta->page_id = $page->id;
							$meta->name = 'fatura_adres';
							$meta->value = \Input::get('fatura_adres');
							$meta->save();

							$meta = new \PageMeta();
							$meta->page_id = $page->id;
							$meta->name = 'teslimat_adres';
							$meta->value = \Input::get('teslimat_adres');
							$meta->save();

							$meta = new \PageMeta();
							$meta->page_id = $page->id;
							$meta->name = 'odeme_sekli';
							$meta->value = \Input::get('odeme_sekli');
							$meta->save();

							$meta = new \PageMeta();
							$meta->page_id = $page->id;
							$meta->name = 'satis_sozlesmesi';
							$meta->value = \Input::get('satis_sozlesmesi');
							$meta->save();

							$meta = new \PageMeta();
							$meta->page_id = $page->id;
							$meta->name = 'lang';
							$meta->value = \Input::get('lang');
							$meta->save();

							$meta = new \PageMeta();
							$meta->page_id = $page->id;
							$meta->name = 'code';
							$meta->value = \Input::get('code');
							$meta->save();


							if($meta->save()){
								\Config::set('mail.port',\Helper::optionValue('smtp_port'));
								\Config::set('mail.username',\Helper::optionValue('smtp_username'));
								\Config::set('mail.password',\Helper::optionValue('smtp_password'));
								\Config::set('mail.host',\Helper::optionValue('smtp_server'));
								\Config::set('mail.encryption', '');
								\Config::set('mail.driver', 'smtp');

								\Mail::send('views.emails.orderAlert', ['name' => \Input::get('ad_soyad'),'eposta'=>\Input::get('eposta'),'phone'=>\Input::get('telefon')], function($message){
									$message->from(\Helper::optionValue('smtp_username'), \Input::get('ad_soyad'));
									$message->to('info@artsanart.com', 'Sipariş');
									$message->subject('Sipariş var');
								});

								\Mail::send('views.emails.order', ['orderTrackingUrl' => \URL::to("/siparis").'/'.\Input::get('code')], function($message){
									$message->from(\Helper::optionValue('smtp_username'), \Input::get('ad_soyad'));
									$message->to(\Input::get('eposta'), 'Siparişiniz alındı');
									$message->subject('Siparişiniz Alındı');
								});

								Session::put('basket',"");
								$return = ['status' => 'success',"message" =>"Siperişiniz alınmıştır :)",'code'=>\Input::get('code')];
							}
						}else{
							$page = \Page::findOrFail($page->id);
							$message = null;
							if($page->forceDelete()){
								$return = ['status' => 'error',"message" => "Siparişiniz gönderilemedi :( Lütfen daha sonra tekrar deneyiniz."];
							}else{
								$return = ['status' => 'error',"message" => "Siparişiniz gönderilemedi :( Lütfen daha sonra tekrar deneyiniz."];
							}
						}
					}else{
						$return = ['status' => 'error',"message" => "Sepetinizde hiç ürün yok ! Biraz alışveriş yapın"];
					}
				}else{
					$return = ['status' => 'error',"message" => "Sepetinizde hiç ürün yok ! Biraz alışveriş yapın"];
				}				
			}else{
				$return = ['status' => 'error',"message"=>"Lütfen tüm gerekli alanları doldurunuz"];
			}
			return \Response::json($return);
		}
	


	}