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
<body align = "center">

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

if($answer === $real_answer_answer){
    $Q_ID_next = $Q_ID + 1;
    if($Q_ID<$count){
        echo "
        
        <h1 align='center'>Correct!</h1>
        <form action='question_page_review.php' method='post' align='center'>
        <input type='hidden' name='username' value='$Username'>
        <input type='hidden' name='password' value='$Password'>
        <input type='hidden' name='Q_ID' value='$Q_ID_next'>
        Continue to the next question here: <input class = 'btn btn-primary' type='submit' name='next' value='Next Question'>     
        </form>
        
        <form action='Review.php' method='post' align='center'>
        Go back to the review homepage: <input class = 'btn btn-primary' type='submit' name='review' value='Review Homepage!'>
        <input type='hidden' name='username' value=$Username>
        <input type='hidden' name='password' value=$Password>
               
        </form>
    ";    }
    else{
        echo "
        <h1 align='center'>Correct!</h1>
        <p align='center'>Unfortunately, there are no more review questions.</p>
        <form action='Review.php' method='post' align='center'>
        Go back to the review homepage: <input class = 'btn btn-primary' type='submit' name='review' value='Review Homepage!'>
        <input type='hidden' name='username' value=$Username>
        <input type='hidden' name='password' value=$Password>
               
        </form>
    
    ";
    }

}
else {
    $Q_ID_next = $Q_ID + 1;

    //This is for if there is a next question
    if ($Q_ID < $count) {
        echo "
        <h1 align='center'>Wrong!</h1>
        
        <form action='question_page_review.php' method='post' align='center'>
        <input type='hidden' name='username' value='$Username'>
        <input type='hidden' name='password' value='$Password'>
        <input type='hidden' name='Q_ID' value='$Q_ID'>
        Click here to try again: <input class = 'btn btn-primary' type='submit' name='next' value='Try Again!'>     
        </form>
        
        <form action='question_page_review.php' method='post' align='center'>
        <input type='hidden' name='username' value='$Username'>
        <input type='hidden' name='password' value='$Password'>
        <input type='hidden' name='Q_ID' value='$Q_ID_next'>
        Continue to the next question here: <input class = 'btn btn-primary' type='submit' name='next' value='Next Question'>     
        </form>
    ";
    }
    //This is for when there is no next question
    else {
        echo "
        <h1 align='center'>Wrong!</h1>
        <form action='question_page_review.php' method='post' align='center'>
        <input type='hidden' name='username' value='$Username'>
        <input type='hidden' name='password' value='$Password'>
        <input type='hidden' name='Q_ID' value='$Q_ID'>
        
        Click here to try again: <input class = 'btn btn-primary' type='submit' name='next' value='Try Again!'>     
        </form>
        
        <br>
        
        <form action='question_page_review.php' method='post' align='center'>
        <input type='hidden' name='username' value='$Username'>
        <input type='hidden' name='password' value='$Password'>
        <input type='hidden' name='Q_ID' value='$Q_ID'>
        There are no more review questions.
        <input class = 'btn btn-primary' type='submit' name='next' value='Return to homepage!'>     
        </form>
    
    ";


    }


}

?>

</body>
</html>