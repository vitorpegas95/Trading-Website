<?php
require "app/init.php";

if(isset($_SESSION["facebook"]))
{
	$session = new Facebook\FacebookSession($_SESSION["facebook"]);
	$request = new Facebook\FacebookRequest($session, 'GET', '/me');
	$request = $request->execute();
	
	$user = $request->getGraphObject()->asArray();
	
	$userid = $user["id"];
	$name = Escape($user["name"]);
	$password = Hash512("facebook" . Rand(0, 199999));
	
	$username = substr($userid, 0, 5) . $user["first_name"];
	$db->Execute("INSERT INTO `accounts`(`facebookid`, `username`, `password`, `nome`) VALUES (?,?,?,?)", Escape($userid), Escape($username), $password, $name);

	//Debug("INSERT INTO `accounts`(`facebookid`, `username`, `password`, `nome`) VALUES ('" . Escape($userid) . "','" . Escape($username) . "','" . $password ."','" . Escape($name) . "')");
	
	$_SESSION["username"] = $username;
	Redirect("index.php");
}
?>