<?php
/**
 * @version	1.5
 * @package	Sample
 * @author 	Dioscouri Design
 * @link 	http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

Sample::load( 'SampleModelBase', 'models._base' );

class SampleModelDashboard extends SampleModelBase 
{
	function getTable()
	{
		JTable::addIncludePath( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sample'.DS.'tables' );
		$table = JTable::getInstance( 'Config', 'SampleTable' );
		return $table;
	}
}