<?php
/*
	This is the main configuration file.
	It can handle some globals and it will setup our connections and functions.
	This page is included in all other pages.
*/
session_start();
ob_start();
	
	//include Database Configuration by Alain Bertrand (a_bertrand)
	include_once "dbClass.php";
	//Initiate a Database Connection
	/*
	$DB_HOST = "localhost";	//Host
	$DB_USER = "root";		//Username
	$DB_PASS = "";			//Password
	$DB_NAME = "marketplace";		//DB Name
	*/
	
	$DB_HOST = "localhost";	//Host
	$DB_USER = "oryzhonc_user";		//Username
	$DB_PASS = "e#nC}[m{UZw4";			//Password
	$DB_NAME = "oryzhonc_marketplace";		//DB Name
	
	
	$db = new Database($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);		//$db will be our database connection.
	
	
	//Main Config	
	$SITE_NAME = "Marketplace";
	$SITE_ROOT = "http://www.oryzhon.com/marketplace/";
	$MAX_SIZE = 2097152;		//2MB
	$ALLOWED = array('jpg', 'png', 'gif');
	$RESULTS_LIMIT = 12;
	$CONTACT_MAIL = "mail@mail.com";
	
	//include Global Functions
	include_once "functions.php";
	
	if(isset($_GET["page"]))
	{
		$pages = Escape($_GET["page"]);
	}
	else
	{
		$pages = 1;
	}	
?>