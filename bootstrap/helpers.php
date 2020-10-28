<?php

if (!function_exists('getMonthName')) {
    function getMonthName($monthNumber)
    {
        return date("F", mktime(0, 0, 0, $monthNumber, 1));
    }
}
