<?php
/*------------------------------------------------------------------------
# plg_videobox - Videobox
# ------------------------------------------------------------------------
# author	HitkoDev
# copyright	Copyright (C) 2014 HitkoDev. All Rights Reserved.
# @license	http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites:	http://hitko.eu/software/videobox
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted Access' );

class plgVideoboxVimeoVideoInstallerScript{

	function install($parent){
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->update('#__extensions AS a');
		$query->set('a.enabled = 1');
		$query->where('a.element = "vimeovideo" AND a.folder = "videobox"');
		$db->setQuery($query);
		$db->query();
	}
	
}