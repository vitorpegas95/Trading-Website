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
		
		<?php
			if(isset($_GET["id"]))
			{
				$product = Escape($_GET["id"]);
				if(is_numeric($product))
				{
					$getProd = $db->Execute("SELECT * FROM `product` WHERE id=?", Escape($_GET['id']));
					$id = $prod->id;
					$name = $prod->name;
					$desc = $prod->description;
					$price = $prod->price;
					$owner = $prod->owner;
					$date = $prod->date;
					$tags = explode(",", $prod->tags);
					$city = ucfirst($prod->city);
					$img = $prod->img;
				?>
				
					<meta property="og:title" content="<?php echo $name; ?>"/>
					<meta property="og:image" content="<?php echo $img; ?>"/>
					<meta property="og:site_name" content="<?php echo $SITE_NAME; ?>"/>
					<meta property="og:description" content="<?php echo $desc; ?>"/>
					<meta property="og:url" content="http://www.oryzhon.com/marketplace/products.php?id=<?php echo $id ?>"/>
				<?php

				}
			}
		?>
	</head>
	
	<body>
		<div class='page'>
			<?php include "header.php"; //Include header module ?>
			
			<div class='fullContainer'>				
			<div class='contentContainer'>
					<?php if(isset($_GET["id"])): ?>
						<content style='width: 630px;'>
					<?php else: ?>
						<content>
					<?php endif; ?>
					<?php 
						if(isset($_GET["my"]) && isset($_SESSION["username"]))
						{
						
							if(strlen(Escape($_GET["my"])) != 1)		//Security above all
								Redirect("products.php");
							else
							{
								//Display only my products
								
								echo "<a href='products.php?add=1'>Add my product</a>";
								echo "<hr>";
								
								$userInfo = $db->Execute("SELECT * FROM `accounts` WHERE username=?", Escape($_SESSION['username']));
								foreach($userInfo as $info)
								{
									$name = $info->nome;
									$email = $info->email;
									$password = $info->password;
									$phone = $info->telefone;
									$Id = $info->id;
								}
								
								$myProds = $db->Execute("SELECT * FROM `product` WHERE owner=? ORDER BY `date` DESC", Escape($Id));
								
								$myProductsNumber = 0;
								foreach($myProds as $prod)
								{
									$myProductsNumber ++;
									$id = $prod->id;
									$name = $prod->name;
									$desc = $prod->description;
									$desc = substr($desc, 0, 50);
									$price = $prod->price;
									$owner = $prod->owner;
									$date = $prod->date;
									$tags = explode(",", $prod->tags);
									$city = ucfirst($prod->city);
									$img = $prod->img;
									
									$linktags = "";
									for($i = 0; $i < sizeof($tags); $i++)
									{
										$linktags = $linktags . " <a href='search.php?tags=" . trim($tags[$i]) . "'>" . trim($tags[$i]) ."</a> ,";
									}
									
										echo "<a href='products.php?id=$id'>
												<article class='article'>
													<table style='width: 100%;'>
														<tr>
															<td style='width: 124px; height:90px;'>
																<img src='$img' alt='Imagem' style='padding-top: 10px; width:90%;height:90%;'/>
															</td>
															
															<td style='width: 300px;'>
																<h3>$name</h3>
																<p style='overflow: hidden; max-height: 50px;'>$desc</p>
															</td>
															
															<td style='width: 190px;'>
																<h3>Price: $price &euro;</h3>
															</td>
														</tr>
													</table>
												</article>	</a>
												";
								}	
								
								if($myProductsNumber == 0)
								{
									echo "<h3>You have no products / services.</h3>";
								}
								
							}
						}
						else if(isset($_GET["add"]))
						{
							$add = Escape($_GET["add"]);
							if(is_numeric($add))
							{
								if($add == 1)
								{
									echo '
										<form method="POST" action="addproduct.php" enctype="multipart/form-data">
											<table style="width: 100%;">
												<tr>
													<td style="width: 50%;">
														<h3>Name</h3>
													</td>
													
													<td style="width: 50%;">
														<input type="text" required name="name" style="height: 30px; width: 98%; border-radius: 5px;"/>
													</td>
												</tr>
												
												<tr>
													<td style="width: 50%;">
														<h3>Description</h3>
													</td>
													
													<td style="width: 50%;">
														<textarea name="desc" required style="min-width: 470px; max-width: 470px; min-height: 100px; max-height: 300px;"></textarea>
													</td>
												</tr>
												
												<tr>
													<td style="width: 50%;">
														<h3>Price</h3>
													</td>
													
													<td style="width: 50%;">
														<input type="number" required step="any" min="0" name="price" style="height: 30px; width: 98%; border-radius: 5px;"/>
													</td>
												</tr>
												
												<tr>
													<td style="width: 50%;">
														<h3>Category</h3>
													</td>
													
													<td style="width: 50%;"><select style="width: 100%; " name="category">';
													$categoriesQ = $db->Execute("SELECT * FROM `category`");
													foreach($categoriesQ as $cat)
													{
														echo '<option value="' . $cat->name . '">'.$cat->name . '</option>';
													}
													$categoriesQ->close();
													echo '
														</select>
													</td>
												</tr>
												
												<tr>
													<td style="width: 50%;">
														<h3>Tags <span style="font-size: 13px;">(tag1, tag2, tag3)</span></h3>
													</td>
													
													<td style="width: 50%;">
														<input required type="text" name="tags" style="height: 30px; width: 98%; border-radius: 5px;"/>
													</td>
												</tr>
												
												<tr>
													<td style="width: 50%;">
														<h3>City</h3>
													</td>
													
													<td style="width: 50%;">
														<input required type="text" name="city" style="height: 30px; width: 98%; border-radius: 5px;"/>
													</td>
												</tr>
												
												<tr>
													<td style="width: 50%;">
														<h3>Image</h3>
													</td>
													
													<td style="width: 50%;">
														<input type="file" name="file" style="font-size: 14px;">
													</td>
												</tr>
												
												<tr>
													<td style="width: 50%;">
														<h3>Add Product</h3>
													</td>
													
													<td style="width: 50%;">
														<input type="image" style="width: 80px; height: 80px;" src="img/Actions-dialog-ok-apply-icon.png"/>
													</td>
												</tr>
											</table>
										</form>
									';
								}
								else
								{
									Redirect("products.php");
								}
							}
							else
							{
								Redirect("products.php");
							}
						}
						else if(isset($_GET["id"]))
						{
							$product = Escape($_GET["id"]);
							if(is_numeric($product))
							{
								$getProd = $db->Execute("SELECT * FROM `product` WHERE id=?", Escape($_GET['id']));
								foreach($getProd as $prod)
								{
									$id = $prod->id;
									$name = $prod->name;
									$desc = $prod->description;
									$price = $prod->price;
									$owner = $prod->owner;
									$date = $prod->date;
									$tags = explode(",", $prod->tags);
									$city = ucfirst($prod->city);
									$img = $prod->img;
									
									$linktags = "";
									for($i = 0; $i < sizeof($tags); $i++)
									{
										$linktags = $linktags . " <a href='search.php?tags=" . trim($tags[$i]) . "'>" . trim($tags[$i]) ."</a> ,";
									}
									
									echo "
									<h3>$name <span style='font-size: 14px;'>$date</span><a href='report.php?prod=$id&owner=$owner'><img title='Report' alt='Report' style='width: 32px; height: 32px;' src='img/dialog-warning.png'/></a></h3>
									<table style='width: 100%;'>
										<tr>
											<td style='width: 33%'>
												<center><b>$price &euro;</b></center>
											</td>
											
											<td style='width: 33%'>
												<center><b>$linktags</b></center>
											</td>
											
											<td style='width: 33%'>
												<center><b>$city</b></center>
											</td>
										</tr>
									</table>	
									
									<hr style='margin-top: 10px; margin-bottom: 10px;'>
									
									<center><img style='width: 100%; height: 400px;' src='$img' alt='Image' /></center>
									
									<hr style='margin-top: 10px; margin-bottom: 10px;'>
									
									<p>$desc</p>
									";
									
									//Social
									
									
									echo '<hr style="margin-top: 15px; margin-bottom: 15px;">';
									echo '<div>';
									$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
									echo '<div class="fb-like" data-href="' . $actual_link .'" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>';
									?>
									<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $actual_link; ?>" data-size="large">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
									<?php
									
									echo '</div>';
									
									//End social
								}
							}
							else
							{
								Redirect("products.php");
							}
						}
						else
						{ //Display every product from the last
							Redirect("search.php");
						} 
						?>
					</content>
					
					
						<?php
						
						if(isset($_GET['id']))
						{
							echo "<aside class='sidebar'>
							<h2>Owner Information</h2>";
							$product = Escape($_GET["id"]);
							if(is_numeric($product))
							{
								$getProd = $db->Execute("SELECT * FROM `product` WHERE id=?", Escape($_GET['id']));
								foreach($getProd as $prod)
								{
									$owner = $prod->owner;
								}
								$getProd->Close();
								
								$OtheruserInfo = getUserInfoByID($db, Escape($owner));
								if($OtheruserInfo[2] == "")	$OtheruserInfo[2] = $OtheruserInfo[1];

								echo "
									<p>" . $OtheruserInfo[2] . "(" . $OtheruserInfo[1] . ") " . getUserRate($db, Escape($owner)) . "</p>
									<p>Phone: " . $OtheruserInfo[4] . "</p>
									<p>Email: <a href='mailto:" . $OtheruserInfo[3] . "'>" . $OtheruserInfo[3] . "</a></p>
									<p><a href='message.php?new=1&userid=" . $OtheruserInfo[0] . "'>Send Message</a></p>
									<hr>";
									if(isset($_SESSION["username"]))
									{
										$ourInfo = getUserInfo($db, Escape($_SESSION["username"]));
										if($OtheruserInfo[0] != $ourInfo[0])
										{
											echo "
											<b>Rate (0-100%)</b>
												<form method='POST' action='rate.php'>
													<input type='number' style='width: 60px;' name='rating' required min='0' max='100'/>
													<input type='hidden' name='rater' value='" . $ourInfo[0] . "'>
													<input type='hidden' name='rated' value='" . $OtheruserInfo[0] . "'>
													<input type='hidden' name='prodID' value='" . $_GET['id'] . "'>
													<input type='image' style='width: 44px; height: 44px; position:relative; top:10px;' src='img/Actions-dialog-ok-apply-icon.png' name='rate'>
												</form>";
										}
									}
							}
							echo "</aside>";
						}
						

						?>
					
				</div>
			</div>
		</div>
		<?php include "clean.php"; ?>
	</body>	
</html>