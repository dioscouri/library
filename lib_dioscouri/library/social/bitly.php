<?php
/**
 * @package	DSC
 * @author 	Dioscouri Design
 * @link 	http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 */

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

class DSCSocialBitly extends DSCSocial
{
    /**
     * 
     * @param unknown_type $url
     * @param unknown_type $login
     * @param unknown_type $appkey
     * @param unknown_type $format
     */
    function get_bitly_short_url($url, $login, $appkey, $format = 'txt')
    {
        $connectURL = 'http://api.bit.ly/v3/shorten?login=' . $login . '&apiKey=' . $appkey . '&uri=' . urlencode($url) . '&format=' . $format;
        return $this->curl_get_result($connectURL);
    }
    
    /**
     * 
     * @param unknown_type $url
     * @param unknown_type $login
     * @param unknown_type $appkey
     * @param unknown_type $format
     */
    function get_bitly_long_url($url, $login, $appkey, $format = 'txt')
    {
        $connectURL = 'http://api.bit.ly/v3/expand?login=' . $login . '&apiKey=' . $appkey . '&shortUrl=' . urlencode($url) . '&format=' . $format;
        return $this->curl_get_result($connectURL);
    }
    
    /**
     * 
     * @param unknown_type $url
     * @return unknown
     */
    function curl_get_result($url)
    {
        $ch      = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}
