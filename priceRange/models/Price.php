<?php
include_once '../templates/aModel.php';
include_once '../templates/iCustomDate.php';

/*
 *  Price represent the table prices
 */
class Price extends aModel implements iCustomDate {
    const TABLE_NAME = "prices";
    
    public $priceId;
    public $startDate;
    public $endDate;
    public $price;
    
    public function validate($scenario = null) {
        if ($scenario === null) {
            $this->validateID();
            $this->validateDate();
            $this->validatePrice();
        }
        
        if ($scenario == self::DELETE || $scenario == self::UPDATE || $scenario == self::READONE) {
            $this->validateID();
        }
        
        if ($scenario == self::CREATE || $scenario == self::UPDATE) {
            $this->validateDate();
            $this->validatePrice();
        }
        
        return $this->error;
    }
    
    public function create() {
        $query = "INSERT INTO " . self::TABLE_NAME . " " .
                 "SET " .
                    "start_date = :startDate, " .
                    "end_date = :endDate, " .
                    "price = :price ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":startDate", $this->startDate);
        $stmt->bindParam(":endDate", $this->endDate);
        $stmt->bindParam(":price", $this->price);
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        
        return null;
    }
    
    public function read($filter = null) {
        $result = [];
        $query = "SELECT * FROM " . self::TABLE_NAME . " ";
        if (!empty($filter) && (isset($filter["endDate"]) || isset($filter["startDate"]) || isset($filter["price"]))) {
            $query .= "WHERE ";
            if (isset($filter["endDate"], $filter["startDate"], $filter["price"])) {
                $query .= ("start_date <= :endDate " .
                           "AND end_date >= :startDate " . 
                           "AND price = :price");
            } else if (isset($filter["endDate"], $filter["startDate"])) {
                $query .= ("start_date <= :endDate " .
                           "AND end_date >= :startDate ");
            } else {
                $query .= "price = :price ";
            }
        }
        $query .= "ORDER BY start_date ";
        $stmt = $this->conn->prepare($query);
        if (!empty($filter) && (isset($filter["endDate"]) || isset($filter["startDate"]) || isset($filter["price"]))) {
            if (isset($filter["startDate"], $filter["endDate"])) {
                $stmt->bindParam(":startDate", $filter["startDate"]);
                $stmt->bindParam(":endDate", $filter["endDate"]);
            }
            if (isset($filter["price"])) {
                $stmt->bindParam(":endDate", $filter["price"]);
            }
        }
        if ($stmt->execute()) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->priceId = $row["price_id"];
                $this->startDate = $row["start_date"];
                $this->endDate = $row["end_date"];
                $this->price = $row["price"];
                $result[] = clone $this;
            }
        } else {
            return null;
        }
        
        return $result;
    }
    
    public function readOne() {
        $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE price_id = :priceId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":priceId", $this->priceId);
        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->startDate = $row["start_date"];
            $this->endDate = $row["end_date"];
            $this->price = $row["price"];
            
            return true;
        }
        
        return false;
    }
    
    public function update() {
        $query = "UPDATE " . self::TABLE_NAME . " " .
                 "SET " .
                    "start_date = :startDate, " .
                    "end_date = :endDate, " .
                    "price = :price " .
                 "WHERE " .
                    "price_id = :priceId ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":startDate", $this->startDate);
        $stmt->bindParam(":endDate", $this->endDate);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":priceId", $this->priceId);
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    public function delete() {
        $query = "DELETE FROM " . self::TABLE_NAME . " WHERE price_id = :priceId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":priceId", $this->priceId);
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    public function validateDateFormat($date, $format = 'Y-m-d') {
        $d = DateTimeImmutable::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
    
    public function modifyDate($mode, $date, $amount) {
        $format = "Y-m-d";
        switch($mode){
            case self::ADD:
                $date = DateTime::createFromFormat($format, $date)->add(new DateInterval($amount))->format($format);
                break;
            case self::REDUCE:
                $date = DateTime::createFromFormat($format, $date)->sub(new DateInterval($amount))->format($format);
                break;
        }
        
        return $date;
    }
    
    /*
     *  This function is used to reset the table records
     *
     *  @return $result: bool
     */
    public function resetRecords() {
        $query = "TRUNCATE TABLE " . self::TABLE_NAME;
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    protected function validateDate() {
        if (!$this->validateDateFormat($this->startDate)) {
            $this->error[] = "Start date is not a proper a date, proper date should be 'Y-m-d'.";
        }
        
        if (!$this->validateDateFormat($this->endDate)) {
            $this->error[] = "End date is not a proper a date, proper date should be 'Y-m-d'.";
        }
        
        if ($this->validateDateFormat($this->startDate) && $this->validateDateFormat($this->endDate)) {
            if ($this->endDate < $this->startDate) {
                $this->error[] = "End date has to be equal or greater than start date.";
            }
        }
    }
    
    protected function validatePrice() {
        if (!filter_var($this->price, FILTER_VALIDATE_FLOAT)) {
            $this->error[] = "Price is invalid.";
        } else {
            $this->price = (float)$this->price;
        }
    }
    
    protected function validateID() {
        $options = array(
            "options" => array(
                "min_range" => 1
            )
        );
        
        if (filter_var($this->priceId, FILTER_VALIDATE_INT, $options)) {
            $this->priceId = (int)$this->priceId;
        } else {
            $this->error[] = "Price ID is not a positive number.";
        }
    }
}