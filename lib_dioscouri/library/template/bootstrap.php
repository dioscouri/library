<?php
/**
 * @package Dioscouri
 * @author  Dioscouri Design
 * @link    http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

class DSCTemplateBootstrap {

	function __construct($parent) {
		if($parent->API->get('recompile_bootstrap', 0) == 1) {

			$framework = $parent->API->get('cssframework', 0);
			if(strlen($framework)) {
				// remove old Bootstrap CSS files
			jimport('joomla.filesystem.file');
			JFile::delete($parent->API->URLtemplatepath().'/css/base.css');
			JFile::delete($parent->API->URLtemplatepath().'/css/responsive.css');
			// generate new Bootstrap CSS files
			try {
				$less = new DSCTemplateHelperLessc;
				// normal Bootstrap code
			    $less->checkedCompile(
			    	$parent->API->URLtemplatepath().'/framework/'.$framework.'/less/bootstrap.less', 
			    	$parent->API->URLtemplatepath().'/css/base.css'
			    );
			    // responsive Bootstrap code
			    $less->checkedCompile(
			    	$parent->API->URLtemplatepath().'/framework/'.$framework.'/less/responsive.less', 
			    	$parent->API->URLtemplatepath().'/css/responsive.css'
			    );
			} catch (exception $ex) {
			    exit('LESS Parser fatal error:<br />'.$ex->getMessage());
			}

				
			}
			
		}
	}	
}

// EOF