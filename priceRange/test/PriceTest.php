<?php
include_once '../models/Price.php';

class PriceTest extends Price {
    /*
     *  Setup the model to test
     *  The connection, $db, should be provided
     *  
     *  @param $db: iDatabaseConfig
     */
    public function __construct($db) {
        parent::__construct($db);
        $this->priceId = 1;
        $this->startDate = "2019-01-01";
        $this->endDate = "2019-10-10";
        $this->price = 20;
        
        $this->validate();
    }
    
    /*
     *  Verify the create function and rollback
     */
    public function testCreate() {
        $result = [];
        
        try {
            $this->conn->beginTransaction();
            $result["result"] = $this->create();
            $this->conn->rollBack();
        } catch (PDOException $e) {
            $result["pdo exception"] = $e->getMessage();
        } catch (Exception $e) {
            $result["exception"] = $e->getMessage();
        }
        
        $result["error"] = $this->error;
        
        return $result;
    }
    
    /*
     *  Verify the read function
     */
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
    
    /*
     *  Verify the readOne function
     */
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
    
    /*
     *  Verify the update function and rollback
     */
    public function testUpdate() {
        $result = [];
        
        try {
            $this->conn->beginTransaction();
            $result["result"] = $this->update();
            $this->conn->rollBack();
        } catch (PDOException $e) {
            $result["pdo exception"] = $e->getMessage();
        } catch (Exception $e) {
            $result["exception"] = $e->getMessage();
        }
        
        $result["error"] = $this->error;
        
        return $result;
    }
    
    /*
     *  Verify the delete function and rollback
     */
    public function testDelete() {
        $result = [];
        
        try {
            $this->conn->beginTransaction();
            $result["result"] = $this->delete();
            $this->conn->rollBack();
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
            $this->conn->beginTransaction();
            $result["result"] = $this->resetRecords();
            $this->conn->rollBack();
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