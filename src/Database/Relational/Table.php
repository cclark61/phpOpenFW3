<?php
//******************************************************************************
//******************************************************************************
/**
 * Database Table Class
 *
 * @package         phpOpenFW
 * @author          Christian J. Clark
 * @copyright       Copyright (c) Christian J. Clark
 * @license         https://mit-license.org
 */
//******************************************************************************
//******************************************************************************

namespace phpOpenFW\Database\Relational;

use \phpOpenFW\Builders\SQL;

abstract class Table
{
    //==========================================================================
    // Class Members
    //==========================================================================
    protected static $data_source = '';
    protected static $ds_obj = false;
    protected static $table = false;
    protected static $select_only = false;

    //--------------------------------------------------------------------------
    // Select Members
    //--------------------------------------------------------------------------
    protected static $select_view = false;
    protected static $select_limit = 1000;
    protected static $select_order_by = 'id desc';
    protected static $select_debug = false;
    protected static $select_debug_only = false;
    protected static $select_return_debug = false;
    protected static $select_return_query = false;
    protected static $select_execute_args = [];

    //--------------------------------------------------------------------------
    // Insert Members
    //--------------------------------------------------------------------------
    protected static $insert_debug = false;
    protected static $insert_debug_only = false;
    protected static $insert_return_debug = false;
    protected static $insert_return_query = false;
    protected static $insert_execute_args = [];

    //--------------------------------------------------------------------------
    // Update Members
    //--------------------------------------------------------------------------
    protected static $update_limit = 1;
    protected static $update_debug = false;
    protected static $update_debug_only = false;
    protected static $update_return_debug = false;
    protected static $update_return_query = false;
    protected static $update_execute_args = [];

    //--------------------------------------------------------------------------
    // Delete Members
    //--------------------------------------------------------------------------
    protected static $delete_limit = 1;
    protected static $delete_debug = false;
    protected static $delete_debug_only = false;
    protected static $delete_return_debug = false;
    protected static $delete_return_query = false;
    protected static $delete_execute_args = [];

    //==========================================================================
    //==========================================================================
    // Select Records
    //==========================================================================
    //==========================================================================
    public static function Select(Array $wheres, Array $args=[])
    {
        //----------------------------------------------------------------------
        // Parse & Extract Args
        //----------------------------------------------------------------------
        $parsed_args = static::ParseArgs(__FUNCTION__, $args);
        extract($parsed_args['build']);

        //----------------------------------------------------------------------
        // Start Query
        //----------------------------------------------------------------------
        $query = SQL::Select($table, $data_source)
        ->Select($table . '.*');

        //----------------------------------------------------------------------
        // Order By
        //----------------------------------------------------------------------
        if (!empty($order_by)) {
            $query->OrderBy($order_by);
        }

        //----------------------------------------------------------------------
        // Limit
        //----------------------------------------------------------------------
        if (!empty($order_by)) {
            $query->Limit($limit);
        }

        //----------------------------------------------------------------------
        // Build Select Where
        //----------------------------------------------------------------------
        static::BuildSelectWhere($query, $wheres, $parsed_args['build']);

        //----------------------------------------------------------------------
        // Execute and Return Results
        //----------------------------------------------------------------------
        return static::Finish($query, $parsed_args['finish']);
    }

    //==========================================================================
    //==========================================================================
    // Select Query
    //==========================================================================
    //==========================================================================
    public static function GetSelectQuery(Array $wheres, Array $args=[])
    {
        $args['return_query'] = true;
        return static::Select($wheres, $args);
    }

    //==========================================================================
    //==========================================================================
    // Select One
    //==========================================================================
    //==========================================================================
    public static function SelectOne(Array $wheres, Array $args=[])
    {
        $recs = static::Select($wheres, $args);
        if ($recs) {
            if (count($recs) == 1) {
                return current($recs);
            }
            else {
                throw new \Exception('Unable to select one record for return. More than one record was found.');
            }
        }
        return [];
    }

    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    // Insert Methods
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //==========================================================================
    //==========================================================================
    // Insert
    //==========================================================================
    //==========================================================================
    public static function Insert(Array $values, Array $args=[])
    {
        //----------------------------------------------------------------------
        // Parse & Extract Args
        //----------------------------------------------------------------------
        $parsed_args = static::ParseArgs(__FUNCTION__, $args);
        extract($parsed_args['build']);

        //----------------------------------------------------------------------
        // Start Query
        //----------------------------------------------------------------------
        $query = SQL::Insert($table, $data_source);

        //----------------------------------------------------------------------
        // Build Values
        //----------------------------------------------------------------------
        static::BuildValues($query, $values, $parsed_args['build']);

        //----------------------------------------------------------------------
        // Execute and Return Results
        //----------------------------------------------------------------------
        return static::Finish($query, $parsed_args['finish']);
    }

    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    // Update Methods
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //==========================================================================
    //==========================================================================
    // Update
    //==========================================================================
    //==========================================================================
    public static function Update($wheres, Array $values, Array $args=[])
    {
        //----------------------------------------------------------------------
        // Parse & Extract Args
        //----------------------------------------------------------------------
        $parsed_args = static::ParseArgs(__FUNCTION__, $args);
        extract($parsed_args['build']);

        //----------------------------------------------------------------------
        // Start Query
        //----------------------------------------------------------------------
        $query = SQL::Update($table, $data_source);

        //----------------------------------------------------------------------
        // Build Values
        //----------------------------------------------------------------------
        static::BuildValues($query, $values, $parsed_args['build']);

        //----------------------------------------------------------------------
        // Build Update Where
        //----------------------------------------------------------------------
        static::BuildUpdateWhere($query, $wheres, $parsed_args['build']);

        //----------------------------------------------------------------------
        // Execute and Return Results
        //----------------------------------------------------------------------
        return static::Finish($query, $parsed_args['finish']);
    }

    //==========================================================================
    //==========================================================================
    // Update One
    //==========================================================================
    //==========================================================================
    public static function UpdateOne($wheres, Array $values, Array $args=[])
    {
        $args['limit'] = 1;
        return static::Update($wheres, $values, $args);
    }

    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    // Delete Methods
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //==========================================================================
    //==========================================================================
    // Delete
    //==========================================================================
    //==========================================================================
    public static function Delete($wheres, Array $args=[])
    {
        //----------------------------------------------------------------------
        // Parse & Extract Args
        //----------------------------------------------------------------------
        $parsed_args = static::ParseArgs(__FUNCTION__, $args);
        extract($parsed_args['build']);

        //----------------------------------------------------------------------
        // Build Delete Where
        //----------------------------------------------------------------------
        static::BuildDeleteWhere($query, $wheres, $parsed_args['build']);

        //----------------------------------------------------------------------
        // Execute and Return Results
        //----------------------------------------------------------------------
        return static::Finish($query, $parsed_args['finish']);
    }

    //==========================================================================
    //==========================================================================
    // Delete One
    //==========================================================================
    //==========================================================================
    public static function DeleteOne($wheres, Array $args=[])
    {
        $args['limit'] = 1;
        return static::Delete($wheres, $args);
    }

    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    // Alias Methods
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //==========================================================================
    //==========================================================================
    // Get Records (Alias to Select)
    //==========================================================================
    //==========================================================================
    public static function Get(Array $args=[])
    {
        return static::Select($args);
    }

    //==========================================================================
    //==========================================================================
    // Get One Record (Alias to SelectOne)
    //==========================================================================
    //==========================================================================
    public static function GetOne(Array $args=[])
    {
        return static::SelectOne($args);
    }

    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    // Internal Methods
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //==========================================================================
    //==========================================================================
    // Get Data Source
    //==========================================================================
    //==========================================================================
    protected static function GetDataSource(Array $args=[])
    {
        $data_source = static::$data_source;
        if (!empty($args['data_source'])) {
            return $args['data_source'];
        }
        return $data_source;
    }

    //==========================================================================
    //==========================================================================
    // Get Data Source
    //==========================================================================
    //==========================================================================
    protected static function GetTable($method, Array $args=[])
    {
        $method = strtolower($method);
        $table = static::$table;
        if (!empty($args['table'])) {
            $table = $args['table'];
        }
        if ($method == 'select') {
            if (!empty(static::$select_view)) {
                $table = static::$select_view;
            }
            if (!empty($args['select_view'])) {
                $table = $args['select_view'];
            }
        }
        if (empty($table)) {
            //trigger_error('Unable to determine database table or view.');
            throw new \Exception('Unable to determine database table or view.');
        }
        return $table;
    }

    //==========================================================================
    //==========================================================================
    // Parse Args
    //==========================================================================
    //==========================================================================
    protected static function ParseArgs($method, Array $args=[])
    {
        //----------------------------------------------------------------------
        // Lowercase method name
        //----------------------------------------------------------------------
        $method = strtolower($method);

        //----------------------------------------------------------------------
        // Is this a SELECT ONLY class?
        //----------------------------------------------------------------------
        if (static::$select_only && $method != 'select') {
            throw new \Exception('This class can only be used for select statements.');
        }

        //----------------------------------------------------------------------
        // Get Data Source
        //----------------------------------------------------------------------
        $data_source = static::GetDataSource($args);
        static::$ds_obj = \phpOpenFW\Core\DataSources::GetOneOrDefault($data_source);

        //----------------------------------------------------------------------
        // Get Table
        //----------------------------------------------------------------------
        $table = static::GetTable($method, $args);

        //----------------------------------------------------------------------
        // Start Return Args
        //----------------------------------------------------------------------
        $return_args = [
            'build' => [
                'data_source' => $data_source,
                'table' => $table
            ],
            'finish' => []
        ];

        //----------------------------------------------------------------------
        // Select Args
        //----------------------------------------------------------------------
        if ($method == 'select') {
            $order_by = static::$select_order_by;
            $limit = static::$select_limit;
            $debug = static::$select_debug;
            $debug_only = static::$select_debug_only;
            $return_debug = static::$select_return_debug;
            $return_query = static::$select_return_query;
            $execute_args = static::$select_execute_args;
        }
        //----------------------------------------------------------------------
        // Insert Args
        //----------------------------------------------------------------------
        else if ($method == 'insert') {
            $debug = static::$insert_debug;
            $debug_only = static::$insert_debug_only;
            $return_debug = static::$insert_return_debug;
            $return_query = static::$insert_return_query;
            $execute_args = static::$insert_execute_args;
        }
        //----------------------------------------------------------------------
        // Update Args
        //----------------------------------------------------------------------
        else if ($method == 'update') {
            $limit = static::$update_limit;
            $debug = static::$update_debug;
            $debug_only = static::$update_debug_only;
            $return_debug = static::$update_return_debug;
            $return_query = static::$update_return_query;
            $execute_args = static::$update_execute_args;
        }
        //----------------------------------------------------------------------
        // Delete Args
        //----------------------------------------------------------------------
        else if ($method == 'delete') {
            $limit = static::$delete_limit;
            $debug = static::$delete_debug;
            $debug_only = static::$delete_debug_only;
            $return_debug = static::$delete_return_debug;
            $return_query = static::$delete_return_query;
            $execute_args = static::$delete_execute_args;
        }

        //----------------------------------------------------------------------
        // Extract Args
        //----------------------------------------------------------------------
        extract($args);

        //----------------------------------------------------------------------
        // Set Return Args
        //----------------------------------------------------------------------
        $return_args['finish'] = [
            'debug' => $debug,
            'debug_only' => $debug_only,
            'return_debug' => $return_debug,
            'return_query' => $return_query,
            'execute_args' => $execute_args,
        ];
        if (isset($order_by)) {
            $return_args['build']['order_by'] = $order_by;
        }
        if (isset($limit)) {
            $return_args['build']['limit'] = $limit;
        }

        //----------------------------------------------------------------------
        // Return Args
        //----------------------------------------------------------------------
        return $return_args;
    }

    //==========================================================================
    //==========================================================================
    // Build Values
    //==========================================================================
    //==========================================================================
    protected static function BuildValues($query, Array $values, Array $args=[])
    {
        //----------------------------------------------------------------------
        // Extract Args, Wheres
        //----------------------------------------------------------------------
        extract($args);

        //----------------------------------------------------------------------
        // Start Values
        //----------------------------------------------------------------------
        $values2 = [];

        //----------------------------------------------------------------------
        // Get Table Fields
        //----------------------------------------------------------------------
        $table_fields = \phpOpenFW\Database\Structure\Table::Instance(static::$ds_obj, $table)->GetStructure();

        //----------------------------------------------------------------------
        // Only set values for known fields
        //----------------------------------------------------------------------
        foreach ($table_fields as $field => $info) {
            if (array_key_exists($field, $values)) {
                $values2[$field] = $values[$field];
            }
        }

        //----------------------------------------------------------------------
        // Add Values
        //----------------------------------------------------------------------
        if ($values2) {
            $query->Values($values2);
        }

        //----------------------------------------------------------------------
        // Return Value Count
        //----------------------------------------------------------------------
        return count($values2);
    }

    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    // Build Where Methods
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

    //=========================================================================
    //=========================================================================
    // Generic Build Where Method
    //=========================================================================
    //=========================================================================
    protected static function BuildWhere($query, Array $wheres, Array $args=[])
    {
        //----------------------------------------------------------------------
        // Extract Args, Wheres
        //----------------------------------------------------------------------
        extract($args);
        extract($wheres, EXTR_SKIP);
        
        //----------------------------------------------------------------------
        // ID(s)
        //----------------------------------------------------------------------
        if (!empty($id)) {
            $query->Where($table . '.id', $id, 'i');
        }
        else if (!empty($ids)) {
            $query->WhereIn($table . '.id', $ids, 'i');
        }
    }

    //=========================================================================
    //=========================================================================
    // Build Select Where Method
    //=========================================================================
    //=========================================================================
    protected static function BuildSelectWhere($query, Array $wheres, Array $args=[])
    {
        static::BuildWhere($query, $wheres, $args);
    }

    //=========================================================================
    //=========================================================================
    // Build Update Where Method
    //=========================================================================
    //=========================================================================
    public static function BuildUpdateWhere($query, Array $wheres, Array $args=[])
    {
        static::BuildWhere($query, $wheres, $args);
    }

    //=========================================================================
    //=========================================================================
    // Build Delete Where Method
    //=========================================================================
    //=========================================================================
    public static function BuildDeleteWhere($query, Array $wheres, Array $args=[])
    {
        static::BuildWhere($query, $wheres, $args);
    }

    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    // Finish
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    protected static function Finish($query, Array $args)
    {
        //----------------------------------------------------------------------
        // Extract Args
        //----------------------------------------------------------------------
        extract($args, EXTR_SKIP);

        //----------------------------------------------------------------------
        // Debug
        //----------------------------------------------------------------------
        if ($debug || $debug_only) {
            if ($return_debug) {
                return [
                    'query' => $query,
                    'bind_params' => $query->GetBindParams()
                ];
            }
            else {
                print $query . "\n";
                print_r($query->GetBindParams());
            }
            if ($debug_only) {
                return;
            }
        }

        //----------------------------------------------------------------------
        // Return Query?
        //----------------------------------------------------------------------
        if (!empty($return_query)) {
            return $query;
        }

        //----------------------------------------------------------------------
        // Execute and Return Results
        //----------------------------------------------------------------------
        return $query->Execute($execute_args);
    }

}
