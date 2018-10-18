<!DOCTYPE html>
<html>
<head>
    <form action="Login_Page.html" method="post" align='right'>
        <input class = "btn btn-primary btn-lg" style='margin: 4px float:top' type="submit" name="sign_out" value="Sign Out!">
    </form>
    <h1 align = 'center'>Question</h1>
    <! THIS IS THE BUTTON TO SIGN OUT>

    <style>
        td, th	{ border:1px solid gray;
            padding:5px; }
    </style>
    <link rel="stylesheet" 
	href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" 
	integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" 
	crossorigin="anonymous">
</head>
<body align = 'center'>


<?php


    date_default_timezone_set('America/New_York');
    $start_time = date('Y-m-d H:i:s');

    //Sets all the variables that have been passed
    $Username =$_POST['username'];
    $Password = $_POST['password'];
    $Q_ID = $_POST['question'];


//connects to the database
$mysqli = new mysqli ("localhost", "keenan","yes", "MasteringCS");
if ($mysqli->connect_errno) { // Check connection
    echo "Failed to connect to MySQL: " . $mysqli->connect_errno;
    exit;
}
//Query to find out the skill_Id bc I am too lazy to pass it this far
$query_skill = $mysqli->prepare("select Skill_ID from Questions where Question_ID = $Q_ID");
$query_skill->execute();
$query_skill->bind_result($Skill);

$Skill_ID = " ";
while($query_skill->fetch()){
    $Skill_ID = $Skill;
}


$query_question_review = $mysqli->prepare("select Question_content from Questions where Question_ID=$Q_ID");
$query_question_review->execute();
$query_question_review->bind_result($content);


while($query_question_review->fetch())
{echo "<p align='center'>$content</p>";}
echo"   
        <form action='answer.php' method='post' align='center'>
        Answer: <input  type='text' name='answer' align='center'>
        <br>
        <input type='hidden' name='username' value='$Username'>
        <input type='hidden' name='password' value='$Password'>
        <input type='hidden' name='Q_ID' value='$Q_ID'>
        <input type='hidden' name='start_time' value='$start_time'>
        <input type='hidden' name='Skill_ID' value='$Skill_ID'>
        <br>
        <input class = 'btn btn-primary btn-lg' type='submit' name='go' value='Check It!' align='center'>
        </form>
    ";




//Closes the connection
$mysqli->close();


?>

</body>
</html>


