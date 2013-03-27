<?php 


Class DSCSocialTwitter {

	function __construct() {
		
	}
	
	function sharebutton($url = NULL) {
		if(empty($url)) {
			$url = JURI::getInstance()->toString();		
		}
		
		$html ='<a href="https://twitter.com/share" class="twitter-share-button" data-via="">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
		return $html;
	}

	function customsharebutton($url = NULL, $attribs = array()) {
		if(empty($url)) {
			$url = JURI::getInstance()->toString();	
		}
		$text = 'Twitter';
		if (@$attibs['text']) {
		$text = $attibs['text'];
		}
		if (@$attibs['img']) {
		$text = $attibs['img'];
		}
		$onclick = "javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;";
		$html ='<a class="btn socialBtn socialbtnTwitter socialbtnTwitterShare" onclick="'.$onclick.'" href="https://twitter.com/intent/tweet?url='.$url.'">'.$text.'</a>';
		
		return $html;
	
	}

	function likebutton() {
		
	}
}


?>