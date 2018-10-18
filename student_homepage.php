<!DOCTYPE html>
<html>
<head>
	<br>
    <h1 align='center'>Student Homepage</h1>
    <link rel="stylesheet" 
	href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" 
	integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" 
	crossorigin="anonymous">
    <style>
        td, th	{ border:1px solid gray;
            padding:5px; }
    </style>
</head>
<body>
<br>

<?php
//This is the page for the student homepage

//connects to the database
$mysqli = new mysqli ("localhost", "keenan","yes", "MasteringCS");
if ($mysqli->connect_errno) { // Check connection
    echo "Failed to connect to MySQL: " . $mysqli->connect_errno;
    exit;
}


//Echos the title of the page

//Gets the values of the variables
$Username = $_POST['username'];
$Password = $_POST['password'];
$Course=$_POST['course_ID'];

//Queries the student ID
$query_ID = $mysqli->prepare("select Student_ID from Students where Username = '$Username' and Password = '$Password'");
$query_ID->execute();
$query_ID->bind_result($Stu_ID);
while($query_ID->fetch()){
    $Stu_id = $Stu_ID;
}

//Querires the student info
$query_userinfo = "select First_name, Last_name from Students where Username='$Username' and Password='$Password'";
$result_student_info = $mysqli->query($query_userinfo);

//Creates an array of the results
$row_student_info = $result_student_info->fetch_array(MYSQLI_NUM);

//Querires the course info
$query_course = "select Course_abb, Course_number, Section, TA_ID from Courses where Course_ID = $Course";
$result_course_info = $mysqli->query($query_course);

//Creates and array of the course info
$row_course_info = $result_course_info->fetch_array(MYSQLI_NUM);

//Queries the TA info
$query_TA = "select  First_name, Last_name from TAs where TA_ID = $row_course_info[3]";
$result_TA_info = $mysqli->query($query_TA);

//Creates and array of the course info
$row_TA_info = $result_TA_info->fetch_array(MYSQLI_NUM);

//Displays all of this information to the screen

// Display the results as a table

echo '<table class = "table table-dark">' . "\n";
echo '<tbody>';
echo '<tr><th scope = "col" align="center">Student Information</th></tr>';
echo '<tr><td>Student</td><td>'. $row_student_info[0] . " " . $row_student_info[1] . '</td></tr>' . "\n";
echo '<tr><td>Course</td><td>'. $row_course_info[0] . " " . $row_course_info[1] . " " . $row_course_info[2] . '</td></tr>' . "\n";
echo '<tr><td>TA</td><td>'. $row_TA_info[0] . " " . $row_TA_info[1] . '</td></tr>' . "\n";
echo '</tbody>';


//Query to get the information about the skills
//$query_skills = "select Skill_name from Skills where Course_ID = $row_student_info[2]";
$query_skills = $mysqli->prepare("select Skill_name, Skill_ID from Skills where Course_ID = $Course");
$query_skills->execute();
$query_skills->bind_result($name, $skill_id);


//Makes the results into a table
echo '<table class = "table table-dark">' . "\n";
echo '<thread>';
echo '<tr><th scope = "col" align="center">Skill Name</th><th scope = "col" align="center">Link To Skill</th><th scope = "col" align="center">Skill Progress</th></tr>' . "\n";
echo '</thread><tbody>';
while($query_skills->fetch()){
    echo '<tr><td align="center">' . $name . '</td><td align="center">';
    echo "<form action='Skill_Homepage.php' method='post'>
        <input type='hidden' name='username' value='$Username'>
        <input type='hidden' name='password' value='$Password'>
        <input type='hidden' name='skill_id' value='$skill_id'>
        
        <input class = 'btn btn-outline-primary btn-lg' type='submit' value='Go to skill!'>
        </form>
    
    
    " . '</td>';

        $prog=find_progress($Stu_id,$skill_id);
        if ($prog==='100%'){
            echo "<td>" . "&#9989" . "</td>" . "</tr>" . "\n";
        }
        else{
            echo '<td>'. $prog.'</td>';
        }
}
echo '</tbody></table>' . "\n";


echo"
<form action='Review.php' method='post' align='center'>
        <input class = 'btn btn-primary btn-lg' type='submit' name='review' value='Review Mode!'>
        <input type='hidden' name='username' value=$Username>
        <input type='hidden' name='password' value=$Password>
               
    </form>
";




function find_progress($Student_ID, $Skill_ID)
{
    $mysqli = new mysqli ("localhost", "keenan", "yes", "MasteringCS");
    if ($mysqli->connect_errno) { // Check connection
        echo "Failed to connect to MySQL: " . $mysqli->connect_errno;
        exit;
    }
    $lengthq = 0;
    $lengtha = 0;
    $skill = $Skill_ID;
    $array = array();
    /// get the skills of each course
    //$query_skills= $mysqli->prepare("select Skill_ID from Skills where Course_ID=");
    //$query_skills->execute();
    //$query_skills->bind_result($Skill);
    //$skill_var=" ";
    //while($query_skills->fetch()) {
    //    $skill_var=$Skill;
    //}
    // get the questions of each skill
    $query_question = $mysqli->prepare("select Question_ID from Questions where Skill_ID='$skill'");
    $query_question->execute();
    $query_question->bind_result($q_id);
    $i = 0;
    while ($query_question->fetch()) {
        $lengthq++;
        ///get the attempts associated with the question_ID
        $array[$i] = $q_id;
        $i++;
    }
    //echo $array[0];
    foreach ($array as $a) {
        $query_att = $mysqli->prepare("select Success from Attempts where Question_ID='$a' and Student_ID='$Student_ID' and Success=1");
        $query_att->execute();
        $query_att->bind_result($suc);
        while ($query_att->fetch()) {
            $lengtha++;
            //echo $lengtha;
        }
    }

    $percent = $lengtha / $lengthq;
    //echo $lengthq;
    //echo '<br>';
    $npercent=($percent * 100) . '%';
    return $npercent;
}



/* free result set */
$result_course_info->free();
$result_student_info->free();
$query_skills->close();

//Closes the connection
$mysqli->close();

?>

<! THIS IS THE BUTTON TO SIGN OUT>
<br>
<form action="Login_Page.html" method="post" align='center'>
    <input class = "btn btn-outline-primary brn-large" type="submit" name="sign_out" value="Sign Out!">
</form>


</body>
</html>

