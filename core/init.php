<?php


session_start(); //allows people to login

//global variable that is array of different config settings
//different names for cookies and sessions,etc..
$GLOBALS['config']=array(
    'mysql'=>array(
        
        
        'host'=>"N/A",
        'username'=>"N/A",,
        'password'=>"N/A",,
        'db'=>"N/A",
         

    ),
    'remember' => array(
        'cookie_name'=>'hash',
        'cookie_expiry'=>604800
    ),
    'session'=> array(
        'session_name'=>'user',
        'token_name'=>'token'
    )
);

//allows you to pass in a function every time a class is accessed.

spl_autoload_register(function($class){
    $relPath = realPath($_SERVER['DOCUMENT_ROOT']);
    require_once ("$relPath/classes/".$class.".php");
});
$relPath = realPath($_SERVER['DOCUMENT_ROOT']);
require_once ("$relPath/functions/sanitize.php");

if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))){
    $hash = Cookie::get(Config::get('remember/cookie_name'));
    $hashCheck = DB::getInstance()->get('usersessions',array('hash','=',$hash));

    if($hashCheck->count()){
        $user = new User($hashCheck->first()->userID);
        $user->login();

    }
}


