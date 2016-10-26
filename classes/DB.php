<?php

/**
 * Class DB
 *
 * Database wrapper that uses PDO to perform various SQL actions
 */
class DB{

    /**
     * @var string $_instance stores instance of db
     * @var string $_query stores the last query that is executed
     * @var string $_error stores any errors associated with the db
     * @var string $_results stores the result set
     * @var int $_count stores a count of the number of results
     */

    private static $_instance = null;
    private $_pdo,
            $_query,
            $_error=false,
            $_results,
            $_count=0;

    private function __construct(){
        try{
            $this->_pdo=new PDO('mysql:host='. Config::get('mysql/host') . ';dbname='. Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    /**
     * Returns an instance of the database
     */
    public static function getInstance(){
        if(!isset(self::$_instance)){
            self::$_instance= new DB();
        }
        return self::$_instance;
    }

    /**
     * creates a a prepared statement via either an sql query or an sql query with an array of attributes
     *
     * @param string $sql  SQL query
     * @param array $params stores params if available
     * @return $this
     */
    public function query($sql, $params=array()){
        $this->_error=false;
        
        if($this->_query=$this->_pdo->prepare($sql)){
            $x=1;
            if(count($params)){
                foreach($params as $param){
                    $this->_query->bindValue($x,$param);
                    $x++;
                }
            }
            if($this->_query->execute()){
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count=$this->_query->rowCount();
            }else{
                $this->_error=true;
            }
        }
        return $this;
    }

    public function error(){
        return $this->_error;
    }

    /**
     *
     *
     * @param $action "SELECT, INSERT, UPDATE, DROP, etc..."
     * @param $table user defined SQL table
     * @param array $where
     * @return $this|bool
     */
    public function action($action,$table,$where=array()){
        if(count($where)===3){
            $operators=array('=','>','<','>=','<=');

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            
            if(in_array($operator,$operators)){
               
                $sql = "{$action}  FROM {$table} WHERE {$field} {$operator} ? ";

                if(!$this->query($sql,array($value))->error()){
                    return $this;
                }
            }

        }
        return false;
    }

    /**
     * @param $table user defined SQL table
     * @param $where
     * @return $this|bool|DB returns instance of action
     */
    public function get($table,$where){
        return $this->action('SELECT *',$table,$where);
    }



    public function customQuery($action,$table,$where){
        return $this->action($action,$table,$where);
    }

    /**
     * Deletes user defined value from the selected table
     *
     * @param $table
     * @param $where
     * @return $this|bool|DB
     */
    public function delete($table,$where){
        return $this->action('DELETE',$table,$where);
    }

    /**
     *Selects a user from the database based on ID
     *
     * @param $table
     * @param $where
     * @return $this|bool|DB
     */
    public function selectID($table,$where){
        return $this->action('SELECT ID', $table, $where);
    }

    /**
     * @param string $table user specified table
     * @param array $fields
     * @return bool
     */
    public function insert($table,$fields = array()){
            $keys=array_keys($fields);
            $values=null;
            $x = 1;

            foreach($fields as $field){
                $values .="?";
              
                if($x<count($fields)){
                    $values.=', ';
                }
                $x++;
            }

            $sql="INSERT INTO {$table}(`" . implode('`,`',$keys). "`) VALUES ({$values})";
            if($this->query($sql, $fields)) {
                return true;
            }
        return false;
    }


    public function update($table,$id,$fields){
        $set='';
        $x=1;
        foreach($fields as $name=> $value){
            $set .= "{$name}=?";
            if($x < count($fields)){
                $set .= ',';
            }
            $x++;
        }
        $sql="UPDATE {$table} SET {$set} WHERE id={$id}";
        if(!$this->query($sql,$fields)->error()){
            return true;
        }
        return false;


    }

    public function results(){
        return $this->_results;
    }

    /**
     * Returns the first result of the requested DB query
     *
     * @return mixed
     */
    public function first(){
        //returns only one result
        return $this->results()[0];
    }

    /**
     * Returns all requested values
     *
     * @param $num
     * @return mixed
     */
    public function all($num){
        return $this->results()[$num];
    }

    /**
     * Counts the requested values
     *
     * @return int
     */
    public function count(){
        return $this->_count;
    }

    /**
     * Creates an event
     *
     * @param string $eventName
     * @return DB inserts event into database
     */
    public function createEvent($eventName){
        $eventName = str_replace(' ', '_', $eventName);
        return $this->query("CREATE TABLE {$eventName} (ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, firstName VARCHAR(255), lastName VARCHAR(255), email VARCHAR(255));");
    }


}
