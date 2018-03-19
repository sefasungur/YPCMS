<?php
namespace Front;


class SearchController extends \BaseController
{
    public function getPage($word = null){ 

        if(!empty($word)){
            $pagessearch = \PageTranslation::leftJoin('pages', 'pages.id', '=', 'page_translations.page_id')->where('page_translations.content', 'like', "%".$word."%")->orWhere('page_translations.title', 'like', "%".$word."%")->where('status',1)->get();
            $this->theme->set('results', $pagessearch);
            $datasearch = ['results'=> $pagessearch,'word'=> $word];
            return \View::make('front.search',$datasearch)->render();
        }else{ 
        	return \View::make('front.home');
        }

    }
}