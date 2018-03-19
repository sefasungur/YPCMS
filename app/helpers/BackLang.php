<?php

	use \Carbon\Carbon;
	class BackLang extends \BaseController{

		
		public static function getLangs(){
	        $langs = 	\Language::select("name","id")->orderBy('sorting', 'ASC');
	        $return = array();
	        if($langs->count()){
	        	$langs = $langs->get()->toArray(); 
	        	foreach ($langs as $lang) {
	        		$return[$lang["id"]] = $lang["name"];
        		}
	            return $return;
	        }
	          
		}


	}