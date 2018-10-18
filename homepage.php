<!DOCTYPE html>
<html>
<head>
    <style>
        td, th	{ border:1px solid gray;
            padding:5px; }
    </style>
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb"
          crossorigin="anonymous">
</head>
<body>

<?php
#This page is used to load the homepage of the user, it checks their status in the database based on the number of thier id

#Sets the values of the username and the password from the previous page
$Username = $_POST['username'];
$Password = $_POST['password'];

#connects to the database and sends an error message if not
$mysqli = new mysqli ("localhost", "keenan","yes", "MasteringCS");
if ($mysqli->connect_errno) { // Check connection
    echo "Failed to connect to MySQL: " . $mysqli->connect_errno;
    exit;
}

//Makes a variable to check for if someone with this password works or not
$well = "no";

//Checking for students with that username and password
$query_students = "select * from Students where Username='$Username' and Password='$Password'";

//THIS IS THE CODE TO CHECK THE NUMBER OF LINES IN A QUERY RESULT
if ($stmt = $mysqli->prepare($query_students)) {

    /* execute query */
    $stmt->execute();

    /* store result */
    $stmt->store_result();

    if(($stmt->num_rows) == 0 ){
    }
    if(($stmt->num_rows) > 0){
        $well = "yes";
        // get the Student's courses
        $query_st_info = $mysqli->prepare("select Course_ID from Students where Username='$Username' and Password='$Password'");
        $query_st_info->execute();
        $query_st_info->bind_result($St_id);

        $St_id_var = array();
        $co=0;
        while($query_st_info->fetch()){
            $St_id_var[$co] = $St_id;
            $co++;
        }
            for ($i=0;$i<sizeof($St_id_var);$i++) {
                $query_c_info = $mysqli->prepare("select Course_abb, Course_number, Course_ID, Section from Courses where Course_ID ='$St_id_var[$i]'");
                $query_c_info->execute();
                $query_c_info->bind_result($c_abb, $c_num, $c_ID, $c_sec);
                $array_c_abb = array();
                $array_c_num = array();
                $array_c_ID = array();
                $array_c_sec = array();
                $j = 0;
                while ($query_c_info->fetch()) {
                    $array_c_abb[$j] = $c_abb;
                    $array_c_num[$j] = $c_num;
                    $array_c_ID[$j] = $c_ID;
                    $array_c_sec[$j] = $c_sec;
                    $j++;
                }
            }
        $well = "yes";
        echo"<br>
        <br>
        <h1 align='center'>Welcome! Continue to Student homepage:</h1>";
        echo '<table align="center">' . "\n";
        echo '<tr><th align="center">Course</th><th align="center">Link to that page</th>';
        for ($i=0;$i<sizeof($array_c_abb);$i++) {


            echo '<tr>';
            $course = $array_c_abb[$i] . " " . $array_c_num[$i] . " " . $array_c_sec[$i];
            echo '<td>' . $course . '</td><td>' . "  
        <form action='student_homepage.php' method='post' align='center'>
        <input type='hidden' name='username' value='$Username'>
        <input type='hidden' name='password' value='$Password'>
        <input type='hidden' name='course_ID' value='$array_c_ID[$i]'>
        <input class ='btn btn-primary btn-lg' type='submit' value='Continue to homepage'>
        </form>" . '</td>';;
        }
    }
    /* close statement */
    $stmt->close();
}


//Checking for instructors with that username and password

$query_instructors = "select * from Instructors where Username='$Username' and Password='$Password'";

//THIS IS THE CODE TO CHECK THE NUMBER OF LINES IN A QUERY RESULT
if ($stmt = $mysqli->prepare($query_instructors)) {

    /* execute query */
    $stmt->execute();

    /* store result */
    $stmt->store_result();

    if(($stmt->num_rows) == 0 ){
    }
    if(($stmt->num_rows) > 0){
        // get the Instructors courses
        $query_ta_info = $mysqli->prepare("select Instructor_ID from Instructors where Username='$Username' and Password='$Password'");
        $query_ta_info->execute();
        $query_ta_info->bind_result($In_id);

        $In_id_var = " ";
        while($query_ta_info->fetch()){
            $In_id_var = $In_id;

        }
        $query_c_info = $mysqli->prepare("select Course_abb, Course_number, Course_ID, Section from Courses where Instructor_ID ='$In_id_var'");
        $query_c_info->execute();
        $query_c_info->bind_result($c_abb, $c_num, $c_ID, $c_sec);
        $array_c_abb=array();
        $array_c_num=array();
        $array_c_ID=array();
        $array_c_sec=array();
        $j=0;
        while($query_c_info->fetch()){
            $array_c_abb[$j]=$c_abb;
            $array_c_num[$j]=$c_num;
            $array_c_ID[$j]=$c_ID;
            $array_c_sec[$j]=$c_sec;
            $j++;
        }
        $well = "yes";
        echo"<br>
        <br>
        <h1 align='center'>Welcome! Continue to instructor homepage:</h1>";
        echo '<table align="center">' . "\n";
        echo '<tr><th align="center">Course</th><th align="center">Link to that page</th>';
        for ($i=0;$i<sizeof($array_c_abb);$i++) {


        echo '<tr>';
        $course=$array_c_abb[$i]." ".$array_c_num[$i]." ".$array_c_sec[$i];
        echo '<td>'. $course . '</td><td>' ."  
        <form action='instructor_homepage.php' method='post' align='center'>
        <input type='hidden' name='username' value='$Username'>
        <input type='hidden' name='password' value='$Password'>
        <input type='hidden' name='course_ID' value='$array_c_ID[$i]'>
        <input class ='btn btn-primary btn-lg' type='submit' value='Continue to homepage'>
        </form>".'</td>';;
        }
    }

    /* close statement */
    $stmt->close();
}


//Checking for TAs in the database

$query_TAs = "select * from TAs where Username='$Username' and Password='$Password'";

//THIS IS THE CODE TO CHECK THE NUMBER OF LINES IN A QUERY RESULT
if ($stmt = $mysqli->prepare($query_TAs)) {

    /* execute query */
    $stmt->execute();

    /* store result */
    $stmt->store_result();

    if(($stmt->num_rows) == 0 ){
    }
    if(($stmt->num_rows) > 0){
        $well = "yes";
        // get the Student's courses
        $query_ta_info = $mysqli->prepare("select TA_ID from TAs where Username='$Username' and Password='$Password'");
        $query_ta_info->execute();
        $query_ta_info->bind_result($TA_id);

        $TA_id_var = " ";
        while($query_ta_info->fetch()){
            $TA_id_var = $TA_id;
        }

            $query_c_info = $mysqli->prepare("select Course_abb, Course_number, Course_ID, Section from Courses where TA_ID ='$TA_id'");
            $query_c_info->execute();
            $query_c_info->bind_result($c_abb, $c_num, $c_ID, $c_sec);
            $array_c_abb = array();
            $array_c_num = array();
            $array_c_ID = array();
            $array_c_sec = array();
            $j = 0;
            while ($query_c_info->fetch()) {
                $array_c_abb[$j] = $c_abb;
                $array_c_num[$j] = $c_num;
                $array_c_ID[$j] = $c_ID;
                $array_c_sec[$j] = $c_sec;
                $j++;
            }

        $well = "yes";
        echo"<br>
        <br>
        <h1 align='center'>Welcome! Continue to  homepage:</h1>";
        echo '<table align="center">' . "\n";
        echo '<tr><th align="center">Course</th><th align="center">Link to that page</th>';
        for ($i=0;$i<sizeof($array_c_abb);$i++) {
            echo '<tr>';
            $course = $array_c_abb[$i] . " " . $array_c_num[$i] . " " . $array_c_sec[$i];
            echo '<td>' . $course . '</td><td>' . "  
        <form action='TA_homepage.php' method='post' align='center'>
        <input type='hidden' name='username' value='$Username'>
        <input type='hidden' name='password' value='$Password'>
        <input type='hidden' name='course_ID' value='$array_c_ID[$i]'>
        <input class ='btn btn-primary btn-lg' type='submit' value='Continue to homepage'>
        </form>" . '</td>';;
        }
    }
    /* close statement */
    $stmt->close();
}


//If none of the previous things work, there must be no user with these passwords and username, so log a page telling them so
if( $well == "no"){
    echo "
        <br>
        <br>
    <h2 align='center'>Error Logging In</h2>
    <p align='center'>There was a problem with either the username or password. Try again or contact your instructor.</p>
    <form action='Login_Page.html' method='post' align='center'>
    <input type='submit' align='center' value='Try Again!'>
    </form>
";

}


//Closes the connection
$mysqli->close();


ob_end_flush();
?>

</body>
</html>
