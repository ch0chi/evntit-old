<?php
class User{
    private $_db;
    private $_data;
    private $_sessionName;
    private $_cookieName;
    private $_isLoggedIn;

    public function data(){
        return $this->_data;
    }

    public function isLoggedIn(){
        //return data
        return $this->_isLoggedIn;
    }

    public function __construct($user=null){
       
        $this->_db=DB::getInstance();

        $this->_sessionName= Config::get('session/session_name');
        $this->_cookieName= Config::get('remember/cookie_name');

        if(!$user){
            if(Session::exists($this->_sessionName)){
                $user= Session::get($this->_sessionName);

                
                if($this->find($user)){
                    $this->_isLoggedIn = true;
                }else{
                    //process Logout
                }
            }
        }else{
            $this->find($user);
        }
    }

    public function create($table, $fields=array()){
        if(!$this->_db->insert($table,$fields)){
            throw new Exception('There was a problem creating an account.');
        }

    }
    public function find($user = null){
        if($user){
            $field = (is_numeric($user)) ? 'id' : 'email';
            $data = $this->_db->get('users',array($field,'=', $user));

            if($data->count()){
                $this->_data=$data->first();
                return true;
            }
        }
    }

    public function login($username=null, $password=null, $remember=false)
    {
        if (!$username && !$password && $this->exists()) {

            Session::put($this->_sessionName, $this->data()->ID);
        } else {
            $user = $this->find($username);


            if ($user) {
              
                if ($this->data()->password === Hash::make($password, $this->data()->salt)) {

                    Session::put($this->_sessionName, $this->data()->ID);//put user id inside of session

                    if ($remember) {

                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get('usersessions', array('userId', '=', $this->data()->ID));

                       
                        if (!$hashCheck->count()) {

                            $this->_db->insert('usersessions', array(
                                'userID' => $this->data()->ID,
                                'hash' => $hash
                            ));
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }

                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                    }
                  
                    return true;
                }
            }

            return false;
        }
    }

    public function hasPermission($key){
        $group = $this->_db->get('groups', array('ID','=',$this->data()->groupID));
        if($group->count()){
            $permissions= json_decode($group->first()->permissions,true);
            if($permissions[$key] == true){
                return true;
            }
        }
        return false;
    }

    public function exists(){
      
        return (!empty($this->_data)) ? true: false;
    }

    public function logout(){
        $this->_db->delete('usersessions',array('userID','=',$this->data()->ID));
        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);

    }


}
