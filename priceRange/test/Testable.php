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
            if (strpos($method, "__construct") !== false) {
                continue;
            }
            
            if (strpos($method, "test") !== false) {
                $methodName = $method->getName();
                $classTest->$methodName();
                var_dump($classTest);
            }
        }
    }
}