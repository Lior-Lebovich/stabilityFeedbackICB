<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$ses_id=session_id();

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
<form class="form-horizontal" role="form" action="experimenttime_3.php" method="post">
<p class="form_div">
Well done.<br>
Press the "Start experiment" button to start the experiment<br><br>
<b>If you usually use vision aids (i.e. eyeglasses or contact lenses), please make sure to wear them during the experiment.</b>
<br><br>
<b>If you need a break during the experiment then please take it during status messages 
(where we report the number of correct responses so far).</b>
<br><br>

<button type="submit" class="btn btn-primary btn-lg" style="font-family:serif; font-size:18px; height:35px; width:200px;">Start experiment</button>
</p>
</form>
</div>
</center>

<?php
?>

</body>
</html>
