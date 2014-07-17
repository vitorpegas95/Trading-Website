<?php
	require_once 'app/init.php';
	$auth = new TwitterAuth($db, $client);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Free Online Marketplace</title>
		<meta charset="UTF-8">
		<meta property="og:image" content="<?php echo $SITE_NAME . "img/logo.png"; ?>"/>
		<!-- CSS -->
		<link rel="stylesheet" href="style.css">
		
		<!-- JQuery -->
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/main.js"></script>
		<script src="//unslider.com/unslider.min.js"></script>
		
		<script>
			$(function() {
   $('.banner').unslider({
	speed: 500,               //  The speed to animate each slide (in milliseconds)
	delay: 3000,              //  The delay between slide animations (in milliseconds)
	complete: function() {},  //  A function that gets called after every slide animation
	keys: true,               //  Enable keyboard (left, right) arrow shortcuts
	dots: true,               //  Display dot navigation
	fluid: true              //  Support responsive design. May break non-responsive designs
});
});
		</script>
		
		<!-- Google Fonts -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700|Oswald|Pacifico' rel='stylesheet' type='text/css'>
	</head>
	
	<body>
		<div class='page'>
			<?php include "header.php"; //Include header module ?>
			
			<div class='fullContainer'>		
			<div class='contentContainer'>
					<content>
						<h2>Welcome to <?php echo $SITE_NAME; ?></h2>
						

					<div class="banner">
						<ul>
							<?php
								$result = $db->Execute("SELECT * FROM `product` ORDER BY `date` DESC LIMIT 0, 5");
								foreach($result as $prod)
								{	
									$id = $prod->id;
									$name = $prod->name;
									$desc = $prod->description;
									$desc = substr($desc, 0, 100);
									$price = $prod->price;
									$owner = $prod->owner;
									$date = $prod->date;
									$tags = explode(",", $prod->tags);
									$city = ucfirst($prod->city);
									$img = $prod->img;
									
									$owner = getUserInfoByID($db, $owner);
									
									$desc = str_replace("<br />", "", $desc);
									
									echo '
									<li >
									<a href="products.php?id=' . $id . '" style="text-decoration: none;">  
										<img src="' . $img . '"/>
										<div class="desc" style="overflow: hidden;">
											<p><b>' . $name .' ( ' . $price . '&euro;)</b><span style="float: right;"><b>Seller: ' . $owner[1] . '</b></span></p>
											
											<p> ' . $desc . ' </p>
										</div>
									</a>
									</li>
									';
								}
							?>
						</ul>
					</div>
			
				
						<table class="grid">
							<?php
								$categoria = $db->Execute("SELECT * FROM `category`");
								$count = 0;
								$colorPicked = array(0, 0, 0, 0);
								foreach($categoria as $c)
								{
									if($count > 3)
									{
										echo '<tr>';
										$count = 0;
									}
									
									$colors = array('#F4D186', '#86C2CC', '#A1C176', '#EA996E');
									$color = rand(0, 3);
									
									
									
									do
									{
										$color = rand(0, 3);
									}
									while($colorPicked[$color] > 2);
									
									$colorPicked[$color]+=1;
									
									
									echo '<td>
									<a href="search.php?category=category&searchText=' . $c->name . '">
											<div class="buttonGrid2" style="background-color: ' . $colors[$color] . ';">
											<center>
											<img src="img/' . $c->name . '.png" alt="' . $c->name . '" style="padding-top: 10px; width: 80px; height: 80px;"/>
											<h3 style="z-index: 5; position: relative; bottom: 10%;">' . $c->name . '</h3></center></div></a></td>';
									
									if($count > 3)
									{
										echo '</tr>';
									}
									$count++;
								}
							?>
						</table>
						<?php
							
							//DisplayLatestProducts($db);
						?>
					</content>
				</div>
			</div>
		</div>
		<?php include "clean.php"; ?>
	</body>	
</html>