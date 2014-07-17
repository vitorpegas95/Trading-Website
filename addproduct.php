<?php
	include "config/config.php";
	
	if(isset($_POST["name"]))
	{
		if(isset($_FILES['file']))
		{
			$file = $_FILES['file'];
			
			$file_name = $file['name'];
			$file_tmp = $file['tmp_name'];
			$file_size = $file['size'];
		}
		else
		{
			$file = "";
		}	
		
		$file_ext = explode('.', $file_name);
		$file_ext = strtolower(end($file_ext));
		
		$allowed = array('jpg', 'png', 'gif');
		$file_is_good = false;
		if(in_array($file_ext, $allowed))
		{
			if($file_size <= $MAX_SIZE)
			{
				$file_name_new = uniqid('', true . '.' . $file_ext);
				$file_destination = 'uploads/images/' . $file_name_new. '.' . $file_ext;
				
				if(move_uploaded_file($file_tmp, $file_destination))
				{
					$file_is_good = true;
				}
			}
		}
	
		$userInfo = $db->Execute("SELECT * FROM `accounts` WHERE username=?", Escape($_SESSION['username']));
		foreach($userInfo as $info)
		{
			$Id = $info->id;
		}
		$userInfo->Close();
	
		$name = Escape($_POST["name"]);
		$desc = nl2br(Escape($_POST["desc"]));
		$price = Escape($_POST["price"]);
		$tags = Escape($_POST["tags"]);
		$city = Escape($_POST["city"]);
		$category = Escape($_POST["category"]);
		
		if($file_is_good)
			$file_url = $file_destination;
		else
			$file_url = "img/product.png";
		
		$db->Execute("INSERT INTO `product`(`name`, `description`, `price`, `owner`, `tags`, `city`, `img`, `category`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", 
					$name, $desc, $price, $Id, $tags, $city, $file_url, $category);
		
		Redirect("products.php?my=1");
	}
	else
	{
		Redirect("products.php");
	}
?>