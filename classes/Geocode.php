<?php
/**
 * Created by PhpStorm.
 * User: Michael's Account
 * Date: 3/16/2016
 * Time: 5:17 PM
 */
class Geocode{

    private $_lat,$_long;

    public function __construct(){
    }

    /**
     * @param $city
     * @param $state
     *
     * Takes in the events city and the events state then calls the google geocode api to
     * reverse geocode the desired location
     */
    public function geocodeAddress($city,$state){
        $url="http://maps.googleapis.com/maps/api/geocode/json?address=$city+$state&sensor=false";
        
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        $contents = curl_exec($ch);
        if (curl_errno($ch)) {
            echo curl_error($ch);
            echo "\n<br />";
            $contents = '';
        } else {
            curl_close($ch);
        }

        if (!is_string($contents) || !strlen($contents)) {
            echo "Failed to get contents.";
            $contents = '';
        }


        //$source = file_get_contents($url);
        //print_r($source);
        $obj = json_decode($contents);
        $this->setLat($obj->results[0]->geometry->location->lat);
        $this->setLong($obj->results[0]->geometry->location->lng);


    }
    public function setLat($latitude){
        $this->_lat=$latitude;
    }
    public function setLong($longitude){
        $this->_long=$longitude;
    }

    public function fetchLat(){
        return $this->_lat;
    }
    public function fetchLong(){
        return $this->_long;
    }
}
