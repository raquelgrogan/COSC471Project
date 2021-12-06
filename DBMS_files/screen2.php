<?php
	//if coming from user_login, customer username is stored in session
	session_start();
	if(isset($_POST["login"])){
		require_once 'connection.php';
		//check if valid username and password
		$username = $_POST["username"];
		$password = $_POST["pin"];
		$query = "SELECT * FROM customers";
		$response = mysqli_query($db, $query);
		$num_rows = mysqli_num_rows($response);

		$validPass = false;
		for ($i = 0; $i < $num_rows; $i++){
			$row = mysqli_fetch_assoc($response);
			if($row["Pin"] == $password  && $row["Username"] == $username){
				$validPass = true;
			}
		}
		if($validPass == false){
			//redirect to user login page and show error message
			echo "<script>alert('Invalid Login!');
			window.location.href='user_login.php';
			</script>";
			exit();
		}else{
			$_SESSION["customer"] = $_POST["username"];
		}
	}
	//if customer does not want to register and has a full shopping cart
	if(isset($_POST['donotregister'])){
		if(isset($_SESSION["cart"])){
			if($_SESSION["cart"] != null){
				//redirect to search screen and show error message
			?>
				<script> alert('In order to proceed with the payment, you need to register first'); </script>
			<?php
			}
		}
	}
?>
<!-- Figure 2: Search Screen by Alexander -->
<html>
<head>
	<title>SEARCH - 3-B.com</title>
</head>
<body>
	<table align="center" style="border:1px solid blue;">
		<tr>
			<td>Search for: </td>
			<form action="screen3.php" method="get">
				<td><input id="searchfor" onkeyup="enable()" name="searchfor" /></td>
				<td><input type="submit" name="search" id="search" value="Search" disabled="disabled"/></td>
				<script>
					// Search button is disabled from the start. Function to enable once some text is entered 
					function enable() {
	 					if(document.getElementById("searchfor").value==="") { 
            				document.getElementById('search').disabled = true; 
        				} else { 
            				document.getElementById('search').disabled = false;
        				}
    				}
				</script>
		</tr>
		<tr>
			<td>Search In: </td>
				<td>
					<select name="searchon[]" multiple>
						<option value="anywhere" selected='selected'>Keyword anywhere</option>
						<option value="title">Title</option>
						<option value="author">Author</option>
						<option value="publisher">Publisher</option>
						<option value="isbn">ISBN</option>				
					</select>
				</td>
				<td><a href="shopping_cart.php"><input type="button" name="manage" value="Manage Shopping Cart" /></a></td>
		</tr>
		<tr>
			<td>Category: </td>
				<td><select name="category">
						<option value='all' selected='selected'>All Categories</option>
						<option value='1'>Fantasy</option><option value='2'>Adventure</option><option value='3'>Fiction</option><option value='4'>Horror</option>				</select></td>
				</form>
	<form action="index.php" method="post">	
				<td><input type="submit" name="exit" value="EXIT 3-B.com" /></td>
			</form>
		</tr>
	</table>
</body>
</html>
