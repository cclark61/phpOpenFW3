<?php
//*****************************************************************************
//*****************************************************************************
/**
 * Date / Time Class
 *
 * @package         phpopenfw/phpopenfw3
 * @author          Christian J. Clark
 * @copyright       Copyright (c) Christian J. Clark
 * @website         https://phpopenfw.org
 * @license         https://mit-license.org
 **/
//*****************************************************************************
//*****************************************************************************

namespace phpOpenFW\Validate;

//*****************************************************************************
/**
 * Date / Time Class
 */
//*****************************************************************************
class DateTime
{
    //=========================================================================
    //=========================================================================
    // Is Valid Date Function
    // *** Returns TRUE if $date is a valid MM/DD/YYYY formatted date.
    //=========================================================================
    //=========================================================================
    public static function is_valid_date($date)
    {
        $regex = '/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/';
        if (preg_match($regex, $date, $parts)) {
            return checkdate($parts[1], $parts[2], $parts[3]);
        }
        else { return false; }
    }
    
    //=========================================================================
    //=========================================================================
    // Is Valid SQL Date Function
    // *** Returns TRUE if $date is a valid SQL formatted date.
    //=========================================================================
    //=========================================================================
    public static function is_valid_sql_date($date)
    {
        $regex = '/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/';
        if (preg_match($regex, $date, $parts)) {
            return checkdate($parts[2], $parts[3], $parts[1]);
        }
        else { return false; }
    }
    
    
    //=========================================================================
    //=========================================================================
    // Is Valid Time Function
    // *** Returns TRUE if $time is HH:MM:SS (12)
    //=========================================================================
    //=========================================================================
    public static function is_valid_time($time, Array $args=[])
    {
        $format = '12hr';
        $format_24hr = false;
        $seconds = false;
        extract($args);
        if (empty($regex)) {
            if ($format == '24hr' || $format_24hr) {
                if ($seconds) {
                    $regex = '/^([01][0-9]|2[0-3]):([0-5][0-9]):([0-5]?\d)$/';
                }
                else {
                    $regex = '/^([01][0-9]|2[0-3]):([0-5][0-9])$/';
                }
            }
            else {
                if ($seconds) {
                    $regex = '/^([0-1]?\d|2[0-3]):([0-5]?\d):([0-5]?\d)$/';
                }
                else {
                    $regex = '/^([0-1]?\d|2[0-3]):([0-5]?\d)$/';
                }
            }
        }
        return preg_match($regex, $time);
    }

}
