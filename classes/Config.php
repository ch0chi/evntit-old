<?php
//basically makes a quick way to say "what's my database called
class Config{

    public static function get($path=null){

        if($path){

            $config=$GLOBALS['config'];
            $path=explode('/',$path); //takes a character we want to explode by and givee us an array back.

            foreach($path as $bit){
                if(isset($config[$bit])){
                    $config=$config[$bit];

                }

            }

            return $config;

        }
    }
}


