<?php
//*****************************************************************************
//*****************************************************************************
/**
 * SQL From Trait
 *
 * @package         phpOpenFW
 * @author          Christian J. Clark
 * @copyright       Copyright (c) Christian J. Clark
 * @website         https://phpopenfw.org
 * @license         https://mit-license.org
 **/
//*****************************************************************************
//*****************************************************************************

namespace phpOpenFW\Builders\SQL\Traits;

//*****************************************************************************
/**
 * SQL From Trait
 */
//*****************************************************************************
trait From
{
    //=========================================================================
    // Trait Memebers
    //=========================================================================
    protected $from = [];

    //=========================================================================
    //=========================================================================
    // From Clause Method
    //=========================================================================
    //=========================================================================
    public function From($from)
    {
        self::AddItemCSC($this->from, $from);
        return $this;
    }

    //=========================================================================
    //=========================================================================
    // Raw From Clause Method
    //=========================================================================
    //=========================================================================
    public function FromRaw($from)
    {
        self::AddItem($this->from, $from);
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
    // Format From Method
    //=========================================================================
    //=========================================================================
    protected function FormatFrom()
    {
        $clause = '';
        foreach ($this->from as $from) {
            if (is_array($from)) {
                if ($from[0] == 'join') {
                    if (count($from) > 2) {
                        $str_condition = (string)$from[3];
                        if ($str_condition) {
                            $rear_pad = str_repeat(' ', $this->depth * 2);
                            $clause .= "\n  {$from[1]} {$from[2]} ON {$str_condition}{$rear_pad}";
                        }
                    }
                    else {
                        $clause .= "\n  " . $from[1];
                    }
                }
                else {
                    throw new \Exception('Invalid from clause item.');
                }
            }
            else {
                if ($clause) {
                    $clause .= ',';
                }
                $clause .= "\n  " . $from;
            }
        }
        return "FROM" . $clause;
    }

}
