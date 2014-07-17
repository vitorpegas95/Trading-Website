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
						<h2>Account Manager</h2>
						<?php
							if(isset($_SESSION["username"]))
							{
						
								$userInfo = getUserInfo($db, Escape($_SESSION["username"]));
								if($userInfo[2] != "")
									echo "<p>" . $userInfo[2] . ", here you can change your account settings.</p>";
								else
									echo "<p>" . $userInfo[1] . ", here you can change your account settings.</p>";
								if(isset($_GET["action"]))
								{
									$action = Escape($_GET["action"]);
									
									if(strlen($action) != 128)
										Redirect("account.php");
									else
									{
										if($action == Hash512("PasswordChangedCodedbyvitorpegas"))
										{
											echo "<b>Your password was changed!</b>";
										}
										else if($action == Hash512("EmailChangedCodedbyvitorpegas"))
										{
											echo "<b>Your email was changed!</b>";
										}
										else if($action == Hash512("PhoneChangedCodedbyvitorpegas"))
										{
											echo "<b>Your phone number was changed!</b>";
										}
										else if($action == Hash512("NameChangedCodedbyvitorpegas"))
										{
											echo "<b>Your Display Name was changed!</b>";
										}
										else
										{
											Redirect("account.php");
										}
									}
								}
								?>
								
								<hr>
								
								<div>
									<article class="actions">
										<a href="#" id="pwBtn"><img title="Password Change" alt="" src="img/Actions-view-pim-contacts-icon.png"></a>
									</article>
									
									<article class="actions">
										<a href="#" id="emailBtn"><img title="Email Change" alt="" src="img/Actions-view-pim-mail-icon.png"></a>
									</article>
									
									<article class="actions">
										<a href="#" id="phoneBtn"><img title="Phone Number Change" alt="" src="img/Devices-phone-icon.png"></a>
									</article>
									
									<article class="actions">
										<a href="#" id="nameBtn"><img title="Display Name Change" alt="" src="img/Actions-resource-group-icon.png"></a>
									</article>
								</div>
								
								<div>
									<div id="password" style="display: none; margin-top: 14px; clear: both;">
										<b>Change Password</b>
										<form method="POST" action="change.php">
											<table style="width: 100%;">
												<tr>
													<td style="width: 50%;">
														<h3>Current Password</h3>
													</td>
													
													<td style="width: 50%;">
														<input type="password" name="current" autocomplete="off" style="height: 30px; width: 98%; border-radius: 5px;"/>
													</td>
												</tr>
												
												<tr>
													<td style="width: 50%;">
														<h3>New Password</h3>
													</td>
													
													<td style="width: 50%;">
														<input type="password" name="newone" autocomplete="off" style="height: 30px; width: 98%; border-radius: 5px;"/>
													</td>
												</tr>
												
												<tr>
													<td style="width: 50%;">
														<h3>Change</h3>
													</td>
													
													<td style="width: 50%;">
														<input type="image" name="changePassword" src="img/Actions-document-save-icon.png" style="float: right; width: 64px; height: 64px;"/>
													</td>
												</tr>
											</table>
										</form>
									</div>
									
									<div id="email" style="display: none; margin-top: 14px; clear: both;">
										<b>Change Email</b>
										<form method="POST" action="change.php">
											<table style="width: 100%;">												
												<tr>
													<td style="width: 50%;">
														<h3>New Email</h3>
													</td>
													
													<td style="width: 50%;">
														<input type="email" name="email" autocomplete="off" style="height: 30px; width: 98%; border-radius: 5px;"/>
													</td>
												</tr>
												
												<tr>
													<td style="width: 50%;">
														<h3>Change</h3>
													</td>
													
													<td style="width: 50%;">
														<input type="image" name="changeEmail" src="img/Actions-document-save-icon.png" style="float: right; width: 64px; height: 64px;"/>
													</td>
												</tr>
											</table>
										</form>
									</div>
									
									<div id="name" style="display: none; margin-top: 14px; clear: both;">
										<b>Change Display Name</b>
										<form method="POST" action="change.php">
											<table style="width: 100%;">												
												<tr>
													<td style="width: 50%;">
														<h3>New Display Name</h3>
													</td>
													
													<td style="width: 50%;">
														<input type="text" name="name" autocomplete="off" style="height: 30px; width: 98%; border-radius: 5px;"/>
													</td>
												</tr>
												
												<tr>
													<td style="width: 50%;">
														<h3>Change</h3>
													</td>
													
													<td style="width: 50%;">
														<input type="image" name="changeName" src="img/Actions-document-save-icon.png" style="float: right; width: 64px; height: 64px;"/>
													</td>
												</tr>
											</table>
										</form>
									</div>
									
									<div id="phone" style="display: none; margin-top: 14px; clear: both;">
										<b>Change Phone</b>
										<form method="POST" action="change.php">
											<table style="width: 100%;">												
												<tr>
													<td style="width: 50%;">
														<h3>New Phone Number</h3>
													</td>
													
													<td style="width: 50%;">
														<input type="number" name="phone" autocomplete="off" style="height: 30px; width: 98%; border-radius: 5px;"/>
													</td>
												</tr>
												
												<tr>
													<td style="width: 50%;">
														<h3>Change</h3>
													</td>
													
													<td style="width: 50%;">
														<input type="image" name="changePhone" src="img/Actions-document-save-icon.png" style="float: right; width: 64px; height: 64px;"/>
													</td>
												</tr>
											</table>
										</form>
									</div>
								</div>
								
								<hr style="margin-top: 15px; margin-bottom: 15px;">
								<h2>Message Center <span><a href='message.php?new=1'><img title='New Message' src='img/mail-message-new.png' alt='New' style='width: 32px; height: 32px;'></a></span></h2>
								
								<?php
									getMyMessages($db);
								?>
								
								<?php
								
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