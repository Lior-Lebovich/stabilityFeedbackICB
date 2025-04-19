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
    width: 600px;
    padding: 20px;
    border: 5px solid #000080;
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
<br><br>
<h1 style="color:#000000; font-size:20px; margin-left:auto; margin-right:auto">
<br>Your worker ID exists in our database, probably because you have already participated in this survey or in a similar version of it.<br>
	Multiple submissions with the same worker ID are not allowed.<br>
	See you on our next surveys.
</h1>
</center>
</body>
</html>

<?php
?>