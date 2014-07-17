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
						<h2>Contact us</h2>
						<?php
						if(isset($_POST["contact"]))
						{
							$name = Escape($_POST["contact"]);
							$subject = Escape($_POST["subject"]);
							$message = nl2br(Escape($_POST["message"]));
							$email = Escape($_POST["email"]);
							
							$message = "Message from " . $SITE_NAME . " [Name: " . $name . " | Email: " . $email . "]<br>" . $message;
							
							mail($CONTACT_MAIL, $subject, $message);
							echo "<h3>Email sent! Thank you for your message. We will reply as soon as possible.</h3>";
						}
						else
						{
						?>
						<form method="POST" action="contact.php">
							<table style="width: 100%;">
								<tr>
									<td style="width: 50%;">
										<h3>Your name</h3>
									</td>
									
									<td style="width: 50%;">
										<input type="text" required name="name" style="height: 30px; width: 98%; border-radius: 5px;"/>
									</td>
								</tr>
								
								<tr>
									<td style="width: 50%;">
										<h3>Email</h3>
									</td>
									
									<td style="width: 50%;">
										<input type="email" required name="email" style="height: 30px; width: 98%; border-radius: 5px;"/>
									</td>
								</tr>
								
								<tr>
									<td style="width: 50%;">
										<h3>Subject</h3>
									</td>
									
									<td style="width: 50%;">
										<input type="text" required name="subject" style="height: 30px; width: 98%; border-radius: 5px;"/>
									</td>
								</tr>
								
								<tr>
									<td style="width: 50%;">
										<h3>Message</h3>
									</td>
									
									<td style="width: 50%;">
										<textarea name="message" required style="min-width: 470px; max-width: 470px; min-height: 100px; max-height: 300px;"></textarea>
									</td>
								</tr>
								
								<tr>
									<td style="width: 50%;">
										<h3>Contact</h3>
									</td>
									
									<td style="width: 50%;">
										<input type="submit" value="Contact" name="contact" style="width: 98%; border-radius: 5px; height: 100%;"/>
									</td>
								</tr>
							</table>
						</form>
						
						<?php
						
						}
						
						?>
					</content>
					
				</div>
			</div>
		</div>
		<?php include "clean.php"; ?>
	</body>	
</html>