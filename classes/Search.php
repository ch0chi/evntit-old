<?php
/**
 * Class Search
 *
 *
 */

class Search{

    private $_city,$_state;

    public function __construct(){
    }

    /**
     * @param string $location  The location inputted by the users
     * @var array $parsedLoc splits $location
     * @var string $clean calls upon the escape method to clean the string from foreign characters.
     * @var string $trimmed
     */
    public function parseSearchLocation($location){
        $clean = escape($location);
        $parsedLoc = explode(",", $clean);
        $trimmed = trim($parsedLoc[1], " ");
        $this->_city = $parsedLoc[0];
        $this->_state = $trimmed;
    }

    /**
     * @return mixed returns the city
     */
    public function fetchCity(){
        return $this->_city;
    }

    /**
     * @return mixed returns the state
     */
    public function fetchState(){
        return $this->_state;
    }

    public function checkIfValidlocation($loc){
        if($loc!="," ){
            return true;
        }
        return false;
    }

    public function checkValidState(){
        $city = $this->_city;
        $state = $this->_state;
        if($city && $state){
            return true;
        }
        return false;
    }
}