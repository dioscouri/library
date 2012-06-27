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

class DSCHelperPathway extends DSCHelper 
{
    /**
     * Adds items to the pathway if they aren't already present
     *  
     * @param array $items A full pathway to the category, an array of pathway objects
     * @param int $item_id A default Itemid to use if none is found 
     */
    function insertCategories( $items, $item_id='' )
    {
        $app = JFactory::getApplication();
        $pathway = $app->getPathway();
        $pathway_values = $pathway->getPathway();

        // find the array_key of the first item in items that is in pathway
        $found = false;
        $found_key = 0;
        $new_pathway = array();
        foreach ($items as $item)
        {
            if (!$found)
            {
                foreach ($pathway_values as $key=>$object)
                {
                    if (!$found)
                    {
                        if ($object->name == $item->name)
                        {
                            $found = true;
                            $found_key = $key;
                        }
                    }
                }
            }
        }

        foreach ($pathway_values as $key=>$object)
        {
            if ($key < $found_key || !$found)
            {
                $new_pathway[] = $object;
            }
        }
        
        // $new_pathway now has the pathway UP TO where we should inject the category pathway
      /*  foreach ($items as $item)
        {
            $category_itemid = (!empty($item_id)) ? $item_id : DSC::getClass( "DSCHelperRoute", 'helpers.route' )->category( $item->id, true );
            $item->link .= "&Itemid=".$category_itemid;
            $new_pathway[] = $item;
        }
		*/
		
        $pathway->setPathway( $new_pathway );
        
        return $new_pathway;
    }
}