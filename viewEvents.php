<?php
require_once 'core/init.php';
include('header.php');
require_once 'vendor/autoload.php';
use Hashids\Hashids;
$userID = new User();
if($userID->isLoggedIn()){
$events = new Events();
$id=$userID->data()->ID;
$registrant = new Registrants();
$count = $events->countEvents($id);
$colCount = $events->getNumOfCols($count);
$colType = $events->getColNum();
echo Input::get('delete');



    if($count>2){

        echo "<div class=\"container\">";
        echo "<div class=\" eventPanelRow masonry-container\">";
    }else{
        echo "<div class=\"container\">";
        echo "<div class=\"row-fluid eventPanelRow\">";
    }



     if ($colCount>0) {

        for ($i = 0; $i < $count; $i++) {

            $db = DB::getInstance()->query("SELECT eventName,eventID,eventFont,city,state,eventKey FROM events JOIN userevents ON events.ID = userevents.eventID WHERE userID={$id}");
            $nm = $db->results()[$i]->eventName;
            $eIDs = $db->results()[$i]->eventID;
            $font = $db->results()[$i]->eventFont;
            $city = $db->results()[$i]->city;
            $state = $db->results()[$i]->state;
            $eventKey = $db->results()[$i]->eventKey;
            $background = $events->displayImage($eIDs);
            $countEvents = $registrant->getRegistrantCount($eIDs);

            $hashids = new Hashids();
            $eKey = $hashids->encode($id,$eIDs);
             $nm = $events->dirtyString($nm);
             ?>

                       <div class="wrapperEvents  item <?php echo $colType;?>" id="<?php echo $eIDs;?>">
                           <div class="well ">
                           <i class="fa fa-trash fa-2x pull-right" id="$nm" onclick='deleteEvent(<?php echo$eIDs;?>)'></i>
                           <h1><?php echo $nm; ?></h1>
                           <p><?php echo"$city, $state ";?><span><i class="fa fa-lg fa-map-marker"></i></span></p>
                           <div style="background-image:url(../<?php echo $background;?>); color:#<?php echo $font;?>" class="events" >
                               <div class="container-fluid eventDetails">

                               </div>
                           </div>
                           <div class="row">
                            <div id="registrantCount" class="col-xs-4">
                                <i id="registrants<?php echo $eIDs;?>" class="fa fa-user fa-2x bottom" onclick="displayRegistrants(<?php echo $eIDs;?>)"><?php echo$countEvents;?></i>
                            </div>
                            <div id="copyLink" class="col-xs-4">
                                <i class="fa fa-share-alt fa-2x" id="share" data-clipboard-text="evntit.com/signup/<?php echo $eKey;?>" alt="copy link" ></i>
                            </div>
                            <div id="editEvent" class="col-xs-4 ">
                               <i id="viewDetails" class="fa fa-2x fa-pencil-square-o" onClick="redirectToEventDetails(<?php echo"$id,$eIDs";?>)"></i>
                                <br>
                            </div>
                           </div>



                           <input type="text"  class="url" value="evntit.com/signup/<?php echo $eKey;?>" name="url" id="url<?php echo$eIDs;?>" title="url">
                       </div>
                   </div>

    <?php
 
 ?>




                    <?php
                }
            }else{
                echo "<h1>Looks like you haven't created any events!</h1>";
                }
            ?>
            </div>
        </div>


    <?php
}else{
    ?>
    <div id="showModal"></div>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-body">
                    <h2>You must log in to add an event!</h2>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

<?php
}
include('footer.php');

