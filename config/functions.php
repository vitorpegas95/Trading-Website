<?php
/*
	Here we have some global functions that will be used through the website.
*/
	
	//Hash string with sha512
	function Hash512($string)
	{
		$hash = hash("sha512", $string);
		return $hash;
	}
	
	//XSS Security
	function Escape($t)
	{
		return htmlentities($t, ENT_QUOTES);
	}
	
	function Redirect($url, $time = 0)
	{
		echo "<p style='color: black;'>If your browser doesn't redirect you. <a href='" . $url ."'>Click Here</a></p>";
		echo '<meta HTTP-EQUIV="REFRESH" content="' . $time . '; url=' . $url . '">';
	}
	
	function Debug($dbgText)
	{
		echo "<p>[DEBUG] " . $dbgText . "</p>";
	}

	function getUserRate($db, $userID)
	{
		$totalRating = 0;
		$count = 0;
		$ratings = $db->Execute("SELECT * FROM rating WHERE `rated`=?", $userID);
		foreach($ratings as $r)
		{
			$totalRating += $r->rating;
			$count ++;
		}
		
		if($count > 0)
		{
			if(round($totalRating / $count, 1) > 80)
			{
				return "<b>" . round($totalRating / $count, 1) . "%</b>" . "<img src='img/Actions-flag-icon.png' title='Good' alt='Good' style='width: 32px; height: 32px;'/>";
			}
			else if(round($totalRating / $count, 1) > 50)
			{
				return "<b>" . round($totalRating / $count, 1) . "%</b>" . "<img src='img/Actions-flag-yellow-icon.png' title='Medium' alt='Medium' style='width: 32px; height: 32px;'/>";
			}
			else
			{
				return "<b>" . round($totalRating / $count, 1) . "%</b>" . "<img src='img/Actions-flag-red-icon.png' title='Bad' alt='Bad' style='width: 32px; height: 32px;'/>";
			}
		}
		else
		{
			return "N/D";
		}
	}	
	
	function getUserInfo($db, $username)
	{
		$userInfo = $db->Execute("SELECT * FROM accounts WHERE username=?", $username);
		foreach($userInfo as $info)
		{
			$id = $info->id;
			$username = $info->username;
			$name = $info->nome;
			$email = $info->email;
			$phone = $info->telefone;
			return array("$id", "$username", "$name", "$email", "$phone");
		}
		
	}
	
	function getUserInfoByID($db, $id)
	{
		$userInfo = $db->Execute("SELECT * FROM accounts WHERE id=?", $id);
		foreach($userInfo as $info)
		{
			$id = $info->id;
			$username = $info->username;
			$name = $info->nome;
			$email = $info->email;
			$phone = $info->telefone;
			return array("$id", "$username", "$name", "$email", "$phone");
		}
		
	}
	
	function getMyMessages($db)
	{
		//Present our messages
		$ourID = getUserInfo($db, Escape($_SESSION["username"]));
		$ourID = $ourID[0];
		$myMsg = $db->Execute("SELECT * FROM `messages` WHERE `receiver`=? ORDER BY `date` DESC", $ourID);
		$count = 0;
		foreach($myMsg as $msg)
		{
			$count ++;
			$mid = $msg->id;
			$subject = $msg->subject;
			$message = $msg->message;
			$message = substr($message, 0, 100);
			$date = $msg->date;
			$sender = $msg->sender;
			$receiver = $msg->receiver;
			$senderUsername = getUserInfoByID($db, $sender);
			$senderUsername = $senderUsername[1];
			echo "<a href='message.php?mid=$mid'>
				<article class='article'>
					<table style='width: 100%;'>
						<tr>
							<td style='width: 124px;'>
								<img src='img/mail-queue.png' alt='Imagem' style='position:relative; bottom: 15px; width:128px;height:128px;'></img>
							</td>
							
							<td style='width: 300px;'>
								<h3>$subject</h3>
								<p style='overflow: hidden; max-height: 50px;'>$message</p>
							</td>
							
							<td style='width: 190px;'>
								<h3>From: $senderUsername</h3>
								<p>$date</p>
							</td>
						</tr>
					</table>
				</article>	</a>
				";
		}
		
		if($count == 0)
		{
			echo "<p>You have no messages.</p>";
		}
	}
?>