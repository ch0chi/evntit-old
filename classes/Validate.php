<?php
class Validate{
    private $_passed=false,
            $_errors=array(),
            $_db=null,
            $imageLocation;

    public function __construct(){
        $this->_db=DB::getInstance();
    }


    public function check($source, $items=array()){

        //list through the items we've defined
        foreach($items as $item =>$rules){ //item will be item (ex. firstname) and $rules will be the array associated with the item
            foreach($rules as $rule => $rule_value){

                $value = trim($source[$item]);
                $item = escape($item);

                if($rule === 'required' && empty($value)){
                    $this->addError("{$item} is required");
                }else if(!empty($value)){
                    //loops through each filed and displays custom error message
                    switch($rule){
                        case 'min':
                            if(strlen($value)<$rule_value){
                                $this->addError("{$item} must be a minimum of {$rule_value} characters");
                            }
                        break;
                        case 'max':
                            if(strlen($value)>$rule_value) {
                                $this->addError("{$item} has too many characters! Max number of characters is {$rule_value}");
                            }
                        break;
                        case 'matches':
                            if($value!=$source[$rule_value]) {
                                $this->addError("{$rule_value} must match {$item}");
                            }
                        break;
                        case 'unique':

                            $check = $this->_db->get($rule_value,array($item, '=', $value));

                            if($check->count()){
                                $this->addError("{$item} already exists");
                            }
                        break;
                        case 'validLocation':
                            if($value===$rule_value){
                                $this->addError("Please Enter a valid location!");
                            }


                    }

                }

            }

        }
        if(empty($this->_errors)){
            //checks if _errors array is empty.
            $this->_passed=true;

        }

        return $this;
    }

    public function checkLocation($loc){
        if(!$loc == " " ){
            return true;
        }
        return false;
    }

    public function checkImage($image){
        if(isset($_FILES[$image])){
            $ext = array('image/pjpeg','image/jpeg','image/JPG','image/X-PNG',
                'image/PNG','image/png','image/x-png','image/gif');
            if(in_array($_FILES[$image]['type'],$ext)){
                return true;
                //transfer file
            }else{

                $this->addError("Looks like we don't support that image type. Try using a JPEG or PNG image.");
            }
        }
        if($_FILES[$image]['error']>0){
            echo "<h3>Looks like we had some trouble uploading your file. This is probably due to it being too large. We only
                 support files up to 2M in size.</h3>";
            }
        return false;
        }
    private function addError($errors){
        $this->_errors[]=$errors;//adds error to an array
    }
    public function errors(){
        return $this->_errors;
    }
    public function passed(){
        return $this->_passed;
    }
    public function getEventImageLocation(){
        return $this->imageLocation;
    }


}