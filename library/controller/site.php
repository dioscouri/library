<?php
/**
 * @package DSC
 * @author  Dioscouri Design
 * @link    http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class DSCControllerSite extends JController 
{   
    var $_models = array();
    var $message = "";
    var $messagetype = "";
        
    /**
     * constructor
     */
    function __construct( $config=array() ) 
    {
        parent::__construct( $config );
        $this->set('suffix', 'dashboard');
        
        // Set a base path for use by the controller
        if (array_key_exists('base_path', $config)) {
            $this->_basePath    = $config['base_path'];
        } else {
            $this->_basePath    = JPATH_COMPONENT;
        }
        
        // Register Extra tasks
        $this->registerTask( 'list', 'display' );
        $this->registerTask( 'close', 'cancel' );
        $this->registerTask( 'add', 'edit' );
        $this->registerTask( 'new', 'edit' );
        $this->registerTask( 'apply', 'save' );
    }
    
    /**
     * 
     * @return unknown_type
     */
    function _setModelState()
    {
        $app = JFactory::getApplication();
        $model = $this->getModel( $this->get('suffix') );
        $ns = $this->getNamespace();

        $state = array();
        
        // limitstart isn't working for some reason when using getUserStateFromRequest -- cannot go back to page 1
        $limit  = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'), 'int');
        $limitstart = JRequest::getVar('limitstart', '0', 'request', 'int');
        // If limit has been changed, adjust offset accordingly
        $state['limitstart'] = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
        $state['limit']     = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'), 'int');
        $state['filter_enabled'] = 1;
        $state['order']     = $app->getUserStateFromRequest($ns.'.filter_order', 'filter_order', 'tbl.'.$model->getTable()->getKeyName(), 'cmd');
        $state['direction'] = $app->getUserStateFromRequest($ns.'.filter_direction', 'filter_direction', 'ASC', 'word');
        $state['filter']    = $app->getUserStateFromRequest($ns.'.filter', 'filter', '', 'string');
        $state['id']        = JRequest::getVar('id', JRequest::getVar('id', '', 'get', 'int'), 'post', 'int');

        // TODO santize the filter
        // $state['filter']     = 

        foreach (@$state as $key=>$value)
        {
            $model->setState( $key, $value );   
        }
        return $state;
    }

    
    
   
    
    /**
     * Gets the available tasks in the controller.
     *
     * @return  array  Array[i] of task names.
     * @since   11.1
     */
    public function getTaskMap()
    {
        if(version_compare(JVERSION,'1.6.0','ge')) {
            // Joomla! 1.6+ code here
            return $this->taskMap;
        } else {
            // Joomla! 1.5 code here
            return $this->_taskMap;
        }
    }
    
    /**
     * Gets the available tasks in the controller.
     *
     * @return  array  Array[i] of task names.
     * @since   11.1
     */
    public function getDoTask()
    {
        if(version_compare(JVERSION,'1.6.0','ge')) {
            // Joomla! 1.6+ code here
            return $this->doTask;
        } else {
            // Joomla! 1.5 code here
            return $this->_doTask;
        }
    }

    /**
     * Sets the tasks in the controller.
     *
     */
    public function setDoTask( $task )
    {
        if(version_compare(JVERSION,'1.6.0','ge')) {
            // Joomla! 1.6+ code here
            $this->doTask = $task;
        } else {
            // Joomla! 1.5 code here
            $this->_doTask = $task;
        }
    }
    
    /**
    *   display the view
    */
    function display($cachable=false)
    {
        $this->setDoTask( JRequest::getCmd( 'task', 'display' ) );
        // this sets the default view
        JRequest::setVar( 'view', JRequest::getVar( 'view', 'items' ) );
        
        $document =& JFactory::getDocument();

        $viewType   = $document->getType();
        $viewName   = JRequest::getCmd( 'view', $this->getName() );
        $viewLayout = JRequest::getCmd( 'layout', 'default' );

        $view = & $this->getView( $viewName, $viewType, '', array( 'base_path'=>$this->_basePath));

        // Get/Create the model
        if ($model = & $this->getModel($viewName)) 
        {
            // controller sets the model's state - this is why we override parent::display()
            $this->_setModelState();
            // Push the model into the view (as default)
            $view->setModel($model, true);
        }

        // Set the layout
        $view->setLayout($viewLayout);
        
        // Set the task in the view, so the view knows it is a valid task 
        if (in_array($this->getTask(), array_keys($this->getTaskMap()) ))
        {
          $view->setTask($this->getDoTask());   
        }
        
        $dispatcher = JDispatcher::getInstance();
        $dispatcher->trigger('onBeforeDisplayComponentSample', array() );
        
        // Display the view
        if ($cachable && $viewType != 'feed') {
            $option	= JRequest::getCmd('option');
            $cache =& JFactory::getCache($option, 'view');
            $cache->get($view, 'display');
        } else {
            $view->display();
        }

        $dispatcher = JDispatcher::getInstance();
        $dispatcher->trigger('onAfterDisplayComponentSample', array() );
        
        $this->footer();        
    }

    /**
     * @return void
     */
    function view() 
    {       
        parent::display();
    }
    
    /**
     * @return void
     */
    function edit() 
    {
        parent::display();
    }

    
    /**
     * Verifies the fields in a submitted form.  Uses the table's check() method.
     * Will often be overridden. Is expected to be called via Ajax 
     * 
     * @return unknown_type
     */
   
   /* function validate()
    {
        Sample::load( 'SampleHelperBase', 'helpers._base' );
        $helper = new SampleHelperBase();
            
        $response = array();
        $response['msg'] = '';
        $response['error'] = '';
            
        // get elements from post
            $elements = json_decode( preg_replace('/[\n\r]+/', '\n', JRequest::getVar( 'elements', '', 'post', 'string' ) ) );

            // validate it using table's ->check() method
            if (empty($elements))
            {
                // if it fails check, return message
                $response['error'] = '1';
                $response['msg'] = $helper->generateMessage(JText::_("Could not process form"));
                echo ( json_encode( $response ) );
                return;
            }
            
        // convert elements to array that can be binded             
            $values = $helper->elementsToArray( $elements );
            

        // get table object
            $table = $this->getModel( $this->get('suffix') )->getTable();
        
        // bind to values
            $table->bind( $values );
        
        // validate it using table's ->check() method
            if (!$table->check())
            {
                // if it fails check, return message
                $response['error'] = '1';
                $response['msg'] = $helper->generateMessage($table->getError());
            }

        echo ( json_encode( $response ) );
        return;
    }

    /**
     * Displays the footer
     * 
     * @return unknown_type
     */
    function footer()
    {
        // show a generous linkback, TIA
        $show_linkback = SampleConfig::getInstance()->get('show_linkback', '1');
        $format = JRequest::getVar('format');
        if ($show_linkback == '1' && $format != 'raw') 
        {
            $model  = $this->getModel( 'dashboard' );
            $view   = $this->getView( 'dashboard', 'html' );
            $view->hidemenu = true;
            $view->setTask('footer');
            $view->setModel( $model, true );
            $view->setLayout('footer');
            $view->assign( 'style', '');
            $view->display();
        } 
            elseif ($format != 'raw')
        {
            $model  = $this->getModel( 'dashboard' );
            $view   = $this->getView( 'dashboard', 'html' );
            $view->hidemenu = true;
            $view->setTask('footer');
            $view->setModel( $model, true );
            $view->setLayout('footer');
            $view->assign( 'style', 'style="display: none;"');
            $view->display();
        }

        return;
    }
    
    /**
     * 
     * @return 
     */
   
   /* function doTask()
    {
        $success = true;
        $msg = new stdClass();
        $msg->message = '';
        $msg->error = '';
                
        // expects $element in URL and $elementTask
        $element = JRequest::getVar( 'element', '', 'request', 'string' );
        $elementTask = JRequest::getVar( 'elementTask', '', 'request', 'string' );

        $msg->error = '1';
        // $msg->message = "element: $element, elementTask: $elementTask";
        
        // gets the plugin named $element
        $import     = JPluginHelper::importPlugin( 'sample', $element );
        $dispatcher =& JDispatcher::getInstance();
        // executes the event $elementTask for the $element plugin
        // returns the html from the plugin
        // passing the element name allows the plugin to check if it's being called (protects against same-task-name issues)
        $result     = $dispatcher->trigger( $elementTask, array( $element ) );
        // This should be a concatenated string of all the results, 
            // in case there are many plugins with this eventname 
            // that return null b/c their filename != element) 
        $msg->message = implode( '', $result );
            // $msg->message = @$result['0'];
                        
        // encode and echo (need to echo to send back to browser)       
        echo $msg->message;
        $success = $msg->message;

        return $success;
    }
    
    /**
     * 
     * @return 
     */
  /*  function doTaskAjax()
    {
        $success = true;
        $msg = new stdClass();
        $msg->message = '';
                
        // get elements $element and $elementTask in URL 
            $element = JRequest::getVar( 'element', '', 'request', 'string' );
            $elementTask = JRequest::getVar( 'elementTask', '', 'request', 'string' );
            
        // get elements from post
            // $elements = json_decode( preg_replace('/[\n\r]+/', '\n', JRequest::getVar( 'elements', '', 'post', 'string' ) ) );
            
        // for debugging
            // $msg->message = "element: $element, elementTask: $elementTask";

        // gets the plugin named $element
            $import     = JPluginHelper::importPlugin( 'sample', $element );
            $dispatcher =& JDispatcher::getInstance();
            
        // executes the event $elementTask for the $element plugin
        // returns the html from the plugin
        // passing the element name allows the plugin to check if it's being called (protects against same-task-name issues)
            $result     = $dispatcher->trigger( $elementTask, array( $element ) );
        // This should be a concatenated string of all the results, 
            // in case there are many plugins with this eventname 
            // that return null b/c their filename != element)
            $msg->message = implode( '', $result );
            // $msg->message = @$result['0'];

        // set response array
            $response = array();
            $response['msg'] = $msg->message;
            
        // encode and echo (need to echo to send back to browser)
            echo ( json_encode( $response ) );

        return $success;
    }
    */
    
}

?>