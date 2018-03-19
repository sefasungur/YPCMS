<?php namespace Back;

	/**
	* 
	*/

	class AjaxController extends \BaseController{

		public function postSortableFilterPages(){
			$parent     = \Input::get('parent');
			$template   = \Input::get('template');
			$slider     = \Input::get('slider');
			$visible    = \Input::get('menu');
			$sorting    = \Input::get('sorting');
			$lang       = \Input::get('lang');
			$notice     = \Input::get('notice');
			$featured   = \Input::get('featured');

			if($sorting == "menu_sorting"){
				//$parent = "0";
			}else{
				//$parent = "none";
			}

			if($sorting == "template_sorting"){
				//$parent = "none";
			}

			if($sorting == "sorting"){
				//$parent = "0";
			}


			return \BackSortable::GetSortableFilterTree(
				$parent,
				$slider,
				"none",
				$visible,
				$template,
				$sorting,
				$lang,
				$notice,
				$featured
			);
		}

		public function postSearchPage(){
			$search   = \Input::get('search');
			$lang     = \Input::get('lang');
			
			if(!empty($lang) && !empty($search)){
				return \BackSortable::SearchPageWithTitle(
					$search,
					$lang
				);
			}
		}

		public function postCreate(){
			$message = array();
			$rules = [
				'title' => 'required'
			];
			$validator = \Validator::make(\Input::all(), $rules);
			if ($validator->passes()) {
				$page = new \Page();
				$page->user_id = \Auth::user()->id;
				$page->parent = \Input::get('parent');
				$page->template = \Input::get('template');
				$page->status = \Input::get('status');
				$page->visible = \Input::get('visible');
				$page->lang = \Input::get('lang');
				$page->save();
				$page->replicate();

				$translation = new \PageTranslation();
				$translation->page_id = $page->id;
				$translation->title = \Input::get('title');
                $translation->slug = $this->permalink(\Input::get('title'))."-".$page->id;
				if($translation->save()){
					$message = ['id' => $page->id,'status' => 'success', 'text' => 'İşlem yapıldı.' ,'html' => \BackSortable::addItem($page->id)["html"],"action" => true];
				}else{
					$message = ['status' => 'error', 'text' => $validator, "action" => true];
				}
			}else{
				$message = ['status' => 'error', 'text' => 'Gerekli Alanları Doldurunuz', "action" => true];
			}
			return \Response::json($message);
		}


		public function postGetPagesWithOption(){
			$message = array();
			if (\Request::ajax()){
				$parents = \Helper::getSelectListMenu(\Input::get('lang'));
				$message["html"] = "";
				foreach ($parents as $key => $parent) {
					$message["html"] .= '<option value="'.$key.'">'.$parent.'</option>';
				}
				$message['status'] = 'success'; 
				$message['text'] = 'İşlem yapıldı.';
			}else{
				$message['status'] = 'error'; 
				$message['text'] = 'Boş';
			}
			return \Response::json($message);
		}

		/*public function postGetPage(){
			if (\Request::ajax()) {
				$page = \Page::where('id',\Input::only('pk'))->first();

				$type = \Input::get('type');
				$detail = "widgets.page.edit.content";//{$type}

				$html = \View::make('widgets.page.edit')
						->withPages($page)
						->withDetail($detail)
						->render();
				return \Response::json(["html" => $html]);
			}
			return \App::abort(500);
		}*/

		public function getEditPage(){
			if (\Input::get('type') AND \Input::get('id')) {
				$page = \Page::findOrFail(\Input::get('id'));
				$type = \Input::get('type');
				$detail = "widgets.page.edit.{$type}";
				if (\View::exists($detail)) {
					$html = \View::make('widgets.page.edit')
							->withData($page)
							->withDetail($detail)
							->render();
					return \Response::json(["html" => $html]);
				}
			}
			return \App::abort(404);
		}

		public function getNextEditPage(){
			if(\Input::get('type') AND \Input::get('id')) {
				$nowPage = \Page::findOrFail(\Input::get('id'));
				$lang = \Input::get('lang');
				$page = \Page::select("*")->where("sorting",">",$nowPage->sorting)->where("parent",$nowPage->parent)->where("lang",$lang)->orderBy('sorting', 'ASC');
				if($page->count()){
					$page = $page->get()->first();
					$type = \Input::get('type');
					$detail = "widgets.page.edit.{$type}";
					if (\View::exists($detail)) {
						$html = \View::make('widgets.page.edit')
								->withData($page)
								->withDetail($detail)
								->render();
						return \Response::json(["html" => $html]);
					}
				}
			}
			return \App::abort(404);
		}

		public function getPreviousEditPage(){
			if(\Input::get('type') AND \Input::get('id')) {
				$nowPage = \Page::findOrFail(\Input::get('id'));
				$lang = \Input::get('lang');
				$page = \Page::select("*")->where("sorting","<",$nowPage->sorting)->where("parent",$nowPage->parent)->where("lang",$lang)->orderBy('sorting', 'DESC');
				if($page->count()){
					$page = $page->get()->first();
					$type = \Input::get('type');
					$detail = "widgets.page.edit.{$type}";
					if (\View::exists($detail)) {
						$html = \View::make('widgets.page.edit')
								->withData($page)
								->withDetail($detail)
								->render();
						return \Response::json(["html" => $html]);
					}
				}
			}
			return \App::abort(404);
		}


		public function postSortable(){
			if(\Request::ajax()) {
				$list    = \Input::get('data');
				$sorting = \Input::get('sorting');

				$data = json_decode($list);
				if($this->updateSortable($data,0,$sorting)){
					$message = ['status' => 'success', 'text' => 'Tamamlandı !' , "action" => true];
				}else{
					$message = ['status' => 'error', 'text' => 'Bir hata oluştu !' , "action" => true];
				}
			}
			return $message;
		}

		/*private function sortableSorting($data = null,$parent = 0,$sorting="sorting"){
			foreach ($data as $key => $value) {
				$page = \Page::find($value->id);
				$page->parent = $parent;
				$page->$sorting = $key;
				$page->save();
				if (array_key_exists('children', $value)) {
					$this->updateSortable($value->children, $value->id,$sorting);
				}
			}
			return true;
		}*/

		private function updateSortable($data = null, $parent = 0,$sorting="sorting"){
			foreach ($data as $key => $value) { 
				if(isset($value->id)){
					if(is_numeric($value->id)){
						$page = \Page::find($value->id);
						if(!empty($page)){
							if($sorting == "sorting"){				
								$page->parent = $parent;
							}
							$page->$sorting = $key; 
							$page->save();
							if (array_key_exists('children', $value)) {
								$this->updateSortable($value->children, $value->id,$sorting);
							}
						}
					}
				}
			}
			return true;
		}

		public function postTrashPage(){
			$page = \Page::findOrFail(\Input::get('page_id'));


			$message = null;
			if($page->forceDelete()){
				$message = ['status' => 'success', 'text' => 'İşlem yapıldı.' , "action" => true];
			}else{
				$message = ['status' => 'success', 'text' => 'Sayfa Silindi !', "action" => true];
			}
			return \Response::json($message);
		}

		public function postMediaUpdate()
		{
			$media = \PageMedia::findOrFail(\Input::get('id'));
			$key = \Input::get('name');
			$media->$key = \Input::get('value') === "true" ? 1 : 0;
			$media->save();
			return $media;
		}

		public function postMediaDelete()
		{
			$message = null;
			$media = \PageMedia::findOrFail(\Input::get('id'));
			if($media->forceDelete())
				$message = ['status' => 'success', 'text' => 'İşlem yapıldı.' , "action" => true];
			else
				$message = ['status' => 'danger', 'text' => 'İşlem yapılamadı.', "action" => false];
			return \Response::json($message);
		}

		public function getMediaSorting()
		{
			foreach (\Input::get('sort') as $key => $value) {
				$media = \PageMedia::findOrFail($value);
				$media->sorting = $key;
				$media->save();
			}
		}

		/*public function postPageTitleEdit()
		{
			$message = null;
			$page = \Page::find(\Input::get('pk'));
			$page->translation->title = \Input::get('value');
			$page->translation->slug = $this->permalink(\Input::get('value'));
			if($page->translation->save())
				$message = ['status' => 'success', 'text' => 'İşlem yapıldı.' , "action" => true];
			else
				$message = ['status' => 'danger', 'text' => 'İşlem yapılamadı.', "action" => false];
			return \Response::json($message);
		}*/
		
		private function permalink($string = null){
			$find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#');
			$replace = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp');
			$string = strtolower(str_replace($find, $replace, $string));
			$string = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $string);
			$string = trim(preg_replace('/\s+/', ' ', $string));
			$string = str_replace(' ', '-', $string);
			return $string;
			
			
		}

		public function postMediaTitleEdit()
		{
			$message = null;
			$media = \PageMedia::find(\Input::get('pk'));
			
		
			
			$media->title = \Input::get('value');
			
			if($media->save())
				$message = ['status' => 'success', 'text' => 'İşlem yapıldı.' , "action" => true];
			else
				$message = ['status' => 'danger', 'text' => 'İşlem yapılamadı.', "action" => false];
			return \Response::json($message);
		}

		public function postSettingsUpdate(){
			$items = \Input::all();
			if (array_key_exists('_token', $items)) {
				unset($items['_token']);
			}
			foreach ($items as $key => $value) {
				$option = \Options::where('name', '=', $key);
				if ($option->count()) {
					$option = $option->first();
					if ($option->value !== $value) {
						$option->value = $value;
					}
				}else{
					$option = new \Options();
					$option->name = $key;
					$option->value = $value;
				}
				$option->save();
			}
			$message = ['status' => 'success', 'text' => 'İşlem yapıldı.' , "action" => true];
			return \Response::json($message);
		}

		public function postPageMeta()
		{
			$meta = new \PageMeta();
			$meta->page_id = \Input::get('page_id');
			$meta->name = \Input::get('meta_name');
			$meta->value = \Input::get('meta_value');
			$message = [];
			if ($meta->save())
				$message = [
					'meta_id' => $meta->id,
					'name' => $meta->name,
					'value' => $meta->value,
					'status' => 'success',
					'text' => 'İşlem yapıldı.',
					"action" => true
				];
			else
				$message = ['status' => 'danger', 'text' => 'İşlem yapılamadı.', "action" => false];

			return \Response::json($message);
		}

		public function postPageMetaDelete()
		{
			$meta = \PageMeta::find(\Input::get('id'));
			$message = null;
			if($meta->forceDelete())
				$message = ['status' => 'success', 'text' => 'İşlem yapıldı.' , "action" => true];
			else
				$message = ['status' => 'danger', 'text' => 'İşlem yapılamadı.', "action" => false];
			
			return \Response::json($message);
		}

		public function getAutoCompletePageMeta()
		{
			$meta = \PageMeta::groupBy('name')->get();

			return \Response::json($meta);
		}

		public function postChangePageMap()
		{
			$maps = \PageMeta::where('page_id', \Input::get('id'))
					->whereName('coordinates');

			if ($maps->count()) {
				$maps = $maps->first();
				$maps->name = 'coordinates';
				$maps->value = \Input::get('gmapx') . ',' . \Input::get('gmapy');
			}else{
				$maps = new \PageMeta();
				$maps->page_id = \Input::get('id');
				$maps->name = 'coordinates';
				$maps->value = \Input::get('gmapx') . ',' . \Input::get('gmapy');
			}

			$message = [];
			if ($maps->save())
				$message = [
					'status' => 'success',
					'text' => 'Harita güncellendi.',
					"action" => true
				];
			else
				$message = ['status' => 'danger', 'text' => 'Harita güncellenemedi.', "action" => false];

			return \Response::json($message);
		}


		public function postChangeDetailPageMap()
		{
			$maps = \PageTranslation::where('page_id', \Input::get('id'))->get();

			if ($maps->count()) {
				$maps = $maps->first();
				$maps->location = \Input::get('gmapx') . ',' . \Input::get('gmapy');
			}


			$message = [];
			if ($maps->save())
				$message = [
					'status' => 'success',
					'text' => 'Harita güncellendi.',
					"action" => true
				];
			else
				$message = ['status' => 'danger', 'text' => 'Harita güncellenemedi.', "action" => false];

			return \Response::json($message);
		}


		

	}