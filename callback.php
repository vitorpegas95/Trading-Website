<?php
	require_once 'app/init.php';
	
	$auth = new TwitterAuth($db, $client);
	
	if($auth->signIn())
	{
		Redirect("index.php", 0);
	}
	else
	{
		echo "<h3>Failed connect!</h3>";
	}
?>