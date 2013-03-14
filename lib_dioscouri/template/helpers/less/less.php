<?php

//
// Bootstrap LESS parser
//
include_once('lessc.inc.php');

class DSCTemplateLESS {

	function __construct($parent) {

		if($parent->API->get('recompile_css', 0) == 1) {
			// remove old Template CSS files
			jimport('joomla.filesystem.file');
			JFile::delete($parent->API->URLtemplatepath() . '/css/template.css');
			JFile::delete($parent->API->URLtemplatepath() . '/css/override.css');
			JFile::delete($parent->API->URLtemplatepath() . '/css/error.css');
			JFile::delete($parent->API->URLtemplatepath() . '/css/print.css');
			JFile::delete($parent->API->URLtemplatepath() . '/css/mail.css');
			// generate new Template CSS files
			try {
				// normal Template code
				$less = new lessc;
			   $less->checkedCompile(
			    	$parent->API->URLtemplatepath(). '/less/main.less', 
			    	$parent->API->URLtemplatepath(). '/css/default.css'
			    );
			   $less->checkedCompile(
			    	$parent->API->URLtemplatepath(). '/less/print.less', 
			    	$parent->API->URLtemplatepath(). '/css/print.css'
			    );
			   $less->checkedCompile(
			    	$parent->API->URLtemplatepath(). '/less/mail.less', 
			    	$parent->API->URLtemplatepath(). '/css/mail.css'
			    );
			    // additional Template code
			   $less->checkedCompile(
			    	$parent->API->URLtemplatepath(). '/less/error.less', 
			    	$parent->API->URLtemplatepath(). '/css/error.css'
			    );
			   $less->checkedCompile(
			    	$parent->API->URLtemplatepath(). '/less/offline.less', 
			    	$parent->API->URLtemplatepath(). '/css/offline.css'
			    );
			   $less->checkedCompile(
			    	$parent->API->URLtemplatepath(). '/less/override.less', 
			    	$parent->API->URLtemplatepath(). '/css/override.css'
			    );
			} catch (exception $ex) {
			    exit('LESS Parser fatal error:<br />'.$ex->getMessage());
			}
		}
	}	
}
