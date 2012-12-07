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


if (version_compare(JVERSION, '3.0', 'ge'))
{
     require_once( JPATH_SITE . '/libraries/dioscouri/library/grid30.php' );

}
else if (version_compare(JVERSION, '2.5', 'ge'))
{
    require_once( JPATH_SITE . '/libraries/dioscouri/library/grid16.php' );

}
else
{
    require_once( JPATH_SITE . '/libraries/dioscouri/library/grid15.php' );

}