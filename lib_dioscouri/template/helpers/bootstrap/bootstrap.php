<?php

//
// Bootstrap LESS parser
//



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
				$less = new lessc;
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