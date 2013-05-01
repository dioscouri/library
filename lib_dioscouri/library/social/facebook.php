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

class DSCSocialFacebook extends DSCSocial
{
    
    function sharebutton($url = NULL)
    {
        if (empty($url)) {
            $url = JURI::getInstance()->toString();
        }
        
        $html = '<div class="fb_share"><a name="fb_share" type="box_count" share_url="$url"
     			 href="http://www.facebook.com/sharer.php">Share</a>
    			<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
			</div>';
        return $html;
    }
    
    function customsharebutton($url = NULL, $attribs = array())
    {
        if (empty($url)) {
            $url = JURI::getInstance()->toString();
        }
        $text = 'Facebook';
        if (@$attibs['text']) {
            $text = $attibs['text'];
        }
        if (@$attibs['img']) {
            $text = $attibs['img'];
        }
        $onclick = "javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;";
        $html    = '<a class="btn socialBtn socialbtnFacebook socialbtnFacebookShare" onclick="' . $onclick . '" href="http://www.facebook.com/share.php?u=' . $url . '">' . $text . '</a>';
        return $html;
    }
}


?>