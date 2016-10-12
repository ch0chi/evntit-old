<?php

class Registrants{

    public function __construct(){
        $this->_user = new User();
        $this->_db= DB::getInstance();
    }

    public static function getRegistrantCount($eventID){
        $countE = 0;
        $registrants = DB::getInstance()->get('registrants',array('eventID','=',$eventID));
        foreach($registrants->results() as $registrants){
            $countE++;
        }
        return $countE;
    }

}