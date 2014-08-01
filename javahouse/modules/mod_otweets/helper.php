<?php
/*------------------------------------------------------------------------
# mod_otweets - Optimized Tweets

# ------------------------------------------------------------------------

# author:    Optimized Sense

# copyright: Copyright (C) 2011 http://www.o-sense.com. All Rights Reserved.

# @license: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.o-sense.com

# Technical Support:  http://www.o-sense.com/contact-us/support-inquiries.html

-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
class oTweets{
	function getData(&$params ){	
	
		$oTBLinkTitle	= 'O-Sense';
		$oTBLink	= 'http://www.o-sense.com';
		$oTBLinkImg = 'http://www.o-sense.com/osensecopy.png';	

		$oTusername	= $params->get('ousername', 'OptimizedSense');
		$oTID   	= $params->get('oid', '344829614071373824');
		$oTnoheader    = $params->get('onoheader');
		$oTnofooter    = $params->get('onofooter');
		$oTnoborders   = $params->get('onoborders');
		$oTnoscrollbar = $params->get('onoscrollbar');
		$oTtransparent = $params->get('otransparent');
		$oTlinks	= $params->get('olinks', '4aed05');		
		$oTborder	= $params->get('oborder', 'ffffff');		
		$oTtheme	= $params->get('otheme');
		$oTwidth	= $params->get('owidth', '250');
		$oTheight	= $params->get('oheight', '300');				
		$oTcount	= $params->get('ocount');
		$oTlang = $params->get('olang');
		$oTshowBacklink = $params->get('oshowbacklink');
		
		
		if($oTcount == '0'){
			$oTcount	= '';
		}
		else {
			$oTcount	= 'data-tweet-limit="'.$params->get('ocount').'"';		
		}
		
		if($oTtheme == '2'){
			$oTtheme	= 'dark';
		}
		else{
			$oTtheme	= 'light';
		}
		
		if($oTnoheader == '2'){
			$oTnoheader	= 'noheader ';
		}
		else {
			$oTnoheader	= '';
		}
		if($oTnofooter == '2'){
			$oTnofooter	= 'nofooter ';
		}
		else {
			$oTnofooter	= '';
		}
		if($oTnoborders == '2'){
			$oTnoborders	= 'noborders ';
		}
		else {
			$oTnoborders	= '';
		}
		if($oTnoscrollbar == '2'){
			$oTnoscrollbar	= 'noscrollbar ';
		}
		else {
			$oTnoscrollbar	= '';
		}
		if($oTtransparent == '1'){
			$oTtransparent	= 'transparent ';
		}
		else {
			$oTtransparent	= '';
		}

		if($oTshowBacklink == '1'){
			$oTshowBacklink	= '<div style="position: relative; height: 15px; width: 100%; font-size: 10px; color: #808080; font-weight: normal; font-family: \'lucida grande\',tahoma,verdana,arial,sans-serif; line-height: 1.28; text-align: right; direction: ltr;"><a href="'.$oTBLink.'" target="_blank" style="color: #808080;"> <img alt="OSense" height="auto" src="'.$oTBLinkImg.'" style="visibility: visible; zoom: 1; opacity: 1; vertical-align: text-top;" width="auto" />  '.$oTBLinkTitle.'</a></div>';
		}
		else {
			$oTshowBacklink	= '';
		}
		
				
		$data = '';
		$data = '<a class="twitter-timeline" data-theme="'.$oTtheme.'" data-link-color="#'.$oTlinks.'" data-chrome="'.$oTnoheader.$oTnofooter.$oTnoborders.$oTnoscrollbar.$oTtransparent.'" data-border-color="#'.$oTborder.'" lang="'.$oTlang.'"'.$oTcount.'  href="https://twitter.com/'.$oTusername.'" data-widget-id="'.$oTID.'" width="'.$oTwidth.'" height="'.$oTheight.'">Tweets by @'.$oTusername.'</a><script type="text/javascript">!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> '.$oTshowBacklink;
		return $data;
	}
}
