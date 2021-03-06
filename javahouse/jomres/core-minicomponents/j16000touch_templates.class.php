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

class j16000touch_templates
	{
	function j16000touch_templates()
		{
		$MiniComponents = jomres_singleton_abstract::getInstance( 'mcHandler' );
		if ( $MiniComponents->template_touch )
			{
			$this->template_touchable = false;

			return;
			}
		if ( !translation_user_check() ) return;
		echo '<h2>' . jr_gettext( "_JOMRES_TOUCHTEMPLATES", _JOMRES_TOUCHTEMPLATES, false ) . '</h2>';
		echo "<br/><h3>" . get_showtime( 'lang' ) . "</h3><br/>";
		// $jomreslang = $jomreslang =jomres_singleton_abstract::getInstance('jomres_language');
		// echo $jomreslang->get_languageselection_dropdown();
		// echo "<hr>";

		$packages = subscriptions_packages_getallpackages();
		if ( count( $packages ) > 0 )
			{
			echo jr_gettext( '_JRPORTAL_SUBSCRIPTIONS_PACKAGES_TITLE',_JRPORTAL_SUBSCRIPTIONS_PACKAGES_TITLE) . "<br/>";
			foreach ( $packages as $package )
				{
				$pack_name = jr_gettext( '_JOMRES_CUSTOMTEXT_SUBSCRIPTIONPACKAGES_NAME' . $package[ 'id' ], stripslashes( $package[ 'name' ] ) );
				$pack_desc = jr_gettext( '_JOMRES_CUSTOMTEXT_SUBSCRIPTIONPACKAGES_DESC' . $package[ 'id' ], stripslashes( $package[ 'description' ] ) );
				echo $pack_name;
				echo "&nbsp;";
				echo $pack_desc;
				echo "<br/>";
				}
			}


		echo "<hr/>";
		$query     = "SELECT room_classes_uid,room_class_abbv FROM #__jomres_room_classes WHERE property_uid = '0' ";
		$roomtypes = doSelectSql( $query );
		foreach ( $roomtypes as $rType )
			{
			$roomtype_abbv = jr_gettext( '_JOMRES_CUSTOMTEXT_ROOMTYPES_ABBV' . $rType->room_classes_uid, stripslashes( $rType->room_class_abbv ) );
			//$roomtype_desc = jr_gettext('_JOMRES_CUSTOMTEXT_ROOMTYPES_DESC'.$rType->room_classes_uid,		stripslashes($rType->room_class_full_desc) );
			//echo '<img src="'.get_showtime('live_site').'/'.$rType->image.'" />'; // Do not re-enable this line, if you do then Jomres will not 'hold' the current language because for some reason showtime triggers the creation of a phantom session file in the root directory.
			echo "&nbsp;";
			echo $roomtype_abbv;
			//echo "&nbsp;";
			//echo $roomtype_desc;
			echo "<br/>";
			}
		echo "<hr/>";
		$query                = "SELECT hotel_features_uid,hotel_feature_abbv,hotel_feature_full_desc FROM #__jomres_hotel_features WHERE property_uid = '0' ORDER BY hotel_feature_abbv ";
		$propertyFeaturesList = doSelectSql( $query );
		foreach ( $propertyFeaturesList as $propertyFeature )
			{
			$feature_abbv = jr_gettext( '_JOMRES_CUSTOMTEXT_FEATURES_ABBV' . $propertyFeature->hotel_features_uid, stripslashes( $propertyFeature->hotel_feature_abbv ) );
			$feature_desc = jr_gettext( '_JOMRES_CUSTOMTEXT_FEATURES_DESC' . $propertyFeature->hotel_features_uid, stripslashes( $propertyFeature->hotel_feature_full_desc ) );

			//echo '<img src="'.get_showtime('live_site').'/'.$propertyFeature->image.'" />';  // Do not re-enable this line, if you do then Jomres will not 'hold' the current language because for some reason showtime triggers the creation of a phantom session file in the root directory.
			echo "&nbsp;";
			echo $feature_abbv;
			echo "&nbsp;";
			echo $feature_desc;
			echo "<br/>";
			}
		echo "<hr/>";
		$MiniComponents->touch_templates();

		}


	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}