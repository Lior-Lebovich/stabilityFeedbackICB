<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$ses_id=session_id();

$emailSQL=(string)$_POST['email'];
$commentsSQL=(string)$_POST['comments'];
$lastID=(string)$_POST['lastID'];
$ID26=substr($ses_id, 0, 26);


$servername = "";
$username = "";
$password = "";
$dbname = "timescalegood2";
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
<h1 style="color:#1E90FF; font-size:100px; margin-left:auto; margin-right:auto">
<br>Thank you!
</h1>
<h2 style="color:#1E90FF; font-size:50px; margin-left:auto; margin-right:auto">
Completion code:  4562114
</h2>
</center>
</body>
</html>

<?php

$sql = "INSERT INTO expcomments(ID,workerID,experimentType,date,email,comments) 
VALUES('$ses_id','$workerID','$experimentType',NOW(),'$emailSQL','".addslashes($commentsSQL)."')";

if (mysqli_query($conn, $sql)) {
    //echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);

?>

<?php
$servername = "";
$username = "";
$password = "";
$dbname = "timescalegood2";
$workerID=(string)$_POST['workerID'];
$experimentType=(string)$_POST['experimentType'];
// Create connection
$conn2 = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn2) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql2 = "INSERT INTO data2(
		ID,workerID,experimentType,startDate,AgeYears,Sex,Hand,Country,Language,Education,vision,visionExpain,neuroPsychiProblems,neuroPsychiExplain,learningDisorder,AntipsychoticDrugs,screen,screenWidth,screenHeight,screenAvailWidth,screenAvailHeight,colorDepth,pixelDepth,innerWidth,innerHeight,
		countCorrect,countCorrectFromPos,extraFeeCents,percentCalculatedCorrect,
		
		pUpVer10,mDtUpVer10,
		pUpVer8,mDtUpVer8,
		pUpVer6,mDtUpVer6,
		pUpVer4,mDtUpVer4,
		pUpVer2,mDtUpVer2,
		pUpVer0,mDtUpVer0,
		pUpVerM2,mDtUpVerM2,
		pUpVerM4,mDtUpVerM4,
		pUpVerM6,mDtUpVerM6,
		pUpVerM8,mDtUpVerM8,
		pUpVerM10,mDtUpVerM10,
		
		pRightHor10,mDtRightHor10,
		pRightHor8,mDtRightHor8,
		pRightHor6,mDtRightHor6,
		pRightHor4,mDtRightHor4,
		pRightHor2,mDtRightHor2,
		pRightHor0,mDtRightHor0,
		pRightHorM2,mDtRightHorM2,
		pRightHorM4,mDtRightHorM4,
		pRightHorM6,mDtRightHorM6,
		pRightHorM8,mDtRightHorM8,
		pRightHorM10,mDtRightHorM10,
		
		comments,email,endDate,
		trialsInDemoBL,
		trialsInDemoVertical,
		trialsInExp
) 


	
	SELECT DISTINCT
	form.*,
	trial248.countCorrect,trial248.countCorrectFromPos,trial248.extraFeeCents,trial248.percentCalculatedCorrect,
	psychoVerticalFastUp10.p AS pUpVer10, psychoVerticalFastUp10.RTmean As mDtUpVer10, 
	psychoVerticalFastUp8.p AS pUpVer8, psychoVerticalFastUp8.RTmean As mDtUpVer8, 
	psychoVerticalFastUp6.p AS pUpVer6, psychoVerticalFastUp6.RTmean As mDtUpVer6, 
	psychoVerticalFastUp4.p AS pUpVer4, psychoVerticalFastUp4.RTmean As mDtUpVer4, 
	psychoVerticalFastUp2.p AS pUpVer2, psychoVerticalFastUp2.RTmean As mDtUpVer2, 
	psychoVerticalFastUp0.p AS pUpVer0, psychoVerticalFastUp0.RTmean As mDtUpVer0, 
	psychoVerticalFastUpM2.p AS pUpVerM2, psychoVerticalFastUpM2.RTmean As mDtUpVerM2, 
	psychoVerticalFastUpM4.p AS pUpVerM4, psychoVerticalFastUpM4.RTmean As mDtUpVerM4, 
	psychoVerticalFastUpM6.p AS pUpVerM6, psychoVerticalFastUpM6.RTmean As mDtUpVerM6, 
	psychoVerticalFastUpM8.p AS pUpVerM8, psychoVerticalFastUpM8.RTmean As mDtUpVerM8, 
	psychoVerticalFastUpM10.p AS pUpVerM10, psychoVerticalFastUpM10.RTmean As mDtUpVerM10, 
	
	psychoVerticalSlowUp10.p AS pRightHor10, psychoVerticalSlowUp10.RTmean As mDtRightHor10, 
	psychoVerticalSlowUp8.p AS pRightHor8, psychoVerticalSlowUp8.RTmean As mDtRightHor8, 
	psychoVerticalSlowUp6.p AS pRightHor6, psychoVerticalSlowUp6.RTmean As mDtRightHor6, 
	psychoVerticalSlowUp4.p AS pRightHor4, psychoVerticalSlowUp4.RTmean As mDtRightHor4, 
	psychoVerticalSlowUp2.p AS pRightHor2, psychoVerticalSlowUp2.RTmean As mDtRightHor2, 
	psychoVerticalSlowUp0.p AS pRightHor0, psychoVerticalSlowUp0.RTmean As mDtRightHor0, 
	psychoVerticalSlowUpM2.p AS pRightHorM2, psychoVerticalSlowUpM2.RTmean As mDtRightHorM2, 
	psychoVerticalSlowUpM4.p AS pRightHorM4, psychoVerticalSlowUpM4.RTmean As mDtRightHorM4, 
	psychoVerticalSlowUpM6.p AS pRightHorM6, psychoVerticalSlowUpM6.RTmean As mDtRightHorM6, 
	psychoVerticalSlowUpM8.p AS pRightHorM8, psychoVerticalSlowUpM8.RTmean As mDtRightHorM8, 
	psychoVerticalSlowUpM10.p AS pRightHorM10, psychoVerticalSlowUpM10.RTmean As mDtRightHorM10, 
	com.comments as comments,
	com.email as email,
	com.date as endDate,
	BLDemo.maxTrial as trialsInDemoBL,
	VerticalDemo.maxTrial as trialsInDemoVertical,
	rowsInExp.trialsInExp as trialsInExp
	
	
	FROM (SELECT * FROM biasform WHERE ID='$ID26') AS form 
	LEFT JOIN (SELECT DISTINCT ID,countCorrect,countCorrectFromPos,extraFeeCents,percentCalculatedCorrect FROM biastrials WHERE ID='$ID26' AND numberOfTrial=496) AS trial248
	ON form.ID=trial248.ID
	
	LEFT JOIN (SELECT DISTINCT ID, 0.05*(COUNT(*)) as p, AVG(1.0*timeBetweenDisp1stPress) as RTmean
	FROM biastrials WHERE ID='$ID26' AND levelOfTrial=\"possibleVertical\" AND devFromMiddle=10 AND keyPressedAns=1 AND delayTimeMS=250) AS psychoVerticalFastUp10
	ON form.ID=psychoVerticalFastUp10.ID
	LEFT JOIN (SELECT DISTINCT ID, 0.05*(COUNT(*)) as p, AVG(1.0*timeBetweenDisp1stPress) as RTmean
	FROM biastrials WHERE ID='$ID26' AND levelOfTrial=\"possibleVertical\" AND devFromMiddle=8 AND keyPressedAns=1 AND delayTimeMS=250) AS psychoVerticalFastUp8
	ON form.ID=psychoVerticalFastUp8.ID
	LEFT JOIN (SELECT DISTINCT ID, 0.05*(COUNT(*)) as p, AVG(1.0*timeBetweenDisp1stPress) as RTmean
	FROM biastrials WHERE ID='$ID26' AND levelOfTrial=\"possibleVertical\" AND devFromMiddle=6 AND keyPressedAns=1 AND delayTimeMS=250) AS psychoVerticalFastUp6
	ON form.ID=psychoVerticalFastUp6.ID
	LEFT JOIN (SELECT DISTINCT ID, 0.05*(COUNT(*)) as p, AVG(1.0*timeBetweenDisp1stPress) as RTmean
	FROM biastrials WHERE ID='$ID26' AND levelOfTrial=\"possibleVertical\" AND devFromMiddle=4 AND keyPressedAns=1 AND delayTimeMS=250) AS psychoVerticalFastUp4
	ON form.ID=psychoVerticalFastUp4.ID
	LEFT JOIN (SELECT DISTINCT ID, 0.05*(COUNT(*)) as p, AVG(1.0*timeBetweenDisp1stPress) as RTmean
	FROM biastrials WHERE ID='$ID26' AND levelOfTrial=\"possibleVertical\" AND devFromMiddle=2 AND keyPressedAns=1 AND delayTimeMS=250) AS psychoVerticalFastUp2
	ON form.ID=psychoVerticalFastUp2.ID
	LEFT JOIN (SELECT DISTINCT ID, 0.025*(COUNT(*)) as p, AVG(1.0*timeBetweenDisp1stPress) as RTmean
	FROM biastrials WHERE ID='$ID26' AND levelOfTrial=\"impossibleVertical\" AND keyPressedAns=1 AND delayTimeMS=250) AS psychoVerticalFastUp0
	ON form.ID=psychoVerticalFastUp0.ID
	LEFT JOIN (SELECT DISTINCT ID, 0.05*(COUNT(*)) as p, AVG(1.0*timeBetweenDisp1stPress) as RTmean
	FROM biastrials WHERE ID='$ID26' AND levelOfTrial=\"possibleVertical\" AND devFromMiddle=-2 AND keyPressedAns=1 AND delayTimeMS=250) AS psychoVerticalFastUpM2
	ON form.ID=psychoVerticalFastUpM2.ID
	LEFT JOIN (SELECT DISTINCT ID, 0.05*(COUNT(*)) as p, AVG(1.0*timeBetweenDisp1stPress) as RTmean
	FROM biastrials WHERE ID='$ID26' AND levelOfTrial=\"possibleVertical\" AND devFromMiddle=-4 AND keyPressedAns=1 AND delayTimeMS=250) AS psychoVerticalFastUpM4
	ON form.ID=psychoVerticalFastUpM4.ID
	LEFT JOIN (SELECT DISTINCT ID, 0.05*(COUNT(*)) as p, AVG(1.0*timeBetweenDisp1stPress) as RTmean
	FROM biastrials WHERE ID='$ID26' AND levelOfTrial=\"possibleVertical\" AND devFromMiddle=-6 AND keyPressedAns=1 AND delayTimeMS=250) AS psychoVerticalFastUpM6
	ON form.ID=psychoVerticalFastUpM6.ID
	LEFT JOIN (SELECT DISTINCT ID, 0.05*(COUNT(*)) as p, AVG(1.0*timeBetweenDisp1stPress) as RTmean
	FROM biastrials WHERE ID='$ID26' AND levelOfTrial=\"possibleVertical\" AND devFromMiddle=-8 AND keyPressedAns=1 AND delayTimeMS=250) AS psychoVerticalFastUpM8
	ON form.ID=psychoVerticalFastUpM8.ID
	LEFT JOIN (SELECT DISTINCT ID, 0.05*(COUNT(*)) as p, AVG(1.0*timeBetweenDisp1stPress) as RTmean
	FROM biastrials WHERE ID='$ID26' AND levelOfTrial=\"possibleVertical\" AND devFromMiddle=-10 AND keyPressedAns=1 AND delayTimeMS=250) AS psychoVerticalFastUpM10
	ON form.ID=psychoVerticalFastUpM10.ID
	
	LEFT JOIN (SELECT DISTINCT ID, 0.05*(COUNT(*)) as p, AVG(1.0*timeBetweenDisp1stPress) as RTmean
	FROM biastrials WHERE ID='$ID26' AND levelOfTrial=\"possibleHorizontal\" AND devFromMiddle=10 AND keyPressedAns=1 AND delayTimeMS=250) AS psychoVerticalSlowUp10
	ON form.ID=psychoVerticalSlowUp10.ID
	LEFT JOIN (SELECT DISTINCT ID, 0.05*(COUNT(*)) as p, AVG(1.0*timeBetweenDisp1stPress) as RTmean
	FROM biastrials WHERE ID='$ID26' AND levelOfTrial=\"possibleHorizontal\" AND devFromMiddle=8 AND keyPressedAns=1 AND delayTimeMS=250) AS psychoVerticalSlowUp8
	ON form.ID=psychoVerticalSlowUp8.ID
	LEFT JOIN (SELECT DISTINCT ID, 0.05*(COUNT(*)) as p, AVG(1.0*timeBetweenDisp1stPress) as RTmean
	FROM biastrials WHERE ID='$ID26' AND levelOfTrial=\"possibleHorizontal\" AND devFromMiddle=6 AND keyPressedAns=1 AND delayTimeMS=250) AS psychoVerticalSlowUp6
	ON form.ID=psychoVerticalSlowUp6.ID
	LEFT JOIN (SELECT DISTINCT ID, 0.05*(COUNT(*)) as p, AVG(1.0*timeBetweenDisp1stPress) as RTmean
	FROM biastrials WHERE ID='$ID26' AND levelOfTrial=\"possibleHorizontal\" AND devFromMiddle=4 AND keyPressedAns=1 AND delayTimeMS=250) AS psychoVerticalSlowUp4
	ON form.ID=psychoVerticalSlowUp4.ID
	LEFT JOIN (SELECT DISTINCT ID, 0.05*(COUNT(*)) as p, AVG(1.0*timeBetweenDisp1stPress) as RTmean
	FROM biastrials WHERE ID='$ID26' AND levelOfTrial=\"possibleHorizontal\" AND devFromMiddle=2 AND keyPressedAns=1 AND delayTimeMS=250) AS psychoVerticalSlowUp2
	ON form.ID=psychoVerticalSlowUp2.ID
	LEFT JOIN (SELECT DISTINCT ID, 0.025*(COUNT(*)) as p, AVG(1.0*timeBetweenDisp1stPress) as RTmean
	FROM biastrials WHERE ID='$ID26' AND levelOfTrial=\"impossibleHorizontal\" AND keyPressedAns=1 AND delayTimeMS=250) AS psychoVerticalSlowUp0
	ON form.ID=psychoVerticalSlowUp0.ID
	LEFT JOIN (SELECT DISTINCT ID, 0.05*(COUNT(*)) as p, AVG(1.0*timeBetweenDisp1stPress) as RTmean
	FROM biastrials WHERE ID='$ID26' AND levelOfTrial=\"possibleHorizontal\" AND devFromMiddle=-2 AND keyPressedAns=1 AND delayTimeMS=250) AS psychoVerticalSlowUpM2
	ON form.ID=psychoVerticalSlowUpM2.ID
	LEFT JOIN (SELECT DISTINCT ID, 0.05*(COUNT(*)) as p, AVG(1.0*timeBetweenDisp1stPress) as RTmean
	FROM biastrials WHERE ID='$ID26' AND levelOfTrial=\"possibleHorizontal\" AND devFromMiddle=-4 AND keyPressedAns=1 AND delayTimeMS=250) AS psychoVerticalSlowUpM4
	ON form.ID=psychoVerticalSlowUpM4.ID
	LEFT JOIN (SELECT DISTINCT ID, 0.05*(COUNT(*)) as p, AVG(1.0*timeBetweenDisp1stPress) as RTmean
	FROM biastrials WHERE ID='$ID26' AND levelOfTrial=\"possibleHorizontal\" AND devFromMiddle=-6 AND keyPressedAns=1 AND delayTimeMS=250) AS psychoVerticalSlowUpM6
	ON form.ID=psychoVerticalSlowUpM6.ID
	LEFT JOIN (SELECT DISTINCT ID, 0.05*(COUNT(*)) as p, AVG(1.0*timeBetweenDisp1stPress) as RTmean
	FROM biastrials WHERE ID='$ID26' AND levelOfTrial=\"possibleHorizontal\" AND devFromMiddle=-8 AND keyPressedAns=1 AND delayTimeMS=250) AS psychoVerticalSlowUpM8
	ON form.ID=psychoVerticalSlowUpM8.ID
	LEFT JOIN (SELECT DISTINCT ID, 0.05*(COUNT(*)) as p, AVG(1.0*timeBetweenDisp1stPress) as RTmean
	FROM biastrials WHERE ID='$ID26' AND levelOfTrial=\"possibleHorizontal\" AND devFromMiddle=-10 AND keyPressedAns=1 AND delayTimeMS=250) AS psychoVerticalSlowUpM10
	ON form.ID=psychoVerticalSlowUpM10.ID	
	
	LEFT JOIN (SELECT DISTINCT * FROM expcomments WHERE ID='$ID26') AS com
	ON  form.ID=com.ID
	LEFT JOIN (SELECT DISTINCT ID,MAX(numberOfTrial) as maxTrial FROM demobl WHERE ID='$ID26') AS BLDemo
	ON  form.ID=BLDemo.ID
	LEFT JOIN (SELECT DISTINCT ID,MAX(numberOfTrial) as maxTrial FROM demovertical WHERE ID='$ID26') AS VerticalDemo
	ON  form.ID=VerticalDemo.ID
	LEFT JOIN (SELECT ID,COUNT(*) as trialsInExp FROM biastrials WHERE ID='$ID26') AS rowsInExp
	ON  form.ID=rowsInExp.ID
	
	
";


if (mysqli_query($conn2, $sql2)) {
    //echo "New record created successinnery";
} else {
    echo "Error: " . $sql2 . "<br>" . mysqli_error($conn2);
}

mysqli_close($conn2);

?>