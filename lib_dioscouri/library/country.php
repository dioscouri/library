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

class DSCCountry extends JObject
{
	function getList()
	{
		static $items;
		
		if (!is_array($items))
		{			
			$items[0] = new JObject();
			$items[0]->id = '0';
			$items[0]->title = 'Not Applicable';
		}
		return $items;
	}
}