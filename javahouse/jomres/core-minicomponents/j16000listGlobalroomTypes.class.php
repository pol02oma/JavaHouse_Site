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

class j16000listGlobalroomTypes
	{
	function j16000listGlobalroomTypes()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return
		$MiniComponents = jomres_singleton_abstract::getInstance( 'mcHandler' );
		if ( $MiniComponents->template_touch )
			{
			$this->template_touchable = false;

			return;
			}
		$editIcon     = '<IMG SRC="' . get_showtime( 'live_site' ) . '/'.JOMRES_ROOT_DIRECTORY.'/images/jomresimages/small/EditItem.png" border="0">';
		$query        = "SELECT room_classes_uid, room_class_abbv, room_class_full_desc,image FROM #__jomres_room_classes  WHERE property_uid = '0' ORDER BY room_class_abbv";
		$roomtypeList = doSelectSql( $query );

		$query      = "SELECT * FROM #__jomres_ptypes";
		$ptypeList  = doSelectSql( $query );
		$all_ptypes = array ();
		if ( count( $ptypeList ) > 0 )
			{
			foreach ( $ptypeList as $ptype )
				{
				$all_ptypes[ $ptype->id ] = $ptype->ptype;
				}
			}
		
		$rtxrefList=array();
		$query               = "SELECT roomtype_id,propertytype_id FROM #__jomres_roomtypes_propertytypes_xref ";
		$rtxref          = doSelectSql( $query );

		foreach ($rtxref as $xref)
			{
			$rtxrefList[$xref->roomtype_id][]=$xref->propertytype_id;
			}

		$rows                       = array ();
		$output[ 'INDEX' ]          = "index.php";
		$output[ 'PAGETITLE' ]      = jr_gettext( '_JOMRES_COM_MR_VRCT_ROOMTYPES_HEADER_LINK', _JOMRES_COM_MR_VRCT_ROOMTYPES_HEADER_LINK,false );
		$output[ 'BACKLINK' ]       = '<a href="javascript:submitbutton(\'cpanel\')">' . jr_gettext( '_JOMRES_COM_MR_BACK', _JOMRES_COM_MR_BACK,false ) . '</a>';
		$output[ 'HLINKTEXT' ]      = jr_gettext( '_JOMRES_COM_MR_VRCT_ROOMTYPES_HEADER_ABBV', _JOMRES_COM_MR_VRCT_ROOMTYPES_HEADER_ABBV,false );
		$output[ 'HLINKTEXTCLONE' ] = jr_gettext( '_JOMRES_COM_MR_VRCT_PROPERTYFEATURES_HEADER_DESC', _JOMRES_COM_MR_VRCT_PROPERTYFEATURES_HEADER_DESC,false );
		$output[ 'HRTTITLE' ]       = jr_gettext( '_JOMRES_COM_MR_VRCT_ROOMTYPES_HEADER_ABBV', _JOMRES_COM_MR_VRCT_ROOMTYPES_HEADER_ABBV,false );
		$output[ 'HRTDESCRIPTION' ] = jr_gettext( '_JOMRES_COM_MR_EB_ROOM_CLASS_DESC', _JOMRES_COM_MR_EB_ROOM_CLASS_DESC,false );
		$output[ 'HJOMRES_A_ICON' ] = jr_gettext( '_JOMRES_A_ICON', _JOMRES_A_ICON,false );

		foreach ( $roomtypeList as $roomtype )
			{
			$selected_ptype_rows = "";
			if ( count( $rtxrefList ) > 0 )
				{
				foreach ( $rtxrefList[$roomtype->room_classes_uid] as $ptype )
					{
					$selected_ptype_rows .= $all_ptypes[ $ptype ] . " ";
					}
				}

			$r[ 'CHECKBOX' ]       = '<input type="checkbox" id="cb' . count( $rows ) . '" name="idarray[]" value="' . $roomtype->room_classes_uid . '" onClick="jomres_isChecked(this.checked);">';
			$r[ 'LINKTEXT' ]       = '<a href="' . JOMRES_SITEPAGE_URL_ADMIN . '&task=editGlobalroomTypes&rmTypeUid=' . $roomtype->room_classes_uid . '">' . $editIcon . '</a>';
			$r[ 'LINKTEXTCLONE' ]  = '<a href="' . JOMRES_SITEPAGE_URL_ADMIN . '&task=editGlobalroomTypes&$rmTypeUid=' . $roomtype->room_classes_uid . '&clone=1">' . $cloneIcon . '</a>';
			$r[ 'RTTITLE' ]        = $roomtype->room_class_abbv;
			$r[ 'RTDESCRIPTION' ]  = $roomtype->room_class_full_desc;
			$r[ 'IMAGE' ]          = get_showtime( 'live_site' ) . "/" . JOMRES_ROOT_DIRECTORY . "/uploadedimages/rmtypes/" . $roomtype->image;
			$r[ 'PROPERTY_TYPES' ] = $selected_ptype_rows;
			$rows[ ]               = $r;
			}
		$output[ 'COUNTER' ]            = count( $rows );
		$output[ 'TOTALINLISTPLUSONE' ] = count( $rows ) + 1;

		$jrtbar = jomres_singleton_abstract::getInstance( 'jomres_toolbar' );
		$jrtb   = $jrtbar->startTable();
		$jrtb .= $jrtbar->toolbarItem( 'cancel', JOMRES_SITEPAGE_URL_ADMIN, '' );
		$image  = $jrtbar->makeImageValid( "/".JOMRES_ROOT_DIRECTORY."/images/jomresimages/small/AddItem.png" );
		$link   = JOMRES_SITEPAGE_URL_ADMIN;
		$jrtb .= $jrtbar->customToolbarItem( 'editGlobalroomTypes', $link, jr_gettext( '_JOMRES_COM_MR_NEWTARIFF', _JOMRES_COM_MR_NEWTARIFF,false ), $submitOnClick = true, $submitTask = "editGlobalroomTypes", $image );
		$image = $jrtbar->makeImageValid( "/".JOMRES_ROOT_DIRECTORY."/images/jomresimages/small/WasteBasket.png" );
		$link  = JOMRES_SITEPAGE_URL_ADMIN;
		$jrtb .= $jrtbar->customToolbarItem( 'deleteGlobalroomTypes', $link, jr_gettext( '_JOMRES_COM_MR_ROOM_DELETE', _JOMRES_COM_MR_ROOM_DELETE,false ), $submitOnClick = true, $submitTask = "deleteGlobalroomTypes", $image );
		$jrtb .= $jrtbar->endTable();

		$output[ 'JOMRESTOOLBAR' ]             = $jrtb;
		$output[ 'JOMRES_SITEPAGE_URL_ADMIN' ] = JOMRES_SITEPAGE_URL_ADMIN;

		$pageoutput[ ] = $output;

		$tmpl = new patTemplate();
		$tmpl->setRoot( JOMRES_TEMPLATEPATH_ADMINISTRATOR );
		$tmpl->readTemplatesFromInput( 'list_room_types.html' );
		$tmpl->addRows( 'pageoutput', $pageoutput );
		$tmpl->addRows( 'rows', $rows );
		$tmpl->displayParsedTemplate();
		}

	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}