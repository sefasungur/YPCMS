<?php namespace Front;

	/**
	* 
	*/
	use Session;
	class BasketController extends \BaseController{
		
		public function postAdd(){  
			$basket = Session::get('basket');

			$product_id  = \Input::get('product');
			$count       = \Input::get('count');

			if(empty($basket)){
				Session::put('basket',array());
			}

			if(isset($basket["products"][$product_id])){ 
				$basket["products"][$product_id]["count"] = $basket["products"][$product_id]["count"]+$count;
			}else{ 
				$basket["products"][$product_id] = array(
					"id"    => $product_id,
					"count" => $count
				);
			}

			//hesapla
			if(!empty($basket)){
				$basketTotal = 0;
				foreach ($basket["products"] as $product){
					$page = \Page::select("*")->where("status",1)->where("id",$product["id"])->get()->first();
					if(!empty($page)){
						$birimFiyat = \Helper::metaValue("Tutar",$product["id"]);
						$basket["products"][$product["id"]]["price"] = $birimFiyat;
						$basket["products"][$product["id"]]["total"] = number_format($birimFiyat*$product["count"], 2, '.', '');
						$basketTotal = number_format($basketTotal+($birimFiyat*$product["count"]), 2, '.', '');
						$basket["products"][$product["id"]]["name"] = $page->translation->title;
					}
				}
				$basket["total"] = $basketTotal;
				$return = ['status' => 'success',"total"=>$basketTotal];
			}else{
				$return = ['status' => 'error',"total"=>"10"];
			}

			Session::put('basket',$basket);
			return \Response::json($return);
		}


		public function postRemove(){  
			$basket = Session::get('basket');
			$product  = \Input::get('product');
		
			if(isset($basket["products"][$product])){ 
				unset($basket["products"][$product]);
			}
		
			Session::put('basket',$basket);
			$return = ['status' => 'success'];
			return \Response::json($return);
		}
		
	
	}