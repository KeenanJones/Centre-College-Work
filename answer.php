<!DOCTYPE html>
<html>
<head>
    <form action="Login_Page.html" method="post" align='right'>
        <input class = "btn btn-primary btn-lg" style='margin: 4px float:top' type="submit" name="sign_out" value="Sign Out!">
    </form>
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
//This page is used to check if the answer was right or not
//It will say if it is correct and give an option for the next question
//If it is wrong it will say try again

//connects to the database
$mysqli = new mysqli ("localhost", "keenan","yes", "MasteringCS");
if ($mysqli->connect_errno) { // Check connection
    echo "Failed to connect to MySQL: " . $mysqli->connect_errno;
    exit;}

//Gets the variables from post
$Username =$_POST['username'];
$Password = $_POST['password'];
$Q_ID = $_POST['Q_ID'];
$answer = $_POST['answer'];
$start_time = $_POST['start_time'];
$Skill_ID = $_POST['Skill_ID'];

date_default_timezone_set('America/New_York');
$end_time = date('Y-m-d H:i:s');


//This is a query to get the students ID
$query_ID = $mysqli->prepare("select Student_ID from Students where Username = '$Username' and Password = '$Password'");
$query_ID->execute();
$query_ID->bind_result($Student_ID);

$Stu_ID = " ";
while($query_ID->fetch()){
    $Stu_ID = $Student_ID;
}

//This is a query to get the right answer of the question
$query_answer_review = $mysqli->prepare("select Answer from Questions where Question_ID='$Q_ID'");
$query_answer_review->execute();
$query_answer_review->bind_result($real_answer);

$real_answer_answer = " ";

while($query_answer_review->fetch())
{
    $real_answer_answer = $real_answer;
}

//This is a query to get the max number of questions for incrementation
$query_review_max = $mysqli->prepare("select Question_ID from Questions order by Question_ID");
$query_review_max->execute();
$query_review_max->bind_result($ID_nums);

$count = 0;
while($query_review_max->fetch()){
    $count = $ID_nums;
}

//Query to find the next question
$query_question = $mysqli->prepare("select Question_ID from Questions where Skill_ID = '$Skill_ID'");
$query_question->execute();
$query_question->bind_result($question_id);
$array1 = array();
$dog = 0;
while($query_question->fetch()){
    $array1[$dog]=$question_id;
    $dog++;
}






if($answer === $real_answer_answer){
    $key = array_search($Q_ID, $array1);
    $key ++;
    $size = sizeof($array1);


    //This is a query to see if there is already a correct answer in the database for this student and question
    $query_any_correct = $mysqli->prepare("select Success from Attempts where Success = 1 and Question_ID = '$Q_ID' and Student_ID = '$Stu_ID'");
    $query_any_correct->execute();
    $query_any_correct->bind_result($Success);
    $well = " ";
    while($query_any_correct->fetch()){
        $well = "yes";
    }
    if($well != "yes") {
        //This adds an correct attempt
        $query_correct_attempt = $mysqli->prepare("
    insert into Attempts
    (Start_time, End_time, Student_response, Success, Student_ID, Question_ID)
    values
    ('$start_time', '$end_time', '$answer', 1, '$Stu_ID', '$Q_ID')");
        $query_correct_attempt->execute();
    }


    if($key != $size){
        echo "
        
        <h1 align='center'>Correct!</h1>
        <form action='question_page.php' method='post' align='center'>
        <input type='hidden' name='username' value='$Username'>
        <input type='hidden' name='password' value='$Password'>
        <input type='hidden' name='question' value='$array1[$key]'>
        Continue to the next question here: <input class = 'btn btn-primary btn-lg' type='submit' name='next' value='Next Question!'>     
        </form>
        
        <form action='Skill_Homepage.php' method='post' align='center'>
        Go back to the skill homepage: <input class = 'btn btn-primary btn-lg' type='submit' name='review' value='Skill Homepage!'>
        <input type='hidden' name='username' value=$Username>
        <input type='hidden' name='password' value=$Password>
        <input type='hidden' name='skill_id' value=$Skill_ID>
               
        </form>
    ";    }
    else{
        echo "
        <h1 align='center'>Correct!</h1>
        <p align='center'>Unfortunately, there are no more questions.</p>
        <form action='Skill_Homepage.php' method='post' align='center'>
        Go back to the skill homepage: <input class = 'btn btn-primary btn-lg' type='submit' name='review' value='Skill Homepage!'>
        <input type='hidden' name='username' value=$Username>
        <input type='hidden' name='password' value=$Password>
        <input type='hidden' name='skill_id' value=$Skill_ID>
        </form>
    
    ";
    }

}
else {
    $key = array_search($Q_ID, $array1);
    $key ++;
    $size = sizeof($array1);

    //This adds an wrong attempt
    $query_wrong_attempt = $mysqli->prepare("
    insert into Attempts
    (Start_time, End_time, Student_response, Success, Student_ID, Question_ID)
    values
    ('$start_time', '$end_time', '$answer', 0, '$Stu_ID', '$Q_ID')");
    $query_wrong_attempt->execute();

    if ($key != $size) {
        echo "
        <h1 align='center'>Wrong!</h1>
        
        <form action='question_page.php' method='post' align='center'>
        <input type='hidden' name='username' value='$Username'>
        <input type='hidden' name='password' value='$Password'>
        <input type='hidden' name='question' value='$Q_ID'>
        Click here to try again: <input class = 'btn btn-primary btn-lg' type='submit' name='next' value='Try Again!'>     
        </form>
        
        <form action='question_page.php' method='post' align='center'>
        <input type='hidden' name='username' value='$Username'>
        <input type='hidden' name='password' value='$Password'>
        <input type='hidden' name='question' value='$array1[$key]'>
        Continue to the next question here: <input class = 'btn btn-primary btn-lg' type='submit' name='next' value='Next Question!'>     
        </form>
    ";
    }
    //This is for when there is no next question
    else {
        echo "
        <h1 align='center'>Wrong!</h1>
        <form action='question_page.php' method='post' align='center'>
        <input type='hidden' name='username' value='$Username'>
        <input type='hidden' name='password' value='$Password'>
        <input type='hidden' name='question' value='$Q_ID'>
        Click here to try again: <input class = 'btn btn-primary btn-lg' style='margin: 4px' type='submit' name='next' value='Try Again!'>     
        </form>
        
        
        
        <form action='Skill_Homepage.php' method='post' align='center'>
        <input type='hidden' name='username' value='$Username'>
        <input type='hidden' name='password' value='$Password'>
        <input type='hidden' name='skill_id' value='$Skill_ID'>
        There are no more questions.
        <input class = 'btn btn-primary btn-lg' style='margin: 4px' type='submit' name='next' value='Return to skill homepage!'>     
        </form>
    
    ";


    }
echo"
    <form action='Skill_Homepage.php' method='post' align='center'>
        Go back to the skill homepage: <input class = 'btn btn-primary btn-lg' style='margin: 4px' type='submit' name='review' value='Skill Homepage!'>
        <input type='hidden' name='username' value=$Username>
        <input type='hidden' name='password' value=$Password>
        <input type='hidden' name='skill_id' value=$Skill_ID>";
}
//Closes the connection
$mysqli->close();
?>

</body>
</html>