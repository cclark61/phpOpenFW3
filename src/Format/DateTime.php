<?php
//**************************************************************************************
//**************************************************************************************
/**
 * Date / Time Class
 *
 * @package		phpOpenFW
 * @author 		Christian J. Clark
 * @copyright	Copyright (c) Christian J. Clark
 * @license		https://mit-license.org
 **/
//**************************************************************************************
//**************************************************************************************

namespace phpOpenFW\Format;

//*****************************************************************************
/**
 * Date / Time Class
 */
//*****************************************************************************
class DateTime
{

	//=============================================================================
	//=============================================================================
	// Make a MySQL Timestamp Look Pretty
	//=============================================================================
	//=============================================================================
	public static function mystamp_pretty($mysql_stamp, $format='n/j/Y g:i a')
	{
		$unix_stamp = strtotime($mysql_stamp);
		if ($unix_stamp > 0) {
			return date($format, $unix_stamp);
		}
		else {
			return false;
		}
	}

	//=============================================================================
	//=============================================================================
	// Generic Date Format Function
	//=============================================================================
	//=============================================================================
	public static function gen_format_date($stamp, $def_ret_val=false, $format="n/j/Y")
	{
		if ($stamp == '0000-00-00') { return $def_ret_val; }
		$unix_stamp = strtotime($stamp);
		if ($unix_stamp !== false) { return date($format, $unix_stamp); }
		else { return $def_ret_val; }
	}
	
	//=============================================================================
	//=============================================================================
	// Convert Date to SQL Format Function
	//=============================================================================
	//=============================================================================
	public static function format_date_sql($stamp, $def_ret_val=false, $format="Y-m-d")
	{
		return self::gen_format_date($stamp, $def_ret_val, $format);
	}
	
	//=============================================================================
	//=============================================================================
	// Convert Date to Viewable Format Function
	//=============================================================================
	//=============================================================================
	public static function format_date_pretty($stamp, $def_ret_val=false, $format="n/j/Y")
	{
		return self::gen_format_date($stamp, $def_ret_val, $format);
	}
	
}
