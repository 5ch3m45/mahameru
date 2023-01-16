<?php 

if(!defined('BASEPATH')) exit('No direct script access allowed');

function validDate($date) {
    $regex = '/^\d{4}-\d{2}-\d{2}$/';

    if (preg_match($regex, $date)) {
        // The date is in the correct format, now we can check if it is a real date
        $parts = explode('-', $date);
        $year = $parts[0];
        $month = $parts[1];
        $day = $parts[2];
        if (checkdate($month, $day, $year)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}