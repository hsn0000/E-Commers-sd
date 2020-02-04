<?php



if ( ! function_exists('is_number')) 
{
   function is_number( $number, $decimals = 0, $points = '.', $thousands_sep = ',') 
   {
       return number_format($number, $decimals, $points, $thousands_sep);
   }
}