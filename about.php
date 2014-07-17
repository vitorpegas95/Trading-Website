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
						<h2>About <?php echo $SITE_NAME; ?></h2>
						
						<hr style='margin-top: 10px; margin-bottom: 10px;'>
						
						<h3>Our Goal</h3>
						<p>The main <b>goal</b> of this website is to provide the best free open online marketplace so that everyone can sell / buy services fast and easy!</p>
						
						<hr style='margin-top: 10px; margin-bottom: 10px;'>
						
						<h3>How to use</h3>
						<p>It's very easy to use our service.</p>
						<p>First <b>create a free account</b> by filling <a href="register.php">this form</a> or you can <b>login directly with your Twitter account</b>.</p>
						<p><b>Note</b>: If you login using twitter, please go to <a href="account.php">your account page</a> and provide a email and/or phone number so that people may contact you for your services</p>
						<p>Once all that is done, you can <b>Add your Products/Services</b> or <b>browse existing ones</b>. You can also <b>search by tags, location, name or onwer</b> of those Products/Services!</p>
						<p>Any question you can <a href="contact.php">Contact us</a> <b>anytime</b>, and we will reply as soon as possible.</p>
						
						<hr style='margin-top: 10px; margin-bottom: 10px;'>
						
						<h3>Contact</h3>
						<p>Email: <a href="mailto:contact@domain.com">contact@domain.com</a></p>
						<p>Address: .......</p>
						<p><a href="contact.php">Contact Form</a></p>
					</content>
					
				</div>
			</div>
		</div>
		<?php include "clean.php"; ?>
	</body>	
</html>