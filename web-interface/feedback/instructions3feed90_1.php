<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$ses_id=session_id();


// pictures for examples:
$exampleleftbigger='exampleleftbigger.png';
$examplerightbigger='examplerightbigger.png';
$exampletopbigger='exampletopbigger.png';
$examplebottombigger='examplebottombigger.png';
$answerpressleft='answerpressleft.png';
$answerpressright='answerpressright.png';
$answerpresstop='answerpresstop.png';
$answerpressbottom='answerpressbottom.png';

$ageSQL=(int)$_POST['age'];
$sexSQL=(string)$_POST['sex'];
$dominantHandSQL=(string)$_POST['dominantHand'];
$countrySQL=(string)$_POST['country'];
$languageSQL=(string)$_POST['language'];
$educationSQL=(string)$_POST['education'];
$eyeVisionSQL=(string)$_POST['eyeVision'];
$explainVisionSQL=(string)$_POST['explainVision'];
$neuroPsychiProblemsSQL=(string)$_POST['neuroPsychiProblems'];
$explainNeuroPsychiSQL=(string)$_POST['explainNeuroPsychi'];
$learningDisorderSQL=(string)$_POST['learningDisorder'];
$antipsychoticDrugsSQL=(string)$_POST['antipsychoticDrugs'];
$workerID=(string)$_POST['workerID'];
$experimentType=(string)$_POST['experimentType'];
$manHor=(int)$_POST['manHor'];
$manVer=(int)$_POST['manVer'];
$whatScreen=(string)$_POST['screen'];
$screenWidthSQLL=(int)$_POST['screenWidthSQL'];
$screenHeightSQLL=(int)$_POST['screenHeightSQL'];
$screenAvailWidthSQLL=(int)$_POST['screenAvailWidthSQL'];
$screenAvailHeightSQLL=(int)$_POST['screenAvailHeightSQL'];
$colorDepthSQLL=(int)$_POST['colorDepthSQL'];
$pixelDepthSQLL=(int)$_POST['pixelDepthSQL'];
$innerWidthSQLL=(int)$_POST['innerWidthSQL'];
$innerHeightSQLL=(int)$_POST['innerHeightSQL'];
$devicePixelRatioSQLL=(float)$_POST['devicePixelRatioSQL'];

?>


<html>
<head>
<meta charset="utf-8"/>

<link rel="stylesheet" type="text/css">
<style>
p {
    font-family:serif;
    font-size: 18px;
    width: 50%;
    padding: 20px;
    border: 5px solid #000080;
    margin: 0px; 
    color: black
	background-color:  #FFFFFF;
} 
button{
    display:block;
	padding: 5px;
	text-align:center;
	margin:0 auto;	
}
.body{
   margin-left: auto;
    margin-right: auto;
    width: 50%;
	background-color: #FFFFE0;

;
}
.imgg{
    margin-left: auto;
    margin-right: auto;
    width: 100%;
}
.imgg2{
    margin-left: auto;
    margin-right: auto;
    width: 25%;
}
.imgg3{
    margin-left: auto;
    margin-right: auto;
    width: 7%;
}
.imgg4{
    margin-left: auto;
    margin-right: auto;
    width: 62%;
}
.form_div{
   font-family:serif;
    font-size: 17px;
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
<?php 
	
?>

<br>
<p class="form_div">
	<b><u>Introduction</u>:</b><br><br>

	The experiment consists of 480 trials, aimed to test your visual acuity.
	Every ten correct responses will provide you with an extra 5 cents payoff (in addition to the participation fee). 
	In addition, a $1 bonus would be given to 10% of participants with best scores. <br>
	During the experiment, there will be no feedback about the correct response but every 30 trials we will report the number of correct responses so far. 
	The experiment is preceded by two short practice sessions, in which you will receive feedback about every response.
	<br><br>
	Please make sure you understand the following instructions before you press the "Start practice 1" button.
</p>
<br>

<p class="form_div">
<b><u>Instructions</u>:</b><br><br>
Each trial starts with a black screen.
The black screen would be replaced by an image and you are to <b>identify the bigger of the two</b>:<br>
In the case of 2 circles (example trials 1-3 below) - identify the bigger circle.<br>
In the case of a bisected line (example trials 4-6 below) - identify the longer segment (either the top or the bottom segment).<br>
Please answer as quickly and accurately as possible.<br> 
To answer, press the <b>space bar</b> key on your keyboard and then <b>mouse-click</b> the correct arrow button.
To submit your response and continue to the next trial <b>mouse-click</b> the central button. 
<br><br>
The two types of trials will alternate every three trials, as demonstrated below.<br>
</p>

<br>

<p class="form_div">
<b>Example:</b><br><br>

<table BORDER="0" width="90%" >
<tr>
	<td><u>Trial 1</u></td>
	<td><u>Trial 2</u></td>
	<td><u>Trial 3</u></td>
</tr>
<tr>
	<td><?php echo '<img class="imgg" src="examplerightbiggercircle.png"/>';?></td>
	<td><?php echo '<img class="imgg" src="examplelefttbiggercircle.png"/>';?></td>
	<td><?php echo '<img class="imgg" src="examplelefttbiggercircle2.png"/>';?></td>
</tr>
<tr>
	<td>Correct response: <?php echo '<img class="imgg4" src="spacekey.png"/>';?> <b> + </b> <?php echo '<img class="imgg2" src="buttonright.png"/>';?></td>
	<td>Correct response: <?php echo '<img class="imgg4" src="spacekey.png"/>';?> <b> + </b> <?php echo '<img class="imgg2" src="buttonleft.png"/>';?></td>
	<td>Correct response: <?php echo '<img class="imgg4" src="spacekey.png"/>';?> <b> + </b> <?php echo '<img class="imgg2" src="buttonleft.png"/>';?></td>
</tr>

<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>

<tr>
	<td><u>Trial 4</u></td>
	<td><u>Trial 5</u></td>
	<td><u>Trial 6</u></td>
</tr>
<tr>
	<td><?php echo '<img class="imgg" src="examplebottombigger.png"/>';?></td>
	<td><?php echo '<img class="imgg" src="exampletopbigger.png"/>';?></td>
	<td><?php echo '<img class="imgg" src="examplebottombigger2.png"/>';?></td>
</tr>
<tr>	
	<td>Correct response: <?php echo '<img class="imgg4" src="spacekey.png"/>';?> <b> + </b> <?php echo '<img class="imgg2" src="buttonbottom.png"/>';?></td>
	<td>Correct response: <?php echo '<img class="imgg4" src="spacekey.png"/>';?> <b> + </b> <?php echo '<img class="imgg2" src="buttontop.png"/>';?></td>
	<td>Correct response: <?php echo '<img class="imgg4" src="spacekey.png"/>';?> <b> + </b> <?php echo '<img class="imgg2" src="buttonbottom.png"/>';?></td>
</tr>

</table>

<br>
After mouse-clicking an arrow button, you will need to finalize your response by clicking:
	<?php echo '<img class="imgg3" src="submitkey.png"/>';?>


, <br>
which appears on the center of the screen. This would bring you to the next trial.
<br>
</p>

<br>
<form class="form-horizontal" action="demobl3feed90_1.php" method="post">
<p class="form_div">

Press "Start practice 1" to start the first practice session.<br><br>
<b>If you usually use vision aids (e.g. eyeglasses or contact lenses), please make sure to wear them <u>now</u>.</b>
<br><br>
<button type="submit" class="btn btn-primary btn-lg" style="font-family:serif; font-size:18px; height:35px; width:230px; margin-left: auto; margin-right: auto;">Start practice 1</button>
</p>
</form>

</body>
</html>

<?php

$servername = "";
$username = "";
$password = "";
$dbname = "timescale3feed901";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "INSERT INTO biasform(ID,workerID,experimentType,manHor,manVer,date,AgeYears,Sex,Hand,Country,Language,Education,vision,visionExpain,neuroPsychiProblems,neuroPsychiExplain,learningDisorder,AntipsychoticDrugs,screen,screenWidth,screenHeight,screenAvailWidth,screenAvailHeight,colorDepth,pixelDepth,innerWidth,innerHeight,devicePixelRatio) 
VALUES('$ses_id','$workerID','$experimentType','$manHor','$manVer',NOW(),'$ageSQL','$sexSQL','$dominantHandSQL',
'".addslashes($countrySQL)."','".addslashes($languageSQL)."','$educationSQL','$eyeVisionSQL','".addslashes($explainVisionSQL)."','$neuroPsychiProblemsSQL','".addslashes($explainNeuroPsychiSQL)."','$learningDisorderSQL','$antipsychoticDrugsSQL','$whatScreen','$screenWidthSQLL','$screenHeightSQLL','$screenAvailWidthSQLL','$screenAvailHeightSQLL','$colorDepthSQLL','$pixelDepthSQLL','$innerWidthSQLL','$innerHeightSQLL','$devicePixelRatioSQLL')";
if (mysqli_query($conn, $sql)) {
	//echo "New record created successfully";
} else {
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

?>