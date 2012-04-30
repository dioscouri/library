<?php
/**
 * @version 1.5
 * @package DSC
 * @author  Dioscouri Design
 * @link    http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 */

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.filter.filteroutput');
jimport('joomla.application.component.view');

/*Use this file to include admin only specific code*/

class DSCViewAdmin extends DSCView {

	/**
	 * Displays a layout file
	 *
	 * @param unknown_type $tpl
	 * @return unknown_type
	 */
	function display($tpl = null) {
		JHTML::_('stylesheet', 'admin.css', 'media/' . $this -> _option . '/css/');

		parent::display($tpl);

	}

}
