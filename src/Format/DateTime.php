<?php
//******************************************************************************
//******************************************************************************
/**
 * Date / Time Class
 *
 * @package         phpOpenFW
 * @author          Christian J. Clark
 * @copyright       Copyright (c) Christian J. Clark
 * @website         https://phpopenfw.org
 * @license         https://mit-license.org
 **/
//******************************************************************************
//******************************************************************************

namespace phpOpenFW\Format;

//******************************************************************************
/**
 * Date / Time Class
 */
//******************************************************************************
class DateTime
{
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    // Date Methods
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //==========================================================================
    //==========================================================================
    // Convert Date to SQL Format
    //==========================================================================
    //==========================================================================
    public static function format_date_sql($value, $def_ret_val=false, $format="Y-m-d")
    {
        return static::format($value, $def_ret_val, $format);
    }

    //==========================================================================
    //==========================================================================
    // Convert Date to Viewable Format
    //==========================================================================
    //==========================================================================
    public static function format_date_pretty($value, $def_ret_val=false, $format="n/j/Y")
    {
        return static::format($value, $def_ret_val, $format);
    }

    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    // Date / Time (timestamp) Methods
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //==========================================================================
    //==========================================================================
    // Make a MySQL Timestamp Look Pretty (DEPRECATED)
    //==========================================================================
    //==========================================================================
    public static function mystamp_pretty($value, $format='n/j/Y g:i a')
    {
        return static::format_datetime_pretty($value, $format);
    }

    //==========================================================================
    //==========================================================================
    // Convert Date / Time to SQL Format
    //==========================================================================
    //==========================================================================
    public static function format_datetime_sql($value, $def_ret_val=false, $format="Y-m-d H:i:s")
    {
        return static::format($value, $def_ret_val, $format);
    }

    //==========================================================================
    //==========================================================================
    // Convert Date / Time to Viewable Format
    //==========================================================================
    //==========================================================================
    public static function format_datetime_pretty($value, $def_ret_val=false, $format="n/j/Y g:i a")
    {
        return static::format($value, $def_ret_val, $format);
    }

    //==========================================================================
    //==========================================================================
    // Convert Date / Time to Military Format
    //==========================================================================
    //==========================================================================
    public static function format_datetime_military($value, $def_ret_val=false, $format="n/j/Y H:i")
    {
        return static::format($value, $def_ret_val, $format);
    }

    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    // Time Methods
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //==========================================================================
    //==========================================================================
    // Convert Time to SQL Format
    //==========================================================================
    //==========================================================================
    public static function format_time_sql($value, $def_ret_val=false, $format="H:i:s")
    {
        return static::format($value, $def_ret_val, $format);
    }

    //==========================================================================
    //==========================================================================
    // Convert Time to Viewable Format
    //==========================================================================
    //==========================================================================
    public static function format_time_pretty($value, $def_ret_val=false, $format="g:i a")
    {
        return static::format($value, $def_ret_val, $format);
    }

    //==========================================================================
    //==========================================================================
    // Convert Time to Military Format
    //==========================================================================
    //==========================================================================
    public static function format_time_military($value, $def_ret_val=false, $format="H:i")
    {
        return static::format($value, $def_ret_val, $format);
    }

    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    // Format Methods
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //==========================================================================
    //==========================================================================
    // Format
    //==========================================================================
    //==========================================================================
    public static function format($value, $def_ret_val=false, $format="n/j/Y")
    {
        //----------------------------------------------------------------------
        // Check for invalid value
        //----------------------------------------------------------------------
        if ($value == '0000-00-00') {
            return $def_ret_val;
        }

        //----------------------------------------------------------------------
        // Check if integer timestamp passed
        //----------------------------------------------------------------------
        if (is_integer($value)) {
            $unix_stamp = $value;
        }
        //----------------------------------------------------------------------
        // Determine timestamp using strtotime()
        //----------------------------------------------------------------------
        else {
            $unix_stamp = strtotime($value);
        }

        //----------------------------------------------------------------------
        // Format and return value
        //----------------------------------------------------------------------
        if ($unix_stamp !== false) {
            return date($format, $unix_stamp);
        }

        //----------------------------------------------------------------------
        // Return default if not a valid timestamp
        //----------------------------------------------------------------------
        return $def_ret_val;
    }

    //==========================================================================
    //==========================================================================
    // Generic Date Format (DEPRECATED)
    //==========================================================================
    //==========================================================================
    public static function gen_format_date($value, $def_ret_val=false, $format="n/j/Y")
    {
        return static::format($value, $def_ret_val, $format);
    }

}
