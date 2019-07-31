<?php
/*
 *  All the things related to work with date eg. validate if is date, 
 *  modify by adding or removing a period of time, etc should be here
 */
interface iCustomDate {
    const ADD = "add";
    const REDUCE = "reduce";
    
    /*
     *  Update the date to the given amount
     *  
     *  @param $mode: iCustomDate constants - add to add time and reduce to reduce time
     *  @param $date: string/date - the date to modify
     *  @param $amount: DateInterval
     *  @return $result: string - date with a specific format
     */
    function modifyDate($mode, $date, $amount);
    
    /*
     *  Validate if the date is valid
     *  
     *  @param $date: string - value to verify
     *  @param $format: string - format of the date
     *  @return $result: bool - whether it is a valid date or not
     */
    function validateDateFormat($date, $format);
}