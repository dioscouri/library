<?php

// no direct access
defined('_JEXEC') or die ;

class DSCTableBase extends JTable
{
    public function load($keys = null, $reset = true)
    {
        if (DSC_JVERSION == '15')
        {
            return parent::load($keys);
        }
        else
        {
            return parent::load($keys, $reset);
        }
    }

}
