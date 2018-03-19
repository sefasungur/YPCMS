<?php

	/**
	* 
	*/
	use \Carbon\Carbon;
	class BackMenu extends \BaseController{

		public static function PagesTree($parent=0){
	        $categories = 	\Page::select("*")->where('parent',$parent)->orderBy('sorting', 'ASC');
	        
	        $path = "";
	        if($categories->count()){
	            $items = $categories->get();
	            if(!empty($items)){
		        	$path = '<ol class="dd-list">';
		        	foreach ($items as $item) {
			        	$path.='<li class="dd-item dd3-item" data-id='.$item->id.'>';
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
	    						$path.= BackMenu::PagesTree($item->id);
			        	$path.="</li>";
		        	}
			        $path.="</ol>";
		    	}
	        }
	        return $path;
		}
	}