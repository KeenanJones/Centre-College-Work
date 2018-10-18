<!DOCTYPE html>
<html>
<head>
    <form action="Login_Page.html" method="post" align='right'>
        <input class = "btn btn-primary btn-lg" style='margin: 4px float:top' type="submit" name="sign_out" value="Sign Out!">
    </form>
    <h1 align="center">Student View</h1>
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
//Gets the values of the variables
$First_name = $_POST['first_name'];
$Last_name = $_POST['last_name'];

//connects to the database
$mysqli = new mysqli ("localhost", "keenan","yes", "MasteringCS");
if ($mysqli->connect_errno) { // Check connection
    echo "Failed to connect to MySQL: " . $mysqli->connect_errno;
    exit;
}

//Query to get the right student ID
$query_ID = $mysqli->prepare("select Student_ID from Students where First_name = '$First_name' and Last_name = '$Last_name'");
$query_ID->execute();
$query_ID->bind_result($Stu_ID);

$ID = " ";
while($query_ID->fetch()){
    $ID = $Stu_ID;
}


//Query to find out all of the question IDs
$query_questions = $mysqli->prepare("select Question_ID, Question_content from Questions where Status = '1'");
$query_questions->execute();
$query_questions->bind_result($question_id, $question_content);

$question_array = array();
$i = 0;
$question_content_array = array();
while($query_questions->fetch()){
    $question_array[$i]=$question_id;
    $question_content_array[$i]=$question_content;
    $i++;
}

//THis creates an array full of the question IDs that the student has attempted but gotten wrong and no successes
$query_the_question_id_wrong = $mysqli->prepare("select distinct Question_ID from Attempts where Student_ID = '$ID' and Success = 0 and Question_ID
                                                        not in
                                                        (select distinct Question_ID from Attempts where Student_ID = '$ID' and Success = 1);");
$query_the_question_id_wrong->execute();
$query_the_question_id_wrong->bind_result($wrong_ID);
$Array_of_wrong_IDs = array();
$counter = 0;
while($query_the_question_id_wrong->fetch()){
    $Array_of_wrong_IDs[$counter] = $wrong_ID;
    $counter++;
}


//$question_array is now an array of all the active questions
$array_wrong = array();
$array_wrong_question = array();

$yep = 0;
for ($m=0;$m<sizeof($question_array);$m++){
    $query_wrong = $mysqli->prepare("select Success from Attempts where Student_ID = '$ID' and Success = 0 and Question_ID = '$question_array[$m]'");
    $query_wrong->execute();
    $query_wrong->bind_result($wrong);


    while($query_wrong->fetch()){
        if($wrong === 0){
            $array_wrong[$yep] = $wrong;
            $array_wrong_question[$yep] = $question_array[$m];
            $yep++;
        }
        else{
            $array_wrong[$yep] = 1;
            $yep++;
        }
    }
}
//$query_wrong->close();

//These two arrays keep track of the question number that they have gotten right and the

$array_missed_question_times = array();
//A blank array the size of the active question array
foreach ($question_array as $quest){
    $array_missed_question_times[$quest - 1] = 0;
}


//an array for how many times you have missed a certain question

foreach ($array_wrong_question as $value) {
    $count = 0;
    foreach ($question_array as $question_num){
        if($question_num === $value){
            $count = $question_num - 1;
            $array_missed_question_times[$count] = $array_missed_question_times[$count] + 1;
        }
    }
}

$question_question = 0;
echo "<p align='center'>$First_name $Last_name has had troubles with these questions:</p>";
echo "<table class = 'table table-dark' align='center'><tr><th>Question</th><th>Attempts</th></tr>";
foreach ($array_missed_question_times as $value) {
    if($value != 0) {
        if(in_array(($question_question + 1), $Array_of_wrong_IDs)) {
            echo "<tr><td>$question_content_array[$question_question]</td><td align='center' style='color:red;'>$value</td></tr>";
        }
    }
    $question_question++;
}
echo "</table>";


?>

</body>
</html>
