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


defined( '_JOMRES_INITCHECK' ) or die( '' );
defined( '_JOMRES_INITCHECK_ADMIN' ) or die( 'Admin Access to this file is not allowed.' );

ob_start( "removeBOMadmin" );
@ini_set( "memory_limit", "128M" );
@ini_set( "max_execution_time", "480" );

require_once( dirname( __FILE__ ) . '/integration.php' );
$MiniComponents = jomres_singleton_abstract::getInstance( 'mcHandler' );
$siteConfig     = jomres_singleton_abstract::getInstance( 'jomres_config_site_singleton' );
$jrConfig       = $siteConfig->get();

if ($jrConfig[ 'development_production' ]  != "production")
	{
	ini_set( "display_errors", 1 );
	ini_set('error_reporting', E_ALL| E_STRICT);
	//@ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
	}

//get all property uids in system, useful for both admin and frontend. Once these uids are set in one side, they`ll be used in the other side too.
set_showtime( 'heavyweight_system', false );

$c = jomres_singleton_abstract::getInstance( 'jomres_array_cache' );
$all_property_uids=$c->retrieve('all_property_uids');

if ($all_property_uids)
	{
	set_showtime( 'numberOfPropertiesInSystem', count($all_property_uids['all_propertys']) );
	set_showtime( 'all_properties_in_system', $all_property_uids['all_propertys'] );
	set_showtime( 'published_properties_in_system', $all_property_uids['all_published_propertys'] );
	}
else
	{
	$query                      = "SELECT propertys_uid,published FROM #__jomres_propertys";
	$countproperties            = doSelectSql( $query );
	$numberOfPropertiesInSystem = count( $countproperties );
	if ( $numberOfPropertiesInSystem > 200 ) set_showtime( 'heavyweight_system', true );
	set_showtime( 'numberOfPropertiesInSystem', $numberOfPropertiesInSystem );
	$all_propertys           = array ();
	$all_published_propertys = array ();
	foreach ( $countproperties as $p )
		{
		$all_propertys[ ] = $p->propertys_uid;
		if ( $p->published == "1" ) $all_published_propertys[ ] = $p->propertys_uid;
		}
	set_showtime( 'all_properties_in_system', $all_propertys );
	set_showtime( 'published_properties_in_system', $all_published_propertys );
	
	$c->store('all_property_uids',array('all_propertys'=>$all_propertys,'all_published_propertys'=>$all_published_propertys));
	}

$thisJRUser = $MiniComponents->triggerEvent( '00002' ); // Register user
$jomreslang = jomres_singleton_abstract::getInstance( 'jomres_language' );
$jomreslang->get_language();
$customTextObj = jomres_singleton_abstract::getInstance( 'custom_text' );
if ( isset( $_REQUEST[ 'jomreslang' ] ) )
	{
	$lang_switcher_lang = jomresGetParam( $_REQUEST, 'jomreslang', '' );
	if ( array_key_exists( $lang_switcher_lang, $jomreslang->datepicker_crossref ) )
		{
		set_showtime( 'lang', $lang_switcher_lang );
		$customTextObj->reset_current_lang( $lang_switcher_lang );
		}
	}

$MiniComponents->triggerEvent( '00003' );

$tmpBookingHandler = jomres_singleton_abstract::getInstance( 'jomres_temp_booking_handler' );
$tmpBookingHandler->initBookingSession();

$jomressession = $tmpBookingHandler->getJomressession();
set_showtime( 'jomressession', $jomressession );

$showSearchOptions = true;


if ( !defined( 'JOMRES_IMAGELOCATION_ABSPATH' ) )
	{
	define( 'JOMRES_IMAGELOCATION_ABSPATH', JOMRESCONFIG_ABSOLUTE_PATH . JRDS . JOMRES_ROOT_DIRECTORY . JRDS . 'uploadedimages' . JRDS );
	define( 'JOMRES_IMAGELOCATION_RELPATH', get_showtime( 'live_site' ) . '/'.JOMRES_ROOT_DIRECTORY.'/uploadedimages/' );
	}
$task = jomresGetParam( $_REQUEST, 'task', "" );
$task = str_replace( "&#60;x&#62;", "", $task );
set_showtime( 'task', $task );

if ( $task == "" )
	{
	// We're going to silently delete any .js files in the temp dir. This is a basic cleanup, if a server's moved from A to B or an upgrade changes something then we'll delete .js files that might cause problems if they're wrong. Any .js files that don't exist are automatically recreated so this will ensure that the js remains fresh.

	$javascript_files_in_temp_dir = scandir_getfiles( JOMRESCONFIG_ABSOLUTE_PATH . JRDS . JOMRES_ROOT_DIRECTORY . JRDS . 'temp' . JRDS, $extension = "js" );
	foreach ( $javascript_files_in_temp_dir as $file )
		{
		unlink( JOMRESCONFIG_ABSOLUTE_PATH . JRDS . JOMRES_ROOT_DIRECTORY . JRDS . 'temp' . JRDS . $file );
		}
	}

require_once( JOMRESCONFIG_ABSOLUTE_PATH . JRDS . JOMRES_ROOT_DIRECTORY . JRDS . 'admin' . JRDS . 'functions' . JRDS . 'jomresxml.functions.php' );
require_once( JOMRESCONFIG_ABSOLUTE_PATH . JRDS . JOMRES_ROOT_DIRECTORY . JRDS . 'admin' . JRDS . 'functions' . JRDS . 'siteconfig.functions.php' );
require_once( JOMRESCONFIG_ABSOLUTE_PATH . JRDS . JOMRES_ROOT_DIRECTORY . JRDS . 'admin' . JRDS . 'functions' . JRDS . 'propertyfeatures.functions.php' );
require_once( JOMRESCONFIG_ABSOLUTE_PATH . JRDS . JOMRES_ROOT_DIRECTORY . JRDS . 'admin' . JRDS . 'functions' . JRDS . 'roomtypes.functions.php' );
require_once( JOMRESCONFIG_ABSOLUTE_PATH . JRDS . JOMRES_ROOT_DIRECTORY . JRDS . 'admin' . JRDS . 'functions' . JRDS . 'propertytypes.functions.php' );
require_once( JOMRESCONFIG_ABSOLUTE_PATH . JRDS . JOMRES_ROOT_DIRECTORY . JRDS . 'admin' . JRDS . 'functions' . JRDS . 'profiles.functions.php' );

if ( !using_bootstrap() ) require_once( JOMRESCONFIG_ABSOLUTE_PATH . JRDS . JOMRES_ROOT_DIRECTORY . JRDS . 'admin' . JRDS . 'admin.jomres.html.php' );
else
require_once( JOMRESCONFIG_ABSOLUTE_PATH . JRDS . JOMRES_ROOT_DIRECTORY . JRDS . 'admin' . JRDS . 'admin.jomres.bootstrap-html.php' );

$nohtml = jomresGetParam( $_REQUEST, 'no_html', 0 );


$jomreslang = jomres_singleton_abstract::getInstance( 'jomres_language' );
$jomreslang->get_language( $propertytype );
$customTextObj = jomres_singleton_abstract::getInstance( 'custom_text' );

$MiniComponents->triggerEvent( '00005' );
if ( !AJAXCALL )
	{
	// And a couple that are only used in the admin area
	init_javascript();
	jomres_cmsspecific_addheaddata( "javascript", JOMRES_ROOT_DIRECTORY.'/javascript/', 'graphs.js' );
	//jomres_cmsspecific_addheaddata("javascript",JOMRES_ROOT_DIRECTORY.'/javascript/','jrportal.js');

	// Dates back to Jomres v4. Could be removed, but we'll leave it in for those users upgrading from v4, as v4 spanned two years
	if ( is_dir( JOMRESCONFIG_ABSOLUTE_PATH . JRDS . JOMRES_ROOT_DIRECTORY . JRDS . 'plugins' ) )
		{
		emptyDir( JOMRESCONFIG_ABSOLUTE_PATH . JRDS . JOMRES_ROOT_DIRECTORY . JRDS . 'plugins' );
		rmdir( JOMRESCONFIG_ABSOLUTE_PATH . JRDS . JOMRES_ROOT_DIRECTORY . JRDS . 'plugins' );
		if ( is_dir( JOMRESCONFIG_ABSOLUTE_PATH . JRDS . JOMRES_ROOT_DIRECTORY . JRDS . 'plugins' ) ) echo '<font color="red" face="arial" size="1">Warning: directory ' . JOMRESCONFIG_ABSOLUTE_PATH . JRDS . JOMRES_ROOT_DIRECTORY . JRDS . 'plugins still exists. Please delete it.</font><br/>';
		emptyDir( JOMRESCONFIG_ABSOLUTE_PATH . JRDS . JOMRES_ROOT_DIRECTORY . JRDS . 'cache' . JRDS );
		}

	$pageoutput = array ();
	$output     = array ();

	$output[ 'SUBSCRIPTION_WARNING' ] = '';
	if ( $jrConfig[ 'useSubscriptions' ] == "1" )
		{
		$souput      = array ();
		$spageoutput = array ();

		$packages = subscriptions_packages_getallpackages();
		if ( count( $packages ) == 0 )
			{
			$soutput[ 'SUBSCRIPTION_WARNING' ] = 'Warning: You have enabled subscription handling, but not yet created any subscription packages therefore only Super Property Managers will be able to create propertys on your server.';

			$spageoutput[ ] = $soutput;
			$tmpl           = new patTemplate();
			$tmpl->setRoot( JOMRES_TEMPLATEPATH_ADMINISTRATOR );
			$tmpl->readTemplatesFromInput( 'subscription_warning.html' );
			$tmpl->addRows( 'pageoutput', $pageoutput );
			$output[ 'SUBSCRIPTION_WARNING' ] = $tmpl->getParsedTemplate();
			}


		}

	$MiniComponents = jomres_singleton_abstract::getInstance( 'mcHandler' );
	$MiniComponents->triggerEvent( '10002' ); // 10002 scripts build the menu options
	$MiniComponents->getAllEventPointsData( '10002' );
	$MiniComponents->triggerEvent( '10003' ); // 10003 builds the menu arrays
	$output[ 'CONTROL_PANEL_MENU' ] = $MiniComponents->miniComponentData[ '10004' ][ 'generate_control_panel' ]; // 10004 Builds the actual menu items

	$ouput[ 'OBSOLETE_FILES_WARNINGS' ] = '';
	jr_import( 'jomres_obsolete_file_handling' );
	$obsolete_files = new jomres_obsolete_file_handling();
	$obsolete_files->set_default_obs_files_array();
	$obsolete_files->add_obs_file( JOMRESCONFIG_ABSOLUTE_PATH . JRDS . 'administrator' . JRDS . 'components' . JRDS . 'com_jomres' . JRDS . 'jomres_webinstall.php' );

	if ($jrConfig[ 'development_production' ] != "development")
		{
		$obsolete_files->add_obs_file( JOMRESCONFIG_ABSOLUTE_PATH . JRDS . JOMRES_ROOT_DIRECTORY . JRDS . 'install_jomres.php' );
		}

	if ( $obsolete_files->ready_to_go() )
		{
		$output[ 'OBSOLETE_FILES_WARNINGS' ] = $obsolete_files->remove_obs_files();
		}

	$output[ 'LANGDROPDOWN' ] = '';
	//if (_JOMRES_DETECTED_CMS != "joomla25" && _JOMRES_DETECTED_CMS != "joomla30") // previously the switcher didn't work in J2.5/J3 so we disabled it from the output. 7.1.4 changes indicate that we've found a way around those problems, so we'll now enable it in those versions. We'll leave this line in-situ for now in case we need to step back from that and disable the lang dropdown in 2.5/3 in the future.
	$output[ 'LANGDROPDOWN' ] = $jomreslang->get_languageselection_dropdown();

	$output[ 'BACKTOTOP' ] = jr_gettext( 'BACKTOTOP', BACKTOTOP, false );

	if ( using_bootstrap() ) $output[ 'USING_BOOTSTRAP' ] = "true";
	else
	$output[ 'USING_BOOTSTRAP' ] = "false";

	$pageoutput[ ] = $output;
	$tmpl          = new patTemplate();
	$tmpl->setRoot( JOMRES_TEMPLATEPATH_ADMINISTRATOR );
	$tmpl->readTemplatesFromInput( 'administrator_content_area_top.html' );
	$tmpl->addRows( 'pageoutput', $pageoutput );
	$tmpl->displayParsedTemplate();
	}
if ( isset( $_REQUEST[ 'statoption' ] ) )
	{
	$statoption = jomresGetParam( $_REQUEST, 'statoption', '' );
	SetCookie( "statoption", $statoption, time() + 60 * 60 );
	}

if ( isset( $_REQUEST[ 'periodoption' ] ) )
	{
	$periodoption = jomresGetParam( $_REQUEST, 'periodoption', '' );
	SetCookie( "periodoption", $periodoption, time() + 60 * 60 );
	}

admins_first_run();


switch ( get_showtime( 'task' ) )
{
	case "convertCustomTextAll":
		convertCustomTextAll();
		break;
	case "publishPropertyType":
		publishPropertyType();
		break;
	case "deletePropertyType":
		deletePropertyType();
		break;
	case "savePropertyType":
		savePropertyType();
		break;
	case "editPropertyType":
		editPropertyType();
		break;
	case "changeUserHotel":
		changeUserHotel( $option );
		break;
	case "changeUserAccessLevel":
		changeUserAccessLevel();
		break;
	case "listMosUsers":
		$MiniComponents->specificEvent( '16000', 'managers_choose' );
		break;
	case "editProfile":
		editProfile();
		break;
	case "saveProfile":
		saveProfile();
		break;
	case "grantMosUser":
		grantMosUser( $option );
		break;
	case "showSiteConfig":
		showSiteConfig();
		break;
	case "saveSiteConfig":
		saveSiteConfig();
		break;
	case "publishPfeature":
		publishPfeature();
		break;
	case 'cpanel':
	default:
		if ( $MiniComponents->eventSpecificlyExistsCheck( '16000', get_showtime( 'task' ) ) )
			{
			$MiniComponents->specificEvent( '16000', get_showtime( 'task' ) ); // Custom task
			}
		else
			{
			// $version=$mrConfig['version'];
			// HTML_jomres::controlPanel($version);
			$MiniComponents->triggerEvent( '10001' );

			}
		break;
}

if ( !AJAXCALL )
	{
	$pageoutput[ ] = $output;
	$tmpl          = new patTemplate();
	$tmpl->setRoot( JOMRES_TEMPLATEPATH_ADMINISTRATOR );
	$tmpl->readTemplatesFromInput( 'administrator_content_area_bottom.html' );
	$tmpl->addRows( 'pageoutput', $pageoutput );
	$tmpl->displayParsedTemplate();
	}


$head_contents = '';
$MiniComponents->triggerEvent( '16003' );
if ( is_array( $MiniComponents->miniComponentData[ '16003' ] ) )
	{
	foreach ( $MiniComponents->miniComponentData[ '16003' ] as $concatenate )
		{
		$head_contents .= $concatenate;
		}
	}

$componentArgs = array ();
$MiniComponents->triggerEvent( '99999', $componentArgs );
$componentArgs = array ();

endrun();

if ( defined( "JOMRES_RETURNDATA" ) )
	{
	$contents = ob_get_contents();
	$contents = $head_contents . $contents;
	define( "JOMRES_RETURNDATA_CONTENT", $contents );
	unset( $contents );
	ob_end_clean();
	}
else
ob_end_flush();

// Jomres 4.7.8 strips BOM from all areas of the output, not just the beginning.
function removeBOMadmin( $str = "" )
	{
	$bom = pack( "CCC", 0xef, 0xbb, 0xbf );
	$str = str_replace( $bom, "", $str );

	// if(substr($str, 0,3) == pack("CCC",0xef,0xbb,0xbf))
	// {
	// $str=substr($str, 3);
	// }
	return $str;
	}
