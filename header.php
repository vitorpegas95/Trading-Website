<div class='headerContainer'>
	<header>
		<div class="right">
			<div class="nav">
				<?php if($auth->signedIn()): ?>
					<a style='max-width: 200px;' href='account.php'><?php
						$userID = getUserInfo($db, $_SESSION["username"]);
						$userID = $userID[0];
						$numMsg = $db->Execute("SELECT COUNT(*) FROM `messages` WHERE `receiver`=?", $userID);
						$numMsg = $numMsg->fields[0];
						if(strlen($_SESSION['username']) > 8)
							echo "<span style='font-size: 13px;'>" . $_SESSION['username'] . " ( $numMsg )</span>";
						else
							echo "" . $_SESSION['username'] . " ( $numMsg )";
					?></a>
					<a href='about.php'>About</a>
					<a href='products.php?my=1'>My Products</a>
					<a href='products.php'>All Products</a>
					<a href='logout.php'>Logout</a>
				<?php else: ?>
					<a href='register.php'>Sign Up</a>
					<a href='about.php'>About</a>
					<a href='products.php'>Products</a>
				<?php endif; ?>
			</div>
			
			<div class="search">
				<form method="GET" action="search.php">
					<?php
						if(isset($_GET["category"]))
						{
							echo "<input type='text' onchange='changeValue(this.value)' autocomplete='off' name='tags' class='searchBar'>";
							echo "<input type='hidden' name='category' value='" . Escape($_GET["category"]) . "'/>";
							echo "<input type='hidden' name='searchText' value='" . Escape($_GET["searchText"]) . "'/>";
							?>
							<select id="category">
								<option id="tag">Tags</option>
							</select>
							<?php
						}
						else
						{
					?>
					<input type='text' onchange='changeValue(this.value)' autocomplete='off' name='searchText' class='searchBar'>
					<select id="category" name="category">
						<option value="name">Name</option>
						<option value="city">City</option>
					</select>
					
					<?php
						}
					?>
				</form>
			</div>
		</div>
		
		<div class="left">
			<a href='index.php' style='font-size: 30px; padding-top: 5px;'><?php echo $SITE_NAME; ?></a>
		</div>

	</header>
</div>



<div class="social">
	<a href="#social" id="arrowLeft" style="position: fixed; right: 10px;"><img style="width: 32px; height: 32px;" src="img/arrow-left.png" alt=""/></a>



	<a href="#facebook"><img src="img/Facebook-icon.png" alt="Facebook" title="Facebook" /></a>
	<a href="#twitter"><img src="img/Twitter-icon.png" alt="Twitter" title="Twitter" /></a>
	<a href="#google"><img src="img/Google-Plus-icon.png" alt="Google+" title="Google+" /></a>
</div>
<?php
	include "facebookSDK.php";
?>