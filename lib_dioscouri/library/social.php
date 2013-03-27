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


class DSCSocial 
{
	/**
	 * Returns a reference to the a Helper object, only creating it if it doesn't already exist
	 *
	 * @param type 		$type 	 The helper type to instantiate
	 * @param string 	$prefix	 A prefix for the helper class name. Optional.
	 * @return helper The Helper Object
	 */
	public static function getInstance( $type = '', $prefix = 'DSCSocial' )
	{
		
		static $instances;

		if (!isset( $instances )) {
			$instances = array();
		}

		$type = preg_replace('/[^A-Z0-9_\.-]/i', '', $type);

		$class = $prefix.ucfirst($type);


		if (empty($instances[$class]))
		{

			if (!class_exists( $class ))
			{
				$path = JPATH_SITE.'/libraries/dioscouri/social/'. strtolower($type).'.php';
				
					JLoader::register($class, $path);

					if (!class_exists( $class ))
					{
						JError::raiseWarning( 0, 'Social class ' . $class . ' not found.' );
						return false;
					}
				
			}

			$instance = new $class();
				
			$instances[$class] = & $instance;
		}

		return $instances[$class];
	}


	public static function makeShortUrl($url) {

		return $url;
	}


}

	?>
