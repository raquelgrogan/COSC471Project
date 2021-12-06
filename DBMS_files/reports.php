<?php
    require_once 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
<title>Reports</title>
<style>
	body {text-align: center;}
    table {
		width: 50%;
	}
    table, th, td {
	  border: 1px solid black;
	  border-collapse: collapse;
	  font-size: 15px;
	  margin: auto;
	}
	th,td {
		padding: 5px;
		text-align: center;
	}
</style>
</head>

<body>
<h1>Number of Customers</h1>
<?php
    //Report 1: Number of Customers 
    $query = "SELECT count(Username) AS numOfCust FROM `customers`";
    $result = mysqli_query($db, $query);
    $num_rows = mysqli_num_rows($result);
    echo "<table>
    <tr>
        <th>Number of Customers</th>
    </tr>";
    for($i = 0; $i < $num_rows; $i++){
        $row = mysqli_fetch_assoc($result);
        echo "<tr>
        <td>".$row["numOfCust"]."</td>
        </tr>";
    }
    echo "</table>";
?>
<h1>Number of Books per Category</h1>
<?php   //Report 2: Total number of book titles available in each category, in descending order.
    $query = "SELECT count(Title) AS titleCount, Category FROM book GROUP BY Category";
    $result = mysqli_query($db, $query);
    $num_rows = mysqli_num_rows($result);
    echo "<table>
    <tr>
        <th>Category</th>
        <th>Number of Books</th>  
    </tr>";
    for($i = 0; $i < $num_rows; $i++){
        $row = mysqli_fetch_assoc($result);
        echo "<tr>
        <td>".$row["Category"]."</td>
        <td>".$row["titleCount"]."</td>
        </tr>";
    }
    echo "</table>";
?>
<h1>Average Monthly Sales</h1>
<?php    //Report 3: Average monthly sales, in dollars, for the current year, ordered by month.
    //select avg(totalPrice) from purchases group by Date order by Date
    $query = "SELECT MONTH(STR_TO_DATE(Date, '%m/%d/%Y')) AS Month, AVG(totalPrice) AS AvgTotal FROM `purchases` GROUP BY MONTH(STR_TO_DATE(Date, '%m/%d/%Y')) ORDER BY MONTH(STR_TO_DATE(Date, '%m/%d/%Y'));";
    $result = mysqli_query($db, $query);
    $num_rows = mysqli_num_rows($result);
    echo "<table>
    <tr>
        <th>Month</th>
        <th>Average Monthly Total</th>  
    </tr>";
    for($i = 0; $i < $num_rows; $i++){
        $row = mysqli_fetch_assoc($result);
        echo "<tr>
        <td>".$row["Month"]."</td>
        <td>$".$row["AvgTotal"]."</td>
        </tr>";
    }
    echo "</table>";

?>
<h1>Number of Reviews per Book</h1>
<?php    //Report 4: All book titles and the number of reviews for that book.
    $query = "SELECT count(A.Review) AS revCount, B.Title FROM `review` A INNER JOIN `book` B ON A.ISBN = B.ISBN GROUP BY B.Title;";
    $result = mysqli_query($db, $query);
    $num_rows = mysqli_num_rows($result);
    echo "<table>
    <tr>
        <th>Title</th>
        <th>Number of Reviews</th>  
    </tr>";
    for($i = 0; $i < $num_rows; $i++){
        $row = mysqli_fetch_assoc($result);
        echo "<tr>
        <td>".$row["Title"]."</td>
        <td>".$row["revCount"]."</td>
        </tr>";
    }
    echo "</table>";
?>

</body>


</html>