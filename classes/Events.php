<?php
include('vendor/SimpleImage/src/abeautifulsite/SimpleImage.php');

/**
 * Class Events
 *
 * Contains all of the functions used for event processing.
 */
class Events{

    /**
     * @var User $_user holds instance of User class
     * @var DB $_db holds instance of database
     * @var int $_count holds number of values of a specified db query
     * @var string $_imgLoc contains the path to a specified events image location
     * @var string $_encodedImage stores a specified events image location as a base64 string
     */
    private $_user,$_db,$_count,$_imgLoc,$_encodedImage,$relPath;
    private $img;



    public function __construct(){
        $this->_user = new User();
        $this->_db= DB::getInstance();
        $this->relPath = realPath($_SERVER['DOCUMENT_ROOT']);
    }

    /**
     * Checks the url token against the database to make sure the token exists.
     *
     * @return bool
     */
    public function checkToken(){
        return true;
    }

    /**
     * Returns every event from a specified user.
     *
     * @param int $id
     * @return string
     */
    public function getUserEvents($id){
        for($i=0;$i<$this->countEvents($id);$i++){
            $sql = "SELECT eventName, eventID FROM userevents JOIN events ON userevents.eventID = events.ID WHERE userID=?";
            $eventName = $this->_db->query($sql,array($id));
            $nm = $eventName->results()[$i]->eventName;
            return $nm;
        }
        return "";
    }

    public function cleanString($string){
        $newStr = str_replace(" ","_",$string);
        return $newStr;
    }

    public function dirtyString($string){
        $newStr = str_replace("_"," ",$string);
        return $newStr;
    }


    public function delete($eventID){
        DB::getInstance()->delete('events',array('ID','=',$eventID));
    }

    public function storeImage($image){
        $imageName= $_FILES[$image]['name'];
        move_uploaded_file($_FILES[$image]['tmp_name'],"uploads/{$_FILES[$image]['name']}");
        $originalImg = new abeautifulsite\SimpleImage("uploads/".$imageName);
        $originalImg->best_fit(320, 200);
        $originalImg->save();
        $this->_imgLoc="uploads/$imageName";
    }


    public function getImgLoc($image){
        return "uploads/$image";
    }

    public function encodeImage(){
        $this->_encodedImage= base64_encode($this->_imgLoc);
        return $this->_encodedImage;
    }

    public function decodeImage($image){//param takes in db query results
        return base64_decode($image);
    }

    public function displayImage($eventID){

        $path= "";
        $query = DB::getInstance()->query("SELECT location,eventID FROM uploads WHERE eventID={$eventID}");
        for($i=0;$i<$query->count();$i++){
            $location = $query->results()[$i]->location;
            $path = $this->decodeImage($location);
            $this->img=$path;
        }
        return $path;
    }



    public function countEvents($id){
        $userId = $this->_db->query("SELECT eventID FROM userevents WHERE userID={$id}");
        $count = 0;
        for($i = 0;$i<$userId->count();$i++){
            return $count= $userId->count();

        }
        return $count;
    }

    public function getEventKey($eventID){
        return $this->_db->query("SELECT eventKey FROM events WHERE ID={$eventID}");
    }

    public function eventID($name,$userID){
        $even = DB::getInstance()->query("SELECT eventID from userevents join events on userevents.eventID = events.ID where userID={$userID} AND eventName={$name}");
        return $even->first()->eventID;
    }

    public function createURL($username,$eventName){
        //check if id and eventName in db
    }

    public function getColNum(){
        $numColumns=$this->getCount();
        switch($numColumns){
            case 12:
                return "col-xs-6 col-xs-offset-3";//returns a count of 12 columns
            break;
            case 6:
                return "col-xs-6";//returns a count of 2 columns because each will be 6
            break;
            case 4:
                return "col-md-4 col-xs-6";//returns a count of 3 columns because each will be 4 in length
            break;
            case 3:
                return "col-xs-6 col-sm-4 col-md-3";
            break;
            case 0:
                return 0;
            break;

            case is_float($numColumns):
                return "col-xs-6 col-sm-4 col-md-3";
            break;
        }
        return "col-md-4";
        //so if a user has 2 events you need 6 columns
    }

    public function getNumOfCols($count){
        if($count !=0){
            return $this->_count=12/$count;
        }
        else{
            return 0;
        }

    }
    public function getCount(){
        return $this->_count;
    }
    public function countAll(){
        $fetchAll = $this->_db->query("SELECT * FROM events");
        $count = $fetchAll->count();
        return $count;
    }
    public function countCategories($category){
        $fetchAll = $this->_db->get('events',array('category','=',$category));
        $count = $fetchAll->count();
        return $count;
    }

    public function getImage(){
        $str = substr(strrchr($this->img, "/"), 1);
        return $str;
    }


}