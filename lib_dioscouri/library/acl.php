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
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

class DSCAcl {

	/**
	 * Checks if the current user, or userID passed to function is an administrator
	 *
	 * @param INT
	 */

	public static function isAdmin($userid = NULL, $admin_groups = array("7", "8"), $group_ids_passed = true)//if group_ids_passed = true then the admin_groups is an array of groupids and not their names
	{

		if (version_compare(JVERSION, '1.6.0', 'ge')) {
			// Joomla! 1.6+ code here
			jimport('joomla.user.helper');
			$user = JFactory::getUser($userid);
			$groups = JUserHelper::getUserGroups($user -> id);

			//var_dump($admin_groups);

			if ($group_ids_passed) {
				foreach ($groups as $temp) {
					if (in_array($temp, $admin_groups)) {
						return true;

					}
				}
			} else {
				foreach ($admin_groups as $temp) {
					if (!empty($groups[$temp])) {
						return true;

					}
				}
			}

			return false;

		} else {
			// Joomla! 1.5 code here
			jimport('joomla.user.helper');
			$user = &JFactory::getUser($userid);
			// Note: in practice I'd use $user->gid here
			if (in_array($user -> usertype, array("Super Administrator", "Administrator"))) {
				return true;
			} else {
				return false;
			}

		}
	}
	
	/**
	 * Returns a list of users that should be administrators
	 * optional only return the query instead of the  object, so you can get arrays or objects or whatever.
	 * @param INT
	 */
	
	public static function getAdminList($returnQuery = NULL) {
		
		if(version_compare(JVERSION,'1.6.0','ge')) {
    		// Joomla! 1.6+ code here
   			 $query = "
				SELECT
					u.*
				FROM
					#__users AS u
					INNER JOIN #__user_usergroup_map AS ug ON u.id = ug.user_id
				WHERE 1
					AND ug.group_id = '8'
			";
			} else {
 		   // Joomla! 1.5 code here
 		   $query = "
				SELECT
					u.*
				FROM
					#__users AS u
				WHERE 1
					AND u.gid = '25'
			";
			}	
			if($returnQuery != NULl){
				return $query;
				
			}
			$database = JFactory::getDBO();
			$database->setQuery( $query );
			$users = $database->loadObjectList();
		
		return $users;
	}
	
	
	

}
?>