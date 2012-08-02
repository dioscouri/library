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

if(version_compare(JVERSION,'1.6.0','ge')) {
    // Joomla! 1.6+ code here
    require_once( JPATH_SITE . '/libraries/dioscouri/library/button16.php' );
} else {
    // Joomla! 1.5 code here
    require_once( JPATH_SITE . '/libraries/dioscouri/library/button15.php' );
}