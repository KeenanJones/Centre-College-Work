<!DOCTYPE html>
<html>
<head>
    <h1 align = "center">Instructor Homepage</h1>
    <style>
        td, th	{ border:1px solid gray;
            padding:5px; }
    </style>
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb"
          crossorigin="anonymous">
</head>
<body align="center">





<! THIS IS THE BUTTON TO SIGN OUT>
<form action="Login_Page.html" method="post" align='center'>
    <input class = "btn btn-primary btn-lg" type="submit" name="sign_out" value="Sign Out!">
</form>
<?php
//This is the page for the instructor homepage

//connects to the database
$mysqli = new mysqli ("localhost", "keenan","yes", "MasteringCS");
if ($mysqli->connect_errno) { // Check connection
    echo "Failed to connect to MySQL: " . $mysqli->connect_errno;
    exit;
}




//Gets the values of the variables
$Username = $_POST['username'];
$Password = $_POST['password'];
$Course = $_POST['course_ID'];

//Querires the instructor info
$query_userinfo = "select First_name, Last_name, Instructor_ID from Instructors where Username='$Username' and Password='$Password'";
$result_instructor_info = $mysqli->query($query_userinfo);

//Creates an array of the results
$row_instructor_info = $result_instructor_info->fetch_array(MYSQLI_NUM);

//Querires the course info
$query_course = "select Course_abb, Course_number, Section, Course_ID from Courses where Instructor_ID = $row_instructor_info[2] and Course_ID=$Course";
$result_course_info = $mysqli->query($query_course);

//Creates and array of the course info
$row_course_info = $result_course_info->fetch_array(MYSQLI_NUM);
$course_id=$Course;


// Display the results as a table

echo '<table class = "table table-dark" align="center">' . "\n";
echo '<tr><td>Professor:</td><td>'. $row_instructor_info[0] . " " . $row_instructor_info[1] . '</td></tr>' . "\n";
echo '<tr><td>Course:</td><td>'. $row_course_info[0] . " " . $row_course_info[1] . " " . $row_course_info[2] . '</td></tr>' . '<br>';


/////////// get the skills for that class
$query_skills = $mysqli->prepare("select Skill_ID, Skill_name from Skills where Course_ID = '$Course'");
$query_skills->execute();
$query_skills->bind_result($skill_ID, $skill_name);
$skilln = array();
$sk_ID= array();
$j=0;
while ($query_skills->fetch()){
    $skilln[$j]=$skill_name;
    $sk_ID[$j]=$skill_ID;
    $j++;
}
// getting the students in the class
$query_s_info = $mysqli->prepare("select First_name, Last_name, Student_ID from Students where Course_ID = '$Course'");
$query_s_info->execute();
$query_s_info->bind_result($s_fname, $s_lname, $stuID);
//Makes the results into a table
echo "<br>";
echo '<table class = "table table-dark" align="center">';
echo '<tr><td>Skills</td>';
for ($m=0;$m<sizeof($skilln);$m++)
{
    echo '<td>'. $skilln[$m] .'</td>';
}
echo '<td>Details</td>';
while ($query_s_info->fetch()) {
    echo '<tr><td align="center">' . $s_fname." ".$s_lname . '</td>';

    for ($m=0;$m<sizeof($skilln);$m++)
    {
        $prog=find_progress($stuID,$sk_ID[$m]);
        if ($prog==='100%'){
            echo '<td>'.'&#9989'.'</td>';
        }
        else{
            echo '<td>'. $prog.'</td>';
        }

    }
    echo '<td>'."
        <form action='TA_student_view.php' method='post' align='center'>
        <input type='hidden' name='first_name' value='$s_fname'>
        <input type='hidden' name='last_name' value='$s_lname'>
        <input class = 'btn btn-primary btn-lg' type='submit' value='&#128269'>
        </form>"
        . '</td>';


}

$query_skills->close();







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


echo "<form action='Edit_question_new.php' method='post' align='left' >
   
    <input type='hidden' name='username' value='$Username'>
    <input type='hidden' name='password' value='$Password'>
    <input type='hidden' name='course_ID' value='$Course'>
    <input class = 'btn btn-primary' style='margin: 4px' type='submit' name='add_question' value='Add Questions'></form>

        <form action='Activate_question.php' method='post' align='left'>
        <input type='hidden' name='username' value='$Username'>
        <input type='hidden' name='password' value='$Password'>
        <input type='hidden' name='course_ID' value='$Course'>
        <input class = 'btn btn-primary' style='margin: 4px' type='submit' name='activate_question' value='Activate Questions'></form>

    <form action='Delete_question.php' method='post' align='left'>
    <input type='hidden' name='username' value='$Username'>
    <input type='hidden' name='password' value='$Password'>
    <input type='hidden' name='course_ID' value='$Course'>
    <input class = 'btn btn-primary' style='margin: 4px' type='submit' name='delete_question' value='Deactivate Questions'></form>";





?>








</body>
</html>