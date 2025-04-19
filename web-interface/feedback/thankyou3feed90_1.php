<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$ses_id=session_id();

$emailSQL=(string)$_POST['email'];
$commentsSQL=(string)$_POST['comments'];
$lastID=(string)$_POST['lastID'];
$ID26=substr($ses_id, 0, 26);
$workerID=(string)$_POST['workerID'];
$experimentType=(string)$_POST['experimentType'];
$numberPartOfExp=(string)$_POST['numberPartOfExp'];
$impManipVert=$_POST['impManipVert'];
$impManipHor=$_POST['impManipHor'];
$showCorrect=(float)$_POST['showCorrect'];
$showCorrectFromPos=(float)$_POST['showCorrectFromPos'];
$extraMoneySQL=(float)$_POST['extraMoney'];
$percentCorrectSQL=(float)$_POST['percentCorrect'];

$servername = "";
$username = "";
$password = "";
$dbname = "timescale3feed901";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


?>

<html>
<head>
<style>
p {
    font-family:serif;
    font-size: 18px;
    width: 600px;
    padding: 20px;
    border: 5px solid grey;
    margin: 0px; 
    color: black
} 
.body{
   margin-left: auto;
    margin-right: auto;
    width: 50%;
    background-color:  #FFFFE0

;
}
.form_div{
   font-family:serif;
    font-size: 17px;
    margin-left: auto;
    margin-right: auto;
    width: 75%;
    background-color: #FFFFE0;
}
.error {color: #FF0000;}

</style>
</head>
<body class="body" bgcolor="white">



<center>
<h1 style="color:#000000; font-size:20px; margin-left:auto; margin-right:auto">
	<br><br>
	Thank you for participating in the first experiment!<br><br>
	We encourage you to complete all three experiments.<br>
	Once completing the third experiment you will also receive a <b>$5 bonus</b> (on top of the participation fee and other bonuses).
</h1>

<h2 style="color:#000000; font-size:34px; margin-left:auto; margin-right:auto">
	Completion code: 
</h2> 

<h3 style="color:#000000; font-size:24px; margin-left:auto; margin-right:auto">
	Please use the following link to start the second experiment:<br>
	<a href="https://.com/f3/pre_form_3feed90_2.php" style="color:#1E90FF; font-size:22px; margin-left:auto; margin-right:auto">
	https://.com/f3/pre_form_3feed90_2.php
	</a>
</h3>

<h4 style="color:#000000; font-size:20px; margin-left:auto; margin-right:auto">
	Note that using that link, you can also check when should you start the second experiment by entering your worker ID.<br><br>
	For further questions, please contact us at: 
	<a href="mailto:@gmail.com" style="color:#1E90FF; font-size:20px; margin-left:auto; margin-right:auto">@gmail.com</a>
</h4>

</center>
</body>
</html>

<?php

$sql = "INSERT INTO expcomments(ID,workerID,experimentType,feedbackType,manipHor,manipVer,countCorrect,countCorrectFromPos,extraFeeCents,percentCalculatedCorrect,date,email,comments) 
VALUES('$ses_id','$workerID','$experimentType','$numberPartOfExp','$impManipHor','$impManipVert','$showCorrect','$showCorrectFromPos','$extraMoneySQL','$percentCorrectSQL',NOW(),'$emailSQL','".addslashes($commentsSQL)."')";

if (mysqli_query($conn, $sql)) {
    //echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);

?>


<?php

// check if worker already exists in email table:
$sql_exist_email = "SELECT DISTINCT * FROM MailF4 WHERE ID = '".$ID26."'";
$conn_exist_email = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn_exist_email) {
	die("Connection failed: " . mysqli_connect_error());
}
$results_exist_email=mysqli_query($conn_exist_email, $sql_exist_email);
$sumResults_exist_email = mysqli_num_rows($results_exist_email);
mysqli_close($conn_exist_email);

// if exists or if no email provided then do nothing. otherwise - save the email.
if (empty($emailSQL) || ($sumResults_exist_email>=1)) {
	$emailToSend = '@gmail.com';
} 
else {
	$whetherToSend = 0;
	$emailToSend = $emailSQL;
	$sql_email = "INSERT INTO MailF4(timeF,emailF,isSentEmail,ID) VALUES(NOW(),'$emailToSend','$whetherToSend','$ID26')";
	$conn_email = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn_email) {
		die("Connection failed: " . mysqli_connect_error());
	}

	if (mysqli_query($conn_email, $sql_email)) {
		//echo "New record created successfully";
	} else {
		echo "Error: " . $sql_email . "<br>" . mysqli_error($conn_email);
	}
	mysqli_close($conn_email);
}

?>


<?php
?>