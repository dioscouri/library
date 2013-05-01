<?php
/**
 * @package Dioscouri
 * @author  Dioscouri Design
 * @link    http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * Based in part on Gavick and the Gantry Templating libraries for Joomla!
*/

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

class DSCTemplateBase 
{

    public $name = 'template';
    public $layout;
    
    // access to the helper classes
    public $API;
    public $bootstrap;
    public $less;
    
    public $page_suffix;
    public $pageclass = '';
    public $doc;
    public $footerScripts = array();

	function __construct($template) {
        
        $this->API = new DSCTemplateAPI($template);
        $this->name = $this->API->templateName();
        $this->bootstrap = new DSCTemplateBootstrap($this);
        $this->layout = $this->API->get('layout', 'default.php');
        $this->pageclass = $this->API->get('pageclass', '');

	}

    function prepareDoc () {

        $this->doc = JFactory::getDocument();
        $this->doc->setGenerator( $this->API->get('generator', 'Dioscouri Design'));
        $this->API->addFavicon();

    }

    function returnLayout() {

        if (JFile::exists( $this->API->getTemplateLayoutPath($this->layout))) {
       
        return $this->API->getTemplateLayoutPath($this->layout);
        }
    }
    
    function prepareFooterScripts() {
        
    }    
	
}