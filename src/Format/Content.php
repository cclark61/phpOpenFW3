<?php
//*****************************************************************************
//*****************************************************************************
/**
 * Content Formatting Class
 *
 * @package		phpOpenFW
 * @author 		Christian J. Clark
 * @copyright	Copyright (c) Christian J. Clark
 * @license		https://mit-license.org
 **/
//*****************************************************************************
//*****************************************************************************

namespace phpOpenFW\Format;

//*****************************************************************************
/**
 * Content Formatting Class
 */
//*****************************************************************************
class Content
{
	//=========================================================================
	//=========================================================================
	// Sanitize and Escape for HTML Output Function
	//=========================================================================
	//=========================================================================
	public static function html_sanitize($s)
	{
		$s = preg_replace('/[\x00-\x1F\x7F]/', '', (string)$s);
		return htmlspecialchars(strip_tags($s));
	}

	//=========================================================================
	//=========================================================================
	// Escape for HTML Output Function
	//=========================================================================
	//=========================================================================
	public static function html_escape($s)
	{
		$s = preg_replace('/[^\xA|\xC|(\x20-\x7F)]*/', '', (string)$s);
		return htmlspecialchars($s);
	}

	//=========================================================================
	//=========================================================================
	// Fill If Empty Function
	//=========================================================================
	//=========================================================================
	public static function fill_if_empty(&$data, $empty_val='--', $trim_non_empty=false)
	{
            if (is_array($data) || is_resource($data)) {
                return false;
            }
            if (trim((string)$data) == '') {
                $data = $empty_val;
                return 1;
            }
            else if ($trim_non_empty) {
                $data = trim($data);
                return 2;
            }
            return 0;
	}

	//=========================================================================
	//=========================================================================
	// Display Error Function
	//=========================================================================
	//=========================================================================
	public static function display_error($scope, $error_msg, $error_type=E_USER_NOTICE)
	{
		$tmp_msg = "Error :: {$scope}() - {$error_msg}";
		return trigger_error($tmp_msg, $error_type);
	}

	//=========================================================================
	//=========================================================================
	// Format Filesize Function
	//=========================================================================
	//=========================================================================
	public static function format_filesize($bytes)
	{
	    if ($bytes < 1024) {
	        return $bytes .' B';
	    }
	    elseif ($bytes < 1048576) {
	        return round($bytes / 1024, 2) .' KB';
	    }
	    elseif ($bytes < 1073741824) {
	        return round($bytes / 1048576, 2) . ' MB';
	    }
	    else {
	        return round($bytes / 1073741824, 2) . ' GB';
	    }
	}
	
	//=========================================================================
	//=========================================================================
	// Get Saveable Password Function
	//=========================================================================
	//=========================================================================
	public static function get_saveable_password($pass, $aps=false)
	{
    	$config = new \phpOpenFW\Core\AppConfig();
		if (!$aps && isset($config->auth_pass_security)) {
			$aps = $config->auth_pass_security;
		}
		$aps = strtolower($aps);
	
		if ($aps) {
			switch ($aps) {

				case 'sha1':
					return sha1($pass);
					break;

				case 'md5':
					return md5($pass);
					break;

				default: // SHA256
					return hash('sha256', $pass);
					break;
			}
		}
	
		return $pass;
	}

	//=========================================================================
	//=========================================================================
	// Generate a globally unique identifier (GUID) Function
	//=========================================================================
	//=========================================================================
	public static function GUID()
	{
	    if (function_exists('com_create_guid') === true) {
	        return trim(com_create_guid(), '{}');
	    }
	
	    return sprintf(
	    	'%04X%04X-%04X-%04X-%04X-%04X%04X%04X', 
	    	mt_rand(0, 65535), 
	    	mt_rand(0, 65535), 
	    	mt_rand(0, 65535), 
	    	mt_rand(16384, 20479), 
	    	mt_rand(32768, 49151), 
	    	mt_rand(0, 65535), 
	    	mt_rand(0, 65535), 
	    	mt_rand(0, 65535)
	    );
	}

}
