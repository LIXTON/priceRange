<?php
class Testable {
    public $output = [];
    /*
     *  This must test only files in test folder
     *  
     *  @param $classTest: mixed - any class in test folder
     */
    public function runTests($classTest) {
        $reflectClass = new ReflectionClass($classTest);
        $this->output = [];
        foreach($reflectClass->getmethods() as $method) {
            if (strpos($method, "test") !== false) {
                $this->output[$reflectClass->getName() . " " . $method] = $classTest->$method();
            }
        }
    }
}