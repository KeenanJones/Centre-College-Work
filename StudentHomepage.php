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
    echo "<h1 align='center' >Student Homepage</h1>";



echo"<p align='center'>Current Skill Progress: 75% Complete</p>";

echo"<form style=\"float: center;\" action=\"Login_Page.html\" method=\"post\" align='right'>
    <input type=\"submit\" name=\"sign_out\" value=\"Sign Out!\">

</form>";

echo "<table style=\"float: center;\" align='center'>
<tr align='center'><td>Skill:</td><td>LINKS TO QUESTIONS</td><td>Status</td></tr>

<tr align='center'><td>Skill 1</td><td>LINK TO QUESTIONS</td><td>Complete</td></tr>

<tr align='center'><td>Skill 2</td><td>LINK TO QUESTIONS</td><td>Complete</td></tr>

<tr align='center'><td>Skill 3</td><td>LINK TO QUESTIONS</td><td>Incomplete</td></tr>

<tr align='center'><td>Skill 4</td><td>LINK TO QUESTIONS</td><td>Locked</td></tr>



</table >

";
    #This makes the table for the skills to be completed
echo "<div>
<table table style=\"display: inline-block;\" align='left'>
    <tr>
    <th>Student Info </th>
  </tr align='center'>
  <tr align='center'>
    <td>Name:</td>
  </tr>
  <tr align='center'>
    <td>Course:</td>
  </tr>
    <tr align='center'>
    <td>TA:</td>
  </tr>
      <tr align='center'>
    <td><br></td>
  </tr>
  <tr align='center'>
    <th>Assigned Skills to Be Completed </th>
  </tr>
  <tr align='center'>
    <td>Skill 1</td>
  </tr>
  <tr align='center'>
    <td>Skill 2</td>
  </tr>
  <tr>
  <tr align='center'>
    <td><br></td>
  </tr>
  <th align='center'>Additional Resource Pages</th>
</tr>
<tr align='center'>
<td>Skill 1: INSERT LINK HERE</td>
</tr>
<tr align='center'><td>Skill 2: INSERT LINK HERE</td></tr>
</table>
</div>";
    echo "<br>";





?>

</body>
</html>
