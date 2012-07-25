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

if (is_subclass_of($extension, 'DSC')) {
	//$extension::getInstance()->get('use_bootstrap'); ??
	if ($params -> get('layout') == 'bootstrapped') {
		DSC::loadBootstrap();
		JHTML::_('stylesheet', 'bootstrapped_submenu.css', 'administrator/modules/mod_dsc_submenu/css/');
	} else {
		JHTML::_('stylesheet', 'default.css', 'administrator/modules/mod_dsc_submenu/css/');
	}
	require JModuleHelper::getLayoutPath('mod_dsc_submenu', $params -> get('layout', 'default'));

} else {
	$menu = JToolBar::getInstance('submenu');
	$list = $menu -> getItems();
	$module = JModuleHelper::getModule('mod_submenu');
	var_dump($module);
	$params = new DSCParameter($module -> params);
	require JModuleHelper::getLayoutPath('mod_submenu', $params -> get('layout', 'default'));

}
?>

