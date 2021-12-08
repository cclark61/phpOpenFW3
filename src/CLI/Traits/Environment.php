<?php
//*****************************************************************************
//*****************************************************************************
/**
 * CLI Environment Trait
 *
 * @package         phpOpenFW
 * @author          Christian J. Clark
 * @copyright       Copyright (c) Christian J. Clark
 * @license         https://mit-license.org
 **/
//*****************************************************************************
//*****************************************************************************

namespace phpOpenFW\CLI\Traits;

//*****************************************************************************
/**
 * Environment Trait
 */
//*****************************************************************************
trait Environment
{
    //#########################################################################
    //#########################################################################
    // Internal Methods
    //#########################################################################
    //#########################################################################

    //*************************************************************************
    //*************************************************************************
    // Set Environment
    //*************************************************************************
    //*************************************************************************
    protected function SetEnv()
    {
        //---------------------------------------------------------------------
        // Environment from CLI
        //---------------------------------------------------------------------
        if (!empty($this->args['env'])) {
            define('ENV', $this->args['env']);
        }
        //---------------------------------------------------------------------
        // Environment from Config
        //---------------------------------------------------------------------
        else if (!empty($this->config->env)) {
            define('ENV', $this->config->env);
        }
        //---------------------------------------------------------------------
        // Environment from GLOBALS
        //---------------------------------------------------------------------
        else if (!empty($GLOBALS['env'])) {
            define('ENV', $GLOBALS['env']);
        }

        //---------------------------------------------------------------------
        // Display Environment
        //---------------------------------------------------------------------
        if (defined('ENV') && defined('VERBOSE') && VERBOSE) {
            $env = ENV;
            $tmp_msg = "Environment is '{$env}'";
            self::PrintInformation($tmp_msg, 0, '*');
        }
    }

    //*************************************************************************
    //*************************************************************************
    // Set Run Mode
    //*************************************************************************
    //*************************************************************************
    protected function SetRunMode()
    {
        $run_mode = false;
        if (isset($this->args['run_mode'])) {
            $run_mode = $this->args['run_mode'];
            define('RUN_MODE', $run_mode);
            if (defined('VERBOSE') && VERBOSE) {
                $tmp_msg = "Run Mode is '{$run_mode}'";
                self::PrintInformation($tmp_msg, 0);
            }
        }
        define('RUN_MODE', $run_mode);
    }

    //*************************************************************************
    //*************************************************************************
    // Set Verbose
    //*************************************************************************
    //*************************************************************************
    protected function SetVerbose()
    {
        $verbose = (isset($this->args['v'])) ? ((int)$this->args['v']) : (false);
        define('VERBOSE', $verbose);
        if ($verbose) {
            $tmp_msg = "Verbose output is ON (Level {$verbose}).";
            self::PrintInformation($tmp_msg, 0);
        }
    }
}
