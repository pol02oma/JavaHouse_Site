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

/**
#
 * remote availability
#
 *
 * @package Jomres
#
 */
class j00012managelogs
	{
	/**
	#
	 * remote availability
	#
	 */
	function j00012managelogs()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return
		$MiniComponents = jomres_singleton_abstract::getInstance( 'mcHandler' );
		if ( $MiniComponents->template_touch )
			{
			$this->template_touchable = false;

			return;
			}

		$maxFileSize           = 1024 * 1024;
		$logFiles              = array ( 'system' => 'jomres_system_log.xml', 'request' => 'jomres_request_log.xml', 'gateway' => 'jomres_gateway_log.xml', 'booking' => 'jomres_booking_log.xml', 'error' => 'jomres_error_log.xml', 'jrportalquery' => 'jrportalquery_log.xml' );
		$jomres_systemLog_path = JOMRES_SYSTEMLOG_PATH;
		foreach ( $logFiles as $file )
			{
			//echo $jomres_systemLog_path.$file;exit;
			if ( file_exists( $jomres_systemLog_path . "/" . $file ) )
				{
				$size = filesize( $jomres_systemLog_path . "/" . $file );
				if ( $size > $maxFileSize )
					{
					$newFileName = date( "U" ) . '_' . $file;
					rename( $jomres_systemLog_path . "/" . $file, $jomres_systemLog_path . "/" . $newFileName );
					}
				}
			}
			
		$log_path = JOMRES_SYSTEMLOG_PATH . "error_logs";
		$files = scandir_getfiles( $log_path );

		if ( count( $files ) > 0 )
			{
			foreach ( $files as $f )
				{
				if ( time() - filemtime($log_path . JRDS . $f) >= 30*24*60*60) // 30 days
					{
					unlink( $log_path . "/" . $f );
					}
				}
			}
		
		}

	/**
	#
	 * Must be included in every mini-component
	#
	 */
	function getRetVals()
		{
		return null;
		}
	}

?>