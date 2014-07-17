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
						<h2>Search</h2>
						<div id="orderDiv">
							<form method="GET" id="order">
								<select id="order" name="order">
									<option value="date" selected>Date</option>
									<option value="price">Price</option>
								</select>
								
								<select id="sort" name="sort">
									<option value="DESC">Desc</option>
									<option value="ASC">Asc</option>
								</select>
								<?php
								if(isset($_GET["searchText"]))
									echo "<input type='hidden' name='searchText' value='" . Escape($_GET["searchText"]) . "'/>";
								if(isset($_GET["category"]))
									echo "<input type='hidden' name='category' value='" . Escape($_GET["category"]) . "'/>";
								if(isset($_GET["tags"]))
									echo "<input type='hidden' name='tags' value='" . Escape($_GET["tags"]) . "'/>";
								?>
								<input type="submit" value="Order" style='width: 100px;'>
							</form>
						</div>
						<hr>
						<?php
							if(!isset($PAGE_NUM))	$PAGE_NUM = 1;
							
							$order = 0;
							if(isset($_GET["order"]))
							{
								$order = Escape($_GET["order"]);
								if($order != "date" && $order != "price")
									Redirect("index.php");
							}
							else
							{
								$order = "date";
							}
							
							if(isset($_GET["sort"]))
							{
								$sort = Escape($_GET["sort"]);
								if($sort != "DESC" && $sort != "ASC")
									Redirect("index.php");
							}
							else
							{
								$sort = " DESC";
							}
							
							if(isset($_GET["searchText"]))
							{
								$hashtag = substr($_GET["searchText"], 0, 1);
								$needle = Escape($_GET["searchText"]);
								$category = Escape($_GET["category"]);
								if(isset($_GET["tags"]))
									$tags = Escape($_GET["tags"]);
								else 
									$tags = "";
									
								if($hashtag == '#')
								{
									$category = "tags";
									$needle = str_replace('#', '', $_GET["searchText"]);
									$needle = Escape($needle);
								}
								
								if($category == "name")
								{
									if(isset($_GET["tags"]))
									{
										if($order == "date")
										{
											$Prods = $db->Execute("SELECT * FROM `product` WHERE `name` LIKE ? OR `tags` LIKE ? ORDER BY `date` $sort", "%".$needle."%", "%".$tags."%");
											$num_rows = $db->Execute("SELECT COUNT(*) FROM `product` WHERE `name` LIKE ? OR `tags` LIKE ? ORDER BY `date` $sort", "%".$needle."%", "%".$tags."%");
											$query = "SELECT * FROM `product` WHERE `name` LIKE ?  OR `tags` LIKE ? ORDER BY `date` $sort";
										}
										else //Price
										{
											$Prods = $db->Execute("SELECT * FROM `product` WHERE `name` LIKE ? OR `tags` LIKE ? ORDER BY `price` $sort", "%".$needle."%", "%".$tags."%");
											$num_rows = $db->Execute("SELECT COUNT(*) FROM `product` WHERE `name` LIKE ? OR `tags` LIKE ? ORDER BY `price` $sort", "%".$needle."%", "%".$tags."%");
											$query = "SELECT * FROM `product` WHERE `name` LIKE ? OR `tags` LIKE ? ORDER BY `price` $sort";
										}
									}
									else
									{
										if($order == "date")
										{
											$Prods = $db->Execute("SELECT * FROM `product` WHERE `name` LIKE ? ORDER BY `date` $sort", "%".$needle."%");
											$num_rows = $db->Execute("SELECT COUNT(*) FROM `product` WHERE `name` LIKE ? ORDER BY `date` $sort", "%".$needle."%");
											$query = "SELECT * FROM `product` WHERE `name` LIKE ? ORDER BY `date` $sort";
										}
										else //Price
										{
											$Prods = $db->Execute("SELECT * FROM `product` WHERE `name` LIKE ? ORDER BY `price` $sort", "%".$needle."%");
											$num_rows = $db->Execute("SELECT COUNT(*) FROM `product` WHERE `name` LIKE ? ORDER BY `price` $sort", "%".$needle."%");
											$query = "SELECT * FROM `product` WHERE `name` LIKE ? ORDER BY `price` $sort";
										}
									}
								}
								else if($category == "city")
								{
									if(isset($_GET["tags"]))
									{
										if($order == "date")
										{
											$Prods = $db->Execute("SELECT * FROM `product` WHERE `city` LIKE ? OR `tags` LIKE ? ORDER BY `date` $sort", "%".$needle."%", "%".$tags."%");
											$num_rows = $db->Execute("SELECT COUNT(*) FROM `product` WHERE `city` LIKE ? OR `tags` LIKE ? ORDER BY `date` $sort", "%".$needle."%", "%".$tags."%");
											$query = "SELECT * FROM `product` WHERE `city` LIKE ?  OR `tags` LIKE ? ORDER BY `date` $sort";
										}
										else //Price
										{
											$Prods = $db->Execute("SELECT * FROM `product` WHERE `city` LIKE ? OR `tags` LIKE ? ORDER BY `price` $sort", "%".$needle."%", "%".$tags."%");
											$num_rows = $db->Execute("SELECT COUNT(*) FROM `product` WHERE `city` LIKE ? OR `tags` LIKE ? ORDER BY `price` $sort", "%".$needle."%", "%".$tags."%");
											$query = "SELECT * FROM `product` WHERE `city` LIKE ? OR `tags` LIKE ? ORDER BY `price` $sort";
										}
									}
									else
									{
										if($order == "date")
										{
											$Prods = $db->Execute("SELECT * FROM `product` WHERE `city` LIKE ? ORDER BY `date` $sort", "%".$needle."%");
											$num_rows = $db->Execute("SELECT COUNT(*) FROM `product` WHERE `city` LIKE ? ORDER BY `date` $sort", "%".$needle."%");
											$query = "SELECT * FROM `product` WHERE `city` LIKE ? ORDER BY `date` $sort";
										}
										else //Price
										{
											$Prods = $db->Execute("SELECT * FROM `product` WHERE `city` LIKE ? ORDER BY `price` $sort", "%".$needle."%");
											$num_rows = $db->Execute("SELECT COUNT(*) FROM `product` WHERE `city` LIKE ? ORDER BY `price` $sort", "%".$needle."%");
											$query = "SELECT * FROM `product` WHERE `city` LIKE ? ORDER BY `price` $sort";
										}
									}
								}
								else if($category == "tags")
								{
									if(isset($_GET["tags"]))
									{
										if($order == "date")
										{
											$Prods = $db->Execute("SELECT * FROM `product` WHERE `tags` LIKE ? OR `tags` LIKE ? ORDER BY `date` $sort", "%".$needle."%", "%".$tags."%");
											$num_rows = $db->Execute("SELECT COUNT(*) FROM `product` WHERE `tags` LIKE ? OR `tags` LIKE ? ORDER BY `date` $sort", "%".$needle."%", "%".$tags."%");
											$query = "SELECT * FROM `product` WHERE `tags` LIKE ?  OR `tags` LIKE ? ORDER BY `date` $sort";
										}
										else //Price
										{
											$Prods = $db->Execute("SELECT * FROM `product` WHERE `tags` LIKE ? OR `tags` LIKE ? ORDER BY `price` $sort", "%".$needle."%", "%".$tags."%");
											$num_rows = $db->Execute("SELECT COUNT(*) FROM `product` WHERE `tags` LIKE ? OR `tags` LIKE ? ORDER BY `price` $sort", "%".$needle."%", "%".$tags."%");
											$query = "SELECT * FROM `product` WHERE `tags` LIKE ? OR `tags` LIKE ? ORDER BY `price` $sort";
										}
									}
									else
									{
										if($order == "date")
										{
											$Prods = $db->Execute("SELECT * FROM `product` WHERE `tags` LIKE ? ORDER BY `date` $sort", "%".$needle."%");
											$num_rows = $db->Execute("SELECT COUNT(*) FROM `product` WHERE `tags` LIKE ? ORDER BY `date` $sort", "%".$needle."%");
											$query = "SELECT * FROM `product` WHERE `tags` LIKE ? ORDER BY `date` $sort";
										}
										else //Price
										{
											$Prods = $db->Execute("SELECT * FROM `product` WHERE `tags` LIKE ? ORDER BY `price` $sort", "%".$needle."%");
											$num_rows = $db->Execute("SELECT COUNT(*) FROM `product` WHERE `tags` LIKE ? ORDER BY `price` $sort", "%".$needle."%");
											$query = "SELECT * FROM `product` WHERE `tags` LIKE ? ORDER BY `price` $sort";
										}
									}
								}
								else if($category == "category")
								{
									if(isset($_GET["tags"]))
									{
										if($order == "date")
										{
											$Prods = $db->Execute("SELECT * FROM `product` WHERE `category` LIKE ? OR `tags` LIKE ? ORDER BY `date` $sort", "%".$needle."%", "%".$tags."%");
											$num_rows = $db->Execute("SELECT COUNT(*) FROM `product` WHERE `category` LIKE ? OR `tags` LIKE ? ORDER BY `date` $sort", "%".$needle."%", "%".$tags."%");
											$query = "SELECT * FROM `product` WHERE `category` LIKE ? OR `tags` LIKE ? ORDER BY `date` $sort";
										}
										else //Price
										{
											$Prods = $db->Execute("SELECT * FROM `product` WHERE `category` LIKE ? OR `tags` LIKE ? ORDER BY `price` $sort", "%".$needle."%", "%".$tags."%");
											$num_rows = $db->Execute("SELECT COUNT(*) FROM `product` WHERE `category` LIKE ? OR `tags` LIKE ? ORDER BY `price` $sort", "%".$needle."%", "%".$tags."%");
											$query = "SELECT * FROM `product` WHERE `category` LIKE ? OR `tags` LIKE ? ORDER BY `price` $sort";
										}
									}
									else
									{
										if($order == "date")
										{
											$Prods = $db->Execute("SELECT * FROM `product` WHERE `category` LIKE ? ORDER BY `date` $sort", "%".$needle."%");
											$num_rows = $db->Execute("SELECT COUNT(*) FROM `product` WHERE `category` LIKE ? ORDER BY `date` $sort", "%".$needle."%");
											$query = "SELECT * FROM `product` WHERE `category` LIKE ? ORDER BY `date` $sort";
										}
										else //Price
										{
											$Prods = $db->Execute("SELECT * FROM `product` WHERE `category` LIKE ? ORDER BY `price` $sort", "%".$needle."%");
											$num_rows = $db->Execute("SELECT COUNT(*) FROM `product` WHERE `category` LIKE ? ORDER BY `price` $sort", "%".$needle."%");
											$query = "SELECT * FROM `product` WHERE `category` LIKE ? ORDER BY `price` $sort";
										}
									}
								}
							}
							else
							{
								if(isset($_GET["tags"]))
									$tags = Escape($_GET["tags"]);
								else 
									$tags = "";
							
								if(isset($_GET["tags"]))
								{
									if($order == "date")
									{
										$Prods = $db->Execute("SELECT * FROM `product` WHERE `tags` LIKE ? ORDER BY `date` $sort", "%".$tags."%");
										$num_rows = $db->Execute("SELECT COUNT(*) FROM `product` WHERE `tags` LIKE ? ORDER BY `date` $sort", "%".$tags."%");
										$query = "SELECT * FROM `product` WHERE `tags` LIKE ? ORDER BY `date` $sort";
									}
									else //Price
									{
										$Prods = $db->Execute("SELECT * FROM `product` WHERE `tags` LIKE ? ORDER BY `price` $sort", "%".$tags."%");
										$num_rows = $db->Execute("SELECT COUNT(*) FROM `product` WHERE `tags` LIKE ? ORDER BY `price` $sort", "%".$tags."%");
										$query = "SELECT * FROM `product` WHERE `tags` LIKE ? ORDER BY `price` $sort";
									}					
								}
								else
								{
									if($order == "date")
									{
										$Prods = $db->Execute("SELECT * FROM `product` ORDER BY `date` $sort");
										$num_rows = $db->Execute("SELECT COUNT(*) FROM `product` ORDER BY `date` $sort");
										$query = "SELECT * FROM `product` ORDER BY `date` $sort";
									}
									else //Price
									{
										$Prods = $db->Execute("SELECT * FROM `product` ORDER BY `price` $sort");
										$num_rows = $db->Execute("SELECT COUNT(*) FROM `product` ORDER BY `price` $sort");
										$query = "SELECT * FROM `product` ORDER BY `price` $sort";
									}	
								}	
							}
							
							
								$num_rows = $num_rows->fields[0];
								
								if(($num_rows%$RESULTS_LIMIT)<>0)
									$pmax = floor($num_rows / $RESULTS_LIMIT) + 1;
								else
									$pmax = floor($num_rows / $RESULTS_LIMIT);
								
								
								if(isset($needle))
								{
									if(strlen($tags) > 0)
										$newProds = $db->Execute(($query . " LIMIT " . (($pages - 1) * $RESULTS_LIMIT) . ", ?"), "%".$needle."%", "%".$tags."%", $RESULTS_LIMIT);
									else
										$newProds = $db->Execute(($query . " LIMIT " . (($pages - 1) * $RESULTS_LIMIT) . ", ?"), "%".$needle."%", $RESULTS_LIMIT);
								}
								else
								{
									if(strlen($tags) > 0)
										$newProds = $db->Execute(($query . " LIMIT " . (($pages - 1) * $RESULTS_LIMIT) . ", ?"), "%".$tags."%", $RESULTS_LIMIT);
									else
										$newProds = $db->Execute(($query . " LIMIT " . (($pages - 1) * $RESULTS_LIMIT) . ", ?"), $RESULTS_LIMIT);
								}
								$i = 0;
								foreach($newProds as $prod)
								{	
								
									$i++;
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
																<b>City: $city</b>
															</td>
														</tr>
													</table>
												</article>	</a>
												";
								}
								$Prods->close();
								if(isset($_GET["category"]))
									$lCat = "&category=" . Escape($_GET["category"]);
								else
									$lCat = "";
									
								if(isset($_GET["searchText"]))
									$lTxt = "&searchText=" . Escape($_GET["searchText"]);
								else
									$lTxt = "";
								
								if(isset($_GET["order"]))
									$lOrd = "&order=" . Escape($_GET["order"]);
								else
									$lOrd = "";
								
								echo "<center><div class='pagesnav'>";
								if($pages > 1)
								{
									echo "<a href='search.php?page=" . ($pages - 1) . $lCat . $lOrd . $lTxt . "' title='Previous Page'>Previous Page</a>";
								}
								else
								{
									echo "";
								}
								
								$pid = 1;
								while($pid <= $pmax)
								{
									$paging = "<a href='search.php?page=$pid" . $lCat . $lOrd . $lTxt . "' title='Page $pid of $pmax'>$pid</a>";
									$newpaging = str_replace("<a href='search.php?page=$pages" . $lCat . $lOrd . $lTxt . "' title='Page $pages of $pmax'>$pages</a>", "<p>$pages</p>", $paging);
									echo $newpaging;
									
									$pid ++;
								}	
								
								if($pages < $pmax)
								{
									echo "<a href='search.php?page=".($pages+1). $lCat . $lOrd . $lTxt . "' title='Next Page'>Next Page</a>";
								}
								else
								{
									echo "";
								}
								echo "<a href='search.php?page=$pmax" . $lCat . $lOrd . $lTxt . "' title='Last Page'>Last Page</a>";
								echo "</div></center>";
							
							
						?>
					</content>
				</div>
			</div>
		</div>
		<?php include "clean.php"; ?>
	</body>	
</html>