<?php

$server = 'localhost'; //change to ip address
$user = 'root'; 
$password = ''; //blank for xampp cosc471database for google
$dbName = 'cosc471'; //name of database youre using

$db = new mysqli($server, $user, $password, $dbName) or die("Unable to connect"); //create the connection

// echo "Connection.php has not died yet!";

?>