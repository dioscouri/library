<?php
/**
 * @version     $Id: query.php 12628 2011-08-13 13:20:46Z erdsiger $
 * @copyright   Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

/**
 * Query Element Class.
 *
 * @package     Joomla.Framework
 * @subpackage  Database
 * @since       1.6
 */
class DSCQueryElement extends JObject
{
    /** @var string The name of the element */
    protected $_name = null;
    
    /** @var array An array of elements */
    protected $_elements = null;
    
    /** @var string Glue piece */
    protected $_glue = null;

    /**
     * Constructor.
     * 
     * @param   string  The name of the element.
     * @param   mixed   String or array.
     * @param   string  The glue for elements.
     */
    public function __construct($name, $elements, $glue=',')
    {
        $this->_elements    = array();
        $this->_name        = $name;        
        $this->_glue        = $glue;
        
        $this->append($elements);
    }
    
    public function __toString()
    {
        return PHP_EOL.$this->_name.' '.implode($this->_glue, $this->_elements);
    }
    
    /**
     * Appends element parts to the internal list.
     * 
     * @param   mixed   String or array.
     */
    public function append($elements)
    {
        if (is_array($elements)) {
            $this->_elements = array_unique(array_merge($this->_elements, $elements));
        } else {
            $this->_elements = array_unique(array_merge($this->_elements, array($elements)));
        }
    }
}