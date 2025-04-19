<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$ses_id=session_id();
?>


<html>
<head>

<style>
.body{
   margin-left: auto;
    margin-right: auto;
    width: 51%;
	background-color: #FFFFE0;

}

.form_div{
   font-family:Verdana;
    font-size: 16px;
    margin-left: auto;
    margin-right: auto;
    width: 100%;
    background-color: #FFFFFF;

	padding: 16px;
	border: 5px solid #000080;
    margin: 0px; 
    color: black
}
.input[type=radio] {
    border: 0px;
    width: 100%;
    height: 18px;
}
.img{horizontal-align:center}
.error {color: #FF0000;}

</style>
</head>
<body class="body" bgcolor="white">
<form id="myForm" name="input" class="form-horizontal" role="form" action="form.php" method="post">
<div class="form_div">
<label for="workerID">
Thank you for participating.<br><br>
<b>Please note that this is a follow-up study and we therefore ask you to participate only if you intend 
to also participate in the second part of the study (in 6 months from now).</b><br><br>
Please type your worker ID in order to start.<br>
</label><br>
<textarea class="form-control" name="workerID" id="workerID" style="background-color:#FFFACD; font-family:Verdana; font-size:16px; height:35px; width:216px" required></textarea>
<br>
<p style="font-family:Verdana; font-size:12px"><br>
By checking the box below, you indicate your agreement to participate in this experiment and receive payment as stated on the HIT Amazon Mechanical Turk page. 
Your participation is voluntary and you may quit at any time by closing the browser window. 
No identifying information will be used and your personal information will be kept confidential.
For further questions please contact 
 <a href="mailto:@gmail.com">@gmail.com</a><br><br>
Please indicate, by checking the box below, that you understand and agree to participate in this experiment.
<br><br>
</p>
<input type="hidden" name="experimentType" id="experimentType" value="6month">
<input type="checkbox" name="ifconsent" value="consent" style="font-family:Verdana; font-size:16px" required> I consent
<br><br>
<button type="submit" id="buttonID" class="btn btn-primary btn-lg" style="font-family:Verdana; margin-left: auto; margin-right: auto; font-size:16px; height:35px; width:200px; color: black;">
	Submit
</button>
</div>
</form>
<br><br>
</body>
</html>

<?php
?>