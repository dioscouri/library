<?php
/**
 * @version 1.5
 * @package DSC
 * @author  Dioscouri
 * @link    http://www.dioscouri.com
 * @copyright Copyright (C) 2011 Dioscouri. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 */

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

class DSCToolBarHelper extends JToolBarHelper 
{
	/**
	 * Button type
	 *
	 * @access	protected
	 * @var		string
	 */
	public $_name = 'custom';
		
	/**
	 * Writes a custom option and task button for the button bar
	 * @param string The task to perform (picked up by the switch($task) blocks
	 * @param string The image to display
	 * @param string The image to display when moused over
	 * @param string The alt text for the icon image
	 * @param boolean True if required to check that a standard list item is checked
	 * @param boolean True if required to include callinh hideMainMenu()
	 * @since 1.0
	 */
	public  function custom($task = '', $icon = '', $iconOver = '', $alt = '', $listSelect = true, $x = false, $taskName = 'shippingTask')
	{
		$bar = JToolBar::getInstance('toolbar');

		//strip extension
		$icon	= preg_replace('#\.[^.]*$#', '', $icon);
		var_dump($this->_name);
		// Add a standard button
		$bar->appendButton( 'DSC', $icon, $alt, $task, $listSelect, $x, $taskName );
	}

	/**
	 * Writes the common 'new' icon for the button bar
	 * @param string An override for the task
	 * @param string An override for the alt text
	 * @since 1.0
	 */
	public  function addNew($task = 'add', $alt = 'New', $taskName = 'shippingTask')
	{
		$bar = JToolBar::getInstance('toolbar');
		// Add a new button
		$bar->appendButton( 'DSC', 'new', $alt, $task, false, false, $taskName );
	}
}