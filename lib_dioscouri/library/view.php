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

jimport('joomla.filter.filteroutput');
jimport('joomla.application.component.view');

class DSCView extends JView 
{
	var $_option = NULL;
	var $_name = NULL;
	protected $_doTask = null;

	function __construct($config = array()) 
	{
		$app = DSC::getApp();
		$this->_option = !empty($app) ? 'com_'.$app->getName() : JRequest::getCmd('option');
		parent::__construct($config);
	}
	
	/**
	* Sets the task to something valid
	*
	* @access   public
	* @param    string $task The task name.
	* @return   string Previous value
	* @since    1.5
	*/
	public function setTask($task)
	{
	    $previous = $this->_doTask;
	    $this->_doTask  = $task;
	    return $previous;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @return string
	 */
	public function getTask()
	{
	    return $this->_doTask;
	}

	/**
	 * Displays a layout file
	 *
	 * @param unknown_type $tpl
	 * @return unknown_type
	 */
	function display($tpl = null) 
	{
	    // display() will return null if 'doTask' is not set by the controller
	    // This prevents unauthorized access by bypassing the controllers
	    $task = $this->getTask();
	    if (empty($task))
	    {
	        return null;
	    }
	    
	    parent::display($tpl);
	}

    /**
     * Gets layout vars for the view
     *
     * @return unknown_type
     */
    function getLayoutVars($tpl=null)
    {
        $layout = $this->getLayout();
        switch(strtolower($layout))
        {
            case "view":
                $this->_form($tpl);
              break;
            case "form":
                JRequest::setVar('hidemainmenu', '1');
                $this->_form($tpl);
              break;
            case "default":
            default:
                $this->_default($tpl);
              break;
        }
    }

    /**
     * Basic commands for displaying a list
     *
     * @param $tpl
     * @return unknown_type
     */
    function _default($tpl='')
    {
        $model = $this->getModel();

        // set the model state
            $state = new JObject();
            if (empty($this->no_state) && method_exists( $model, 'getState') ) {
                $state = $model->getState();
            }
            JFilterOutput::objectHTMLSafe( $state );
            $this->assign( 'state', $state );

        // page-navigation
            if (empty($this->no_pagination) && method_exists( $model, 'getPagination') ) {
                $this->assign( 'pagination', $model->getPagination() );
            }

        // list of items
            if (empty($this->no_items) && method_exists( $model, 'getList') ) {
                $this->assign('items', $model->getList());
            }

        // form
            $validate = JUtility::getToken();
            $form = array();
            $view = strtolower( JRequest::getVar('view') );
            $form['action'] = $this->get( '_action', "index.php?option={$this->_option}&controller={$view}&view={$view}" );
            $form['validate'] = "<input type='hidden' name='{$validate}' value='1' />";
            $this->assign( 'form', $form );
    }

    /**
     * Basic methods for a form
     * @param $tpl
     * @return unknown_type
     */
    function _form($tpl='')
    {
        $model = $this->getModel();

        // get the data
            $row = $model->getItem();
            JFilterOutput::objectHTMLSafe( $row );
            $this->assign('row', $row );

        // form
            $form = array();
            $controller = strtolower( $this->get( '_controller', JRequest::getVar('controller', JRequest::getVar('view') ) ) );
            $view = strtolower( $this->get( '_view', JRequest::getVar('view') ) );
            $task = strtolower( $this->get( '_task', 'edit' ) );
            $form['action'] = $this->get( '_action', "index.php?option={$this->_option}&controller={$controller}&view={$view}&task={$task}&id=".$model->getId() );
            $form['validation'] = $this->get( '_validation', "index.php?option={$this->_option}&controller={$controller}&view={$view}&task=validate&format=raw" );
            $form['validate'] = "<input type='hidden' name='".JUtility::getToken()."' value='1' />";
            $form['id'] = $model->getId();
            $this->assign( 'form', $form );

        // set the required image
        // TODO Fix this
            $required = new stdClass();
            $required->text = JText::_( 'LIB_DSC_REQUIRED' );
            $required->image = DSCGrid::required( 'LIB_DSC_REQUIRED' );
            $this->assign('required', $required );
    }

	/**
	 * The default toolbar for a list
	 * @return unknown_type
	 */
	function _defaultToolbar() 
	{
	}

	/**
	 * The default toolbar for editing an item
	 * @param $isNew
	 * @return unknown_type
	 */
	function _formToolbar($isNew = null) 
	{
	}

	/**
	 * The default toolbar for viewing an item
	 * @param $isNew
	 * @return unknown_type
	 */
	function _viewToolbar($isNew = null) 
	{
	}

}
