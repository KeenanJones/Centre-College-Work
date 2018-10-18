<!DOCTYPE html>
<html>
<head>
    <form action="Login_Page.html" method="post" align='right'>
        <input class = "btn btn-primary btn-lg" style='margin: 4px float:top' type="submit" name="sign_out" value="Sign Out!">
    </form>
    <h1 align = 'center'>TA Homepage</h1>
    

    <link rel="stylesheet" 
	href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" 
	integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" 
	crossorigin="anonymous">
    <style>
td, th	{ border:1px solid gray;
            padding:5px; }
    </style>
</head>
<body>


<?php
//This is the page for the student homepage

//connects to the database
$mysqli = new mysqli ("localhost", "keenan","yes", "MasteringCS");
if ($mysqli->connect_errno) { // Check connection
    echo "Failed to connect to MySQL: " . $mysqli->connect_errno;
    exit;
}

//Gets the values of the variables
$Username = $_POST['username'];
$Password = $_POST['password'];

// get the TA data
$query_ta_info = $mysqli->prepare("select First_name, Last_name, TA_ID from TAs where Username='$Username' and Password='$Password'");
$query_ta_info->execute();
$query_ta_info->bind_result($ta_fname, $ta_lname,$ta_id);

$ta_id_var = " ";
$ta_fname_var=" ";
$ta_lname_var=" ";
while($query_ta_info->fetch()){
    $ta_id_var = $ta_id;
    $ta_fname_var=$ta_fname;
    $ta_lname_var=$ta_lname;

}
$name=$ta_fname_var." ".$ta_lname_var;
// get the course data for the TA
// get the TA data
$query_c_info = $mysqli->prepare("select Course_abb, Course_number, Course_ID, Section from Courses where TA_ID ='$ta_id_var'");
$query_c_info->execute();
$query_c_info->bind_result($c_abb, $c_num, $c_ID, $c_sec);
// making strings for data
$c_abb_var = " ";
$c_ID_var=" ";
$c_num_var=" ";
$c_sec_var=" ";
// assigning to strings
while($query_c_info->fetch()){
    $c_abb_var = $c_abb;
    $c_num_var=$c_num;
    $c_ID_var=$c_ID;
    $c_sec_var=$c_sec;
}

/////////// get the skills for that class
$query_skills = $mysqli->prepare("select Skill_ID, Skill_name from Skills where Course_ID = '$c_ID_var'");
$query_skills->execute();
$query_skills->bind_result($skill_ID, $skill_name);
$skilln = array();
$sk_ID= array();
$j=0;
while ($query_skills->fetch()){
    $skilln[$j]=$skill_name;
    $sk_ID[$j]=$skill_ID;
    $j++;
}

// getting the students in the class
$query_s_info = $mysqli->prepare("select First_name, Last_name, Student_ID from Students where Course_ID = '$c_ID_var'");
$query_s_info->execute();
$query_s_info->bind_result($s_fname, $s_lname, $stuID);

echo '<table class = "table table-dark">' . "\n";
echo '<tbody>';
echo '<tr><th scope = "col" align="center">TA Information</th></tr>';
echo '<tr><td>TA</td><td>'. $ta_fname_var . " " . $ta_lname_var . '</td></tr>' . "\n";
echo '<tr><td>Course</td><td>'. $c_abb_var . " " . $c_num_var . " " . $c_sec_var . '</td></tr>' . "\n";
echo '</tbody>';
echo '</table>';
echo '<br>';
echo '<table class = "table table-dark">' . "\n";
echo '<tbody>';
echo '<tr><th scope = "col" align="center">Student Progress</th>';
echo '<tr><td>Student</td>';
for ($m=0;$m<sizeof($skilln);$m++)
{
    echo '<td>'. $skilln[$m] .'</td>';
}
echo '<td>Details</td></tr>';

while ($query_s_info->fetch()) {
    echo '<tr><td align="center">' . $s_fname." ".$s_lname . '</td>';

    for ($m=0;$m<sizeof($skilln);$m++)
    {
        $prog=find_progress($stuID,$sk_ID[$m]);
        if ($prog==='100%'){
            echo '<td>'.'&#9989'.'</td>';
        }
        else{
            echo '<td>'. $prog.'</td>';
        }

    }
    echo '<td>'."
        <form action='TA_student_view.php' method='post' align='center'>
        <input type='hidden' name='first_name' value='$s_fname'>
        <input type='hidden' name='last_name' value='$s_lname'>
        <input type='hidden' name='username' value='$Username'>
        <input type='hidden' name='password' value='$Password'>
        <input class = 'btn btn-primary btn-lg' type='submit' value='&#128269'>
        </form>"
        . '</td>';


}
echo '<tr><td>Answer key</td>';
for ($p=0;$p<sizeof($skilln);$p++)
{
    echo '<td align="center">';
    echo "<form action='Answer_key.php' method='post'>
            <input type='hidden' name='skill_id' value='$sk_ID[$p]'>
            <input type='hidden' name='username' value='$Username'>
            <input type='hidden' name='password' value='$Password'>
            <input class = 'btn btn-primary' type='submit' value='$skilln[$p]'>
            </form>";
    echo '</td>';
}
echo '<td></td></tr>';

function find_progress($Student_ID, $Skill_ID)
{
    $mysqli = new mysqli ("localhost", "keenan", "yes", "MasteringCS");
    if ($mysqli->connect_errno) { // Check connection
        echo "Failed to connect to MySQL: " . $mysqli->connect_errno;
        exit;
    }
    $lengthq = 0;
    $lengtha = 0;
    $skill = $Skill_ID;
    $array = array();
    /// get the skills of each course
    //$query_skills= $mysqli->prepare("select Skill_ID from Skills where Course_ID=");
    //$query_skills->execute();
    //$query_skills->bind_result($Skill);
    //$skill_var=" ";
    //while($query_skills->fetch()) {
    //    $skill_var=$Skill;
    //}
    // get the questions of each skill
    $query_question = $mysqli->prepare("select Question_ID from Questions where Skill_ID='$skill'");
    $query_question->execute();
    $query_question->bind_result($q_id);
    $i = 0;
    while ($query_question->fetch()) {
        $lengthq++;
        ///get the attempts associated with the question_ID
        $array[$i] = $q_id;
        $i++;
    }
    //echo $array[0];
    foreach ($array as $a) {
        $query_att = $mysqli->prepare("select Success from Attempts where Question_ID='$a' and Student_ID='$Student_ID' and Success=1");
        $query_att->execute();
        $query_att->bind_result($suc);
        while ($query_att->fetch()) {
            $lengtha++;
            //echo $lengtha;
        }
    }

    $percent = $lengtha / $lengthq;
    //echo $lengthq;
    //echo '<br>';
    $npercent=($percent * 100) . '%';
    return $npercent;
}
?>