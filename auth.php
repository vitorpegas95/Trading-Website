<?php
require_once "config/config.php";

	if(isset($_POST["register"]))
	{
		$username = Escape($_POST["utilizador"]);
		$password = Hash512(Escape($_POST["passchave"]));
		$name = $_POST["name"];
		$email = Escape($_POST["email"]);
		$phone = Escape($_POST["phone"]);
		
		
		$reg = $db->Execute("INSERT INTO `accounts`(`username`, `password`, `nome`, `telefone`, `email`) VALUES (?, ?, ?, ?, ?)", $username, $password, $name, $phone, $email);
		if($reg)
		{
			echo "<h3>Success!</h3>";
			Redirect("index.php");
			$_SESSION["username"] = $username;
		}
		else
		{
			Redirect(("register.php?error=" . Hash512("Your username / email or phone number is already in use. Please try again.")));
		}
	}
	else if(isset($_POST["login"]))
	{
		$username = Escape($_POST["username"]);
		$password = Hash512(Escape($_POST["password"]));
		
		$result = $db->Execute("SELECT * FROM accounts WHERE username=? AND password=?", $username, $password);
		foreach($result as $row)
		{
			$_SESSION["username"] = Escape($row->username);
		}
		$result->Close();
		
		if(isset($_SESSION["username"]))		
			Redirect("index.php");
		else
			Redirect(("register.php?error=" . Hash512("Username or Password are invalid!")));
	}
	else
	{
		Redirect("index.php");
	}
?>		