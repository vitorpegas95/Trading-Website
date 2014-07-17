<?php
	include 'config/config.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="iso-8859-2">
	</head>
	
	<body>
<?php
	
	if(isset($_POST["current"]))
	{
		$cur = Hash512(Escape($_POST["current"]));
		$new = Hash512(Escape($_POST["newone"]));
		
		if($cur !== $new)
		{
			$info = $db->LoadArray("SELECT * FROM `accounts` WHERE `username`=?", $_SESSION["username"]);
			if($info[0][3] == $cur)
			{
				$db->Execute("UPDATE accounts SET `password`=? WHERE `username`=?", $new, $_SESSION["username"]);
			}		
		}
		
		Redirect('account.php?action=' . Hash512("PasswordChangedCodedbyvitorpegas"));
	}
	else if(isset($_POST["email"]))
	{
		$new = Escape($_POST["email"]);
		
		$db->Execute("UPDATE accounts SET `email`=? WHERE `username`=?", $new, $_SESSION["username"]);	
		
		$link = "account.php?action=" . Hash512("EmailChangedCodedbyvitorpegas");
		Redirect($link);
	}
	else if(isset($_POST["name"]))
	{		
		$db->Execute("UPDATE accounts SET `nome`=? WHERE `username`=?", $_POST["name"], $_SESSION["username"]);	
		
		$link = "account.php?action=" . Hash512("NameChangedCodedbyvitorpegas");
		Redirect($link);
	}
	else if(isset($_POST["phone"]))
	{
		$new = Escape($_POST["phone"]);
		
		$db->Execute("UPDATE accounts SET `telefone`=? WHERE `username`=?", $new, $_SESSION["username"]);
		
		Redirect('account.php?action=' . Hash512("PhoneChangedCodedbyvitorpegas"));
	}
	else
	{
		Redirect('index.php');
	}
?>	

</body>

</html>