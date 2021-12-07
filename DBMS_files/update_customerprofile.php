<script>alert('Please enter all values')</script><!DOCTYPE HTML>
<?php
require_once 'connection.php';
session_start();

echo $_SESSION["customer"];

if (isset($_POST['update_submit'])) {	
	# Registration Submit button was clicked
	$pin = $_POST['new_pin'];
	$fname = $_POST['firstname'];
	$lname = $_POST['lastname'];
	$address = $_POST['address'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip = $_POST['zip'];
	$cctype = $_POST['credit_card'];
	$ccnumber = $_POST['card_number'];
	$ccexpiration = $_POST['expiration_date'];

	
	$pin = (int)$pin;
	$zip = (int)$zip;
	$ccnumber = (int)$ccnumber;

	//$sql = "INSERT INTO customers VALUES ('$username', $pin, '$fname', '$lname', '$address', '$city', '$state', $zip, '$cctype', $ccnumber, '$ccexpiration');";
	//echo $sql;
	$sql = "UPDATE `customers` SET `Pin`= $pin,`FName`='$fname',`LName`='$lname',`Address`='$address',`City`='$city',`State`='$state',`ZIP`= $zip,`CC_Type`='$cctype',`CC_Num`=$ccnumber,`CC_Exp`='$ccexpiration' 
	WHERE `Username` = '".$_SESSION['customer']."'";
	echo $sql;

	if (mysqli_query($db, $sql)) {
        //echo "New record has been added successfully !";
		//redirect to search page
		header("Location: http://localhost/DBMS_files/confirm_order.php");
		exit();
     } else {
        echo "Error: " . $sql . ":-" . mysqli_error($db); 
	}	
}
	mysqli_close($db);
?>
<head>
	<title>UPDATE CUSTOMER PROFILE</title>

</head>

<body>
	<form id="update_profile" action="" method="post">
		<table align="center" style="border:2px solid blue;">
			<tr>
				<td align="right">
					Username:
				</td>
				<td colspan="3" align="center">
				</td>
			</tr>
			<tr>
				<td align="right">
					New PIN<span style="color:red">*</span>:
				</td>
				<td>
					<input type="text" id="new_pin" name="new_pin">
				</td>
				<td align="right">
					Re-type New PIN<span style="color:red">*</span>:
				</td>
				<td>
					<input type="text" id="retypenew_pin" name="retypenew_pin">
				</td>
			</tr>
			<tr>
				<td align="right">
					First Name<span style="color:red">*</span>:
				</td>
				<td colspan="3">
					<input type="text" id="firstname" name="firstname">
				</td>
			</tr>
			<tr>
				<td align="right">
					Last Name<span style="color:red">*</span>:
				</td>
				<td colspan="3">
					<input type="text" id="lastname" name="lastname">
				</td>
			</tr>
			<tr>
				<td align="right">
					Address<span style="color:red">*</span>:
				</td>
				<td colspan="3">
					<input type="text" id="address" name="address">
				</td>
			</tr>
			<tr>
				<td align="right">
					City<span style="color:red">*</span>:
				</td>
				<td colspan="3">
					<input type="text" id="city" name="city">
				</td>
			</tr>
			<tr>
				<td align="right">
					State<span style="color:red">*</span>:
				</td>
				<td>
					<select id="state" name="state">
						<option selected disabled>select a state</option>
						<option>Michigan</option>
						<option>California</option>
						<option>Tennessee</option>
					</select>
				</td>
				<td align="right">
					Zip<span style="color:red">*</span>:
				</td>
				<td>
					<input type="text" id="zip" name="zip">
				</td>
			</tr>
			<tr>
				<td align="right">
					Credit Card<span style="color:red">*</span>:
				</td>
				<td>
					<select id="credit_card" name="credit_card">
						<option selected disabled>select a card type</option>
						<option>VISA</option>
						<option>MASTER</option>
						<option>DISCOVER</option>
					</select>
				</td>
				<td align="left" colspan="2">
					<input type="text" id="card_number" name="card_number" placeholder="Credit card number">
				</td>
			</tr>
			<tr>
				<td align="right" colspan="2">
					Expiration Date<span style="color:red">*</span>:
				</td>
				<td colspan="2" align="left">
					<input type="text" id="expiration_date" name="expiration_date" placeholder="MM/YY">
				</td>
			</tr>
			<tr>
				<td align="right" colspan="2">
					<input type="submit" id="update_submit" name="update_submit" value="Update">
				</td>
	</form>
	<form id="cancel" action="index.php" method="post">
		<td align="left" colspan="2">
			<input type="submit" id="cancel_submit" name="cancel_submit" value="Cancel">
		</td>
		</tr>
		</table>
	</form>
</body>

</html>