<?php
/**
 * @version 1.5
 * @package Sample
 * @author  Dioscouri Design
 * @link    http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.filter.filteroutput' );
jimport( 'joomla.application.component.view' );

class DSCViewSite extends DSCView
{
    /**
     * The valid task set by the controller
     * @var str
     */
    protected $_doTask;

    /**
     * First displays the submenu, then displays the output
     * but only if a valid _doTask is set in the view object
     *
     * @param $tpl
     * @return unknown_type
     */
    public function display($tpl=null)
    {
        // display() will return null if 'doTask' is not set by the controller
        // This prevents unauthorized access by bypassing the controllers
        if (empty($this->_doTask))
        {
            return null;
        }
        
        $this->getLayoutVars($tpl);

        if (!JRequest::getInt('hidemainmenu') && empty($this->hidemenu))
        {
            $this->displaySubmenu();
        }
        
        $app = DSC::getApp();
        $config = $app::getInstance();
        if ($config->get('include_site_css', '1'))
        {
            JHTML::_('stylesheet', 'site.css', 'media/'.$this->_option.'/css/');
        }

        parent::display($tpl);
    }

    /**
     * Displays a submenu if there is one and if hidemainmenu is not set
     *
     * @param $selected
     * @return unknown_type
     */
    public function displaySubmenu($selected='')
    {
        if (!JRequest::getInt('hidemainmenu') && empty($this->hidemenu))
        {
            jimport('joomla.html.toolbar');
            require_once( JPATH_ADMINISTRATOR.'/includes/toolbar.php' );
            $view = strtolower( JRequest::getVar('view') );

            $menu = DSCMenu::getInstance();
        }
    }
}