<?php
/**
 * @version	1.5
 * @package	DSC Library
 * @author 	Dioscouri Design
 * @link 	http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

if (version_compare(JVERSION,'1.6.0','ge')) {
    // Joomla! 1.6+ code here
    class DSCParameter extends JRegistry
    {
        
    }
} else {
    // Joomla! 1.5 code here
    jimport('joomla.html.parameter');
    class DSCParameter extends JParameter
    {
        
    }
}