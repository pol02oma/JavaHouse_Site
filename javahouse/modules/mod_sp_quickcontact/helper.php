<?php
/*
# mod_sp_quickcontact - Ajax based quick contact Module by JoomShaper.com
# -----------------------------------------------------------------------	
# Author    JoomShaper http://www.joomshaper.com
# Copyright (C) 2010 - 2014 JoomShaper.com. All Rights Reserved.
# License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomshaper.com
*/

class modSpQuickcontactHelper
{
	public static function getAjax()
	{
		jimport('joomla.application.module.helper');
		$input  		= JFactory::getApplication()->input;
		$module 		= JModuleHelper::getModule('sp_quickcontact');
		$params 		= new JRegistry();
		$params->loadString($module->params);

		$mail 			= JFactory::getMailer();

		$success 		= $params->get('success');
		$failed 		= $params->get('failed');
		$recipient 		= $params->get('email');

		//inputs
		$inputs 		= $input->get('data', array(), 'ARRAY');

		foreach ($inputs as $input) {
			
			if( $input['name'] == 'email' )
			{
				$email 			= $input['value'];
			}

			if( $input['name'] == 'name' )
			{
				$name 			= $input['value'];
			}

			if( $input['name'] == 'subject' )
			{
				$subject 			= $input['value'];
			}

			if( $input['name'] == 'message' )
			{
				$message 			= nl2br( $input['value'] );
			}

		}

		$sender 		= array($email, $name);	
		$mail->setSender($sender);
		$mail->addRecipient($recipient);
		$mail->setSubject($subject);
		$mail->isHTML(true);
		$mail->Encoding = 'base64';	
		$mail->setBody($message);
		 
		if ($mail->Send()) {
		  	return '<p class="sp_qc_success">' . $success . '</p>';
		} else {
		   	return '<p class="sp_qc_warn">' . $failed . '</p>';
		}
	}
}