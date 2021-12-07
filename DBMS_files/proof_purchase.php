<?php
	session_start();
	require_once 'connection.php';
	if(isset($_POST["btnbuyit"])){
		date_default_timezone_set("America/New_York"); 
		$time = date("h:i:s"); 
		$date = date("m/d/Y"); 
		echo $time."<br>";
		echo $date;
		$total = $_SESSION["total"];
		$username = $_SESSION["customer"];
		
		foreach ($_SESSION['cart'] as $isbn){
			$partialTotal = 0;
			$bookQuery = "SELECT `ISBN`, `Price` FROM `book` WHERE ISBN = '$isbn'";
			$response2 = mysqli_query($db, $bookQuery);
			while ($row = mysqli_fetch_array($response2)) {
				$partialTotal = $row["Price"] * (int) implode($_SESSION['qtyCart'][$isbn]);
			}
			
			$query = "INSERT INTO `purchases`(`time`, `totalPrice`, `ISBN`, `Username`, `Date`, `Quantity`) 
			VALUES ('".date("h:i:s")."','$partialTotal','$isbn','$username','$date',".(int) implode($_SESSION['qtyCart'][$isbn]).");";
			echo $query."<br>";
			if (mysqli_query($db, $query)) {
				echo "New purchase has been added successfully !";		
			} else {
				echo "Error: " . $query . ":-" . mysqli_error($db); 
			}
		}

		$query = "SELECT * FROM `customers` WHERE Username = '".$username."'";
		echo $query;
		$response1 = mysqli_query($db, $query);
		if ($response1) {
			while ($row = mysqli_fetch_array($response1)) {
				$firstname = $row["FName"];
				$lastname = $row["LName"];
				$address = $row["Address"];
				$city = $row["City"];
				$state = $row["State"];
				$zip = $row["ZIP"];
				$cardType = $row["CC_Type"];
				$cardNumber = $row["CC_Num"];
				$cardExp = $row["CC_Exp"];
			}
	}
			
	}
?>
<!DOCTYPE HTML>
<head>
	<title>Proof purchase</title>
	<header align="center">Proof purchase</header> 
</head>
<body>
	<table align="center" style="border:2px solid blue;">
	<form id="buy" action="" method="post">
	<tr>
	<td>
	Shipping Address: <?php echo $address?>
	</td>
	</tr>
	<td colspan="2">
	<?php echo $firstname?> <?php echo $lastname?>	</td>
	<td rowspan="3" colspan="2">
		<b>UserID:</b><?php echo $username?><br />
		<b>Date:</b><?php echo $date?><br />
		<b>Time:</b><?php echo $time?><br />
		<b>Card Info:</b><?php echo $cardType?><br /><?php echo $cardExp?>- <?php echo $cardNumber?>	</td>
	<tr>
	<td colspan="2">
		<?php echo $city?>	</td>		
	</tr>
	<tr>
	<td colspan="2">
	<?php echo $state?>, <?php echo $zip?>	</td>
	</tr>
	<tr>
	<td colspan="3" align="center">
	<div id="bookdetails" style="overflow:scroll;height:180px;width:520px;border:1px solid black;">
	<table border='1'>
		<th>Book Description</th><th>Qty</th><th>Price</th>
		<?php
			$subTotal = 0;
			foreach ($_SESSION['cart'] as $isbn){
				$query = "SELECT `ISBN`, `Title`, `Author`, `Publisher`, `Category`, `Price`, `Quantity` FROM `book` WHERE `ISBN` = '".$isbn."'";
				//echo $query;
				$response1 = mysqli_query($db, $query);
				while ($row = mysqli_fetch_array($response1)) {
				?>
				<tr>
					<td><?php echo $row["Title"]?></br>
					<b>By</b> <?php echo $row["Author"]?></br>
					<b>Publisher:</b> <?php echo $row["Publisher"]?></td>
					<td><?php echo implode($_SESSION['qtyCart'][$isbn]) ?></td>
					<td>$<?php echo $row["Price"]?></td>
				</tr>	
				<?php
					$subTotal += $row['Price'] * (int) implode($_SESSION['qtyCart'][$isbn]);
				}
			}
			$_SESSION["total"] = $subTotal;
		?>
	</table>
	</div>
	</td>
	</tr>
	<tr>
	<td align="left" colspan="2">
	<div id="bookdetails" style="overflow:scroll;height:180px;width:260px;border:1px solid black;background-color:LightBlue">
	<b>Shipping Note:</b> The book will be </br>delivered within 5</br>business days.
	</div>
	</td>
	<td align="right">
	<div id="bookdetails" style="overflow:scroll;height:180px;width:260px;border:1px solid black;">
		SubTotal: $<?php echo $subTotal?></br>Shipping_Handling:$2</br>_______</br>Total: $<?php echo $subTotal+2?>	</div>
	</td>
	</tr>
	<tr>
		<td align="right">
			<input type="submit" id="buyit" name="btnbuyit" value="BUY IT!">
		</td>
		</form>
		<td align="right">
			<form id="update" action="update_customerprofile.php" method="post">
			<input type="submit" id="update_customerprofile" name="update_customerprofile" value="Update Customer Profile">
			</form>
		</td>
		<td align="left">
			<form id="cancel" action="index.php" method="post">
			<input type="submit" id="cancel" name="cancel" value="Cancel">
			</form>
		</td>
	</tr>
	</table>
</body>
</HTML>
