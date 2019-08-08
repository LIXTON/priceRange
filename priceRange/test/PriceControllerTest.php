<?php
include_once '../controllers/PriceController.php';
include_once '../models/Price.php';

class PriceControllerTest extends PriceController {
    /*
     *  Setup the model to test
     *  The connection, $db, should be provided
     *  
     *  @param $db: iDatabaseConfig
     */
    public function __construct($conn, $db) {
        $this->model = new Price($conn);
        $this->model->priceId = 12;
        $this->model->startDate = "2019-01-05";
        $this->model->endDate = "2019-01-10";
        $this->model->price = 100;
        
        $this->db = $db;
        
        parent::__construct($this->model, $db);
    }
    
    public function testFixRecords_Price() {
        $testName = "FixRecord Same Price";
        
        $price1 = new Price($this->db);
        $price1->priceId = 5;
        $price1->startDate = "2019-01-01";
        $price1->endDate = "2019-01-07";
        $price1->price = 100;
        
        $list = [
            $this->model
        ];
        $result = [];
        $result["input"] = $price1;
        $result["list"] = $list;
        
        try{
            $result["result"] = $this->fixRecords($price1, $list, $this->model::CREATE);
        } catch(Exception $e) {
            $result["exception"] = $e->getMessage();
        }
        
        $result["error"] = $this->error;
        
        return $result;
    }
    
    public function testFixRecords_Overlap() {
        $testName = "FixRecord Overlap";
        
        $price1 = new Price($this->db);
        $price1->priceId = 5;
        $price1->startDate = "2019-01-04";
        $price1->endDate = "2019-01-11";
        $price1->price = 10;
        
        $list = [
            $this->model
        ];
        $result = [];
        $result["input"] = $price1;
        $result["list"] = $list;
        
        try{
            $result["result"] = $this->fixRecords($price1, $list, $this->model::CREATE);
        } catch(Exception $e) {
            $result["exception"] = $e->getMessage();
        }
        
        $result["error"] = $this->error;
        
        return $result;
    }
    
    public function testFixRecords_End() {
        $testName = "FixRecord Cross End";
        
        $price1 = new Price($this->db);
        $price1->priceId = 5;
        $price1->startDate = "2019-01-01";
        $price1->endDate = "2019-01-07";
        $price1->price = 10;
        
        $list = [
            $this->model
        ];
        $result = [];
        
        $result["input"] = $price1;
        $result["list"] = $list;
        
        try{
            $result["result"] = $this->fixRecords($price1, $list, $this->model::CREATE);
        } catch(Exception $e) {
            $result["exception"] = $e->getMessage();
        }
        
        $result["error"] = $this->error;
        
        return $result;
    }
    
    public function testFixRecords_Start() {
        $testName = "FixRecord Cross Start";
        
        $price1 = new Price($this->db);
        $price1->priceId = 5;
        $price1->startDate = "2019-01-07";
        $price1->endDate = "2019-01-12";
        $price1->price = 10;
        $list = [
            $this->model
        ];
        $result = [];
        
        $result["input"] = $price1;
        $result["list"] = $list;
        
        try{
            $result["result"] = $this->fixRecords($price1, $list, $this->model::CREATE);
        } catch(Exception $e) {
            $result["exception"] = $e->getMessage();
        }
        
        $result["error"] = $this->error;
        
        return $result;
    }
    
    public function testFixRecords_Middle() {
        $testName = "FixRecord Cross Middle";
        
        $price1 = new Price($this->db);
        $price1->priceId = 5;
        $price1->startDate = "2019-01-06";
        $price1->endDate = "2019-01-09";
        $price1->price = 10;
        
        $list = [
            $this->model
        ];
        $result = [];
        
        $result["input"] = $price1;
        $result["list"] = $list;
        
        try{
            $result["result"] = $this->fixRecords($price1, $list, $this->model::CREATE);
        } catch(Exception $e) {
            $result["exception"] = $e->getMessage();
        }
        
        $result["error"] = $this->error;
        
        return $result;
    }
}