<?php
/**
 * @package DSC
 * @author  Dioscouri Design
 * @link    http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 */

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

abstract class DSCElement extends JObject
{
    public $element = array();
    public $name = null; // form field name
    public $id = null; // form field id
    public $value = null; // form field value
    public $asset = null; // component name by default
    
    public function __construct($config=array())
    {
        $this->setProperties( $config );
        
        if (empty($this->asset))
        {
            $this->asset = JRequest::getCmd('option');
        }
    }
    
    /**
     *
     * @return
     * @param object $name
     * @param object $value[optional]
     * @param object $node[optional]
     * @param object $control_name[optional]
     */
    abstract public function fetchElement($name, $value='', $attribs=array());
}