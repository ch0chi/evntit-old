<?php
class Admin{
    private $_db,$_data;

    public function __construct(){
        $this->_db=DB::getInstance();
    }

    public function data(){
        return $this->_data;
    }

    public function editGroup($username){
        if($this->getID($username)){
            $ID = $this->data()->ID;
            $this->_db->update('clientPrivate',$ID,array(
                'groupID'=>'3'));
        }
    }


    public function checkGroupID($username){
        
        if($this->getID($username)) {
            $ID = $this->data()->groupID;
            if($ID == 1){
                return true;
            }
            return false;
        }
        return false;

    }
    public function getID($username){
        if($username){
            $data = $this->_db->get('clientPrivate',array('username','=',$username));
            if($data->count()) {
                $this->_data = $data->first();
                return true;
            }

        }
        return false;

    }

}
