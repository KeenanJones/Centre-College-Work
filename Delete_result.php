<!DOCTYPE html>
<html>
<head>
    <h1 align="center">Deactivation Results</h1>
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
$question_id=$_POST['question_id'];
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

$delete_question = $mysqli->prepare("select Question_ID from Questions ");
$delete_question->execute();
$delete_question->bind_result($valid_id);
$present=false;

while ($delete_question->fetch()){
    $real_id = $question_id;

    if($question_id == $valid_id){
        $present= true;
    }
}

if ($present != 1)
{echo "Sorry the question number is invalid, please re-enter  <a href ='Delete_question.php'>Go back</a>";}

if ($present == 1){
    $delete_a_question_query = $mysqli->prepare("update Questions set Status = 0 where Question_ID = $question_id");
    $delete_a_question_query->execute();

    echo "<h2 align='center'>Successfully Changed Status of Question $question_id</h2>";

    //create a button to delete more questions
    echo'<form action="Delete_question.php" method="post" align="center">If you want to deactivate more questions, click here: ';
    echo"
    <input type='hidden' name='username' value='$Username'>
    <input type='hidden' name='password' value='$Password'>
    <input type='hidden' name='course_ID' value='$Course'>

<input type='submit' name='delete_question' class = 'btn btn-primary' style='margin: 4px' value='Deactivate Questions!'>";

    echo '</form>';
}
$mysqli -> close();


echo"
<form action='instructor_homepage.php' method='post' align='center'>
    <input type='hidden' name='username' value='$Username'>
    <input type='hidden' name='password' value='$Password'>
    <input type='hidden' name='course_ID' value='$Course'>

    <input type='submit' class = 'btn btn-primary' style='margin: 4px' value='Back To Instructor Homepage'>
</form>";
?>
</body>
</html>

