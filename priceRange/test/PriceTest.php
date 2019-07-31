<?php
include_once '../models/Price.php';

class PriceTest extends Price {
    public function __construct($db) {
        parent::__construct($db);
        $this->priceId = 1;
        $this->startDate = "2019-01-01";
        $this->endDate = "2019-10-10";
        $this->price = 20;
        
        $this->validate();
    }
    
    public function testCreate() {
        $result = [];
        
        try {
            $this->db->beginTransaction();
            $result["result"] = $this->create();
            $this->db->rollBack();
        } catch (PDOException $e) {
            $result["pdo exception"] = $e->getMessage();
        } catch (Exception $e) {
            $result["exception"] = $e->getMessage();
        }
        
        $result["error"] = $this->error;
        
        return $result;
    }
    
    public function testRead() {
        $result = [];
        
        try {
            $result["result"] = $this->read();
        } catch (PDOException $e) {
            $result["pdo exception"] = $e->getMessage();
        } catch (Exception $e) {
            $result["exception"] = $e->getMessage();
        }
        
        $result["error"] = $this->error;
        
        return $result;
    }
    
    public function testReadOne() {
        $result = [];
        
        try {
            $result["result"] = $this->readOne();
        } catch (PDOException $e) {
            $result["pdo exception"] = $e->getMessage();
        } catch (Exception $e) {
            $result["exception"] = $e->getMessage();
        }
        
        $result["error"] = $this->error;
        
        return $result;
    }
    
    public function testUpdate() {
        $result = [];
        
        try {
            $this->db->beginTransaction();
            $result["result"] = $this->update();
            $this->db->rollBack();
        } catch (PDOException $e) {
            $result["pdo exception"] = $e->getMessage();
        } catch (Exception $e) {
            $result["exception"] = $e->getMessage();
        }
        
        $result["error"] = $this->error;
        
        return $result;
    }
    
    public function testDelete() {
        $result = [];
        
        try {
            $this->db->beginTransaction();
            $result["result"] = $this->delete();
            $this->db->rollBack();
        } catch (PDOException $e) {
            $result["pdo exception"] = $e->getMessage();
        } catch (Exception $e) {
            $result["exception"] = $e->getMessage();
        }
        
        $result["error"] = $this->error;
        
        return $result;
    }
    
    /*
     *  For test purposes this was disabled since MySQL will
     *  implicit COMMIT it
     */
    /*
    public function testResetRecords() {
        $result = [];
        
        try {
            $this->db->beginTransaction();
            $result["result"] = $this->resetRecords();
            $this->db->rollBack();
        } catch (PDOException $e) {
            $result["pdo exception"] = $e->getMessage();
        } catch (Exception $e) {
            $result["exception"] = $e->getMessage();
        }
        
        $result["error"] = $this->error;
        
        return $result;
    }
    */
}
?>