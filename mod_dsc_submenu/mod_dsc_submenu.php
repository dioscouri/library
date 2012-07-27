<?php
/**
 * @package Tienda
 * @author  Dioscouri
 * @link    http://www.dioscouri.com
 * @copyright Copyright (C) 2010 Dioscouri. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 */

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

// Check the registry to see if our Tienda class has been overridden

$hide = JRequest::getInt('hidemainmenu');
if (class_exists('DSC')) {
	$menu = DSCMenu::getInstance('submenu');
} else {
	$menu = JToolBar::getInstance('submenu');
}
$app = JFactory::getApplication();
$document = JFactory::getDocument();
/*lets check and see if we are a DSC Option*/
$option = JRequest::getCmd('option');
$extension = DSC::getApp($option);


/*First we check if we are in a DSC APP*/
if (is_subclass_of($extension, 'DSC')) {
	
	/*Now we check if the app is bootstrapped*/
	if ($extension::getInstance()->get('use_bootstrap') ) {
		DSC::loadBootstrap();
		JHTML::_('stylesheet', 'bootstrapped_submenu.css', 'administrator/modules/mod_dsc_submenu/css/');
		require JModuleHelper::getLayoutPath('mod_dsc_submenu', 'bootstrapped');
	} else {
	/*IF not bootstrapped we use the dropdowns  the old way all CSS*/	
		JHTML::_('stylesheet', 'default.css', 'administrator/modules/mod_dsc_submenu/css/');
		require JModuleHelper::getLayoutPath('mod_dsc_submenu', 'default');
	}
	

} else {
	/*IF we are not in a DSC app, we load in menu items just like the way  joomla default modules does, and we get the layout in case someone has a layout override for submenu*/	
	if(version_compare(JVERSION,'1.6.0','ge')) {
	$menu = JToolBar::getInstance('submenu');
	$list = $menu -> getItems();
	$module = JModuleHelper::getModule('mod_submenu');
	
	$params = new DSCParameter($module -> params);
	require JModuleHelper::getLayoutPath('mod_submenu', $params -> get('layout', 'default'));
} else {
	/*IF we are not in a DSC app, ad joomla 1.5 we  can just require the module file*/	
	require_once(JPATH_ADMINISTRATOR.'/modules/mod_submenu/mod_submenu.php');

}
}
?>

