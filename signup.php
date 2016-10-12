<?php
$relPath = realPath($_SERVER['DOCUMENT_ROOT']);
require_once ("$relPath/core/init.php");
include('header.php');
require_once 'vendor/autoload.php';
use Hashids\Hashids;

$hashids = new Hashids();
$events = new Events();
$eventInfo = $hashids->decode(Input::get('key'));
$eventID = $eventInfo[1];
$userID = $eventInfo[0];
$db = DB::getInstance()->get('events',array("ID","=",$eventID));
$eventName = $db->first()->eventName;
$background = $events->displayImage($eventID);

if(Input::exists()) {
    $validate = new Validate();
    $validation = $validate->check($_POST, array(
        'firstName' => array(
            'required' => true,
            'min' => 2,
            'max' => 35
        ),
        'lastName'=> array(
            'required'=>true,
            'min'=>2,
            'max'=>35
        ),
        'email' => array(
            'required' => true,
            'min' => 7,
            'max' => 255

        )

    ));


    if ($validation->passed()) {

        $clients = new User();
        $trackDB = 0;




        try{
            //if trackDB = 0 then add clientPrivate fields
            if($trackDB===0){
                $clients->create('registrants',array(
                    'firstName'=> Input::get('firstName'),
                    'lastName'=> Input::get('lastName'),
                    'email'=> Input::get('email'),
                    'eventID'=> $eventID
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
}

?>

    <div class="container center-block" style="<?php echo $background;?>" id="">
        <div class="row">
            <div class="col-md-12 addAttendee">
                <h2 class="form-signin-heading registerHead"><?php echo $eventName;?></h2>
                <form action="" method="post" class="form-signin" id="addPerson">
                    <label for="firstName" class="sr-only">firstName</label>

                    <input type="text" name="firstName" id="firstName"  value="<?php echo Input::get('firstName')?>" class="form-control" placeholder="First Name">

                    <label for="lastName" class="sr-only">lastName</label>

                    <input type="text" name="lastName" id="lastName" value="<?php echo Input::get('lastName')?>" class="form-control" placeholder="Last Name">

                    <label for="email" class="sr-only">email</label>

                    <input type="email" name="email" id="email" value="<?php echo Input::get('email')?>" class="form-control" placeholder="Email">
                    <button class="btn btn-lg btn-primary btn-block" type="submit" >Add</button>
                </form>
            </div>

        </div>
    </div>


<?php
include('footer.php');
?>