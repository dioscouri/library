<?php
/**
 * @package	Library
 * @author 	Dioscouri Design
 * @link 	http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

class DSCModule extends JObject
{
	public static function renderModules( $position, $item_id, $options = array('style' => 'default') )
	{
		$html = '';
		$modules = DSCModule::loadModules( $position, $item_id );
	
		foreach ($modules as $module)
		{
			// foreach module, render
			$renderer = JFactory::getDocument()->loadRenderer('module');
			$html .= $renderer->render( $module, $options );
		}
	
		return $html;
	}
	
	public static function loadModules( $position, $Itemid )
	{
		$modules = array();
	
		$db	= JFactory::getDbo();
		$app		= JFactory::getApplication();
		$user		= JFactory::getUser();
		$groups		= implode(',', $user->getAuthorisedViewLevels());
		$lang 		= JFactory::getLanguage()->getTag();
		$clientId 	= (int) $app->getClientId();
	
		$query = $db->getQuery(true);
		$query->select('m.id, m.title, m.module, m.position, m.content, m.showtitle, m.params, mm.menuid');
		$query->from('#__modules AS m');
		$query->join('LEFT', '#__modules_menu AS mm ON mm.moduleid = m.id');
		$query->where('m.published = 1');
	
		$query->join('LEFT', '#__extensions AS e ON e.element = m.module AND e.client_id = m.client_id');
		$query->where('e.enabled = 1');
	
		$date = JFactory::getDate();
		$now = $date->toMySQL();
		$nullDate = $db->getNullDate();
		$query->where('(m.publish_up = '.$db->Quote($nullDate).' OR m.publish_up <= '.$db->Quote($now).')');
		$query->where('(m.publish_down = '.$db->Quote($nullDate).' OR m.publish_down >= '.$db->Quote($now).')');
	
		$query->where('m.access IN ('.$groups.')');
		$query->where('m.client_id = '. $clientId);
		$query->where('(mm.menuid = '. (int) $Itemid .' OR mm.menuid <= 0)');
		$query->where("m.position = '". $position ."'");
	
		// Filter by language
		if ($app->isSite() && $app->getLanguageFilter()) {
			$query->where('m.language IN (' . $db->Quote($lang) . ',' . $db->Quote('*') . ')');
		}
	
		$query->order('m.position, m.ordering');
	
		// Set the query
		$db->setQuery($query);
		$modules = $db->loadObjectList();
		$clean	= array();
	
		if ($db->getErrorNum()){
			JError::raiseWarning(500, JText::sprintf('JLIB_APPLICATION_ERROR_MODULE_LOAD', $db->getErrorMsg()));
			return $clean;
		}
	
		// Apply negative selections and eliminate duplicates
		$negId	= $Itemid ? -(int)$Itemid : false;
		$dupes	= array();
		for ($i = 0, $n = count($modules); $i < $n; $i++)
		{
		$module = &$modules[$i];
	
		// The module is excluded if there is an explicit prohibition or if
		// the Itemid is missing or zero and the module is in exclude mode.
		$negHit	= ($negId === (int) $module->menuid)
		|| (!$negId && (int)$module->menuid < 0);
	
		if (isset($dupes[$module->id])) {
		// If this item has been excluded, keep the duplicate flag set,
		// but remove any item from the cleaned array.
			if ($negHit) {
			unset($clean[$module->id]);
		}
		continue;
		}
	
		$dupes[$module->id] = true;
	
		// Only accept modules without explicit exclusions.
		if (!$negHit) {
			//determine if this is a custom module
			$file				= $module->module;
			$custom				= substr($file, 0, 4) == 'mod_' ?  0 : 1;
			$module->user		= $custom;
			// Custom module name is given by the title field, otherwise strip off "mod_"
			$module->name		= $custom ? $module->title : substr($file, 4);
				$module->style		= null;
				$module->position	= strtolower($module->position);
				$clean[$module->id]	= $module;
			}
			}
	
			unset($dupes);
	
			// Return to simple indexing that matches the query order.
			$modules = array_values($clean);
	
			return $modules;
		}
}