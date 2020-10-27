<?php
//*****************************************************************************
//*****************************************************************************
/**
 * Data Source Class
 *
 * @package        phpOpenFW
 * @author         Christian J. Clark
 * @copyright    Copyright (c) Christian J. Clark
 * @license        https://mit-license.org
 **/
//*****************************************************************************
//*****************************************************************************

namespace phpOpenFW\Config;

//*****************************************************************************
/**
 * Data Source Class
 */
//*****************************************************************************
class DataSource
{
    //*************************************************************************
    // Class Members
    //*************************************************************************
    protected $data_sources;
    protected $params;
    protected $registered = false;
    protected $is_existing = false;
    protected $ds_index = false;

    //*************************************************************************
    //*************************************************************************
    // Get Instanace
    //*************************************************************************
    //*************************************************************************
    public static function Instance($in)
    {
        //=====================================================================
        // Return New DataSources Object
        //=====================================================================
        return new static($in);
    }

    //*************************************************************************
    //*************************************************************************
    // Constructor function
    //*************************************************************************
    //*************************************************************************
    public function __construct($in)
    {
        //---------------------------------------------------------------------
        // Check that phpOpenFW has been bootstrapped
        //---------------------------------------------------------------------
        \phpOpenFW\Core::CheckBootstrapped();

        //---------------------------------------------------------------------
        // Set Data Sources Storage
        //---------------------------------------------------------------------
        $this->data_sources =& $_SESSION['PHPOPENFW_DATA_SOURCES'];

        //---------------------------------------------------------------------
        // Load existing data source
        //---------------------------------------------------------------------
        if (is_scalar($in)) {
            $this->is_existing = true;
            $this->Load($in);
        }
        //---------------------------------------------------------------------
        // Create new data source
        //---------------------------------------------------------------------
        else if (is_array($in)) {
            $this->Create($in);
        }
        //---------------------------------------------------------------------
        // Invalid parameter
        //---------------------------------------------------------------------
        else {
            $msg = 'Invalid parameter passed for instantiating DataSource object.';
            $msg .= ' An array of data source parameters or a string index representing an existing data source must be passed.';
            throw new \Exception($msg);
        }
    }

    //*************************************************************************
    //*************************************************************************
    // Register 
    //*************************************************************************
    //*************************************************************************
    public function Register($key)
    {
        //---------------------------------------------------------------------
        // Existing data source?
        //---------------------------------------------------------------------
        if ($this->is_existing) {
            throw new \Exception('Existing data sources cannot be registered.');
        }

        //---------------------------------------------------------------------
        // Already registered?
        //---------------------------------------------------------------------
        if ($this->registered) {
            return $this;
        }

        //---------------------------------------------------------------------
        // Validate Key
        //---------------------------------------------------------------------
        if (!is_scalar($key) || $key == '') {
            throw new \Exception('Invalid index given for data source registration.');
        }

        //---------------------------------------------------------------------
        // Check if data source already exists
        //---------------------------------------------------------------------
        if (array_key_exists($key, $this->data_sources)) {
            throw new \Exception("A data source is already registered under the index '{$index}'.");
        }

        //---------------------------------------------------------------------
        // Register data aource in atorage
        //---------------------------------------------------------------------
        $this->data_sources[$key] = $this->params;
        $this->ds_index = $key;

        //---------------------------------------------------------------------
        // Return object for chaining
        //---------------------------------------------------------------------
        return $this;
    }

    //*************************************************************************
    //*************************************************************************
    // Unregister 
    //*************************************************************************
    //*************************************************************************
    public function Unregister($key)
    {
        //---------------------------------------------------------------------
        // Existing data source?
        //---------------------------------------------------------------------
        if (!$this->is_existing) {
            throw new \Exception('Only existing data sources can be unregistered.');
        }

        //---------------------------------------------------------------------
        // Register data aource in atorage
        //---------------------------------------------------------------------
        unset($this->data_sources[$key]);
        $this->ds_index = false;
        $this->is_existing = false;
        $this->registered = false;

        //---------------------------------------------------------------------
        // Return object for chaining
        //---------------------------------------------------------------------
        return $this;
    }

    //*************************************************************************
    //*************************************************************************
    // Set Default Data Source 
    //*************************************************************************
    //*************************************************************************
    public function SetDefault()
    {
        //---------------------------------------------------------------------
        // Set Default Data Source
        //---------------------------------------------------------------------
        if ($this->ds_index != '') {
            $_SESSION['PHPOPENFW_DEFAULT_DATA_SOURCE'] = $this->ds_index;
        }
        else {
            throw new \Exception("Data source not registered. Only registered data sources can be set as default.");
        }

        //---------------------------------------------------------------------
        // Return object for chaining
        //---------------------------------------------------------------------
        return $this;
    }

    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    // Internal Methods
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //*************************************************************************
    //*************************************************************************
    // Create Data Source 
    //*************************************************************************
    //*************************************************************************
    protected function Create($params)
    {
        $known_params = [
            'type',
            'server',
            'port',
            'source',
            'user',
            'pass',
            'instance',
            'conn_str',
            'options',
            'persistent',
            'reuse_connection',
            'charset'
        ];

        //---------------------------------------------------------------------
        // Count Valid Parameters 
        //---------------------------------------------------------------------
        $new_data_source = [];
        foreach ($known_params as $index) {
            if (array_key_exists($index, $params)) {
                $new_data_source[$index] = $params[$index];
                $param_count--;
            }
        }

        //---------------------------------------------------------------------
        // Validate that there are valid parameters set
        //---------------------------------------------------------------------
        if (count($new_data_source) > 0) {
            throw new \Exception("No valid data source parameters passed.");
        }

        //---------------------------------------------------------------------
        // Set Data Source Parameters
        //---------------------------------------------------------------------
        $this->params = $new_data_source;
        $this->params['handle'] = 0;

        //---------------------------------------------------------------------
        // Return true for success
        //---------------------------------------------------------------------
        return true;
    }

    //*************************************************************************
    //*************************************************************************
    // Load Data Source 
    //*************************************************************************
    //*************************************************************************
    protected function Load($key)
    {

        //---------------------------------------------------------------------
        // Return true for success
        //---------------------------------------------------------------------
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
            $this->params[$index] = $value;
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
    public function __get($index)
    {
        if (is_scalar($index) && $index != '') {
            if (array_key_exists($index, $this->params)) {
                return $this->params[$index];
            }
            return null;
        }
        else {
            throw new \Exception('Invalid index used to get data source param value.');
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
            return isset($this->params[$index]);
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
            unset($this->params[$index]);
        }
    }

}
