<?php
/**
 * @package Dioscouri
 * @author  Dioscouri Design
 * @link    http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

class plgSystemDioscouri extends JPlugin 
{
    function onAfterInitialise() 
    {
        jimport('joomla.filesystem.file');
        if (!version_compare(JVERSION,'1.6.0','ge')) 
        {
            // Joomla! 1.5 code here
            if (JFile::exists(JPATH_SITE.'/plugins/system/dioscouri/dioscouri.php')) 
            {
                $this->attemptInstallation();
            }
        }
        
		if (!class_exists('DSC')) 
		{
			if (!JFile::exists(JPATH_SITE.'/libraries/dioscouri/dioscouri.php')) {
				return false;
			}
			require_once JPATH_SITE.'/libraries/dioscouri/dioscouri.php';
		}
		return DSC::loadLibrary();
    }
    
    protected function attemptInstallation()
    {
        $return = false;
        
        // attempt to install the files manually (primarily for J1.5)
        
        if (!JFile::exists(JPATH_SITE.'/plugins/system/dioscouri/dioscouri.php')) {
            return $return;
        }
        
        jimport('joomla.filesystem.folder');
        
        $src = DS . 'plugins' . DS . 'system' . DS . 'dioscouri' . DS;
        $dest = DS . 'libraries' . DS . 'dioscouri' . DS;
        $src_folders = JFolder::folders(JPATH_SITE.'/plugins/system/dioscouri', '.', true, true);
        if (!empty($src_folders)) {
            foreach ($src_folders as $src_folder) {
                $src_folder = str_replace(JPATH_SITE, '', $src_folder);
                $dest_folder = str_replace( $src, '', $src_folder);
                if (!JFolder::exists(JPATH_SITE.$dest.$dest_folder)) {
                    JFolder::create(JPATH_SITE.$dest.$dest_folder);
                }
            }
        }
                
        // move files from plugins to libraries
        $src = DS . 'plugins' . DS . 'system' . DS . 'dioscouri' . DS;
        $dest = DS . 'libraries' . DS . 'dioscouri' . DS;        
        $src_files = JFolder::files(JPATH_SITE.'/plugins/system/dioscouri', '.', true, true);
        if (!empty($src_files)) {
            foreach ($src_files as $src_file) {
                $src_filename = str_replace(JPATH_SITE, '', $src_file);
                $dest_filename = str_replace( $src, '', $src_filename);
                JFile::move(JPATH_SITE.$src_filename, JPATH_SITE.$dest.$dest_filename);
            }
            
            JFolder::delete(JPATH_SITE.'/plugins/system/dioscouri');
        }

        // move the media files from libraries to media
        $src = DS . 'libraries' . DS . 'dioscouri' . DS . 'media' . DS;
        $dest = DS . 'media' . DS . 'dioscouri' . DS;
        $src_files = JFolder::files(JPATH_SITE.'/libraries/dioscouri/media', '.', true, true);
        if (!empty($src_files)) {
            foreach ($src_files as $src_file) {
                $src_filename = str_replace(JPATH_SITE, '', $src_file);
                $dest_filename = str_replace( $src, '', $src_filename);
                JFile::move(JPATH_SITE.$src_filename, JPATH_SITE.$dest.$dest_filename);
            }
            JFolder::delete(JPATH_SITE.'/libraries/dioscouri/media');
        }

        // move the lang files from libraries to language
        $src_files = JFolder::files(JPATH_SITE.'/libraries/dioscouri/language', '.', true, true);
        $src = DS . 'libraries' . DS . 'dioscouri' . DS . 'language' . DS;
        $dest = DS . 'language' . DS;
        if (!empty($src_files)) {
            foreach ($src_files as $src_file) {
                $src_filename = str_replace(JPATH_SITE, '', $src_file);
                $dest_filename = str_replace( $src, '', $src_filename);
                JFile::move(JPATH_SITE.$src_filename, JPATH_SITE.$dest.$dest_filename);
            }
            JFolder::delete(JPATH_SITE.'/libraries/dioscouri/language');
        }
        
        if (JFile::exists(JPATH_SITE.'/libraries/dioscouri/dioscouri.php')) {
            $return = true;
        }
        
        return $return;
    }
	
	function onAfterRoute() {
		$doc = JFactory::getDocument();
		
		if($this->params->get('activeAdmin')==1) {
			$juri = JFactory::getURI();
			if(strpos($juri->getPath(),'/administrator/')!==false) return;
		}
		
		if($value=$this->params->get('embedjquery')) {
			DSC::loadJQuery('latest',$this->params->get('jquerynoconflict'));
		}
		if($value=$this->params->get('embedjqueryui')) {
			if($value==1) $document->addScript(JURI::root( true ).'/media/dioscouri/jquery/ui/jquery-ui-1.8.6.custom.min.js');
		}
		if($value=$this->params->get('embedjqueryuicss')) {
			if($value==1) $document->addStyleSheet($this->params->get('jqueryuicsspath'));
		}
		if($value=$this->params->get('embedjquerytools')) {
			if($value==1) $document->addScript(JURI::root( true ).'/plugins/system/jqueryintegrator/jqueryintegrator/jquery.tools.min.js');
			elseif($value==2) $document->addScript($this->params->get('jquerytoolscdnpath'));
		}
	}
	
	
}
?>