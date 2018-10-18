<!DOCTYPE html>
<html>
<head>
    <form action="Login_Page.html" method="post" align='right'>
        <input class = "btn btn-primary btn-lg" style='margin: 4px float:top' type="submit" name="sign_out" value="Sign Out!">
    </form>
    <h1 align = "center">Skill Homepage</h1>
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
<body>

<?php
//This is the code for the skill homepage

//connects to the database
$mysqli = new mysqli ("localhost", "keenan","yes", "MasteringCS");
if ($mysqli->connect_errno) { // Check connection
    echo "Failed to connect to MySQL: " . $mysqli->connect_errno;
    exit;
}

//Gets the values of the variables
$Username = $_POST['username'];
$Password = $_POST['password'];
$Skill_ID = $_POST['skill_id'];

//Runs the query to get all the information about the student so that we know the course_id
$query_student = $mysqli->prepare("select First_name, Last_name, Course_ID from Students where Username='$Username' and Password='$Password'");
$query_student->execute();
$query_student->bind_result($First_name, $Last_name, $Course_ID);

//Does a query and sets the var variable to the course ID
$Course_ID_var = " ";
while($query_student->fetch()){
    $Course_ID_var = $Course_ID;
}

//Runs the query to get all the information about the skill
$query_skill = $mysqli->prepare("select Skill_name, Skill_ID, Textbook_ref from Skills where Skill_ID = '$Skill_ID'");
$query_skill->execute();
$query_skill->bind_result($skill_name, $skill_id, $ref);

$Skill_name_var = " ";
$Skill_ID_var = " ";
$Skill_textbook_ref_var = " ";

while($query_skill->fetch()){
    $Skill_ID_var = $skill_id;
    $Skill_name_var = $skill_name;
    $Skill_textbook_ref_var = $ref;
}

//This is a query to get the students ID
$query_ID = $mysqli->prepare("select Student_ID from Students where Username = '$Username' and Password = '$Password'");
$query_ID->execute();
$query_ID->bind_result($Student_ID);

$Stu_ID = " ";
while($query_ID->fetch()){
    $Stu_ID = $Student_ID;
}

//THis is a query to put all the question ID into a array
$query_question_array = $mysqli->prepare("select Question_ID from Questions where Skill_ID = '$Skill_ID'");
$query_question_array->execute();
$query_question_array->bind_result($question_id);
$question_array = array();
$spot = 0;

while($query_question_array->fetch()){
    $question_array[$spot] = $question_id;
    $spot++;
}

$array_of_success = array();
$i = 0;

for($m=0;$m<sizeof($question_array);$m++) {
    //THis is a query to find out if a student has answered a question right or wrong yet
    $query_any_correct = $mysqli->prepare("select Success from Attempts where Success = 1 and Question_ID = '$question_array[$i]' and Student_ID = '$Stu_ID'");
    $query_any_correct->execute();
    $query_any_correct->bind_result($Success);

    $success_yes = "0";
    while ($query_any_correct->fetch()) {
        $success_yes = $Success;
    }

    $array_of_success[$m] = $success_yes;
    $i++;
}


//Echos the skills ID as a title
echo"<h3>Skill: $Skill_name_var</h3>";

//Query over all the questions
$query_question = $mysqli->prepare("select Question_ID from Questions where Skill_ID = '$Skill_ID'");
$query_question->execute();
$query_question->bind_result($question_id);


$i = 1;
$j_spot = 0;

//Makes the results into a table
echo '<table class = "table table-dark">' . "\n";
echo '<thread>';
echo '<tr><th scope = "col" align="center">Question Number</th><th scope = "col" align="center">Link To Question</th><th scope = "col" align="center">Status</th></tr>' . "\n";
echo '</thread><tbody>';
while($query_question->fetch()){
    //echo $question_id;
    echo '<tr><td align="center">' . $i . '</td><td align="center">';
    echo "<form action='question_page.php' method='post'>
        <input type='hidden' name='username' value='$Username'>
        <input type='hidden' name='password' value='$Password'>
        <input type='hidden' name='question' value='$question_id'>
        <input type='hidden' name='skill_id' value='$Skill_ID'>
        
        <input class = 'btn btn-primary btn-lg' type='submit' value='Go to question!'>
        </form>
    " . '</td>';

        if($array_of_success[$j_spot] === 1) {
            echo '<td>Correct</td>' . '</tr>' . "\n";
        }
        else {
            echo '<td>Incorrect/No Attempt</td>' . '</tr>' . "\n";
        }
    $i++;
    $j_spot++;
}
echo '</tbody></table>' . "\n";


//Closes the connection
$mysqli->close();
echo '<br>';
echo"
    <form action='student_homepage.php' method='post' align='center'>
    <input type='hidden' name='username' value='$Username'>
    <input type='hidden' name='password' value='$Password'>
    <input type='hidden' name='course_ID' value='$Course_ID_var'>
    <input class = 'btn btn-primary btn-lg' type='submit' value='Return to Homepage'>
    </form>



";


?>



</body>
</html>

