<?php
use \Carbon\Carbon;
class BackTemplate extends \BaseController{
    public static function TemplateListArray($none=null,$add=null){
        $return = array();

        if(is_array($none))
        {
            $return = array_merge($return,$none);
        }
        else
        {
            $return = array_merge($return,array("none"=>"Seçimsiz"));
        }
        
        $return = array(
            "default"            => "Varsayılan",
            "defaultList"        => "Varsayılan liste",
            "home"               => "Anasayfa"
        );
        
        if(is_array($add))
        {
            $return = array_merge($return,$add);
        }   
        return $return;
    }
}