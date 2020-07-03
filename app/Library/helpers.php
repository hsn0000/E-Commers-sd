<?php

if ( ! function_exists('is_number')) 
{
   function is_number( $number, $decimals = 0, $points = '.', $thousands_sep = ',') 
   {
       return number_format($number, $decimals, $points, $thousands_sep);
   }
}


/* print for required fields */
if( ! function_exists('required_field'))
{
    function required_field($message) 
    {
        return '<div class="invalid-feedback">'.$message.'</div>';
    }
} 


/* push to multidimention array */
if(!function_exists('array_push_multidimension')) 
{
    function array_push_multidimension($array_data = array(), $array_push = array(), $position = 'last') 
    {
        $array = array();
        if(is_array($array_data))
        {
            if($position == 'last')
            {
                $position_key = @end(array_keys($array_data));
            }
            else
            {
                $position_key = $position;
            }

            foreach($array_data as $key => $val )
            {
                if($position != 'first') 
                {
                    $array[$key] = $val;
                }

                if($key == $position_key || $position == 'first')
                {
                    foreach($array_push as $push_key => $push_val)
                    {
                        if(is_numeric($push_key) && $key == 0 )
                        {
                            ++$push_key;
                        }

                        $array[$push_key] = $push_val;
                        if(is_array($push_key))
                        {
                            return array_push_multidimension($array, $push_key, $position);
                        }

                    }
                }

                if($position == 'first')
                {
                    $array[$key] = $val;
                }

            }

        }
        else
        {
            foreach($array_push as $push_key => $push_val)
            {
                $array[$push_key] = $push_val;
                if(is_array($push_key))
                {
                    return array_push_multidimension($array, $push_key);
                }
            }
        }

        return ($array);
    }
}