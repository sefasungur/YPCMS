<?php namespace Front;
use Input;
use Validator;
use Redirect;
use Request;
use Session;
/**
* 
*/

class MailController extends \BaseController
{
    public function postIletisim()
    {
        
        $port = \DB::table('options')->select('value')->where('name','smtp_port')->get();
        $username =  \DB::table('options')->select('value')->where('name','smtp_username')->get();
        $password = \DB::table('options')->select('value')->where('name','smtp_password')->get();
        $server = \DB::table('options')->select('value')->where('name','smtp_server')->get();
        $newserv  = $server[0]->value;
        \Config::set('mail.port',$port[0]->value);
        \Config::set('mail.username',$username[0]->value);
        \Config::set('mail.password',$password[0]->value);
        \Config::set('mail.host',$newserv);
        \Config::set('mail.encryption', '');
        \Config::set('mail.driver', 'smtp');

        \Mail::send('views.emails.iletisim', ['data' => \Input::all()], function($message){
            $message->from(\Helper::optionValue('smtp_username'), \Input::get('form_name'));
            $message->to(\Helper::optionValue('contact_form_email'), \Helper::optionValue('site_title'));
            $message->subject("İletişim Formu");
        });
        
       
        echo 'İletişim formunuz başarıyla gönderildi.';

    }
    
   
}