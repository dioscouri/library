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

class DSCTableContent extends DSCTable 
{
    function DSCTableContent( &$db ) 
    {
        $tbl_key    = 'id';
        $tbl_suffix = 'content';
        $this->set( '_suffix', $tbl_suffix );
        
        parent::__construct( "#__{$tbl_suffix}", $tbl_key, $db );   
    }
}