<?php
include "config/config.php";

	if(isset($_POST["rating"]))
	{
		$rated = Escape($_POST["rated"]);
		$rater = Escape($_POST["rater"]);
		$rating = Escape($_POST["rating"]);
		
		if($rater != $rated)
		{
			$isDuplicate = false;
			$duplicate = $db->Execute("SELECT * FROM `rating` WHERE `rated`=? AND `rater`=?", $rated, $rater);
			foreach($duplicate as $d)
			{
				$rID = $d->id;
				$isDuplicate = true;
			}
			
			if($isDuplicate == false)
				$db->Execute("INSERT INTO `rating`(`rater`, `rated`, `rating`) VALUES (?, ?, ?)", $rater, $rated, $rating);
			else
				$db->Execute("UPDATE `rating` SET `rating`=? WHERE `id`=?", $rating, $rID);
			
			Redirect("products.php?id=" . Escape($_POST["prodID"]));
		}
		else
		{
			Redirect("products.php?id=" . Escape($_POST["prodID"]));
		}
	}
	else
	{
		Redirect("index.php");
	}
?>