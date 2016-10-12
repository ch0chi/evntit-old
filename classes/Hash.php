<?php
class Hash{
    //generate one way hash using sha-512
    //salt improves secuirty because it provides a randomly generated string of a password and is added to check whether the
    public static function make($string,$salt=''){
        return hash('sha512',$string.$salt);

    }
    //ensure strong salt
    public static function salt($length){

        return mcrypt_create_iv($length);
    }

    public static function unique(){
        return self::make(uniqid());
    }
}
