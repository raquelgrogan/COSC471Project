<?php
	session_start();
	require_once 'connection.php';

	//print_r($_SESSION["cart"]);
	//echo "<br>";

	if (isset($_GET['delIsbn'])) {
		$delIsbn = $_GET['delIsbn'];
		$_SESSION["cart"]=array_diff($_SESSION["cart"],(array)$delIsbn);
	}
	
	if(isset($_SESSION["cart"])){
		$cartArr = $_SESSION["cart"];
	}else {
		$cartArr = [];
	}
	if(isset($_POST['recalculate_payment'])) {
		$queryCart = "SELECT `ISBN`, `Title`, `Quantity` FROM book WHERE ISBN IN (";
		foreach($cartArr as $isbn){
			$queryCart .= "$isbn, ";
		}
		$queryCart = rtrim($queryCart,', '); //remove last comma
		$queryCart .= ");";
		echo $queryCart;
		
		$response2 = mysqli_query($db, $queryCart);
		$i = 0;
		if($response2){
			while($row = mysqli_fetch_array($response2)){
				$qtyStr = "quantity".$i;
				if($row['Quantity'] < $_POST[$qtyStr]){
					echo '<script type="text/javascript">';
					echo ' alert("Quantity for '.$row['Title'].' is too large, there is only '.$row['Quantity'].' books")'; 
					echo '</script>';
				}
				$i += 1;
			}
		}

		$_POST['recalculate_payment'] = ""; //reset button so isset is not always true
	}

	

	$query = "SELECT * FROM book WHERE ISBN IN (";
	foreach($cartArr as $isbn){
		$query .= "$isbn, ";
	}
	$query = rtrim($query,', '); //remove last comma
	$query .= ");";
	echo $query. "<br>";
	if(isset($_SESSION["cart"])){
		if($_SESSION["cart"] != null){
			$response1 = mysqli_query($db, $query);
		}
	}	
	
	//Subtotal
	$subTotal = 0.0;
?>
<!DOCTYPE HTML>
<head>
	<title>Shopping Cart</title>
	<script>
	//remove from cart
	function del(isbn){
		window.location.href="shopping_cart.php?delIsbn="+ isbn;
	}
	</script>
</head>
<body>
	<table align="center" style="border:2px solid blue;">
		<tr>
			<td align="center">
				<form id="checkout" action="confirm_order.php" method="get">
					<input type="submit" name="checkout_submit" id="checkout_submit" value="Proceed to Checkout">
				</form>
			</td>
			<td align="center">
				<form id="new_search" action="screen2.php" method="post">
					<input type="submit" name="search" id="search" value="New Search">
				</form>								
			</td>
			<td align="center">
				<form id="exit" action="index.php" method="post">
					<input type="submit" name="exit" id="exit" value="EXIT 3-B.com">
				</form>					
			</td>
		</tr>
		<tr>
				<form id="recalculate" name="recalculate" action="" method="post">
			<td  colspan="3">
				<div id="bookdetails" style="overflow:scroll;height:180px;width:400px;border:1px solid black;">
					<table align="center" BORDER="2" CELLPADDING="2" CELLSPACING="2" WIDTH="100%">
						<?php 
						$index = 0;
						if(isset($_SESSION["cart"])){
							if($_SESSION["cart"] != null){
								if($response1){
									while($row = mysqli_fetch_array($response1)){ ?>
									<th width='10%'>Remove</th><th width='60%'>Book Description</th>
									<th width='10%'>Qty</th><th width='10%'>Price</th>
									<tr>
										<td><button name='delete' id='delete' onClick='del("<?php echo $row['ISBN']?>");return false;'>Delete Item</button></td>
										<td><?php echo $row['Title'] ?></br>
										<b>By</b> <?php echo $row['Author'] ?></br>
										<b>Publisher:</b><?php echo $row['Publisher'] ?></td>
										<td><input id='quantity<?php echo $index?>' name='quantity<?php echo $index?>' value='1' size='1' /></td>
										<td><?php echo $row['Price'] ?></td>
									</tr>
									<?php
										
										if(isset($_POST['recalculate_payment'])) {
											$qIndex = "quantity".$index;
											$subTotal += $row['Price']*$_POST[$qIndex];
										}else{
											$subTotal += $row['Price'];
										}
										$index += 1;
									}
								}
								else {
									echo "Couldn't run database query";
									echo msqli_error($db);
								}
								mysqli_close($db);
							}
						}
					?>	
					</table>
				</div>
			</td>
		</tr>
		<tr>
			<td align="center">				
					<input type="submit" name="recalculate_payment" id="recalculate_payment" value="Recalculate Payment">
				</form>
			</td>
			<td align="center">
				&nbsp;
			</td>
			<td align="center">			
				Subtotal:  $<?php echo $subTotal?>			</td>
		</tr>
	</table>
</body>
