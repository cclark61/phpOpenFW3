<?php
//******************************************************************************
//******************************************************************************
/**
 * Array Formatting Class
 *
 * @package         phpOpenFW
 * @author          Christian J. Clark
 * @copyright       Copyright (c) Christian J. Clark
 * @license         https://mit-license.org
 **/
//******************************************************************************
//******************************************************************************

namespace phpOpenFW\Format;

//******************************************************************************
/**
 * Array Formatting Class
 */
//******************************************************************************
class Arrays
{
    //==========================================================================
    /**
     * Get Array Reference Values
     */
    //==========================================================================
    public static function RefValues(Array $arr)
    {
        $refs = array();
        foreach($arr as $key => $value) {
            $refs[$key] = &$arr[$key];
        }
        return $refs;
    }

}
