<html>
    <head>
        <title>Add User and Room Data</title>
    </head>

    <body>

    <?php
    //User Submit
        if(isset($_POST['submitUser'])){
            $data_missing = array();
                if(empty($_POST['first_name'])){
                    // Adds name to array
                    $data_missing[] = 'First Name';
                } else {
                    // Trim white space from the name and store the name
                    $f_name = trim($_POST['first_name']);
                }
                if(empty($_POST['last_name'])){
                    $data_missing[] = 'Last Name';
                } else {
                    $l_name = trim($_POST['last_name']);
                }
                if(empty($_POST['room_id'])){
                    $data_missing[] = 'Room ID';
                } else {
                    $room_no = trim($_POST['room_id']);
                }

                if(empty($data_missing)){
                    require_once('connection.php');
                     $query = "INSERT INTO userprofile (FName, LName, RoomID)
                     VALUES (?,?,?);";

                     $stmt = mysqli_prepare($db, $query);
                     
                     //i Integers
                     //s Everything Else

                     mysqli_stmt_bind_param($stmt, "ssi", $f_name, $l_name, $room_no);

                     mysqli_stmt_execute($stmt);

                     $affected_rows = mysqli_stmt_affected_rows($stmt);
                     echo "<br /> Affected Rows: $affected_rows <br/>";

                     if($affected_rows == 1){
                         echo "User Entered";
                         mysqli_stmt_close($stmt);
                         mysqli_close($db);
                     }
                     else {
                         echo "Error Occured<br />";
                         echo mysqli_error($db);

                         mysqli_stmt_close($stmt);
                         mysqli_close($db);
                     }
                }
            else {
                echo 'You need to enter the following data<br />';
                foreach($data_missing as $missing){
                    echo "$missing<br />";
                }
            }
        }
    //Room Submit
    if(isset($_POST['submitRoom'])){
        $data_missing = array();
            if(empty($_POST['size'])){
                // Adds name to array
                $data_missing[] = 'Size';
            } else {
                // Trim white space from the name and store the name
                $size = trim($_POST['size']);
            }
            if(empty($_POST['beds'])){
                $data_missing[] = 'Beds';
            } else {
                $beds = trim($_POST['beds']);
            }
            if(empty($_POST['bathrooms'])){
                $data_missing[] = 'Bathrooms';
            } else {
                $bathrooms = trim($_POST['bathrooms']);
            }

            if(empty($data_missing)){
                require_once('connection.php');
                 $query = "INSERT INTO rooms (size, beds, bathrooms)
                 VALUES (?,?,?)";

                 $stmt = mysqli_prepare($db, $query);

                 //i Integers
                 //s Everything Else

                 mysqli_stmt_bind_param($stmt, "sii", $size, $beds, $bathrooms);

                 mysqli_stmt_execute($stmt);

                 $affected_rows = mysqli_stmt_affected_rows($stmt);
                 echo "<br /> Affected Rows: $affected_rows <br/>";

                 if($affected_rows == 1){
                     echo "Room Entered";
                     mysqli_stmt_close($stmt);
                     mysqli_close($db);
                 }
                 else {
                     echo "Error Occured<br />";
                     echo mysqli_error($db);

                     mysqli_stmt_close($stmt);
                     mysqli_close($db);
                 }
            }
        else {
            echo 'You need to enter the following data<br />';
            foreach($data_missing as $missing){
                echo "$missing<br />";
            }
        }
    }
    ?>

    <form action="http://localhost/DBMS_files/addToDB.php" method="post">

        <b>Add a new user</b>
        <p> First Name:
            <input type="text" name="first_name" size="20" value="">
        </p>
        <p> Last Name:
            <input type="text" name="last_name" size="20" value="">
        </p>
        <p> Room ID:
            <input type="number" name="room_id" min="1" max="5" value="">
        </p>
        
        <p>
            <input type="submit" name="submitUser" value="Send">
        </p>

        <b>Add a new room</b>
        <p> Size:
            <input type="text" name="size" size="20" value="">
        </p>
        <p> Beds:
            <input type="number" name="beds" min="1" max="5" value="">
        </p>
        <p> Bathrooms:
            <input type="number" name="bathrooms" min="1" max="5" value="">
        </p>
        
        <p>
            <input type="submit" name="submitRoom" value="Send">
        </p>


    </body>
</html>