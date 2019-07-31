<?php
/*
 *  The Controller is in charge to display and execute 
 *  all the behaivors related to the model in charge,
 *  the business rules are also define here
 */
abstract class aController {
    public $model;
    protected $db;
    public $error = [];
    
    /*
     *  Provide all the data the controller needs to validate
     */
    public function __construct($model, $db, $scenario) {
        $this->model = $model;
        $this->db = $db;
        
        $this->error = array_merge(
            $this->error, 
            $model->validate($scenario), 
            $db->error);
    }
    
    /*
     *  Provides the data for index.php of the model
     *  
     *  @return $result: mixed it can return any type of data
     */
    abstract public function indexView();
    
    /*
     *  Provide the data for create.php of the model
     */
    abstract public function createView();
    
    /*
     *  Provide the data for readone.php of the model
     */
    abstract public function readOneView();
    
    /*
     *  Provide the data for update.php of the model
     */
    abstract public function updateView();
    
    /*
     *  Provide the data for delete.php of the model
     */
    abstract public function deleteView();
    
    /*
     *  Format and prints the error messages stored
     *
     *  @return string the error message
     */
    public function printError() {
        $msg = "Something went wrong. Reason(s):\n";
        
        foreach($this->$error as $key => $e) {
            $msg .= (" - " . $key . " ". $e . "\n");
        }
        
        return $msg;
    }
}