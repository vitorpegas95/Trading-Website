<?php
require_once 'app/init.php';

//Logout Twitter and Normal session
$auth = new TwitterAuth($db, $client);
$auth->signOut();

//Logout Facebook token
unset($_SESSION["facebook"]);

//Logout Google token
$google = new GoogleAuth();
$google->logout();

Redirect("index.php", 0);
?>