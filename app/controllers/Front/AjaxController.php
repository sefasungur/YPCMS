<?php namespace Front;

	/**
	* 
	*/
	class AjaxController extends \BaseController
	{
		
		public function getSubPage()
		{

			$getSubPages = "";

			if($_GET["animalSearch"] != "empty") {

				$getPages = \PageTranslation::leftJoin('pages', 'pages.id', '=', 'page_translations.page_id')->
				where('page_translations.title', 'like', '%' . $_GET["animalSearch"] . '%')->get();

				$html = "";

				$searchIds = array();

				foreach ($getPages as $g_p) {
					array_push($searchIds, $g_p->page_id);
					$html .= '<a href="'.asset($g_p->slug).'" class="list-group-item">'.$g_p->title.'</a>';
				}

				$location = \PageTranslation::leftJoin('pages', 'pages.id',  '=', 'page_translations.page_id')
					->whereIn('pages.id', $searchIds)->get();

				$locations = array();

				$counter = 1;

				foreach ($location as $l) {
					if($l->location != ""){
						$picture = \PageMedia::where('page_id', $l->page_id)->where('is_cover', 1)->get()->first();
						$pageLocation = explode(',', $l->location);
						$loca = array("<a href='$l->slug'>".( (isset($picture) && $picture->filename != "") ? "<img style='width: 80px' src='".asset('/uploads/Images/'.$picture->filename)."' alt=''/>" : "" )."</br>$l->title</a>", $pageLocation[0], $pageLocation[1], $counter);
						$counter++;
						array_push($locations, $loca);
					}
				}


				return \Response::json(['html' => $html, 'location' => $locations]);

			}

			if(isset($_GET["id"]) && $_GET["id"] != ""){
				if($_GET["id"] < 0){

					$parentId = str_replace("-", "", $_GET["id"]);

					$parentPage = \Page::where('pages.parent', $parentId)->get();

					$pageIds = array();

					$html = "";

					foreach ($parentPage as $p_p) {
						array_push($pageIds, $p_p->id);

					}
					$html = $this->theme->widget('article', ['page' => $p_p->parent])->render();
					$location = \PageTranslation::leftJoin('pages', 'pages.id',  '=', 'page_translations.page_id')
						->whereIn('pages.id', $pageIds)->get();
//					print_r($pageIds);exit;
				}
				else{

					$location = \PageTranslation::leftJoin('pages', 'pages.id',  '=', 'page_translations.page_id')
						->where('pages.id', $_GET["id"])->get();

					$html = '<a href="'.asset($location[0]->slug).'" class="list-group-item">'.$location[0]->title.'</a>';
//					$html = $this->theme->widget('article', ['page' => $_GET["id"]])->render();

				}
			}

			$locations = array();

			$counter = 1;

			foreach ($location as $l) {
				if($l->location != ""){
					$picture = \PageMedia::where('page_id', $l->page_id)->where('is_cover', 1)->get()->first();
					$pageLocation = explode(',', $l->location);
					$loca = array("<a href='$l->slug'>".( (isset($picture) && $picture->filename != "") ? "<img style='width: 80px' src='".asset('/uploads/Images/'.$picture->filename)."' alt=''/>" : "" )."</br>$l->title</a>", $pageLocation[0], $pageLocation[1], $counter);
					$counter++;
					array_push($locations, $loca);
				}
			}


			return \Response::json(['html' => $html, 'location' => $locations]);
		}

		public function postSearchSubPage()
		{


//			if(count($getPages) > 0){
//
//				return $this->getSubPage("-".$getPages->id);
//			}

			exit;

				$parentId = str_replace("-", "", \Input::get('id'));

				$parentPage = \Page::where('pages.parent', $parentId)->get();

				$pageIds = array();

				$html = "";

				foreach ($parentPage as $p_p) {
					array_push($pageIds, $p_p->id);
					$html .= $this->theme->widget('article', ['page' => $p_p->id])->render();
				}

				$location = \PageTranslation::leftJoin('pages', 'pages.id',  '=', 'page_translations.page_id')
					->whereIn('pages.parent', $pageIds)->get();

//			}
//			else{

				$location = \PageTranslation::leftJoin('pages', 'pages.id',  '=', 'page_translations.page_id')
					->where('pages.parent', \Input::get('id'))->get();

				$html = $this->theme->widget('article', ['page' => \Input::get('id')])->render();

//			}

			$locations = array();

			$counter = 1;

			foreach ($location as $l) {
				if($l->location != ""){
					$pageLocation = explode(',', $l->location);
					$loca = array("<a href='$l->slug'>$l->title</a>", $pageLocation[0], $pageLocation[1], $counter);
					$counter++;
					array_push($locations, $loca);
				}
			}


//			foreach ($location as $l) {
//				array_push($locations, $l->location);
//			}

//			print_r($loca);exit;

			return \Response::json(['html' => $html, 'location' => $locations]);
		}



		public function postSubPage(){
			$data['pages'] = [];
			$page = \Helper::menuList(\Input::get('id'));

			foreach ($page as $key => $p) {
				$data['pages'][] = [
					'id' => $p->id,
					'title' => $p->translation->title
				];
			}

			return json_encode($data);
		}
        
        
        public function postSurveyVote(){ 
            $status  = false;
            $message = "";
            if(isset($_POST["vote"]) && is_numeric($_POST["vote"])){
                $meta = \PageMeta::where('page_id', $_POST["vote"]);
                if(!$meta->count() > 0){                    
                    $newmeta =        new \PageMeta();
                    $newmeta->page_id = $_POST["vote"];
                    $newmeta->name    = "ip";
                    $newmeta->value   = $_SERVER['REMOTE_ADDR'];
                    $newmeta->save();
                   
                    $status  = true;
                    $message = "Oy kullanıldı.";
                }else{
                    $status  = false;
                    $message = "Daha önce oy kullanmışsınız.";
                }
            }       
            //return \Response::json(['status' => $status,'message' => $message]);
            echo json_encode(array('status' => $status,'message' => $message));
        }
        
        
        public function postUrunTypes()
        {
            $path = null;
            $cat = \Input::get('cat');
            if($cat == null or $cat == 0)
            {
                return false;
            }
            else
            {
                $Pages = \Page::select("*")->where("parent",$cat)->where("status",1)->orderBy("sorting","ASC");
                if($Pages->count())
                {
                    $Pages = $Pages -> get();
                    foreach($Pages as $page)
                    {
                        $path .= '<option value="'.$page->id.'">'.$page->translation->title.'</option>';
                    }
                }
            }
            return $path;
        }
        
        public function postCheckArac(){
        $type = \Input::get('type');
            if($type!=null or $type != 0)
            {
                $meta = \PageMeta::select("*")->where("page_id",$type)->where("name","arac")->where("value",1);
                if($meta -> count())
                {
                    return 1;
                }
                else
                {
                    return 0;
                }
            }
            else
            {
                return false;
            }
        }
    
}