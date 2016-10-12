<?php
include('core/init.php');
include('header.php');
$user = new User();

if($user->isLoggedIn()){


$events = new Events();
$registrant = new Registrants();
$geocode = new Geocode();


$userID = escape(Input::get('userID'));
$eventID = escape(Input::get('eventID'));
$registrantCount = $registrant->getRegistrantCount($eventID);

$fetchDetails = DB::getInstance()->get('events',array('ID','=',$eventID));
$eventName = $fetchDetails->first()->eventName;
$cityWithWhiteSpace = $fetchDetails->first()->city;

//add underscore to city for indexing
$city = $events->cleanString($cityWithWhiteSpace);

$state = $fetchDetails->first()->state;
$eventImage = $events->displayImage($eventID);


//geocode address
$geocode->geocodeAddress($city,$state);
$lat = $geocode->fetchLat();
$long = $geocode->fetchLong();

?>
<div id="eDetailOutterWrapper" class="container-fluid">
    <div id="eDetailInnerWrapper" class="container">
        <div class="row">
            <div id="eDetailPictureWrapper" class="col-sm-3">
                <div id="eventPicture" class="well" style="background-image:url(../../<?php echo $eventImage;?>">

                </div>
            </div>
            <div id="eDetailName" class="col-sm-9">
                <div class="well">
                    <h1><?php echo $eventName;?></h1>
                    <p id="lat"><?php echo"$lat";?></p>
                    <p id="long"><?php echo"$long";?></p>
                    <p id="eLocation"><?php echo"$city, $state ";?><span><i class="fa fa-lg fa-map-marker"></i></span></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div id="map" class="well"></div>

            </div>
        </div>

        <div  class="row">
            <div class="col-xs-3">
                <p><strong>First Name</strong></p>
            </div>
            <div class="col-xs-3">
                <p><strong>Last Name</strong></p>
            </div>
            <div class="col-xs-3">
                <p><strong>Phone</strong></p>
            </div>
            <div class="col-xs-3">
                <p><strong>Email</strong></p>
            </div>
        </div>
        <?php
        for($i = 0;$i<$registrantCount;$i++){
            $fetchRegistrants = DB::getInstance()->get('registrants',array('eventID','=',$eventID));
            $firstName = $fetchRegistrants->results()[$i]->firstName;
            $lastName = $fetchRegistrants->results()[$i]->lastName;
            $email = $fetchRegistrants->results()[$i]->email;

        ?>
            <div id="eDetailRegistrants" class="row">
                <div id="registrantFirstName" class="col-xs-3">
                    <p><?php echo $firstName;?></p>
                </div>
                <div id="registrantLastName" class="col-xs-3">
                    <p><?php echo $lastName;?></p>
                </div>
                <div id="registrantPhone" class="col-xs-3">
                    <p> </p>
                </div>
                <div id="registrantEmail" class="col-xs-3">
                    <p><?php echo $email;?></p>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>
<?php
}else{
    ?>
<div class="container-fluid loginError">
    <div class="row">
        <div class="col-md-12">
            <h1>You don't have permission to view this page.</h1>
        </div>
    </div>
    <?php
}
?>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB65J1c21fbfmLEnCIznELua_meaQt0PCs&callback">
</script>
<?php
include('footer.php');
?>
<script src="../../js/Map.js"></script>

