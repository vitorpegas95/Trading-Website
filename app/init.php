<?php
	require_once 'vendor/autoload.php';
	require_once 'app/classes/TwitterAuth.php';
	require_once 'app/classes/GoogleAuth.php';
	require_once 'config/config.php';
	
	\Codebird\Codebird::setConsumerKey('IiSDiGtrjEXtRh2GpZlZdqR5r', 'qgFZkVuIHqFe39G5k4hX5ekTxTa9uhwCQ2uHJQz2LXRPjzNb2O');
	\Facebook\FacebookSession::setDefaultApplication('712524015472769', 'fe2c8697d85e496f4f10f63043697172');
	
	
	$client = \Codebird\Codebird::getInstance();
	$facebook = new Facebook\FacebookRedirectLoginHelper('http://www.oryzhon.com/marketplace/index.php');
	
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