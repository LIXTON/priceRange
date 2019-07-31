<?php
include_once '../templates/aController.php';

/*
 *  PriceController define the business rules for the price model
 */
class PriceController extends aController {
    public function indexView() {
        $list = [];
        
        $list = $this->model->read();
        
        if ($list === null) {
            $this->error[] = "Unable to read Prices. Try again later.";
        }
        
        return $list;
    }
    
    public function createView() {
        $this->adjustPriceRecords($this->model::CREATE);
    }
    
    public function readOneView() {
        if (!$this->model->readOne()) {
            $this->error[] = "Unable to read Price. Try again later.";
        }
    }
    
    public function updateView() {
        $this->adjustPriceRecords($this->model::UPDATE);
    }
    
    public function deleteView() {
        if (!$this->model->delete()) {
            $this->error[] = "Unable to delete Price. Try again later.";
        }
    }
    
    public function resetView() {
        if (!$this->model->resetRecords()) {
            $this->error[] = "Unable to reset Price records. Try again later.";
        }
    }
    
    public function printError() {
        $msg = "Something went wrong. Reason(s):<br>";
        
        foreach($this->error as $key => $e) {
            $msg .= (" - " . $key . " ". $e . "<br>");
        }
        
        return $msg;
    }
    
    /*
     *  It loads the list of records that could match with the 
     *  current model range of dates and adjust them so the records
     *  range of dates doesn't cross with each other
     *
     *  @param $scenario: string - specify the scenario CREATE/UPDATE
     */
    protected function adjustPriceRecords($scenario) {
        $newRecord = clone $this->model;
        $filter = [
            "startDate" => $newRecord->startDate,
            "endDate" => $newRecord->endDate
        ];
        $list = $this->model->read($filter);
        $scenarioList = $this->fixRecords($list, $scenario);
        
        $this->updateRecords($scenarioList);
    }
    
    /*
     *  Recieve a list of Price and modify their range of date if
     *  they cross with the current model
     *  The return type is an array of arrays as follow:
     *  [
     *      [
     *          "id" => Price->id,
     *          "object" => Price,
     *          "scenario" => CREATE/UPDATE/DELETE
     *      ],
     *      ...
     *  ]
     *
     *  @param $list: array of Price
     *  @param $scenario: string - specify the scenario CREATE/UPDATE
     *  @return $scenarioList: array of arrays
     */
    protected function fixRecords($list, $scenario) {
        $scenarioList = [];
        foreach($list as $k => $l) {
            if ($l instanceof Price) {
                $error = $l->validate();
                if (!empty($error)) {
                    $this->error["price " . $k] = $error;
                }
            } else {
                $this->error["price " . $k] = "Is not a Price Model";
            }
            
            if (!empty($this->error)) {
                continue;
            }
            
            if ($newRecord->priceId == $l->priceId) {
                continue;
            }
            
            if ($newRecord->price == $l->price) {
                $newRecord->startDate = $newRecord->startDate <= $l->startDate ? $newRecord->startDate:$l->startDate;
                $newRecord->endDate = $newRecord->endDate >= $l->endDate ? $newRecord->endDate:$l->endDate;
                $scenarioList[] = [
                    "id" =>$l->priceId, 
                    "object" => $l, 
                    "scenario" => $this->model::DELETE
                ];
            } else {
                if ($newRecord->startDate <= $l->startDate && $newRecord->endDate >= $l->endDate) {
                    $scenarioList[] = [
                        "id" =>$l->priceId, 
                        "object" => $l, 
                        "scenario" => $this->model::DELETE
                    ];
                } else {
                    $cloneRecord = clone $l;
                    $isNewRecord = false;
                    if ($newRecord->startDate <= $cloneRecord->endDate && $newRecord->startDate > $cloneRecord->startDate) {
                        $l->endDate = $l->modifyDate($l::REDUCE, $newRecord->startDate, "P1D");
                        $scenarioList[] = [
                            "id" =>$l->priceId, 
                            "object" => $l, 
                            "scenario" => $this->model::UPDATE
                        ];
                        $isNewRecord = true;
                    }
                    if ($newRecord->endDate < $cloneRecord->endDate && $newRecord->endDate >= $cloneRecord->startDate) {
                        $cloneRecord->startDate = $l->modifyDate($l::ADD, $newRecord->endDate, "P1D");
                        $scenarioList[] = [
                            "id" => ($isNewRecord ? "new clone ":"") . $l->priceId, 
                            "object" => $cloneRecord, 
                            "scenario" => $isNewRecord ? $this->model::CREATE:$this->model::UPDATE];
                    }
                }
            }
            
        }
        
        $scenarioList[] = [
            "id" => "new current", 
            "object" => $newRecord, 
            "scenario" => $scenario
        ];
        
        return $scenarioList;
    }
    
    /*
     *  Loops through the list scenario provided by fixRecords method
     *  and call their correspoding scenario
     *
     *  @param $scenarioList: array of arrays
     */
    protected function updateRecords($scenarioList) {
        foreach($scenarioList as $key => $l) {
            switch($l['scenario']) {
                case $this->model::CREATE:
                    if ($l["object"]->create() == null) {
                        $this->error["price " . $l->id] = "Fail to create";
                    }
                    break;
                case $this->model::UPDATE:
                    if (!$l["object"]->update()) {
                        $this->error["price " . $l->id] = "Fail to update";
                    }
                    break;
                case $this->model::DELETE:
                    if (!$l["object"]->delete()) {
                        $this->error["price " . $l->id] = "Fail to delete";
                    }
                    break;
            }
        }
    }
}
