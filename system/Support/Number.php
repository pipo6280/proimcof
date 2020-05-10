<?php
namespace system\Support;

class Number
{

    public static function format($number, $decimals = 0, $search = '.', $replace = ',')
    {
        return number_format($number, $decimals, $search, $replace);
    }
}