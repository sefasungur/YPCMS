<?php

	use \Carbon\Carbon;
	class BackSortable extends \BaseController{

		public static function GetSortableFilterTree($parent="none",$is_slider="none",$status="none",$visible="none",$template="none",$sorting="sorting",$lang="none",$notice="none",$featured="none"){
	        $message = ['status' => '', 'text' => '' , "action" => true,"html" =>""];
	        $pages = 	\Page::select("*");

	        if($parent != "none"){ 
				$pages = $pages->where('parent',$parent);
	        }
	        if($template != "none"){ 
				$pages = $pages->where('template',$template);
	        }
	        if($is_slider != "none"){ 
				$pages = $pages->where('is_slider',$is_slider);
	        }
	        if($visible != "none"){ 
				$pages = $pages->where('visible',$visible);
	        }
	        if($status != "none"){ 
				$pages = $pages->where('status',$status);
	        }	
	        if($lang != "none"){ 
				$pages = $pages->where('lang',$lang);
	        }
            if($notice != "none"){ 
				$pages = $pages->where('notice',$notice);
	        }
            if($featured != "none"){ 
				$pages = $pages->where('featured',$featured);
	        }
	       
	        $pages = $pages->orderBy($sorting, 'ASC');


	        if($pages->count()){
	            $items = $pages->get();
	            if(!empty($items)){
		        	$message["html"] = '<ol class="dd-list">';
		        	foreach ($items as $item) {
		        		$subPages = \Page::select("*")->where('parent',$item->id)->where('lang',$lang)->orderBy('sorting', 'ASC');
			        	$message["html"].='<li class="dd-item dd3-item" data-id='.$item->id.' id="page-'.$item->id.'">';
			        		if($subPages->count()){
		    					$message["html"] .= '<button data-action="collapse" type="button" style="display: none;">Collapse</button>
		    					<button data-action="expand" type="button" style="display: block;">Expand</button>';
		    				}
			        		$message["html"].='<div class="dd-handle dd3-handle">Sırala</div>';
			        			$message["html"].='<div class="dd3-content">';
			        			if(!empty($item->translation->title)){
			        				$message["html"].= \HTML::link(
			        					"#", 
			        					$item->translation->title,
			        					[
			        						'class' => 'showPageSettings',
			        						'data-pk' => $item->id,
			        						'title' => $item->translation->title
			        					]
			        				);
			        			}
			        			$message["html"] .= "</div>";
		    					if($subPages->count()){
		    						$message["html"] .= '<ol class="dd-list"></ol>';
		    					}
			        			//$message["html"] .= BackSortable::GetSortableFilterTree($item->id,$is_slider,$status,$visible,$template,$sorting,$lang)["html"];
			        	$message["html"].="</li>";
		        	}
			        $message["html"].="</ol>";
		    	}
		    	$message["status"] = "success";
		    	$message["text"] = $pages->count()." adet sayfa bulundu";
	        }else{
	        	$message["status"] = "success";
	        	$message["text"] = "Hiç sayfa bulamadık";
	        	if($parent == 0 || $parent == "none"){
					$message["html"] = '<ol class="dd-list"><div class="alert alert-danger"><strong>Malesef !</strong>Bu kriterlerde hiç sayfa yok</div></ol>';
	        	}
	        }
	        return $message;
		}

		public static function addItem($page=false){
			$message = array();
			$pages = \Page::select("*")->where('id',$page);
			if($pages->count()){
	            $item = $pages->get()->first();
				$message["html"] = '<li class="dd-item dd3-item" data-id='.$item->id.' id="page-'.$item->id.'">';
				    $message["html"].='<div class="dd-handle dd3-handle">Sırala</div>';
				        $message["html"].='<div class="dd3-content">';
				        if(!empty($item->translation->title)){
				        	$message["html"].= \HTML::link(
				        		"#", 
				        		$item->translation->title,
				        		[
				        			'class' => 'showPageSettings',
				        			'data-pk' => $item->id,
				        			'title' => $item->translation->title
				        		]
				        	);
				        }
				    $message["html"] .= "</div>";
				$message["html"].="</li>";
				$message["status"] = "success";
		    	$message["text"] = "Sayfa Eklendi";
			}else{
				$message["status"] = "error";
		    	$message["text"] = "Sayfa Eklenemedi";
				$message["html"] = "";
			}
			return $message;
		}

		public static function GetSortable($parent=0,$lang=1){
	        $categories = 	\Page::select("*")->where('parent',$parent)->where('lang',$lang)->orderBy('sorting', 'ASC');
	        
	        $path = ""; 
	        if($categories->count()){
	            $items = $categories->get();
	            if(!empty($items)){
		        	$path = '<ol class="dd-list">';
		        	foreach ($items as $item) {
			        	$path.='<li class="dd-item dd3-item" data-id='.$item->id.' id="page-'.$item->id.'">';
			        		$path.='<div class="dd-handle dd3-handle">Sırala</div>';
			        			$path.='<div class="dd3-content">';
			        				if(!empty($item->translation->title)){
			        				$path.= \HTML::link(
			        							"#", 
			        							$item->translation->title,
			        							[
			        								'class' => 'showPageSettings',
			        								'data-pk' => $item->id,
			        								'title' => $item->translation->title
			        							]
			        						);
			        			}
			        			$path.= "</div>";
			        			$subPages = \Page::select("*")->where('parent',$item->id)->where('lang',$lang)->orderBy('sorting', 'ASC');
	    						if($subPages->count()){
	    							$path .= '<ol class="dd-list"></ol>';
	    						}
	    						//$path.= BackSortable::GetSortable($item->id);
			        	$path.="</li>";
		        	}
			        $path.="</ol>";
		    	}
	        }
	        return $path;
		}



		public static function SearchPageWithTitle($title,$lang){
	        $pages = \PageTranslation::select("*")
	        ->where('lang',$lang)
	        ->where('title', 'LIKE', "%$title%")
	        ->join('pages', 'page_translations.page_id', '=', 'pages.id');
	        
	        $path = ""; 
	        if($pages->count()){
	            $items = $pages->get();
	            if(!empty($items)){
		        	$path = '<ol class="dd-list">';
		        	foreach ($items as $item) { 
			        	$path.='<li class="dd-item dd3-item" data-id='.$item->page_id.' id="page-'.$item->page_id.'">';
			        		$path.='<div class="dd-handle dd3-handle">Sırala</div>';
			        			$path.='<div class="dd3-content">';
			        				if(!empty($item->title)){
			        				$path.= \HTML::link(
			        							"#", 
			        							$item->title,
			        							[
			        								'class' => 'showPageSettings',
			        								'data-pk' => $item->page_id,
			        								'title' => $item->title
			        							]
			        						);
			        			}
			        			$path.= "</div>";
			        	$path.="</li>";
		        	}
			        $path.="</ol>";
		    	}
	        }
	        return $path;
		}

	}