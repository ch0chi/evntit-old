<?php
ini_set('display_errors', 'On');
require_once 'core/init.php';

$location = "";
$rowCount = 0;
$zip = "";
$city = "";
$state = "";
$inputtedLocation = escape(Input::get('location'));

if(strlen($inputtedLocation)>0){
    $location = $inputtedLocation;
    $location = escape($location);
}

$db= DB::getInstance()->query("SELECT zip, city, state FROM cities WHERE city LIKE ?",array("%$location%"));

        for($i=0;$i<$db->count();$i++){
            if($db->count()<100){
                $zip = $db->results()[$i]->zip;
                $city = $db->results()[$i]->city;
                $state = $db->results()[$i]->state;

                echo"<li class=\"searchResults\" onclick='selectCity(\"{$city}, {$state}\")'>";
                echo"$zip $city, $state";
                echo"</li>";
            }
        }
?>
















