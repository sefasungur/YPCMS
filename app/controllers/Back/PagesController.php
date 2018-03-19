<?php namespace Back;

	/**
	* 
	*/

	use \Carbon\Carbon;
	use Imagick;

	class PagesController extends \BaseController{
        
        //Sayfa kopyalar
        public function postCopy($id=null,$parent=0,$parent_get=0){
				if(!empty($id)){
                    $page = \Page::findOrFail($id);
				}else{
                    $page = \Page::findOrFail(\Input::get('page_id'));
                    $parent = 0;
                    $parent_get = \Input::get('parent');
				}
				$lang = \Input::get('lang');

				$copyPage = new \Page();
				$copyPage->user_id  = $page->user_id;
				$copyPage->parent   = $parent;
				$copyPage->template = $page->template;
				$copyPage->status   = $page->status;
				$copyPage->visible  = $page->visible;
				$copyPage->target   = $page->target;
				$copyPage->lang     = $page->is_slider;
				$copyPage->lang     = $lang;
				$copyPage->save();
				$copyPage->replicate();

				$translation = \PageTranslation::where(['page_id' => $page->id])->first();
				$copyTranslation = new \PageTranslation();
				$copyTranslation->page_id = $copyPage->id;
				$copyTranslation->title   = $translation->title;
				$copyTranslation->content = $translation->content;
				$copyTranslation->summary = $translation->summary;
				$copyTranslation->slug    = $translation->slug."-".$copyPage->id;
				if($copyTranslation->save()){
						$images = \PageMedia::select("*")->where("page_id",$page->id)->get();
						foreach ($images as $image) {
                            $name = 'copy_'.time().rand(0,999999).$image->filename;
                            $to = 'uploads/Images/'.$name;
                            file_put_contents($to, file_get_contents($image->full_url));
                            $copyMedia = new \PageMedia();
                            $copyMedia->page_id	  			=   $copyPage->id;
                            $copyMedia->title				=   $image->title;
                            $copyMedia->filename			=   $name;
                            $copyMedia->url					=   $image->url;
                            $copyMedia->full_url			=   $to;
                            $copyMedia->type				=   $image->type;
                            $copyMedia->is_slider			=   $image->is_slider;
                            $copyMedia->is_gallery			=   $image->is_gallery;
                            $copyMedia->is_cover		    =   $image->is_cover;
                            $copyMedia->facebook_share	    =   $image->facebook_share;
                            $copyMedia->twitter_share		=   $image->twitter_share;
                            $copyMedia->sorting				=   $image->sorting;
                            $copyMedia->save();
                            $copyMedia->replicate();
						}

						if($parent_get == 1){
								$altPages  = \Page::where("parent",$page->id);
								if($altPages->count()){
										$altPages = $altPages->get();
										foreach($altPages as $altPage){
												$this->postCopy($altPage->id,$copyPage->id,1);
										}
								}
						}

						$message = ['id' => $page->id,'status' => 'success', 'text' => 'Ä°ÅŸlem yapÄ±ldÄ±.' ,'html' => "","action" => true];
				}else{
					$message = ['status' => 'error', 'text' => $validator, "action" => true];
				}
		}
        

		public function getIndex(){
			$pages = \Page::where('parent',0)->get();
			return \View::make('views.pages.index')
					->withPages($pages);
		}

		public function postMainUpdate(){
			$page = \Page::findOrFail(\Input::get('page_id'));
			$page->status = \Input::get('status');
			$page->visible = \Input::get('visible');
			$page->is_slider = \Input::get('is_slider');
			$message = [];
			if ($page->save()) {
					$message = [
					'status' => 'success', 
					'text' => 'Güncellendi', 
					'action' => true
					];
			}else{
				$message = [
					'status' => 'danger', 
					'text' => 'Hata oluştu', 
					'action' => false
					];
			}
			if (\Request::ajax()) {
				return \Response::json($message);
			}
			return \Redirect::back()
					->withMessages($message);
		}

		public function postEditContent(){
			$translation = \PageTranslation::where(['page_id' => \Input::get('page_id')])
							->first();
			$translation->content = \HTML::entities(\Input::get('content'));
			$translation->summary = \Input::get('summary');
			$translation->tags = count(\Input::get('tags')) ? implode(',', \Input::get('tags')) : \Input::get('tags');
			$message = [];
			if ($translation->save()) {
				$message = [
					'status' => 'success', 
					'text' => 'İçerik bilgileri güncellendi', 
					'action' => true
					];
			}else{
				$message = [
					'status' => 'danger', 
					'text' => 'İçerik bilgileri güncellenirken sorun oluştu', 
					'action' => false
					];
			}
			if (\Request::ajax()) {
				return \Response::json($message);
			}
			return \Redirect::back()
					->withMessages($message);
		}
                
                public function postEditPrice(){
			$translation = \PageTranslation::where(['page_id' => \Input::get('page_id')])
							->first();
			$translation->price = \HTML::entities(\Input::get('price'));
			$translation->price_detail_1 = \Input::get('price_detail_1');
                        $translation->price_detail_2 = \Input::get('price_detail_2');
                        $translation->price_detail_3 = \Input::get('price_detail_3');
                        $translation->price_detail_4 = \Input::get('price_detail_4');
                        $translation->price_detail_5 = \Input::get('price_detail_5');
			$message = [];
			if ($translation->save()) {
				$message = [
					'status' => 'success', 
					'text' => 'İçerik bilgileri güncellendi', 
					'action' => true
					];
			}else{
				$message = [
					'status' => 'danger', 
					'text' => 'İçerik bilgileri güncellenirken sorun oluştu', 
					'action' => false
					];
			}
			if (\Request::ajax()) {
				return \Response::json($message);
			}
			return \Redirect::back()
					->withMessages($message);
		}

		private function permalink($string = null){
			$find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#');
			$replace = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp');
			$string = strtolower(str_replace($find, $replace, $string));
			$string = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $string);
			$string = trim(preg_replace('/\s+/', ' ', $string));
			$string = str_replace(' ', '-', $string);
			return $string;	
		}

		public function postEditInformation(){
			$page = \Page::findOrFail(\Input::get('page_id'));
			$page->parent = \Input::get('parent');
			$page->target = \Input::get('target');
			$page->template = \Input::get('template');
			$page->started_at = \Helper::timestamps(\Input::get('started_at'));
			$page->expired_at = \Helper::timestamps(\Input::get('expired_at'));
			$page->status = \Input::get('status');
			$page->visible = \Input::get('visible');
			$page->visible_sub = \Input::get('visible_sub');
			$page->is_slider = \Input::get('is_slider');
			$page->featured = \Input::get('featured');
			$page->cuff = \Input::get('cuff');
			$page->topmenu = \Input::get('topmenu');
			$page->is_guide = \Input::get('is_guide');
			$page->notice = \Input::get('notice');
			$message = [];
			if ($page->save()) {
				$translation = \PageTranslation::where(['page_id' => $page->id])->first();
				$translation->title = \Input::get('title');
				$translation->slug = $this->permalink(\Input::get('title')).$page->id.".html";
				$translation->save();

				$message = [
					'status' => 'success', 
					'text' => 'Bilgiler güncellendi',
					'action' => true
					];
			}else{
				$message = [
					'status' => 'danger', 
					'text' => 'Bilgiler güncellenirken sorun oluştu',
					'action' => false
					];
			}

			if (\Request::ajax()) {
				return \Response::json($message);
			}
			return \Redirect::back()
					->withMessages($message);
		}

		public function postMediaUpload(){
			$file = \Input::file('file');
			if($file) {
				$folder = "";
				$image = false;
				switch ($file->getMimeType()) {
					case 'application/pdf':
						$folder = "Pdf";
						break;
					case 'image/png':
						$folder = "Images";
						$image = true;
						break;
					case 'image/gif':
						$folder = "Images";
						$image = true;
						break;
					case 'image/jpeg':
						$folder = "Images";
						$image = true;
						break;
					default:
						$folder = "Others";
						break;
				}
	        	$destinationPath = public_path() . '/uploads/' . $folder;
	        	$realName = $file->getClientOriginalName();
	        	$randomString = "bb2_" . \Str::random(32) . '.';
		        $filename = $randomString . $file->getClientOriginalExtension();
		        $upload_success = \Input::file('file')->move($destinationPath, $filename);
		        $message = [];
		        if ($upload_success) {
		        	$media = new \PageMedia();
		        	$media->page_id = \Input::get('page_id');
		        	$media->filename = $filename;
		        	$media->url  = "/uploads/{$folder}";
		        	$media->full_url  = "uploads/{$folder}/{$filename}";
		        	$media->type = $file->getClientOriginalExtension();
		        	$media->is_slider = 0;
		        	$media->is_gallery = 1;
		        	if ($media->save()) {
		        		if ($file->getClientOriginalExtension() == "pdf") {
		        			
		        			/*$pdfImage = new \Imagick("uploads/{$folder}/{$filename}[0]");
		        			$folder = "Images/PDF-Cover";
		        			$filename = $randomString . "pdf";
		        			$pdfImage->writeImage(public_path() . "/uploads/{$folder}/{$filename}");
		        			$pdfImage->destroy();
		        			$pdfCover = \Img::make("uploads/{$folder}/{$filename}");
		        			$pdfCover->save(public_path() . "/uploads/{$folder}/{$filename}");*/
		        			$message = [
				        		'fileid' => $media->id,
				        		'filename' => $filename,
				        		'full_url' => asset("uploads/{$folder}/{$filename}"),
				        		'status' => 'success',
				        		'action' => true,
				        		'text' => "<strong>{$realName}</strong> kayıt işlemi gerçekleşti"
				        	];
		        		}elseif($image){
		        			$remake = \Img::make("uploads/{$folder}/{$filename}");
		        			if ($remake->width() > 1920) {
		        				$remake->resize(1920, null, function ($constraint){
		        					$constraint->aspectRatio();	
		        				});
		        			}elseif($remake->height() > 960){
		        				$remake->resize(null, 960, function ($constraint){
		        					$constraint->aspectRatio();	
		        				});
		        			}
		        			$remake->save(public_path() . "/uploads/{$folder}/{$filename}");

		        			$message = [
				        		'fileid' => $media->id,
				        		'filename' => $filename,
				        		'full_url' => asset("uploads/{$folder}/{$filename}"),
				        		'status' => 'success',
				        		'action' => true,
				        		'text' => "<strong>{$realName}</strong> kayıt işlemi gerçekleşti"
				        	];
		        		}
		        	}else{
		        		$message = [
			        		'status' => 'danger',
			        		'action' => false,
			        		'text' => "<strong>{$realName}</strong> kayıt işleminde sorun oluştu"
			        	];
	        		}
		        }else {
		        	$message = [
		        		'status' => 'danger',
		        		'action' => false,
		        		'text' => "<strong>{$realName}</strong> yükleme işleminde sorun oluştu"
		        	];
		        }
		        return \Response::json($message);
		    }
		}


		public function postPageMeta(){
			$items = \Input::all();
			$message = null;
			if (array_key_exists('_token', $items)) {
				unset($items['_token']);
			}
			foreach ($items as $key => $value) {
				$meta = \PageMeta::where('name', '=', $key)
						->where('page_id', '=', \Input::get('page_id'));
				if ($meta->count()) {
					$meta = $meta->first();
					if ($meta->value !== $value) {
						$meta->value = $value;
					}
				}else{
					$meta = new \PageMeta();
					$meta->name = $key;
					$meta->value = $value;
				}
			}
			if($meta->save())
				$message = ['status' => 'success', 'text' => 'İşlem yapıldı.' , "action" => true];
			else
				$message = ['status' => 'danger', 'text' => 'İşlem yapılamadı.', "action" => false];
			
			if (\Request::ajax()) {
				return \Response::json($message);
			}
			return \Redirect::back()
					->withMessages($message);
		}

        
        
        
		public function getTrash(){
            $id = \Input::get('id');
            if(!empty($id) && is_numeric($id)){
                \Page::where("id",$id);
                \PageTranslation::where("page_id",$id)->delete();
                $message = null;
                if($page->forceDelete())
                    $message = ['status' => 'success', 'text' => 'İşlem yapıldı.' , "action" => true];
                else
                    $message = ['status' => 'danger', 'text' => 'İşlem yapılamadı.', "action" => false];
                return \Redirect::action("Back\PagesController@getIndex")->withMessages($message);
            }			
		}



        
        
        



}