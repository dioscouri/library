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
defined( '_JEXEC' ) or die( 'Restricted access' );

class DSCControllerTools extends DSCController 
{
	/**
	 * constructor
	 */
	function __construct() 
	{
		parent::__construct();
		
		$this->set('suffix', 'tools');
	}

    /**
     * Sets the model's state
     * 
     * @return array()
     */
    function _setModelState()
    {
        $state = parent::_setModelState();      
        $app = JFactory::getApplication();
        $model = $this->getModel( $this->get('suffix') );
        $ns = $this->getNamespace();

        $state['filter_id_from']    = $app->getUserStateFromRequest($ns.'id_from', 'filter_id_from', '', '');
        $state['filter_id_to']      = $app->getUserStateFromRequest($ns.'id_to', 'filter_id_to', '', '');
        $state['filter_name']         = $app->getUserStateFromRequest($ns.'name', 'filter_name', '', '');
        
        foreach (@$state as $key=>$value)
        {
            $model->setState( $key, $value );   
        }
        return $state;
    }
	
    /**
     * Displays item
     * @return void
     */
    function view()
    {
        $model = $this->getModel( $this->get('suffix') );
        $model->getId();
        $row = $model->getItem();

        if (empty($row->published))
        {
            $table = $model->getTable();
            $table->load( $row->id );
            $table->published = 1;
            if ($table->save())
            {
                $redirect = "index.php?option=com_sample&view=".$this->get('suffix')."&task=view&id=".$model->getId();
                $redirect = JRoute::_( $redirect, false );
                $this->setRedirect( $redirect );
                return;
            }
        }
        
        parent::view();
    }
}

?>