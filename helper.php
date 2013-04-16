<?php
/**
 * @author		Pedro Augusto Mendes e Silva		
 * @copyright	Copyright (C) 2013 Web Feroz.
 */

// no direct access
defined('_JEXEC') or die;

class modWFContactHelper
{
	static function getConfigs(&$params)
	{
		$configs['file']			= $params->get('file');
		$configs['button_value']	= $params->get('button_value');
		$configs['mensage_success']	= $params->get('mensage_success');
		
		$configs['subject']			= $params->get('subject');
		$configs['mail']	  	 	= $params->get('mail');		
		$configs['subject2']	 	= $params->get('subject2');
		$configs['mail2']	  	 	= $params->get('mail2');

		$configs['host']			= $params->get('host');
		$configs['port']			= $params->get('port');
		$configs['dbname']			= $params->get('dbname');
		$configs['user']			= $params->get('user');
		$configs['password'] 		= $params->get('password');

		//$headerText	= trim($params->get('header_text'));
		
		return $configs;
	}
	
	public static function sendEmail($data, $configs)
	{
		# Set some variables for the email message
		if($data['subject']){
			$subject = $configs['subject2'];
			$to 	 = $configs['mail2'];
		}
		else {
			$subject = $configs['subject'];
			$to 	 = $configs['mail'];
		}
		
		$body   = '<p><strong>Nome: </strong>'.$data['name'].'</p>
				   <p><strong>E-mail: </strong>'.$data['email'].'</p>
				   <p><strong>DDD: </strong>'.$data['ddd'].'</p>
				   <p><strong>Telefone: </strong>'.$data['phone'].'</p>
				   <p><strong>Data: </strong> '.date("j/n/Y").'</p>
				   <p><strong>Mensagem: </strong>'.$data['mensage'].'</p>';
				
		
		$from 	= array('site@alfahotel.com.br', $data['name']);
		 
		# Invoke JMail Class
		$mailer = JFactory::getMailer();
	 
		# Set sender array so that my name will show up neatly in your inbox
		$mailer->setSender($from);
		
		$mailer->addReplyTo($data['email']);
		 
		# Add a recipient -- this can be a single address (string) or an array of addresses
		$mailer->addRecipient($to);
		 
		$mailer->setSubject($subject);
		$mailer->setBody($body);
		 
		# If you would like to send as HTML, include this line; otherwise, leave it out
		$mailer->isHTML();

		if(is_numeric($data['phone']) AND (strlen($data['phone']) > 7))
		{
			# Send once you have set all of your options
			if ($mailer->send()) 
				return true;
		}
		else
			return false;
	}

	public static function insertDB($data, $configs)
	{
		$nome 		= utf8_decode($data['name']);
		$email 		= $data['email'];
		$ddd		= $data['ddd'];
		$telefone 	= $data['phone'];
		$mensagem 	= utf8_decode($data['mensage']);
        $now = date("Y-m-d H:i:s");

        if($data['subject'])
        	$subject	= 'Críticas e Sugestões';
       	else
       		$subject 	= 'Dúvidas';

      	$subject = utf8_decode($subject);

		$con_string = 'host='.$configs['host'].' port='.$configs['port'].' dbname='.$configs['dbname'].' user='.$configs['user'].' password='.$configs['password']; 
		
		
		$conn = pg_pconnect($con_string);
		if (!$conn) {
			return false;
		}
	
		$sql = "INSERT INTO hotel.contato (nome, email, ddd, telefone,  mensagem, data, tipo) 
		VALUES ('".$nome."', '".$email."', '".$ddd."', '".$telefone."', '".$mensagem."', '".$now."', '".$subject."')";
		
		$result = pg_query($conn,$sql );
		if (!$result) {
			return false;
		}
		return true;
		
	}
}