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
						<h2>Report Product</h2>
						<?php
						if(isset($_POST["report"]))
						{
							$reporter = Escape($_POST["reporter"]);
							$reported = Escape($_POST["reported"]);
							$product = Escape($_POST["product"]);
							$message = nl2br(Escape($_POST["message"]));
							
							$message = "Report from " . $SITE_NAME . " [Username: " . $reporter . " | Product ID: " . $product . " | Owner ID: " . $reported ."]<br>" . $message;
							
							mail($CONTACT_MAIL, $subject, $message);
							echo "<h3>Email sent! Thank you for your message. We will reply as soon as possible.</h3>";
						}
						else
						{
						?>
						<form method="POST" action="report.php">
							<?php
								if(isset($_SESSION["username"]))
								{
									echo '<input type="hidden" name="reporter" value="' . Escape($_SESSION["username"]) . '"/>';
								}	
								
								echo '<input type="hidden" name="reported" value="' . Escape($_GET["prod"]) . '"/>';
								echo '<input type="hidden" name="product" value="' . Escape($_GET["onwer"]) . '"/>';
							?>
							<table style="width: 100%;">
								
								<tr>
									<td style="width: 50%;">
										<h3>Reason</h3>
									</td>
									
									<td style="width: 50%;">
										<input type="text" required name="subject" style="height: 30px; width: 98%; border-radius: 5px;"/>
									</td>
								</tr>
								
								<tr>
									<td style="width: 50%;">
										<h3>Details <span style='font-size: 15px;'>(Please tell us more about the problem)</span></h3>
									</td>
									
									<td style="width: 50%;">
										<textarea name="message" required style="min-width: 470px; max-width: 470px; min-height: 100px; max-height: 300px;"></textarea>
									</td>
								</tr>
								
								<tr>
									<td style="width: 50%;">
										<h3>Report</h3>
									</td>
									
									<td style="width: 50%;">
										<input type="submit" value="Send" name="report" style="width: 98%; border-radius: 5px; height: 100%;"/>
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