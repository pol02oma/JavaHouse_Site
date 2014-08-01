<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
  
class com_jomresInstallerScript
{
    function preflight($route, $adapter) {
		}
     
    function install($adapter) {}
 
    function update($adapter) {}
 
    function uninstall($adapter) {}
 
    function postflight($route, $adapter){
		
		// These lines send a message to our update server to tell us that an installation was performed through the Joomla Install from Web feature
		// We do not record any other information except the time that the request was sent, it is done purely so that we can get an understanding of 
		// how popular the Joomla web installer feature is so we can decide if there's a value in supporting this functionality.
		// We do NOT record any information about your server, IP number or any other identifying details.
		
		$curl_handle = curl_init();
		curl_setopt( $curl_handle, CURLOPT_URL, 'http://updates.jomres4.net/record_installation.php?');
		curl_setopt($curl_handle, CURLOPT_TIMEOUT, 1 );
		curl_setopt( $curl_handle, CURLOPT_USERAGENT, 'Jomres Joomla web installer' );
		$response = curl_exec( $curl_handle );
		curl_close( $curl_handle );
		
		// Let's get on with the business of installing Jomres
		
		$dir_path = str_replace( $_SERVER['SCRIPT_NAME'], "", dirname(realpath(__FILE__)) ) ;
		define('JOMRESPATH_BASE', $dir_path );

		$jversion = new JVersion();
		
		if ($jversion->RELEASE == "2.5")
			$sep = DS;
		else
			$sep = DIRECTORY_SEPARATOR;
			
 		JFile::copy(
			JPATH_ROOT.$sep.'components'.$sep.'com_jomres'.$sep.'jomres_webinstall.php' , 
			JPATH_ROOT.$sep.'jomres_webinstall.php'
			);
		
		$jomresConfig_live_site = rtrim(str_replace('/administrator', '', JURI::base()), '/');

		if (file_exists(JPATH_ROOT.$sep.'jomres_webinstall.php') )
			{
			JFile::delete(JPATH_ROOT.$sep.'components'.$sep.'com_jomres'.$sep.'jomres_webinstall.php');
			$url=$jomresConfig_live_site.'/jomres_webinstall.php';
			echo "<script>document.location.href='".$url."';</script>\n";
			return;
			}
		else
			{
			echo 'Error, couldn\'t copy '.JPATH_ROOT.$sep.'components'.$sep.'com_jomres'.$sep.'jomres_webinstall.php to '.JPATH_ROOT.$sep.'jomres_webinstall.php <br/>';
			echo 'Please manually copy the file to '.JPATH_ROOT.$sep.' then run it by visiting '.$jomresConfig_live_site.'/jomres_webinstall.php';
			}
		}

}