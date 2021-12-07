<?php
	session_start();
	require_once 'connection.php';
	print_r($_SESSION["cart"]); echo "<br>";
	if(isset($_SESSION["qtyCart"])){
		print_r($_SESSION["qtyCart"]); echo "<br>";
	}
	//handle proceeding to checkout
	if($_SESSION["customer"] == "unknown"){
		//redirect to registration screen
		header("Location: http://localhost/DBMS_files/customer_registration.php");
		exit();
	}else{
		//proceed to checkout as normal
		echo $_SESSION["customer"];
	}

	$query = "SELECT * FROM `customers` WHERE Username = '".$_SESSION["customer"]."'";
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

	
?>
<!DOCTYPE HTML>
<head>
	<title>CONFIRM ORDER</title>
	<header align="center">Confirm Order</header> 
</head>
<body>
	<table align="center" style="border:2px solid blue;">
	<form id="buy" action="proof_purchase.php" method="post">
	<tr>
	<td>
	Shipping Address: <?php echo $address?>
	</td>
	</tr>
	<td colspan="2">
	<?php echo $firstname?> <?php echo $lastname?>	</td>
	<td rowspan="3" colspan="2">
		<input type="radio" name="cardgroup" value="profile_card" checked>Use Credit card on file<br /><?php echo $cardType?> - <?php echo $cardNumber?> - <?php echo $cardExp?><br />
		<input type="radio" name="cardgroup" value="new_card">New Credit Card<br />
				<select id="credit_card" name="credit_card">
					<option selected disabled>select a card type</option>
					<option>VISA</option>
					<option>MASTER</option>
					<option>DISCOVER</option>
				</select>
				<input type="text" id="card_number" name="card_number" placeholder="Credit card number">
				<br />Exp date<input type="text" id="card_expiration" name="card_expiration" placeholder="mm/yyyy">
	</td>
	<tr>
	<td colspan="2">
	<?php echo $address?>	</td>		
	</tr>
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
					$subTotal += $row['Price']* (int) implode($_SESSION['qtyCart'][$isbn]);
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
