<?php
    $mysqli = new mysqli ("localhost", "keenan","yes", "MasteringCS");
    if ($mysqli->connect_errno) { // Check connection
        echo "Failed to connect to MySQL: " . $mysqli->connect_errno;
        exit;
    }

    // Create query
    $FirstName = $_POST['First_name'];
    $LastName = $_POST['Last_name'];
    $CourseID = (int)$_POST['Course_ID'];
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];



    $sql = "insert into Students
            (First_name, Last_name, Course_ID, Password, Username)
            values
            ('$FirstName', '$LastName', $CourseID, '$Password', '$Username');";



if (mysqli_query($mysqli, $sql)) {
    echo "<h1 align='center'>You have been added!</h1>";}
    echo"<br>";


echo"
<form action=\"Login_Page.html\" method=\"post\" align='center'>
    Continue to login page:
    <input type=\"submit\" name=\"sign_up\" value=\"Login!\">

</form>


";

    $mysqli -> close();


?>