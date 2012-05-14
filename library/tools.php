<?php
/**
 * @version	1.5
 * @package	DSC
 * @author 	Dioscouri Design
 * @link 	http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

class DSCTools 
{
	/**
	 * 
	 * @param $folder
	 * @return unknown_type
	 */
	public static function getPlugins( $folder='DSC' )
	{
		$database = JFactory::getDBO();
		
		$order_query = " ORDER BY ordering ASC ";
		$folder = strtolower( $folder );
		
	    if(version_compare(JVERSION,'1.6.0','ge')) {
            // Joomla! 1.6+ code here
    		$query = "
    			SELECT 
    				* 
    			FROM 
    				#__extensions 
    			WHERE 
    				`type` = 'plugin'
    			AND 
    				LOWER(`folder`) = '{$folder}'
    			ORDER BY ordering ASC
    		";
        } else {
            // Joomla! 1.5 code here
    		$order_query = " ORDER BY ordering ASC ";
    		$folder = strtolower( $folder );
    		
    		$query = "
    			SELECT 
    				* 
    			FROM 
    				#__plugins 
    			WHERE 1 
    			AND 
    				LOWER(`folder`) = '{$folder}'
    			{$order_query}
    		";
        }
			
		$database->setQuery( $query );
		$data = $database->loadObjectList();
		
		return $data;
	}
	
	/**
	 * 
	 * @param $element
	 * @param $eventName
	 * @return unknown_type
	 */
	public static function hasEvent( $element, $eventName, $group )
	{
		$success = false;
		if (!$element || !is_object($element)) {
			return $success;
		}
		
		if (!$eventName || !is_string($eventName)) {
			return $success;
		}
		
		// Check if they have a particular event
		$import 	= JPluginHelper::importPlugin( strtolower( $group ), $element->element );
		$dispatcher	= JDispatcher::getInstance();
		$result 	= $dispatcher->trigger( $eventName, array( $element ) );
		if (in_array(true, $result, true)) {
			$success = true;
		}		
		return $success;
	}	
	
}