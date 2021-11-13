<?php
	require_once 'connection.php';
	// echo 'ISBN: ' . htmlspecialchars($_GET["isbn"]) . '<br>';
	$isbn = $_GET["isbn"];
	$query = 'select * from review where isbn = "'.$isbn.'";';

	// echo $query.'<br>';

	$response1 = mysqli_query($db, $query);
?>
<!-- screen 4: Book Reviews by Prithviraj Narahari, php coding: Alexander Martens-->
<!DOCTYPE html>
<html>
<head>
<title>Book Reviews - 3-B.com</title>
<style>
.field_set
{
	border-style: inset;
	border-width:4px;
}
</style>
</head>
<body>
	<table align="center" style="border:1px solid blue;">
		<tr>
			<td align="center">
				<h5> Reviews For: <?php echo $_GET["title"]?></h5>
			</td>
			<td align="left">
				<h5> </h5>
			</td>
		</tr>
			
		<tr>
			<td colspan="2">
			<div id="bookdetails" style="overflow:scroll;height:200px;width:300px;border:1px solid black;">
			<table>
				<?php
					if($response1){
						while($row = mysqli_fetch_array($response1)){
							echo '<tr> <td align="left">'.
							$row['Review'].'</td> </tr>';
						}
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
			<td colspan="2" align="center">
				<form action="screen2.php" method="post">
					<input type="submit" value="Done">
				</form>
			</td>
		</tr>
	</table>

</body>

</html>
