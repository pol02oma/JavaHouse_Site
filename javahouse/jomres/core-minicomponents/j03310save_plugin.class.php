<?php
/**
 * Core file
 *
 * @author Vince Wooll <sales@jomres.net>
 * @version Jomres 8
 * @package Jomres
 * @copyright	2005-2014 Vince Wooll
 * Jomres (tm) PHP, CSS & Javascript files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly.
 **/


// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class j03310save_plugin
	{
	function j03310save_plugin( $componentArgs )
		{

		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return
		$MiniComponents = jomres_singleton_abstract::getInstance( 'mcHandler' );
		if ( $MiniComponents->template_touch )
			{
			$this->template_touchable = false;

			return;
			}
		if ( isset( $_REQUEST[ 'plugin' ] ) && !empty( $_REQUEST[ 'plugin' ] ) )
			{
			$plugin = jomresGetParam( $_REQUEST, plugin, '' );
			savePlugin( $plugin );
			}

		}

	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}

?>