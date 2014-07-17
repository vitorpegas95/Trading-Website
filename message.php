<?php
	require_once 'app/init.php';
	$auth = new TwitterAuth($db, $client);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Free Online Marketplace</title>
		<meta charset="UTF-8">
		<!-- CSS -->
		<link rel="stylesheet" href="style.css">
		
		<!-- JQuery -->
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/main.js"></script>
		
		<!-- Google Fonts -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700|Oswald|Pacifico' rel='stylesheet' type='text/css'>
	</head>
	
	<body>
		<div class='page'>
			<?php include "header.php"; //Include header module ?>
			
			<div class='fullContainer'>				
				<div class='contentContainer'>
					<content>
						<h2>Message Center </h2>
						<?php if(isset($_GET["action"]))
								if(strlen(Escape($_GET["action"])) == 128)
									if(Escape($_GET["action"]) == Hash512("Message Sent!"))
										echo "<p>Message Sent!</p>";
									else if(Escape($_GET["action"]) == Hash512("Message Deleted"))
										echo "<p>Message Deleted!</p>";
								
						?>
						<hr>
						<?php
						if(isset($_SESSION["username"]))
						{
							if(isset($_GET["new"]))
							{
								$new = Escape($_GET["new"]);
								if(strlen($new) == 1)
								{
									if($new == 1)
									{
										if(isset($_GET["userid"]))
										{
											$userID = Escape($_GET["userid"]);
											$receiverInfo = getUserInfoByID($db, $userID);
											$receiverUsername = $receiverInfo[1];
										}
										else
										{
											$receiverUsername = "";
										}	
										
										if(isset($_GET["subject"]))
										{
											$subject = Escape($_GET["subject"]);
										}
										else
										{
											$subject = "";
										}
										
										echo '
											<form method="POST" action="message.php">
												<table style="width: 100%;">
													<tr>
														<td style="width: 50%;">
															<h3>Receiver</h3>
														</td>
														
														<td style="width: 50%;">
															<input type="text" value="' . $receiverUsername . '" required name="receiver" style="height: 30px; width: 98%; border-radius: 5px;"/>
														</td>
													</tr>
													
													<tr>
														<td style="width: 50%;">
															<h3>Subject</h3>
														</td>
														
														<td style="width: 50%;">
															<input required value="' . $subject . '" type="text" name="subject" style="height: 30px; width: 98%; border-radius: 5px;"/>
														</td>
													</tr>
													
													<tr>
														<td style="width: 50%;">
															<h3>Message</h3>
														</td>
														
														<td style="width: 50%;">
															<textarea name="message" required style="min-width: 470px; max-width: 470px; min-height: 100px; max-height: 300px;border-radius: 5px;"></textarea>
														</td>
													</tr>
													<tr>
														<td style="width: 50%;">
															<h3>Send Message</h3>
														</td>
														
														<td style="width: 50%;">
															<input type="image" style="width: 80px; height: 80px;" src="img/Actions-dialog-ok-apply-icon.png"/>
														</td>
													</tr>
												</table>
											</form>
										';
									}
								}
							}
							else if(isset($_POST["subject"]))
							{
								$receiverUsername = Escape($_POST["receiver"]);
								$subject = Escape($_POST["subject"]);
								$message = nl2br(Escape($_POST["message"]));
								
								$receiverID = getUserInfo($db, $receiverUsername);
								$receiverID = $receiverID[0];
								$senderID = getUserInfo($db, Escape($_SESSION["username"]));
								$senderID = $senderID[0];
								$db->Execute("INSERT INTO `messages`(`sender`, `receiver`, `subject`, `message`) VALUES (?, ?, ?, ?)", $senderID, $receiverID, $subject, $message);
								
								Redirect("message.php?action=" . Hash512("Message Sent!"));
							}
							else if(isset($_GET["mid"]))
							{
								$messageID = Escape($_GET["mid"]);
								if(is_numeric($messageID))
								{
									$messageInfo = $db->Execute("SELECT * FROM `messages` WHERE `id`=?", $messageID);
									foreach($messageInfo as $msg)
									{
										$subject = $msg->subject;
										$message = $msg->message;
										$date = $msg->date;
										$sender = $msg->sender;
										$receiver = $msg->receiver;
									}
									$tmpUsername = getUserInfo($db, Escape($_SESSION["username"]));
									if($tmpUsername[0] == $receiver)
									{
										$senderUsername = getUserInfoByID($db, $sender);
										$senderUsername = $senderUsername[1];
										//If this message belongs to us
										echo "<h3>$subject <span style='font-size: 14px;'>$date</span> &nbsp;&nbsp; <span><a href='message.php?delete=" . $messageID . "'><img title='Delete' src='img/edit-delete.png' style='width: 32px; height: 32px;' alt='Delete'></a> &nbsp;&nbsp;<a href='message.php?new=1&reply=1&subject=" . 'Re: ' . $subject ."&userid=" . $sender . "'><img title='Reply' src='img/mail-reply-all.png' style='width: 32px; height: 32px;' alt='Delete'></a></span></h3>";
										echo "<p><b>FROM: $senderUsername</b></p>";
										echo "<p><b>Message:</b><br>$message</p>";
									}
									else
									{
										Redirect("message.php");
									}
								}
								else
								{
									Redirect("message.php");
								}
							}
							else if(isset($_GET["delete"]))
							{
								$delete = Escape($_GET["delete"]);
								if(is_numeric($delete))
								{
									$messageInfo = $db->Execute("SELECT * FROM `messages` WHERE `id`=?", $delete);
									foreach($messageInfo as $msg)
									{
										$subject = $msg->subject;
										$message = $msg->message;
										$date = $msg->date;
										$sender = $msg->sender;
										$receiver = $msg->receiver;
									}
									
									$tmp2 = getUserInfo($db, Escape($_SESSION["username"]));
									if($tmp2[0] == $receiver)
									{
										//Its ours
										$db->Execute("DELETE FROM `messages` WHERE `id`=?", $delete);
										Redirect("message.php?action=" . Hash512("Message Deleted"));
									}
									else
									{
										Redirect("message.php");
									}
									
								}	
							}
							else
							{
								getMyMessages($db);							
							}
						}
						else
						{
							Redirect("index.php");
						}
						?>
					</content>
					
				</div>
			</div>
		</div>
		<?php include "clean.php"; ?>
	</body>	
</html>