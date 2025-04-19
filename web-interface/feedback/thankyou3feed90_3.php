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
$dbname = "timescale3feed903";
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
	Thank you for participating in the experiment!
</h1>

<h2 style="color:#000000; font-size:34px; margin-left:auto; margin-right:auto">
	Completion code: 
</h2> 


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
?>