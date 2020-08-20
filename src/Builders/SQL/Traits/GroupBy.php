<?php
//*****************************************************************************
//*****************************************************************************
/**
 * SQL Group By Trait
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
 * SQL Group By Trait
 */
//*****************************************************************************
trait GroupBy
{
    //=========================================================================
	// Trait Memebers
    //=========================================================================
	protected $group_by = [];

    //=========================================================================
    //=========================================================================
	// Add Group By Method
    //=========================================================================
    //=========================================================================
	public function GroupBy($group_by)
	{
    	self::AddItemCSC($this->group_by, $group_by);
    	return $this;
	}

    //=========================================================================
    //=========================================================================
	// Raw Group By Clause Method
    //=========================================================================
    //=========================================================================
	public function GroupByRaw($group_by)
	{
        self::AddItem($this->group_by, $group_by);
    	return $this;
	}

    //#########################################################################
    //#########################################################################
    //#########################################################################
    // Protected / Internal Methods
    //#########################################################################
    //#########################################################################
    //#########################################################################

    //=========================================================================
    //=========================================================================
    // Format Group By Method
    //=========================================================================
    //=========================================================================
    protected function FormatGroupBy()
    {
        return self::FormatCSC('GROUP BY', $this->group_by);
    }

}
