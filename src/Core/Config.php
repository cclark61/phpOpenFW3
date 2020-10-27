<?php
//*****************************************************************************
//*****************************************************************************
/**
 * Config Class
 *
 * @package		phpOpenFW
 * @author 		Christian J. Clark
 * @copyright	Copyright (c) Christian J. Clark
 * @license		https://mit-license.org
 **/
//*****************************************************************************
//*****************************************************************************

namespace phpOpenFW;

//*****************************************************************************
/**
 * Config Class
 */
//*****************************************************************************
class Config
{
	//*************************************************************************
    // Class Members
	//*************************************************************************
    protected $config_file = false;
    protected $config = [];
    protected $is_valid = false;

	//*************************************************************************
	//*************************************************************************
	// Constructor function
	//*************************************************************************
	//*************************************************************************
	public function __construct($config_file)
	{
        //---------------------------------------------------------------------
        // Validate Config File
        //---------------------------------------------------------------------
        if (!file_exists($config_file)) {
            throw new \Exception('Configuration file is invalid or cannot be opened.');
        }

        //---------------------------------------------------------------------
        // Include Config File
        //---------------------------------------------------------------------
        $this->config_file = $config_file;
        include($config_file);

        //---------------------------------------------------------------------
        // Check for Configuration Data
        //---------------------------------------------------------------------
        if (isset($config) && is_array($config)) {
            $this->config = $config;
            $is_valid = true;
        }
        else if (isset($config_arr) && is_array($config_arr)) {
            $this->config = $config_arr;
            $is_valid = true;
        }
        else {
            throw new \Exception('Configuration not set. $config not found.');
        }

        //---------------------------------------------------------------------
        // 
        //---------------------------------------------------------------------

    }

	//*************************************************************************
	//*************************************************************************
    // Is Configuration Valid?
	//*************************************************************************
	//*************************************************************************
	public function IsValid()
	{
        return $this->is_valid;
    }

	//*************************************************************************
	//*************************************************************************
    // Export
	//*************************************************************************
	//*************************************************************************
	public function Export()
    {
        return $this->config;
    }

	//*************************************************************************
	//*************************************************************************
    // Set
	//*************************************************************************
	//*************************************************************************
    public function __set($index, $value)
    {
        if (is_scalar($index) && $index != '') {
            $this->config[$index] = $value;
        }
        else {
            throw new \Exception('Invalid index used to set configuration value.');
        }
    }

	//*************************************************************************
	//*************************************************************************
    // Get
	//*************************************************************************
	//*************************************************************************
    public function &__get($index)
    {
        if (is_scalar($index) && $index != '') {
            if (array_key_exists($index, $this->config)) {
                return $this->config[$index];
            }
            return null;
        }
        else {
            throw new \Exception('Invalid index used to get configuration value.');
        }
    }

	//*************************************************************************
	//*************************************************************************
    // Isset
	//*************************************************************************
	//*************************************************************************
    public function __isset($index)
    {
        if (is_scalar($index) && $index != '') {
            return isset($this->config[$index]);
        }
        return null;
    }

	//*************************************************************************
	//*************************************************************************
    // Unset
	//*************************************************************************
	//*************************************************************************
    public function __unset($index)
    {
        if (is_scalar($index) && $index != '') {
            unset($this->config[$index]);
        }
    }
}
