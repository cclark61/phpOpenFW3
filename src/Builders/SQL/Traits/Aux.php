<?php
//*****************************************************************************
//*****************************************************************************
/**
 * Auxillary / Helper Trait
 *
 * @package		phpOpenFW
 * @author 		Christian J. Clark
 * @copyright	Copyright (c) Christian J. Clark
 * @license		https://mit-license.org
 **/
//*****************************************************************************
//*****************************************************************************

namespace phpOpenFW\Builders\SQL\Traits;

//*****************************************************************************
/**
 * Aux Trait
 */
//*****************************************************************************
trait Aux
{
    //=========================================================================
    //=========================================================================
    // Is Database Type Valid?
    //=========================================================================
    //=========================================================================
    protected static function DbTypeIsValid(String $db_type)
    {
        if (!in_array($db_type, ['mysql', 'pgsql', 'oracle', 'sqlsrv'])) {
            return false;
        }
        return true;
    }

    //=========================================================================
    //=========================================================================
    // Is Valid Operator
    //=========================================================================
    //=========================================================================
    protected static function IsValidOperator($op)
    {
        if (!is_scalar($op) || (string)$op === '') {
            return false;
        }
        $op = strtolower($op);
        $ops = [
            '=', 
            '!=', 
            '<>', 
            '<', 
            '<=', 
            '>', 
            '>=', 
            'in', 
            'not in', 
            'like', 
            'not like', 
            'between', 
            'not between',
            'is null',
            'is not null',
            'exists',
            'not exists'
        ];
        if (!in_array($op, $ops)) {
            return false;
        }
        return true;
    }

    //=========================================================================
    //=========================================================================
    // Is Valid Param Type
    //=========================================================================
    //=========================================================================
    protected static function IsValidParamType($type)
    {
        if ($type && is_scalar($type)) {
            return in_array($type, ['i', 's', 'd', 'b']);
        }
        return false;
    }

    //=========================================================================
    //=========================================================================
    // Is Valid And Or Value
    //=========================================================================
    //=========================================================================
    protected static function IsValidAndOr($andor)
    {
        if ($andor && is_scalar($andor)) {
            return in_array($andor, ['and', 'or']);
        }
        return false;
    }
}
