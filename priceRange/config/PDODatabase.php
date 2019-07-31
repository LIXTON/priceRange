<?php
include_once '../templates/iDatabaseConfig.php';

/*
 *  PDODatabase connects by MySQL and has all the configuration to do it
 */
class PDODatabase implements iDatabaseConfig {
    private $host = "";
    private $db_name = "";
    private $username = "";
    private $password = "";
    public $conn;
    public $error = [];
    
    public function getConnection() {
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            $this->error[] .= "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}