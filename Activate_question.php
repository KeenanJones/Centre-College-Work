<!DOCTYPE html>
<html>
<head>
    <h1 align="center">Make Questions Active</h1>
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

<?php
//Gets the values of the variables
$Username = $_POST['username'];
$Password = $_POST['password'];
$Course= $_POST['course_ID'];

//connects to the database
$mysqli = new mysqli ("localhost", "keenan","yes", "MasteringCS");
if ($mysqli->connect_errno) { // Check connection
    echo "Failed to connect to MySQL: " . $mysqli->connect_errno;
    exit;
}

$query_all_question = $mysqli->prepare("select  Question_ID as 'Question Numer',Question_content as 'Question Content', Skill_name as 'Skill Name'  from  Questions natural join Skills where Status = 0");
$query_all_question->execute();
$query_all_question->bind_result($question_id,$question_content,$skill_name);


//Makes the results into a table
echo '<table class = "table table-dark" align="center">';
echo '<tr><th align="center">Question Number</th> <th align="center">Question Content</th> <th align="center">Skill Name</th>';

while ($query_all_question->fetch()){
    echo '<tr><td align="center">'. $question_id.' </td> <td>'.$question_content.'</td><td>'.$skill_name.'</td></tr>';
}


echo"
<form action='instructor_homepage.php' method='post'>
    <input type='hidden' name='username' value='$Username'>
    <input type='hidden' name='password' value='$Password'>
    <input type='hidden' name='course_ID' value='$Course'>

    <div align='center'><input style='margin: 4px' class = 'btn btn-primary btn-lg' type='submit' value='Back To Instructor Homepage'></div>
</form>";

echo "<br>";
echo "<div align='center'>Enter the question number you want to make active:</div>
<form action='Active_results.php' method='post' align='center'>
    <div align='center'><input type='text' name='question_id'>
    <input type='hidden' name='username' value='$Username'>
    <input type='hidden' name='password' value='$Password'>
    <input type='hidden' name='course_ID' value='$Course'>
    <input class = 'btn btn-primary btn-lg' style='margin: 4px' type='submit' value='Activate Question'></div>
</form>";



?>





</body>
</html>
