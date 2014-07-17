<?php
	require_once 'vendor/autoload.php';
	require_once 'app/classes/TwitterAuth.php';
	require_once 'app/classes/GoogleAuth.php';
	require_once 'config/config.php';
	
	\Codebird\Codebird::setConsumerKey('PUBLIC KEY', 'SECRET KEY');
	\Facebook\FacebookSession::setDefaultApplication('PUBLIC KEY', 'SECRET KEY');
	
	
	$client = \Codebird\Codebird::getInstance();
	$facebook = new Facebook\FacebookRedirectLoginHelper('http://localhost/marketplace/index.php');
	
	try
	{
		if($session = $facebook->getSessionFromRedirect())
		{
			$_SESSION["facebook"] = $session->getToken();
			Redirect("fbAuth.php");
		}
	}
	catch(Facebook\FacebookRequestException $e)
	{
		//When facebook returns a error
	}
	catch(\Exception $e)
	{
		//Local issue
	}
?>
