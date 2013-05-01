<?php
/**
 * @package Dioscouri
 * @author  Dioscouri Design
 * @link    http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

class DSCTemplateAPI extends JObject 
{
	private $API;

	function __construct($parentTpl) {
		$this->API = $parentTpl;
	}

    public function addCSS($url, $type = 'text/css', $media = null) { 
        $this->API->addStyleSheet($url, $type, $media);
    }
    
    public function addJS($url) {
        $this->API->addScript($url);
    }
    
    public function addCSSRule($code) {
        $this->API->addStyleDeclaration($code);
    }
    
    public function addJSFragment($code) { 
    	$this->API->addScriptDeclaration($code); 
    }

    public function get($key, $default) {
        return $this->API->params->get($key, $default);
    }
    
    public function modules($rule) {
        return $this->API->countModules($rule);
    }
    
    public function URLbase() {
        return JURI::base();
    }
    
    public function URLtemplate() {
        return JURI::base() . "templates/" . $this->API->template;
    }
    
    public function URLpath() {
        return JPATH_SITE;
    }
    
    public function URLtemplatepath() {
        return $this->URLpath() . "/templates/" . $this->API->template;
    }
    public function getTemplateLayoutPath($layout) {
        return $this->URLpath() . "/templates/" . $this->API->template . '/layouts/' .$layout;
    }
    public function templateName() {
        return $this->API->template;
    }
    
    public function getPageName() {
        $config = new JConfig();
        return $config->sitename;
    }
    
    public function addFavicon() {
        $icon = $this->URLtemplatepath() . '/images/ico/favicon.ico';
    	return $this->API->addFavicon($icon);
    }
}

// EOF