<?php
/*
 *  Model is in charge to represent the information related to a single table 
 *  as well as any thing related to make a change in there
 */
abstract class aModel {
    const CREATE = "create";
    const READ = "read";
    const READONE = "readone";
    const UPDATE = "update";
    const DELETE = "delete";
    
    protected $conn;
    public $error = [];
    
    /*
     *  This method validate if the model properties are correct
     *
     *  @param $scenario: string - should be the constants of the model
     *  @return $error: array - empty means it pass
     */
    abstract public function validate($scenario);
    
    /*
     *  Add a new record to the DB
     *  Values are provided by the model
     *
     *  @return $id: int - last id inserted if success otherwise null
     */
    abstract public function create();
    
    /*
     *  A basic read with a specific filter, if filter is empty it search the whole table
     *
     *  @param $filter: array - to search for specific attributes in the model
     *  @return $result: array - list of models that match the criteria
     */
    abstract public function read($filter);
    
    /*
     *  A basic single read. Value provided by the model
     *
     *  @return $result: bool - if search was success
     */
    abstract public function readOne();
    
    /*
     *  Update the record. Values provided by the model
     *
     *  @return $result: bool - if update was success
     */
    abstract public function update();
    
    /*
     *  Delete the record. Values provided by the model
     *
     *  @return $result: bool - if delete was success
     */
    abstract public function delete();
    
    /*
     *  Constructor to set the database connection
     *
     *  @param $db: iDatabaseConfig
     */
    public function __construct($db) {
        $this->conn = $db;
    }
}