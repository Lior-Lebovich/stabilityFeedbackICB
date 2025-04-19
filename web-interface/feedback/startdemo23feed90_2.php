<?php
		
ini_set('display_errors', 'On');
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$ses_id=session_id();

$workerID=(string)$_POST['workerID'];
$experimentType=(string)$_POST['experimentType'];
?>


<html>
<head>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<style>
p {
    font-family:serif;
    font-size: 18px;
    width: 100%;
    padding: 20px;
    border: 5px solid #000080;
	margin-left: auto;
    margin-right: auto;
    color: black
	background-color:  #FFFFFF;
}
.body{
	padding: 20px;
	margin-left: auto;
    margin-right: auto;
    width: 50%;
	background-color: #FFFFE0;

;
}
button{
    display:block;
	padding: 5px;
	text-align:center;
	margin:0 auto;	
}
.form_div{
   font-family:serif;
    font-size: 17px;
	padding: 20px;
    margin-left: auto;
    margin-right: auto;
    width: 100%;
    background-color: #FFFFFF;
	border: 5px solid #000080;
}  
.error {color: #FF0000;}


</style>
</head>
<body class="body" bgcolor="white">
<form class="form-horizontal" role="form" action="demovertical3feed90_2.php" method="post">
<p class="form_div">
Well-done.<br>
Press the "Start practice 2" button to start the second practice session.
</div>

<br><br>

<button type="submit" class="btn btn-primary btn-lg" style="font-family:serif; font-size:18px; height:35px; width: 200px">Start practice 2</button>
</p>
</form>


<?php
?>

</body>
</html>
