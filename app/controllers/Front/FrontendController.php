<?php namespace Front;

	/**
	* 
	*/
	class FrontController extends \BaseController{

		public function getMain($page = null){ 
			

			


			$data = array();
			$template = "home";
			if ($page === null) {
				$detail = \PageTranslation::whereSlug("turler-ve-irklar")->get()->first();
				$data = ['slug'=> $page, 'element' => new \Details($detail->page_id),'detail' => $detail, 'pages' => \Page::find($detail->page_id)];

				$this->theme->set('title', "Anasayfa");
				$this->theme->set('keywords', \Helper::optionValue('site_keywords'));
				$this->theme->set('description', \Helper::optionValue('site_description') );
			}

			if ($page !== null) {
				$detail = \PageTranslation::whereSlug($page);
				if ($detail->count()) {
					$detail = $detail->first();
					$template = $detail->page->template;

					$this->theme->breadcrumb()->add(array(
						array(
							'label' => 'Anasayfa',
							'url'   => asset('/')
						),
						array(
							'label' => $detail->title,
							'url'   => asset($detail->slug)
						),
					));

					if ( $detail->title ) {
						$this->theme->setTitle( $detail->title);
					}
					if ( $detail->summary ) {
						$this->theme->set('description', $detail->summary);
					}else{
						$this->theme->set('description', \Helper::optionValue('site_description') );
					}

					if ( $detail->tags) {
						$this->theme->set('keywords', $detail->tags);
					}else{
						$this->theme->set('keywords', \Helper::optionValue('site_keywords') );
					}

					$this->theme->set('slug', $page);
					$this->theme->set('detail', $detail);
					$this->theme->set('active', false);

					$data = ['slug'=> $page, 'element' => new \Details($detail->page_id),'detail' => $detail, 'pages' => \Page::find($detail->page_id)];
				}else{
					return \App::abort(404);
				}
			} 
			return $this->theme->scope("template.".$template,$data)->render();
		}

		/*public function getThumb()
		{
			$file = \Input::get('file');
			if ($file) {
				\App::make('phpthumb')
					->create('resize', array($file, 100, 100, 'adaptive'))
					->show();
			}

			return \App::abort(404);
		}*/

		public function search(){

			if($_POST){

				$pages = \PageTranslation::where('title', 'like', "%".$_POST["search_text"]."%")->
										   orWhere('content', 'like', "%".$_POST["search_text"]."%")->get();

				return \View::make('views.search.site_search')
					->withPages($pages);

			}

		}
		
		

	}