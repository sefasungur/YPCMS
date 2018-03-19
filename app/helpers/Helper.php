<?php

	/**
	* 
	*/
	use \Carbon\Carbon;
	class Helper extends \BaseController{
		private $dependencies = array();

		public static function getAdsSelectListMenu(){
			$data = [];
			$pages = \Page::where('status',1)->where("is_ads",1)->get();
			$data[0] = "Seçimsiz";
			foreach ($pages as $page) {
				if (!empty($page->translation->title)) { //hata düzeltildi
					$data[$page->id] = "[".$page->template."] ".$page->translation->title;
				}
			}
			return $data;
		}
		public static function getAdsLineSelectListMenu(){
			$data = [];
			$pages = \Page::where('status',1)
			->where("is_ads",1)
			->where("template","blogListAdsList")
			->get();
			$data[0] = "Seçimsiz";
			foreach ($pages as $page) {
				if (!empty($page->translation->title)) { //hata düzeltildi
					$data[$page->id] = "[".$page->template."] ".$page->translation->title;
				}
			}
			return $data;
		}

		public static function optionValue($key = null){
			if ($key) {
				$option = Options::whereName($key);
				if ($option->count()) {
					return $option->first()->value;
				}
			}
			return false;
		}

		public static function getSelectListMenu($lang=1){ 
			$data = [];
			$pages = \Page::where('status',1)->where('lang',$lang)->get();
			$data["none"] = "Seçimsiz";
			foreach ($pages as $page) {
				if (!empty($page->translation->title)) { //hata düzeltildi
					$data[$page->id] = "[".$page->template."] ".$page->translation->title;
				}
			}
			return $data;
		}
                
                public static function selectPageMenu($lang=1){ 
			$data = [];
			$pages = \Page::where('status',1)->where('lang',$lang)->get();
			foreach ($pages as $page) {
				if (!empty($page->translation->title)) { //hata düzeltildi
					$data[$page->id] = $page->translation->title;
				}
			}
			return $data;
		}

		public static function AllTagsList(){
			$pages = \PageTranslation::get();
			$tags = [];
			foreach ($pages as $page) {
				if ($page) {
					$tag = explode(',', $page->tags);
					foreach ($tag as $t) {
						if (!in_array($t,$tags)) {
							$tags[$t] = $t;
						}
					}
				}
			}

			return $tags;
		}

		public static function thumb($type = null, $file = null){
			if(is_file($file)) {
				$folder = "Images/thumbs";
				$size = getimagesize($file);
				$width = $size[0];
				$height = $size[1];
				switch ($type) {
					case 'xsmall':
						$height = $size[1] / 8;
						$width = $size[0] / 8;
						break;
					case 'small':
						$height = $size[1] / 5;
						$width = $size[0] / 5;
						break;
					case 'medium':
						$height = $size[1] / 2;
						$width = $size[0] / 2;
						break;
					case 'large':
						$height = $size[1] / 0.3;
						$width = $size[0] / 0.3;
						break;
					case 'full':
							continue;
						break;
					default:
						$size = explode('x', $type);
						$width = $size[0];
						$height = $size[1];
						break;
				}
				$width = round($width);
				$height = round($height);

				$filename = explode('/', $file);				
				$filename = "thumb_{$width}x{$height}_".$filename[count($filename)-1];
				$path = public_path()."/uploads/{$folder}/";

				if (!file_exists($path.$filename)) {
					\Thumb::create($file)
					 ->make('resize', array($width, $height, 'adaptive'))
					 ->make('crop', array('center', $width, $height))
					 ->save($path, $filename);
				}

				return asset("/uploads/{$folder}/{$filename}");
			}else{
				return false;
			}
			return false;
		}

		public static function timestamps($date = ''){
			$timestamp = str_replace('/','-',$date);
			return Carbon::createFromTimestamp(strtotime($timestamp));
		}

		public static function metaValue($key = null, $page_id = 0){
			if ($key) {
				$option = PageMeta::where('name', "=", $key)
						->where('page_id', "=", $page_id, 'AND');
				if ($option->count()) {
					return $option->first()->value;
				}
			}
			return false;
		}

		public static function ReadMore($count,$link,$string){
			$string = strip_tags($string);
			if (strlen($string) > $count) {

			    // truncate string
			    $stringCut = substr($string, 0, $count);

			    // make sure it ends in a word so assassinate doesn't become ass...
			    $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'... <a href="'.$link.'">Devamını Oku</a>'; 
			}
			return $string;
		}

		public static function groups()
		{
			return[
				'1' => 'Yönetici',
				'2' => 'Editör',
				'3' => 'Kullanıcı',
			];
		}


		public static function cover($id = 0,$type = false){
            if($type){
                $page = \PageMedia::where('page_id', $id)
					->where($type, 1);
            }else{
                $page = \PageMedia::where('page_id', $id)
					->where('is_cover', 1);
            }
            if ($page->count()) {
				$page = $page->first();
				if ($page->type == "pdf") {
					return Helper::pdfCover($page->filename);
				}else{
					return $page->full_url;
				}
            }else{
                return "public/assets/img/amblem.png";
            }
		} 
        
        public static function media_icon($id = 0){
			$page = \PageMedia::where('page_id', $id)
					->where('menu_icon', 1);
				
				if (!$page->count()) {
					$page = \PageMedia::where('page_id', $id);
					if (!$page->count()) {
						return false;
					}
				}
				$page = $page->first();
				if ($page->type == "pdf") {
					return Helper::pdfCover($page->filename);
				}else{
					return $page->full_url;
				}
		}

		public static function pdfCover($filename = null){
			$info = pathinfo($filename);
			return asset("uploads/Pdf/{$info['filename']}.pdf");
		}

		public static function userProfile($user_id = 0){
			return \User::find($user_id)->firstOrFail();
		}
        
        public static function clickForReadMore($string,$limit = 130){
            $string = strip_tags($string);
            if (strlen($string) > $limit){
                $stringCut = substr($string, 0, $limit);
                $string = substr($stringCut, 0, strrpos($stringCut, ' '))/*.'... <a href="/this/story">Read More</a>'*/; 
            }
            echo $string;
        }
        
        public static function dateNameTrans($date){
            $aylar = array( 
                'January'    =>    'Ocak', 
                'February'    =>    'Şubat', 
                'March'        =>    'Mart', 
                'April'        =>    'Nisan', 
                'May'        =>    'Mayıs', 
                'June'        =>    'Haziran', 
                'July'        =>    'Temmuz', 
                'August'    =>    'Ağustos', 
                'September'    =>    'Eylül', 
                'October'    =>    'Ekim', 
                'November'    =>    'Kasım', 
                'December'    =>    'Aralık', 
                'Monday'    =>    'Pazartesi', 
                'Tuesday'    =>    'Salı', 
                'Wednesday'    =>    'Çarşamba', 
                'Thursday'    =>    'Perşembe', 
                'Friday'    =>    'Cuma', 
                'Saturday'    =>    'Cumartesi', 
                'Sunday'    =>    'Pazar', 
                'Jan' => 'Oca',
                'Feb' => 'Şub',
                'Mar' => 'Mar',
                'Apr' => 'Nis',
                'May' => 'May',
                'Jun' => 'Haz',
                'Jul' => 'Tem',
                'Aug' => 'Ağu',
                'Sep' => 'Eyl',
                'Oct' => 'Eki',
                'Nov' => 'Kas',
                'Dec' => 'Ara'
            );  
            return strtr($date, $aylar);  
        }
        

	}