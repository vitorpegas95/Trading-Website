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
						<h2><?php echo "<b>" . $SITE_NAME . "</b>"; ?> Terms of Service</h2>
						
						<hr style='margin-top: 10px; margin-bottom: 10px;'>
						
						<h3> Rules </h3>
						<p> Terms and Conditions stipulate the terms under which the service is provided from <?php echo "<b>" . $SITE_NAME . "</b>"; ?> and define the rules for the participation of individuals or entities registered in said service.
						Provision of the service is dependent on <?php echo "<b>" . $SITE_NAME . "</b>"; ?> full acceptance of these conditions, so that any user that does not conform or not to undertake to behave in accordance with these you can not use that service.
						The interpretation of these Terms and Conditions is the exclusive <?php echo "<b>" . $SITE_NAME . "</b>"; ?>, who reserves the right to modify at any time. </p>

						<Hr style = 'margin-top: 10px; margin-bottom: 10px; '>

						<h3> Service </h3>

						<p> <?php echo "<b>" . $SITE_NAME . "</b>"; ?> is an online service that gives users a website with the aim to facilitate the dissemination of intent for the sale or hire of goods, services or interpersonal communication through a system of ranked.
						Registration on <?php echo "<b>" . $SITE_NAME . "</b>"; ?> and placing classified ads are completely free.
						<?php echo "<b>" . $SITE_NAME . "</b>"; ?> has no access or control over the conditions of articles or services communicated in ads or engages or participates in the actual transaction between buyer / contractor and vendor / provider. So <?php echo "<b>" . $SITE_NAME . "</b>"; ?> not guarantee the quality, safety or legality of items or services advertised, the truth or accuracy of these, the ability of sellers to sell items and providers or services, the ability of buyers to purchase products or services hire contractors, nor can it guarantee that both parties to complete the transaction. </ p>


						<Hr style = 'margin-top: 10px; margin-bottom: 10px; '>

						<h3> Access to the Service </h3>

						<p> <?php echo "<b>" . $SITE_NAME . "</b>"; ?> Not having a uniform content, you can not restrict access to the Service only in accordance with a criterion of age.
						The legality of access to service is dependent on their not being awarded any contracts, expensive or not, under the purview of <?php echo "<b>" . $SITE_NAME . "</b>"; ?>, so access to the service users is allowed, regardless of possession of full legal capacity, by thereof. Not owning a mediator character of transactions <?php echo "<b>" . $SITE_NAME . "</b>"; ?> not responsible for any event resulting from the lack of legal capacity of users.
						Any interested can match only one record and may cancel any subsequent registration made by the same individual <?php echo "<b>" . $SITE_NAME . "</b>"; ?>.
						The records on <?php echo "<b>" . $SITE_NAME . "</b>"; ?> are non-transferable and the holder thereof solely responsible for actions taken with your registration. </p>



						<Hr style = 'margin-top: 10px; margin-bottom: 10px; '>

						<h3> General Terms of Service </h3>

						<p> is allowed to place a associated with a particular item listing, property, vehicle or job vacancy. The same ad can not be more than a subject to be announced; </p>
						<p> ads containing or manipulation of words that are attributed to inappropriate categories, according to these terms can conditions be targets of measures including its permanent removal; </p>
						<p> <?php echo "<b>" . $SITE_NAME . "</b>"; ?> not responsible for the content of advertisements, hyperlinks or sources mentioned in the description of a notice, with the parameters of liability for content and links described further below in this document; </p>
						<p> <?php echo "<b>" . $SITE_NAME . "</b>"; ?> can remove or edit the descriptions placed an advertisement by users, without having to refer to the same cause; </p>
						<p> <?php echo "<b>" . $SITE_NAME . "</b>"; ?> can delete the user from using the service (eg prevent you from logging in, placing or answering advertisements), when you have breached any of the conditions of use of this term, this document , </p>
						<p> <?php echo "<b>" . $SITE_NAME . "</b>"; ?> strives to operate correctly without fail, but however, reserves the right to temporarily suspend their operations for technical reasons, or causes beyond the control of <?php echo "<b>" . $SITE_NAME . "</b>"; ?>, </p>
						<p> <?php echo "<b>" . $SITE_NAME . "</b>"; ?> not responsible for the behavior of advertisers, or items and services advertised by them for sale as described in your ads. To infringe a particular ad on <?php echo "<b>" . $SITE_NAME . "</b>"; ?> current rules, the user assumes all liability resulting in injury or damage to any authority, natural person or legal entity, be free from any liability arising <?php echo "<b>" . $SITE_NAME . "</b>"; ?>, </p>
						<p> <?php echo "<b>" . $SITE_NAME . "</b>"; ?> not be liable for any damage that occurs as a result of the transaction, or inappropriate behavior of one of the parties to the transaction. </p>
						<p> messages and their attachments stored in My <?php echo "<b>" . $SITE_NAME . "</b>"; ?>, remain in the system for a period of 90 days. </p>



						<Hr style = 'margin-top: 10px; margin-bottom: 10px; '>

						<h3> Term of responsibility </h3>

						<p> To ensure a high quality of service to all users, preventing abuses or to bring into question the performance of service, <?php echo "<b>" . $SITE_NAME . "</b>"; ?> may apply a fair use policy, limiting free ad placement, all users who have more than 100 active listings in a specific sub-category (or more than 2 active ads in the categories of Employment Services, Real Estate and Cars, Vehicles). </p>
						<p> Where this policy is applied will be issued a warning on ad placement and will have to opt for a buying mode for additional announcements as plans for professionals. Alternatively you may be recommended a more appropriate service for professional use.</p>
						<hr style='margin-top: 10px; margin-bottom: 10px;'>
						
						
						
					</content>
					
				</div>
			</div>
		</div>
		<?php include "clean.php"; ?>
	</body>	
</html>