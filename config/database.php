<?php

/**
 * Short Description:
 * 
 * Class to manage database connection based on singleton instance.
 * This will read env.ini file which has database connection parameters.
 * 
 *
 * @package      App
 * @category     Config
 * @author       José Gomes <zx.gomes@gmail.com>
 */

namespace App\Config;

class DatabaseClass {

    //-- database connection:
    private $_connection;
    
    //-- the single instance:
    private static $_instance;

    /*
      Get an instance of the Database
      @return Instance
     */

    public static function getInstance() {

        //-- if no instance then make one:
        if (!self::$_instance) {
            self::$_instance = new self();
        }

        //-- return db instance:
        return self::$_instance;
    }

    private function __construct() {

        //-- get DB parameters from config file:
        $params = parse_ini_file(BASE_PATH . DIRECTORY_SEPARATOR
                . "config" . DIRECTORY_SEPARATOR . "env.ini");

        //-- create new database connection:
        $this->_connection = new \mysqli($params['DB_HOST'], 
                $params['DB_USERNAME'], $params['DB_PASSWORD']);

        //-- case connection error:
        if ($this->_connection->connect_error) {
            die("Connection failed: " . $this->_connection->connect_error);
        }

        //-- set current db:
        $db_selected = mysqli_select_db($this->_connection, $params['DB_DATABASE']);

        if (!$db_selected) {
            
            die(mysqli_error($this->_connection));
        }
    }

    //-- magic method clone is empty to prevent duplication of connection
    private function __clone() {
        
    }

    //-- get mysqli connection
    public function getConnection() {
        return $this->_connection;
    }

}
