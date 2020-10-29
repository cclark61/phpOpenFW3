<?php
//*****************************************************************************
//*****************************************************************************
/**
 * Application Configuration Class
 *
 * @package         phpOpenFW
 * @author          Christian J. Clark
 * @copyright       Copyright (c) Christian J. Clark
 * @license         https://mit-license.org
 **/
//*****************************************************************************
//*****************************************************************************

namespace phpOpenFW\Core;

//*****************************************************************************
/**
 * AppConfig Class
 */
//*****************************************************************************
class AppConfig
{
    //*************************************************************************
    // Class Members
    //*************************************************************************
    protected $config_data = [];
    protected $display_errors = false;

    //*************************************************************************
    //*************************************************************************
    // Get Instanace
    //*************************************************************************
    //*************************************************************************
    public static function Instance(Array $args=[])
    {
        //=====================================================================
        // Return New AppConfig Object
        //=====================================================================
        return new static($args);
    }

    //*************************************************************************
    //*************************************************************************
    // Constructor function
    //*************************************************************************
    //*************************************************************************
    public function __construct(Array $args=[])
    {
        //---------------------------------------------------------------------
        // Check that phpOpenFW has been bootstrapped
        //---------------------------------------------------------------------
        \phpOpenFW\Core::CheckBootstrapped();

        //---------------------------------------------------------------------
        // Set Defaults / Args
        //---------------------------------------------------------------------
        $display_errors = false;
        extract($args);
        $this->display_errors = $display_errors;

        //---------------------------------------------------------------------
        // Set Config
        //---------------------------------------------------------------------
        $this->config_data =& $_SESSION[PHPOPENFW_CONFIG_INDEX];
    }

    //*************************************************************************
    //*************************************************************************
    // Load Configuration
    //*************************************************************************
    //*************************************************************************
    public function Load($config_file)
    {
        //---------------------------------------------------------------------
        // No Config File Set? Use default.
        //---------------------------------------------------------------------
        if (!$config_file || !file_exists($config_file)) {
            $config_file = PHPOPENFW_APP_FILE_PATH . '/config.inc.php';
        }

        //---------------------------------------------------------------------
        // Validate Config File
        //---------------------------------------------------------------------
        if (!file_exists($config_file)) {
            if ($this->display_errors) {
                throw new \Exception('Configuration file is invalid or cannot be opened.');
            }
            return false;
        }

        //---------------------------------------------------------------------
        // Include Config File
        //---------------------------------------------------------------------
        include($config_file);

        //---------------------------------------------------------------------
        // Check for Configuration Data
        //---------------------------------------------------------------------
        if (isset($config) && is_array($config)) {
            $this->SetConfigValues($this->config_data, $config);
        }
        else if (isset($config_arr) && is_array($config_arr)) {
            $this->SetConfigValues($this->config_data, $config_arr);
        }
        else {
            if ($this->display_errors) {
                throw new \Exception('Configuration not set. $config not found.');
            }
            return false;
        }

        //---------------------------------------------------------------------
        // Configuration Loaded Successfully
        //---------------------------------------------------------------------
        return true;
    }

    //*************************************************************************
    //*************************************************************************
    // Export Configuration
    //*************************************************************************
    // Formats: array (default), json, raw
    //*************************************************************************
    //*************************************************************************
    public function Export($format='')
    {
        if ($format == 'raw') {
            return $this->config_data;
        }
        else if ($format == 'json') {
            return json_encode($this->config_data);
        }
        else {
            return (array)$this->config_data;
        }
    }

    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    // Internal Methods
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //*************************************************************************
    //*************************************************************************
    // Set Config Values
    //*************************************************************************
    //*************************************************************************
    protected function SetConfigValues(&$config, $values)
    {
        if (!is_iterable($values)) {
            return false;
        }

        foreach ($values as $index => $value) {
            if (is_iterable($value)) {
                $config->$index = new \stdClass();
                $this->SetConfigValues($config->$index, $value);
            }
            else {
                $config->$index = $value;
            }
        }

        return true;
    }

    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    // Magic Methods
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //*************************************************************************
    //*************************************************************************
    // Set
    //*************************************************************************
    //*************************************************************************
    public function __set($index, $value)
    {
        if (is_scalar($index) && $index != '') {
            $this->config_data->$index = $value;
        }
        else {
            throw new \Exception('Invalid index used to set value.');
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
            if (isset($this->config_data->$index)) {
                return $this->config_data->$index;
            }
            return null;
        }
        else {
            throw new \Exception('Invalid index used to get value.');
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
            return isset($this->config_data->$index);
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
            unset($this->config_data->$index);
        }
    }
}
