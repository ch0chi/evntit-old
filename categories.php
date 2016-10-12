<?php
require_once 'core/init.php';
include('header.php');
require_once 'vendor/autoload.php';


$events = new Events();
$count=$events->countCategories(Input::get('category'));
$registrant = new Registrants();
$category = Input::get('category');
?>

    <div class="container eventPanelWrapper">
        <div class="row eventPanelRow">
            <?php


            $colCount = $events->getNumOfCols($count);

            $colType = $events->getColNum();


            if($colCount>0){
                for ($i = 0; $i < $count; $i++) {
                    $fetchEvents = DB::getInstance()->query("SELECT username,city,state,eventName,eventID,eventKey FROM events JOIN userevents ON events.ID = userevents.eventID JOIN users ON userevents.userID = users.ID
WHERE category=\"{$category}\"");
                    $nm = $fetchEvents->results()[$i]->eventName;
                    $eIDs = $fetchEvents->results()[$i]->eventID;
                    $username = $fetchEvents->results()[$i]->username;
                    $city = $fetchEvents->results()[$i]->city;
                    $state = $fetchEvents->results()[$i]->state;
                    $eventKey = $fetchEvents->results()[$i]->eventKey;
                    $background = $events->displayImage($eIDs);
                    $countEvents = $registrant->getRegistrantCount($eIDs);
                    $nm = $events->dirtyString($nm);
                    ?>
                    <div class="wrapperEvents  item <?php echo $colType;?>" id="<?php echo $eIDs;?>">
                        <div class="well ">
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
                ?>
                <h1>Looks like there aren't any events in this category.</h1>
                <?php
            }




            ?>


        </div>
    </div>

<?php

include('footer.php');
