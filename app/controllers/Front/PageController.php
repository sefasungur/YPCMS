<?php namespace Front;

	/**
	* 
	*/
	use Session;
	class PageController extends \BaseController{
		public function Get($slug = null){  
			$lang = Session::get('lang');
			if(empty($lang)){
				Session::put('lang',1); 
				$lang = 1;
			}
			if(!empty($slug)){ 
				$pageTranslations = \PageTranslation::select("*")->where("slug",$slug)->get(); 
				if(!empty($pageTranslations)){ 
					foreach ($pageTranslations as $pageTranslation){ 
						$page = \Page::select("*")->where("id",$pageTranslation->page_id)->where("status",1)->get()->first();
						if(!empty($page)){ 
							if($page->lang == $lang){  
                                $date = strtotime($page->expired_at);
                                $dated = date("d",$date);
                                $datem = date("m",$date);
                                $datey = date("Y",$date);
                                
                                $nowdated = date("d",time());
                                $nowdatem = date("m",time());
                                $nowdatey = date("Y",time());
                                
                                if($page->expired_at != "0000-00-00" && $page->expired_at != "1970-01-01"){  
                                    if($dated != $nowdated && $datem != $nowdatem && $datey != $nowdatey){
                                        $data = array(
                                            "page" 		       => $page,
                                            "page_translation" => $pageTranslation
                                        );
                                        return \View::make('front.'.$page->template,$data);	
                                        break;
                                    }
                                }else{  
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

					header("Location: ".\URL::to('/'));
				}else{
					return \View::make('front.notfound');
				}
			}else{
                $page = \Page::select("*")->where("template","home");
                if($page->count() > 0){
                    $page = $page->get()->first();
                    $pageTranslations = \PageTranslation::select("*")->where("page_id",$page->id);
                    if($pageTranslations->count() > 0){
                        $pageTranslations = $pageTranslations->get()->first();
                        $data = array(
                            "page" 		       => $page,
                            "page_translation" => $pageTranslation
                        );
                        return \View::make('front.home',$data);	
                    }
                }else{
                    return \View::make('front.home');
                }				
			}
		}
		
		public function Home(){
			$lang = Session::get('lang');
			if(empty($lang)){
				Session::put('lang',1); 
			}
			$page = \Page::select("*")->where("template","home");
            if($page->count() > 0){
                $page = $page->get()->first();
                $pageTranslation = \PageTranslation::select("*")->where("page_id",$page->id);
                if($pageTranslation->count() > 0){
                    $pageTranslation = $pageTranslation->get()->first();
                    $data = array(
                        "page" 		       => $page,
                        "page_translation" => $pageTranslation
                    );
                    return \View::make('front.home',$data);	
                }
            }else{
                return \View::make('front.home');
            }
		}

		public function search() {

		    $q = Input::get('myInputField');

		    $searchTerms = explode(' ', $q);

		    $query = DB::table('products');

		    foreach($searchTerms as $term)
		    {
		        $query->where('name', 'LIKE', '%'. $term .'%');
		    }

		    $results = $query->get();

		}


		
		
	}