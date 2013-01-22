<?php
/**
* @package		DSC
* @copyright	Copyright (C) 2011 DT Design Inc. All rights reserved.
* @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
* @link 		http://www.dioscouri.com
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

require_once( JPATH_SITE.DS.'libraries'.DS.'joomla'.DS.'html'.DS.'html'.DS.'select.php' );

if(version_compare(JVERSION,'1.6.0','ge')) {
    // Joomla! 1.6+ code here
    require_once( JPATH_SITE . '/libraries/dioscouri/library/select16.php' );
} else {
    // Joomla! 1.5 code here
    require_once( JPATH_SITE . '/libraries/dioscouri/library/select15.php' );
}