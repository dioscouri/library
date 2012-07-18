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
	}else {
	$menu = JToolBar::getInstance('submenu');
	}
	$app = JFactory::getApplication();
	$document = JFactory::getDocument();
	/*lets check and see if we are a DSC Option*/
	$option = JRequest::getCmd('option');
 $extension = DSC::getApp($option);
if( is_subclass_of( $extension, 'DSC')) {
	require JModuleHelper::getLayoutPath('mod_dsc_submenu', $params->get('layout', 'bootstrapped'));
	DSC::loadBootstrap();
} else {
	require (JModuleHelper::getLayoutPath('mod_dsc_submenu','default'));
}
	

