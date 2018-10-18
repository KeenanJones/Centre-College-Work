<!DOCTYPE html>
<html>
<head>
    <form action="Login_Page.html" method="post" align='right'>
        <input class = "btn btn-primary btn-lg" style='margin: 4px float:top' type="submit" name="sign_out" value="Sign Out!">
    </form>
    <h1 align="center">Review Mode</h1>
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
//This is the page for review mode


#Sets the values of the username and the password from the previous page
$Username = $_POST['username'];
$Password = $_POST['password'];

//connects to the database
$mysqli = new mysqli ("localhost", "keenan","yes", "MasteringCS");
if ($mysqli->connect_errno) { // Check connection
    echo "Failed to connect to MySQL: " . $mysqli->connect_errno;
    exit;
}

$course_query = $mysqli->prepare("select Course_ID from Students where Username = '$Username' and Password ='$Password' ");
$course_query->execute();
$course_query->bind_result($ID);
$Course = '';
while($course_query->fetch()){
    $Course = $ID;
}

//Does a query to get the questions in the database
$query_questions = $mysqli->prepare("select * from Questions");
$query_questions->execute();
$query_questions->bind_result($Q_ID, $Q_content, $Q_answer, $Q_status, $Q_skill);


//Makes the results into a table
$i = 1;
echo '<table class = "table table-dark" align="center">' . "\n";
echo '<tr><th scope = "col" align="center">Question</th><th scope = "col" align="center">Link To Question</th></tr>' . "\n";
while($query_questions->fetch()){
    echo '<tr><td align="center">' . $i . '</td><td align="center">';
    echo "<form action='question_page_review.php' method='post'>
        <input type='hidden' name='username' value='$Username'>
        <input type='hidden' name='password' value='$Password'>
        <input type='hidden' name='Q_ID' value='$Q_ID'>
        
        <input type='submit' value='Continue to question $i'>
        </form>
    " . '</td></tr>' . "\n";
    $i ++;

}
echo '</table>' . "\n";

echo "<br>";
echo"
    <form action='student_homepage.php' method='post' align='center'>
    <input type='hidden' name='username' value='$Username'>
    <input type='hidden' name='password' value='$Password'>
    <input type='hidden' name='course_ID' value='$Course'>
    <input class = 'btn btn-primary btn-lg' type='submit' value='Return to Student Homepage'>
    </form>
";


?>


</body>
</html>
