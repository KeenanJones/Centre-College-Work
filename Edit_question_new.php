<!DOCTYPE html>
<html>
<head>
    <h1 align="center">Add Questions</h1>
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

echo"
<p align='center'> Please type in the question you want to add: </p>
<form action='Edit_question.php' method='post' align='center'>
    <input type='text' name='new_question'  style='font-size:12pt;height:100px;width:300px;'>
    <p> 
    Please type in the answer: </p>
    <input type='text' name='answer'  style='font-size:12pt;height:100px;width:300px;'>
   
    <p> Which skill does this question belong to? </p>
    <input type='text' name='skill_name' checked><br>
    <p></p>
    <input type='hidden' name='username' value='$Username'>
    <input type='hidden' name='password' value='$Password'>
    <input type='hidden' name='course_ID' value='$Course'>

    <input class = 'btn btn-primary' style='margin: 4px' type='submit' value='Add Question'>
</form>";

echo"
<form action='instructor_homepage.php' method='post' align='left'>
    <input type='hidden' name='username' value='$Username'>
    <input type='hidden' name='password' value='$Password'>
    <input type='hidden' name='course_ID' value='$Course'>

    <div align='center'><input type='submit' class = 'btn btn-primary' style='margin: 4px' value='Back To Instructor Homepage'></div>
</form>";





?>

</body>
</html>

