<?php
include_once '../controllers/PriceController.php';
include_once '../models/Price.php';

class PriceControllerTest extends PriceController {
    public function __construct($db) {
        $this->model->priceId = 12;
        $this->model->startDate = "2019-01-05";
        $this->model->startDate = "2019-01-010";
        $this->model->price = 100;
        
        $this->db = $db;
    }
    
    public function testFixRecords_Price() {
        $testName = "FixRecord Same Price";
        
        $price1 = new Price($this->db);
        $price1->priceId = 5;
        $price1->startDate = "2019-01-01";
        $price1->endDate = "2019-01-07";
        $price1->price = 100;
        
        $list = [
            $price1
        ];
        $result = [];
        
        $result["input"] = $list;
        
        try{
            $result["result"] = $this->fixRecords($list, $this->model::CREATE);
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
        $price1->startDate = "2019-01-06";
        $price1->endDate = "2019-01-09";
        $price1->price = 10;
        
        $list = [
            $price1
        ];
        $result = [];
        
        $result["input"] = $list;
        
        try{
            $result["result"] = $this->fixRecords($list, $this->model::CREATE);
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
            $price1
        ];
        $result = [];
        
        $result["input"] = $list;
        
        try{
            $result["result"] = $this->fixRecords($list, $this->model::UPDATE);
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
            $price1
        ];
        $result = [];
        
        $result["input"] = $list;
        
        try{
            $result["result"] = $this->fixRecords($list, $this->model::DELETE);
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
            $price1
        ];
        $result = [];
        
        $result["input"] = $list;
        
        try{
            $result["result"] = $this->fixRecords($list, $this->model::DELETE);
        } catch(Exception $e) {
            $result["exception"] = $e->getMessage();
        }
        
        $result["error"] = $this->error;
        
        return $result;
    }
}