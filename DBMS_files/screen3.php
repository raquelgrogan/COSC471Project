
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
	</script>
</head>
<body>
	<table align="center" style="border:1px solid blue;">
		<tr>
			<td align="left">
				
					<h6> <fieldset>Your Shopping Cart has 0 items</fieldset> </h6>
				
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
			<tr><td align='left'><button name='btnCart' id='btnCart' onClick='cart("123441", "", "Array", "all")'>Add to Cart</button></td><td rowspan='2' align='left'>iuhdf</br>By Avi Silberschatz</br><b>Publisher:</b> McGraw-Hill,</br><b>ISBN:</b> 123441</t> <b>Price:</b> 12.99</td></tr><tr><td align='left'><button name='review' id='review' onClick='review("123441", "iuhdf")'>Reviews</button></td></tr><tr><td colspan='2'><p>_______________________________________________</p></td></tr><tr><td align='left'><button name='btnCart' id='btnCart' onClick='cart("978-0316055437", "", "Array", "all")'>Add to Cart</button></td><td rowspan='2' align='left'>title</br>By fname lname</br><b>Publisher:</b> pub,</br><b>ISBN:</b> 978-0316055437</t> <b>Price:</b> 12.99</td></tr><tr><td align='left'><button name='review' id='review' onClick='review("978-0316055437", "title")'>Reviews</button></td></tr><tr><td colspan='2'><p>_______________________________________________</p></td></tr><tr><td align='left'><button name='btnCart' id='btnCart' onClick='cart("978-0345339706", "", "Array", "all")'>Add to Cart</button></td><td rowspan='2' align='left'>Lord of the Rings, The Fellowship of the</br>By J.R.R. Tolkien</br><b>Publisher:</b> Del Rey,</br><b>ISBN:</b> 978-0345339706</t> <b>Price:</b> 8.09</td></tr><tr><td align='left'><button name='review' id='review' onClick='review("978-0345339706", "Lord of the Rings, The Fellowship of the")'>Reviews</button></td></tr><tr><td colspan='2'><p>_______________________________________________</p></td></tr><tr><td align='left'><button name='btnCart' id='btnCart' onClick='cart("978-0590353427", "", "Array", "all")'>Add to Cart</button></td><td rowspan='2' align='left'>Harry Potter and the Sorcerer Stone</br>By J.K. Rowling</br><b>Publisher:</b> Scholastic,</br><b>ISBN:</b> 978-0590353427</t> <b>Price:</b> 8.47</td></tr><tr><td align='left'><button name='review' id='review' onClick='review("978-0590353427", "Harry Potter and the Sorcerer Stone")'>Reviews</button></td></tr><tr><td colspan='2'><p>_______________________________________________</p></td></tr>			</table>
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
