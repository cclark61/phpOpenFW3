<?php
//**************************************************************************************
//**************************************************************************************
/**
 * SQL Union Trait
 *
 * @package		phpOpenFW
 * @author 		Christian J. Clark
 * @copyright	Copyright (c) Christian J. Clark
 * @license		https://mit-license.org
 **/
//**************************************************************************************
//**************************************************************************************

namespace phpOpenFW\Builders\SQL\Traits;

//**************************************************************************************
/**
 * SQL Union Trait
 */
//**************************************************************************************
trait Union
{
    //==================================================================================
	// Trait Memebers
    //==================================================================================
	protected $unions = [];

    //==================================================================================
    //==================================================================================
	// Union Clause Method
    //==================================================================================
    //==================================================================================
	public function Union(\phpOpenFW\Builders\SQL\Select $query)
	{
    	if ($this->GetDbType() != $query->GetDbType()) {
            throw new \Exception('Unions can only be performed on select statements of the same database type.');
        }
        $this->unions[] = ['union', $query];
    	return $this;
	}

    //==================================================================================
    //==================================================================================
	// Union All Clause Method
    //==================================================================================
    //==================================================================================
	public function UnionAll(\phpOpenFW\Builders\SQL\Select $query)
	{
    	if ($this->GetDbType() != $query->GetDbType()) {
            throw new \Exception('Unions can only be performed on select statements of the same database type.');
        }
        $this->unions[] = ['union all', $query];
    	return $this;
	}

    //##################################################################################
    //##################################################################################
    //##################################################################################
    // Protected / Internal Methods
    //##################################################################################
    //##################################################################################
    //##################################################################################

    //==================================================================================
    //==================================================================================
    // Format Unions Method
    //==================================================================================
    //==================================================================================
    protected function FormatUnions()
    {
        $clause = '';
        foreach ($this->unions as $union) {
            $union[1]->SetParentQuery($this);
            $union_query = (string)$union[1];
            $this->bind_params = $union[1]->GetBindParams();
            if ($union[0] == 'union all') {
                $clause .= "\nUNION ALL\n\n{$union_query}";
            }
            else {
                $clause .= "\nUNION\n\n{$union_query}";
            }
            
        }
        return $clause;
    }

}
