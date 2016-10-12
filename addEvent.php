<?php
$relPath = realPath($_SERVER['DOCUMENT_ROOT']);
require_once ("$relPath/core/init.php");
require_once 'vendor/autoload.php';
use Hashids\Hashids;
$user = new User();
$search = new Search();
if($user->isLoggedIn()){

    include("header.php");
    if(Input::exists()){
        $e = new Events();
        $validate = new Validate();
        if($validate->checkImage('eventImage')){
            $e = new Events();
            $img = $_FILES['eventImage']['name'];

            $e->storeImage('eventImage');
        }
        $validation = $validate->check($_POST, array(
            'eventName' => array(
                'required' => true,
                'min' => 2,
                'max' => 140
            )
        ));

        if ($validation->passed()) {

            $id = $user->data()->ID;
            $event = $e->cleanString(Input::get('eventName'));
            $trackDB=0;
            try{
                if($trackDB===0){
                    //inserts the event into events
                    $search->parseSearchLocation(Input::get('district'));
                    $city = $search->fetchCity();
                    $state = $search->fetchState();
                    $user->create('events',array(
                        'eventName'=> $event,
                        'city'=>$city,
                        'state'=>$state,
                        'eventFont'=>Input::get('font'),
                        'category'=>Input::get('category')
                    ));



                    $trackDB =1;

                }if($trackDB===1){
                    //inserts recently created eventID and userID into userEvents
                    $fetchEventID = DB::getInstance()->get('events',array('eventName','=',$event));
                    $eventID= $fetchEventID->first()->ID;

                    $user->create('userevents',array(
                        'userID'=> $id,
                        'eventID'=>$eventID
                    ));

                    //create unique hash, and generate short url.

                    $crypt= new Hashids();

                    $key = $crypt->encode($id,$eventID);//user id and event id.

                    DB::getInstance()->update('events',$eventID,array(
                        'eventKey'=>$key

                    ));
                    $trackDB=2;

                }if($trackDB===2){


                    $fetchEventID = DB::getInstance()->get('events',array('eventName','=',$event));
                    $eventID= $fetchEventID->first()->ID;
                    //inserts image into uploads
                    $user->create('uploads',array(
                        'location'=> $e->encodeImage(),
                        'uploadDate'=>date('Y-m-d'),
                        'eventID'=>$eventID
                    ));
                }


            }catch(Exception $e){
                die($e->getMessage());
            }
        } else {
            foreach($validation->errors() as $error){
                echo $error,'<br>';
            }
        }
        $er=3;
        if($er==3) {
            include 'header.php';
            ?>
            <div id="showModal"></div>
            <?php
        }
    }
    ?>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-body">
                    <h2>Event Added!</h2>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <div  class="container">
        <div class="row">
            <div id="eventPreview" class="col-xs-12 col-sm-4 col-sm-offset-4">
                <div class="well">
                    <h1 id="userInput"></h1>
                    <div class="previewImage">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container" id="addEvent">
        <form action="" method="post" class="form-signin events" enctype="multipart/form-data">
            <div class='row'>
                <div class='col-md-12 center-block'>
                    <input type="hidden" id="locationSearch" name="district">
                    <input type="text" name="eventName" id="eventName" value="<?php echo Input::get('eventName')?>" class="form-control" placeholder="Event Name">
                    <input type="file" id="eventImage" name="eventImage" class="hidden">
                    <input type="text" id="font" name="font" class="hidden">
                    <label class="fileUpload" for="eventImage"><i class="fa fa-camera fa-2x pull-left"></i><h3>Upload</h3></label>
                            <select id="company" class="form-control" name="category">
                                <option value="" disabled selected>Category</option>
                                <option>Outdoors</option>
                                <option>Sports</option>
                                <option>Gaming</option>
                                <option>Music</option>
                                <option>Movies</option>
                                <option>Food</option>
                                <option>Programming</option>
                                <option>Politics</option>
                                <option>Environment</option>
                                <option>Health</option>
                            </select>


                    <button type="submit" class="btn btn-primary btn-lg btn-block">Add Event</button>
                </div>
            </div>
        </form>
    </div>
    <?php
}else{
    Redirect::to('/includes/errors/404.php');
}
include('footer.php');
?>