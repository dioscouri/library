<?php
/**
 * @package		DSC
 * @copyright	Copyright (C) 2011 DT Design Inc. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link 		http://www.dioscouri.com
 */

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

if (version_compare(JVERSION, '3.0', 'ge')) {
	require_once (JPATH_SITE . '/libraries/dioscouri/library/select30.php');

} else if (version_compare(JVERSION, '2.5', 'ge')) {
	require_once (JPATH_SITE . '/libraries/dioscouri/library/select16.php');
} else {
	require_once (JPATH_SITE . '/libraries/dioscouri/library/select15.php');
}
