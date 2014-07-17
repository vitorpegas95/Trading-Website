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
						<h2>Help</h2>
						
						<hr style='margin-top: 10px; margin-bottom: 10px;'>
						
						<h3><?php echo $SITE_NAME; ?> Mobile Apps</h3>
						
						<b>ANDROID</b>
						<p>You can acess and use the website directly in your Android Phone, just download the Android APP from the Google Play Store!</p>
						
						<b>iOS</b>
						<p>If you have a iPad, iPhone or iPod, you can use the website directly from the iOS APP by downloading it from the App Store!</p>
						
						<hr style='margin-top: 10px; margin-bottom: 10px;'>
						
						<h3>How to add Products</h3>
						<p>It's very easy and super simple to add your products to our website!</p>
						<p>- First make sure you have an account. If you don't, you can create one in the <a href="register.php">Sign Up</a> page, or Login using Facebook or Twitter!</p>
						<p>- Once logged in, head over to <a href="products.php?my=1">My Products page</a> and click the "Add my Product" Link</p>
					</content>
					
				</div>
			</div>
		</div>
		<?php include "clean.php"; ?>
	</body>	
</html>