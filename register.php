<?php
	require_once 'app/init.php';
	$auth = new TwitterAuth($db, $client);		//Twitter Auth
	
	$googleClient = new Google_Client;
	$google = new GoogleAuth($db, $googleClient);	//Google Auth
	
	if($google->checkRedirectCode())
	{
		//Redirect("index.php");
	}
	
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
							<h2>Sign Up</h2>
						
						
						<?php if($auth->signedIn()): ?>
							<?php Redirect("index.php"); ?>
						<?php else: ?>
							<?php
								if(isset($_GET["error"]))
								{
									$error = Escape($_GET["error"]);
									if(strlen($error) == 128)
									{
										if($error == Hash512("Username or Password are invalid!"))
										{
											echo "<center><h2>Your Username or Password are invalid! Please try again.</h2></center>";
										}
										else if($error == Hash512("Your username / email or phone number is already in use. Please try again."))
										{
											echo "<center><h2>Your username / email or phone number is already in use. Please try again.</h2></center>";
										}	
									}
									else
									{
										$error = "";
									}
								}
							?>
						
							<h3>With Twitter, Facebook or Google Account.</h3>
							<p>You sign in <?php echo $SITE_NAME; ?> using your Social Network account.</p>
						
							<a href='<?php echo $auth->getAuthUrl(); ?>'><img style='width: 150px; height: 30px;' src='img/sign-in-with-twitter-gray.png' alt='Login with Twitter'/></a>
							<a href='<?php echo $facebook->getLoginUrl(); ?>'><img style='width: 150px; height: 30px;' src='img/sign-in-with-fb.png' alt='Login with Facebook'/></a>
							<a href='<?php echo $google->getAuthUrl(); ?>'><img style='width: 150px; height: 30px;' src='img/sign-in-with-gmail.png' alt='Login with Google'/></a>
							<hr style='margin-top: 20px; margin-bottom: 20px;'>
						
							<h3>Create a new account</h2>
							<p>You can fill up the form with your contact details and you're ready to go!</p>
							
							<b><a href="#" id="loginBtn" style="display: inline-block; width: 100px; text-align: center;">Login</a></b>
							<b><a href="#" id="registerBtn" style="display: inline-block; width: 100px; float: right; text-align: center;">Register</a></b>
							
							<div id="login" style="display: none; margin-top: 14px; clear: both;">
								<form method="POST" action="auth.php">
									<table style="width: 100%;">
										<tr>
											<td style="width: 50%;">
												<h3>Username</h3>
											</td>
											
											<td style="width: 50%;">
												<input type="text" name="username" style="height: 30px; width: 98%; border-radius: 5px;"/>
											</td>
										</tr>
										
										<tr>
											<td style="width: 50%;">
												<h3>Password</h3>
											</td>
											
											<td style="width: 50%;">
												<input type="password" name="password" style="height: 30px; width: 98%; border-radius: 5px;"/>
											</td>
										</tr>
										
										<tr>
											<td style="width: 50%;">
												<h3>Login</h3>
											</td>
											
											<td style="width: 50%;">
												<input type="submit" value="Login" name="login" style="width: 98%; border-radius: 5px; height: 100%;"/>
											</td>
										</tr>
									</table>
								</form>
							</div>
							
							<div id="register" style="display: none; margin-top: 14px; clear: both;">
								<form method="POST" action="auth.php">
									<table style="width: 100%;">
										<tr>
											<td style="width: 50%;">
												<h3>Username</h3>
											</td>
											
											<td style="width: 50%;">
												<input type="text" required name="utilizador" autocomplete="off" style="height: 30px; width: 98%; border-radius: 5px;"/>
											</td>
										</tr>
										
										<tr>
											<td style="width: 50%;">
												<h3>Password</h3>
											</td>
											
											<td style="width: 50%;">
												<input type="password" required autocomplete="off" name="passchave" style="height: 30px; width: 98%; border-radius: 5px;"/>
											</td>
										</tr>
										
										<tr>
											<td style="width: 50%;">
												<h3>Name</h3>
											</td>
											
											<td style="width: 50%;">
												<input type="text" required autocomplete="off" name="name" style="height: 30px; width: 98%; border-radius: 5px;"/>
											</td>
										</tr>
										
										<tr>
											<td style="width: 50%;">
												<h3>Email</h3>
											</td>
											
											<td style="width: 50%;">
												<input type="email" required autocomplete="off" name="email" style="height: 30px; width: 98%; border-radius: 5px;"/>
											</td>
										</tr>
										
										<tr>
											<td style="width: 50%;">
												<h3>Phone Number</h3>
											</td>
											
											<td style="width: 50%;">
												<input type="number" required autocomplete="off" name="phone" style="height: 30px; width: 98%; border-radius: 5px;"/>
											</td>
										</tr>
										
										<tr>
											<td style="width: 50%;">
												<h3>Read the Terms of Service</h3>
											</td>
											
											<td style="width: 50%;">
												<input type="checkbox" name="readTos" required value="readTos">I've read the <a href="tos.php" target="_blank">Terms of Service</a></input>
											</td>
										</tr>
										
										<tr>
											<td style="width: 50%;">
												<h3>Register</h3>
											</td>
											
											<td style="width: 50%;">
												<input type="submit" value="Register" name="register" style="width: 98%; border-radius: 5px; height: 100%;"/>
											</td>
										</tr>
									</table>
								</form>
							</div>
							
							
							
							
							
						<?php endif; ?>
						
						
					</content>
					
				</div>
			</div>
		</div>
		<?php include "clean.php"; ?>
	</body>	
</html>