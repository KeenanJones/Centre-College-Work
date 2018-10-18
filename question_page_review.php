<!DOCTYPE html>
<html>
<head>
    <form action="Login_Page.html" method="post" align='right'>
        <input class = "btn btn-primary btn-lg" style='margin: 4px float:top' type="submit" name="sign_out" value="Sign Out!">
    </form>
    <h1 align = 'center' >Question</h1>
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
    //Sets all the variables that have been passed
    $Username =$_POST['username'];
    $Password = $_POST['password'];
    $Q_ID = $_POST['Q_ID'];

    //connects to the database
    $mysqli = new mysqli ("localhost", "keenan","yes", "MasteringCS");
    if ($mysqli->connect_errno) { // Check connection
        echo "Failed to connect to MySQL: " . $mysqli->connect_errno;
        exit;
    }

    $query_question_review = $mysqli->prepare("select Question_content from Questions where Question_ID=$Q_ID");
    $query_question_review->execute();
    $query_question_review->bind_result($content);


    while($query_question_review->fetch())
    {echo "<p align='center'>$content</p>";}
    echo"   
        <form action='answer_review.php' method='post' align='center' class = 'display-5'>
        Answer: <input align='center' type='text' name='answer'>
        <br>
        <br>
        <input type='hidden' name='username' value='$Username'>
        <input type='hidden' name='password' value='$Password'>
        <input type='hidden' name='Q_ID' value='$Q_ID'>
        <input class = 'btn btn-primary' type='submit' name='go' value='Check It!'>
        </form>
    ";








?>

</body>
</html>

