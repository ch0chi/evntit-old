<?php
ob_start();
include('header.php');
require_once 'core/init.php';
require_once 'vendor/autoload.php';
use Hashids\Hashids;
$events = new Events();
//define variables
$category = Input::get('category');
$state = Input::get('state');
$inputtedCity = Input::get('city');
$city = $events->dirtyString($inputtedCity);

$events = new Events();
$search = new Search();
$registrant = new Registrants();

if(Input::get('category')=='All'){

}


//retrieve instance of database
$db = DB::getInstance();
$db->query("SELECT eventID FROM events JOIN userevents ON events.ID = userevents.eventID WHERE category=? AND state=? and city=?",array($category,$state,$city));
$count = $db->count();

/**
 * return number of columns for display
 */
$colCount = $events->getNumOfCols($count);
$colType = $events->getColNum();


 if($count>2){

        echo "<div class=\"container\">";
        echo "<div class=\" eventPanelRow masonry-container\">";
    }else{
        echo "<div class=\"container\">";
        echo "<div class=\"row-fluid eventPanelRow\">";
    }



     if ($colCount>0) {

        for ($i = 0; $i < $count; $i++) {
            $db->query("SELECT eventName,eventID,userID,eventFont,city,state,eventKey FROM events JOIN userevents ON events.ID = userevents.eventID WHERE category=? AND state=? and city=?",array($category,$state,$city));
            $nm = $db->results()[$i]->eventName;
            $eIDs = $db->results()[$i]->eventID;
            $userID = $db->results()[$i]->userID;
            $font = $db->results()[$i]->eventFont;
            $city = $db->results()[$i]->city;
            $state = $db->results()[$i]->state;
            $eventKey = $db->results()[$i]->eventKey;
            $background = $events->displayImage($eIDs);
            $countEvents = $registrant->getRegistrantCount($eIDs);
            $hashids = new Hashids();

             $nm = $events->dirtyString($nm);
                //$fetchFont = DB::getInstance()->query("SELECT eventKey FROM events JOIN userevents ON events.ID = userevents.eventID WHERE userID = {$id}");
             ?>

                       <div class="wrapperEvents  item <?php echo $colType;?>" id="<?php echo $eIDs;?>">
                           <div class="well "   >
                           <h1><?php echo $nm; ?></h1>
                           <p><i class="fa fa-lg fa-map-marker"></i><span><?php echo"$city, $state ";?> <i class="fa fa-user fa-lrg bottom"><?php echo$countEvents;?></i><a href="http://evntit.com/signup/<?php echo$eventKey;?>"><button type="button"
                            class="btn btn-sm btn-warning">Sign up</button></a></span></p>
                           <div style="background-image:url(../../../<?php echo $background;?>); color:#<?php echo $font;?>" class="events" >
                               <div class="container-fluid eventDetails">

                               </div>
                           </div>

                       </div>
                   </div>

                    <?php
                }
            }else{
                echo "<h1>Looks like there aren't any events of this category in your area.</h1>";
                }

            ?>
            </div>
        </div>




<?php
include('footer.php');