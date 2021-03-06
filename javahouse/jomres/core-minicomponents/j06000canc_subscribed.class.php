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

class j06000canc_subscribed
	{
	function j06000canc_subscribed()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return
		$MiniComponents = jomres_singleton_abstract::getInstance( 'mcHandler' );
		if ( $MiniComponents->template_touch )
			{
			$this->template_touchable = false;

			return;
			}

		$thisJRUser = jomres_singleton_abstract::getInstance( 'jr_user' );


		$id = (int) jomresGetParam( $_GET, 'id', 0 );
		jr_import( 'jrportal_subscriptions' );
		$subscription     = new jrportal_subscriptions();
		$subscription->id = $id;
		$subscription->getSubscription();
		//error_logging(  "cms_user_id =".$subscription->cms_user_id);
		//error_logging(  "Jruser id =".$thisJRUser->id);
		if ( $subscription->cms_user_id == $thisJRUser->id )
			{
			echo jr_gettext( '_JRPORTAL_SUBSCRIBERS_CANCED_SUBSCRIBE', _JRPORTAL_SUBSCRIBERS_CANCED_SUBSCRIBE, false );
			$subscription->deleteSubscription();
			}
		else
		error_logging( "Could not cancel Subscription, could not correlate subscriptions cms_user_id with user's id." );
		}


	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}