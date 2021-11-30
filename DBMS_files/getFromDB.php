<?php

require_once 'connection.php';

$queryUser = 'select * from userprofile;';
$queryRoom = 'select * from rooms;';

$response1 = mysqli_query($db, $queryUser);
$response2 = mysqli_query($db, $queryRoom);

if($response1){
    echo '<table align="left" cellspacing="5" cellpadding="8">
    <tr>
        <td align="left"><b>ID</b></td>
        <td align="left"><b>First Name</b></td>
        <td align="left"><b>Last Name</b></td>
        <td align="left"><b>RoomID</b></td>
    </tr>';
    while($row = mysqli_fetch_array($response1)){
        echo '<tr> <td align="left">'.
        $row['ID'].'</td> <td align="left">'.
        $row['FName'].'</td> <td align="left">'.
        $row['LName'].'</td> <td align="left">'.
        $row['RoomID'].'</td> </tr>';
    }

    echo '</table>';
} else {
    echo "Couldn't run database query";
    echo msqli_error($db);
}

if($response2){
    echo '<table align="center" cellspacing="5" cellpadding="8">
    <tr>
        <td align="left"><b>ID</b></td>
        <td align="left"><b>Size</b></td>
        <td align="left"><b>Beds</b></td>
        <td align="left"><b>Bathrooms</b></td>
    </tr>';
    while($row = mysqli_fetch_array($response2)){
        echo '<tr> <td align="left">'.
        $row['ID'].'</td> <td align="left">'.
        $row['size'].'</td> <td align="left">'.
        $row['beds'].'</td> <td align="left">'.
        $row['bathrooms'].'</td> </tr>';
    }

    echo '</table>';
} else {
    echo "Couldn't run database query";
    echo msqli_error($db);
}

mysqli_close($db);

?>