<!DOCTYPE html><html><head>    <form action="Login_Page.html" method="post" align='right'>        <input class = "btn btn-primary btn-lg" style='margin: 4px float:top' type="submit" name="sign_out" value="Sign Out!">    </form>    <h1 align = 'center'>Answer Key</h1>    <style>        td, th	{ border:1px solid gray;            padding:5px; }    </style>    <link rel="stylesheet" 	href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" 	integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" 	crossorigin="anonymous"></head><body><?php    $mysqli = new mysqli ("localhost", "keenan","yes", "MasteringCS");    if ($mysqli->connect_errno) { // Check connection        echo "Failed to connect to MySQL: " . $mysqli->connect_errno;        exit;}////posted values from TA Homepage$skill=$_POST['skill_id'];//Gets the values of the variables$Username = $_POST['username'];$Password = $_POST['password'];    $query_question= $mysqli->prepare("select Question_content, Answer from Questions where Skill_ID='$skill' and Status=1");    $query_question->execute();    $query_question->bind_result($q_content, $q_answer);    echo '<table class = "table table-dark">' . "\n";    echo '<tr><th align="center">Question</th><th align="center">Answer</th>';    while ($query_question->fetch()){        ////// echo question content and awnsers        echo '<tr>';        echo '<td>'. $q_content . '</td><td>' . $q_answer . '</td>';    }echo "<form action='TA_homepage.php' method='post'>            <input type='hidden' name='username' value='$Username'>            <input type='hidden' name='password' value='$Password'>            <input class = 'btn btn-primary' type='submit' value='Return To Homepage'>            </form>";?></body></html>