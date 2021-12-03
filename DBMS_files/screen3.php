<?php
	require_once 'connection.php';

	//initialize session for cart
	session_start();

	//create array to hold cart if the session is set
	if (!isset($_SESSION['cart'])) {
		$_SESSION["cart"] = array();
	}
	
	//if customer is not set, set it equal to unknown
	if (!isset($_SESSION['customer'])) {
		$_SESSION["customer"] = "unknown";
		//echo "Customer is not set, set to: ".$_SESSION["customer"]." <br>";
	}

	//grab elements from post
	$searchFor = $_GET["searchfor"];
	$searchOn = $_GET["searchon"];
	$category = $_GET["category"];

	//echo gettype($searchOn);
	//After Add to Cart is pressed, searchon becomes a string, this converts it back to php array
	if(gettype($searchOn) == 'string'){
		$searchOn = explode(" ",$searchOn);
	}

	//echo "category: $category <br>";


	if (isset($_GET['cartisbn'])) {
		array_push($_SESSION["cart"],$_GET['cartisbn']);
		print_r($_SESSION["cart"]);
	}//else {echo "There is no cart";}
	//echo "<br>";

	//make searchfor an array to allow query making
	$searchForArr = explode (",", $searchFor); 
	//print_r($searchForArr); echo "<br>";
	
	//print_r($searchOn); echo "<br>";
	$searchOnStr = implode(" ",$searchOn);
	//creating query
	$query = "SELECT `ISBN`, `Title`, `Author`, `Publisher`, `Category`, `Price`, `Quantity` FROM `book` WHERE (";
	if($searchOnStr == 'anywhere'){
		foreach($searchForArr as $keyword){
			$query .= "Title LIKE '%$keyword%' OR Author LIKE '%$keyword%' OR Publisher LIKE '%$keyword%' OR ISBN LIKE '%$keyword%'";
			$query .= " OR ";
		}
		$query = rtrim($query,' OR ');
	}
	else{
		foreach($searchOn as $categoryType){
			foreach($searchForArr as $keyword)
				$query .= " $categoryType LIKE '%$keyword%' OR";
		}
		$query = rtrim($query,' OR'); //remove last "OR"
	}
	$query .= ")";
	if($category != "all"){
		//add AND statements to query, 1=Fantasy 2=Adventure 3=Fiction 4=Horror
		switch ($category) {
			case '1':
				$query .= " AND Category = 'Fantasy'";
				break;
			case '2':
				$query .= " AND Category = 'Adventure'";
				break;
			case '3':
				$query .= " AND Category = 'Fiction'";
				break;
			case '4':
				$query .= " AND Category = 'Horror'";
				break;
			default:
				break;
		}
	}
	$query .= ";";
	//echo $query.'<br>';

	$response1 = mysqli_query($db, $query);
	//session_unset(); //unset session variables
?>
<!-- Figure 3: Search Result Screen by Prithviraj Narahari, php coding: Alexander Martens -->
<html>
<head>
	<title> Search Result - 3-B.com </title>
	<script>
	//redirect to reviews page
	function review(isbn, title){
		window.location.href="screen4.php?isbn="+ isbn + "&title=" + title;
	}
	//add to cart
	function cart(isbn, searchfor, searchon, category){
		window.location.href="screen3.php?cartisbn="+ isbn + "&searchfor=" + searchfor + "&searchon=" + searchon + "&category=" + category;
	}
	//disable button
	function disableButton(isbn){
		document.getElementById("btnCart"+isbn).disabled = true;
	}
	</script>
</head>
<body>
	<table align="center" style="border:1px solid blue;">
		<tr>
			<td align="left">
				
					<h6> <fieldset>Your Shopping Cart has <?php echo count($_SESSION["cart"]); echo " "; ?> items</fieldset> </h6>
				
			</td>
			<td>
				&nbsp
			</td>
			<td align="right">
				<form action="shopping_cart.php" method="post">
					<input type="submit" value="Manage Shopping Cart">
				</form>
			</td>
		</tr>	
		<tr>
		<td style="width: 350px" colspan="3" align="center">
			<div id="bookdetails" style="overflow:scroll;height:180px;width:400px;border:1px solid black;background-color:LightBlue">
			<table>
				<?php 
					if($response1){
						while($row = mysqli_fetch_array($response1)){ ?>
							<tr><td align='left'><button name='btnCart' id='btnCart<?php echo $row["ISBN"]?>' onClick='cart("<?php echo $row['ISBN'] ?>", "<?php echo $searchFor ?>", "<?php echo implode(" ",$searchOn); ?>", "<?php echo $category ?>");'>Add to Cart</button></td>
							<td rowspan='2' align='left'>"<?php echo $row['Title']?>"</br>
							By <?php echo $row['Author'] ?></br>
							<b>Publisher: </b><?php echo $row['Publisher'] ?></br>
							<b>ISBN:</b><?php echo $row['ISBN'] ?></t> <b>Price:</b><?php echo $row['Price'] ?></td></tr>
							<tr>
								<td align='left'><button name='review' id='review' onClick='review("<?php echo $row['ISBN'] ?>", "<?php echo $row['Title'] ?>")'>Reviews</button></td>
							</tr>
							<tr><td colspan='2'><p>_______________________________________________</p></td></tr>
						<?php }
					}
					else {
						echo "Couldn't run database query";
						echo msqli_error($db);
					}
					mysqli_close($db);
				?>	
			</table>
			</div>
			
			</td>
		</tr>
		<tr>
			<td align= "center">
				<form action="confirm_order.php" method="get">
					<input type="submit" value="Proceed To Checkout" id="checkout" name="checkout">
				</form>
			</td>
			<td align="center">
				<form action="screen2.php" method="post">
					<input type="submit" value="New Search">
				</form>
			</td>
			<td align="center">
				<form action="index.php" method="post">
					<input type="submit" name="exit" value="EXIT 3-B.com">
				</form>
			</td>
		</tr>
	</table>
</body>
</html>
