<!DOCTYPE html>
<html>
<head>
    <h1 align="center">Results</h1>
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
//connect to the database
$mysqli = new mysqli ("localhost", "keenan","yes", "MasteringCS");
if ($mysqli->connect_errno) { // Check connection
    echo "Failed to connect to MySQL: " . $mysqli->connect_errno;
    exit;
}

$Username = $_POST['username'];
$Password = $_POST['password'];
$Course= $_POST['course_ID'];
//get all the variables
$new_question=$_POST['new_question'];
$answer=$_POST['answer'];
$skill_name=$_POST['skill_name'];
//echo $skill_name."kkkkkkkk";

$query_skill_id = $mysqli->prepare("SELECT Skill_ID FROM Skills WHERE Skill_name = ?");
$query_skill_id->bind_param('s', $skill_name);
$query_skill_id->execute();
$query_skill_id->bind_result($skill_id);
$query_skill_id->fetch();


$query_skill_id->close();

if ($new_question==null|| $answer==null ||$skill_id==null)
{ echo"<div align='center'><em><b>"." There is a mistake, please re-enter"."</b></em></div>";
    echo"
<form action='Edit_question_new.php' method='post' align='center'>
    
    <input type='hidden' name='username' value='$Username'>
    <input type='hidden' name='password' value='$Password'>
    <input type='hidden' name='course_ID' value='$Course'>
    <input type='submit' class = 'btn btn-primary' style='margin: 4px' value='Add Question'>
</form>";
}


$sql = "insert into
            Questions(Question_content, Answer, Status, Skill_ID)
            values
            ('$new_question', '$answer','1', '$skill_id')";
//echo $sql;
//echo "<br>";


if (mysqli_query($mysqli, $sql)) {
    echo "<div align='center'>Successfully added the question!</div>";
echo"
<form action='Edit_question_new.php' method='post' align='center'>
    Want to add another question?
    <input type='hidden' name='username' value='$Username'>
    <input type='hidden' name='password' value='$Password'>
    <input type='hidden' name='course_ID' value='$Course'>
    <input type='submit' class = 'btn btn-primary' style='margin: 4px' value='Add Another Question'>
</form>";}

echo"
<form action='instructor_homepage.php' method='post' align='left'>
    <input type='hidden' name='username' value='$Username'>
    <input type='hidden' name='password' value='$Password'>
    <input type='hidden' name='course_ID' value='$Course'>

    <div align='center'><input type='submit' class = 'btn btn-primary' style='margin: 4px' value='Back To Instructor Homepage'></div>
</form>";
$mysqli -> close();
//echo "Connection Succesful";

?>


