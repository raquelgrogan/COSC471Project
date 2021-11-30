<?php

$server = 'localhost';
$user = 'rgrogan'; 
$password = 'cosc471database';
$dbName = 'cosc471'; //name of database youre using

$db = new mysqli($server, $user, $password, $dbName) or die("Unable to connect"); //create the connection

 echo "Connection.php has not died yet!";

?>