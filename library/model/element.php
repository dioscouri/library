<?php
/**
 * @version 1.5
 * @package Dioscouri
 * @author  Dioscouri Design
 * @link    http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/
 
/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Restricted access' );

class DSCModelElement extends DSCModel 
{
    var $title_key = 'title';
    var $select_title_constant = 'LIB_DSC_SELECT_ITEM';
    var $select_constant = 'LIB_DSC_SELECT';
    var $clear_constant = 'LIB_DSC_CLEAR_SELECTION';
    
    /**
    *
    * @return
    * @param object $name
    * @param object $value[optional]
    * @param object $node[optional]
    * @param object $control_name[optional]
    */
    function fetchElement($name, $value='', $control_name='', $js_extra='', $fieldName='' )
    {
        $doc = JFactory::getDocument();
    
        if (empty($fieldName)) {
            $fieldName = $control_name ? $control_name.'['.$name.']' : $name;
        }
    
        if ($value)
        {
            $table = $this->getTable();
            $table->load($value);
            $title_key = $this->title_key;
            $title = $table->$title_key;
        }
        else
        {
            $title = JText::_($this->select_title_constant);
        }
    
        $close_window = '';
        if(version_compare(JVERSION,'1.6.0','ge')) {
            $close_window = "window.parent.SqueezeBox.close();";
        } else {
            $close_window = "document.getElementById('sbox-window').close();";
        }
    
        $js = "Dsc.select" . $this->getName() . " = function(id, title, object) {
                        document.getElementById(object + '_id').value = id;
                        document.getElementById(object + '_name').value = title;
                        document.getElementById(object + '_name_hidden').value = title;
        $close_window
        $js_extra
                   }";
        $doc->addScriptDeclaration($js);
    
        $option = $this->option;
		if(empty($option)){  $option = JRequest::getCmd( 'option' );}
		
        $link = 'index.php?option='.$option.'&view='.$this->getName().'&tmpl=component&object='.$name;
    
        JHTML::_('behavior.modal', 'a.modal');
        $html = "\n".'<div style="float: left;"><input style="background: #ffffff;" type="text" id="'.$name.'_name" value="'.htmlspecialchars($title, ENT_QUOTES, 'UTF-8').'" disabled="disabled" /></div>';
        $html .= '<div class="button2-left"><div class="blank"><a class="modal" title="'.JText::_($this->select_title_constant).'"  href="'.$link.'" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">'.JText::_($this->select_constant).'</a></div></div>'."\n";
        $html .= "\n".'<input type="hidden" id="'.$name.'_id" name="'.$fieldName.'" value="'.$value.'" />';
        $html .= "\n".'<input type="hidden" id="'.$name.'_name_hidden" name="'.$name.'_name_hidden" value="'.htmlspecialchars($title, ENT_QUOTES, 'UTF-8').'" />';
    
        return $html;
    }
    
    /**
     *
     * @return
     * @param object $name
     * @param object $value[optional]
     * @param object $node[optional]
     * @param object $control_name[optional]
     */
    function clearElement($name, $value='', $control_name='')
    {
        $doc = JFactory::getDocument();
        $fieldName  = $control_name ? $control_name.'['.$name.']' : $name;
    
        $js = "
            Dsc.reset" . $this->getName() . " = function(id, title, object) {
                document.getElementById(object + '_id').value = id;
                document.getElementById(object + '_name').value = title;
            }";
        $doc->addScriptDeclaration($js);
    
        $html = '
            <div class="button2-left">
                <div class="blank">
                    <a href="javascript:void(0);" onclick="Dsc.reset'. $this->getName() .'( \''.$value.'\', \''.JText::_( $this->select_title_constant ).'\', \''.$name.'\' )">' . 
        JText::_( $this->clear_constant ) . '
                    </a>
                </div>
            </div>
            ';
    
        return $html;
    }
}