<?php
//#3b5998
ini_set('display_errors', 'On');
error_reporting(E_ALL ^ E_NOTICE);


session_start();
$ses_id=session_id();

settype($showCorrect, "float");
settype($showCorrectFromPos, "float");
settype($extraMoney, "float");
settype($extraMoneySQL, "float");
settype($percentCorrect, "float");

$servername = "";
$username = "";
$password = "";
$dbname = "timescale3feed902";
$workerID=(string)$_POST['workerID'];
$experimentType=(string)$_POST['experimentType'];

if($experimentType=="1day"){
	$experimentTypeNum1day = " 1 day ";
}
if($experimentType=="1month"){
	$experimentTypeNum1day = " 30 days ";
}

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$impossible1OrNot1SQL=(int)$_POST['impossible1OrNot1SQL'];
$numberPartOfExp=(string)$_POST['numberPartOfExp'];

$x1_lineSQL=(int)$_POST['x1_lineSQL'];
$x2_lineSQL=(int)$_POST['x2_lineSQL'];
$y1_lineSQL=(int)$_POST['y1_lineSQL'];
$y2_lineSQL=(int)$_POST['y2_lineSQL'];
$x1_bisectionSQL=(int)$_POST['x1_bisectionSQL'];
$x2_bisectionSQL=(int)$_POST['x2_bisectionSQL'];
$y1_bisectionSQL=(int)$_POST['y1_bisectionSQL'];
$y2_bisectionSQL=(int)$_POST['y2_bisectionSQL'];
$left_rightSQL=(int)$_POST['left_rightSQL'];
$dev_from_middleSQL=(int)$_POST['dev_from_middleSQL'];
$whichIsBiggerSQL=(string)$_POST['whichIsBiggerSQL'];
$trialLevelSQL=(string)$_POST['trialLevelSQL'];
$margSQL=(int)$_POST['margSQL'];
$top_bottomSQL=(int)$_POST['top_bottomSQL'];
$plusMinusSQL=(int)$_POST['plusMinusSQL'];
$correctIsEqualSQL=(int)$_POST['correctIsEqual'];

// the vectors below define the "correct" response in impossible trials and manip=1. It's the opposite if manip=-1.
$arrayTrue1ImpHorRightString=(string)$_POST["arrayTrue1ImpHorRightString"];
$arrayTrue1ImpHorLeftString=(string)$_POST["arrayTrue1ImpHorLeftString"];
$arrayTrue1ImpVerTopString=(string)$_POST["arrayTrue1ImpVerTopString"];
$arrayTrue1ImpVerBottomString=(string)$_POST["arrayTrue1ImpVerBottomString"];
$arrayTrue1ImpHorRight=unserialize($arrayTrue1ImpHorRightString);
$arrayTrue1ImpHorLeft=unserialize($arrayTrue1ImpHorLeftString);
$arrayTrue1ImpVerTop=unserialize($arrayTrue1ImpVerTopString);
$arrayTrue1ImpVerBottom=unserialize($arrayTrue1ImpVerBottomString);

$arrayDevHorizontalString=(string)$_POST["arrayDevHorizontalString"];
$arrayDevVerticalString=(string)$_POST["arrayDevVerticalString"];
$arrayLocHorizontalString=(string)$_POST["arrayLocHorizontalString"];
$arrayLocVerticalString=(string)$_POST["arrayLocVerticalString"];
$arrayDevHorizontal=unserialize($arrayDevHorizontalString);
$arrayDevVertical=unserialize($arrayDevVerticalString);
$arrayLocHorizontal=unserialize($arrayLocHorizontalString);
$arrayLocVertical=unserialize($arrayLocVerticalString);

$devicePixelRatioSQL=(float)$_POST['devicePixelRatio'];

$buttonPressed=$_POST['buttonPressed'];
$timeIntervalDispSubmit=$_POST['time2'];
$timeIntervalDisp1stPress=$_POST['time2firstpress'];

$number=$_POST['numberKey'];
$letter=$_POST['letterKey'];

$correct=$_POST['correct'];
$showCorrect=(float)$_POST['showCorrect'];
$showCorrectFromPos=(float)$_POST['showCorrectFromPos'];
$extraMoneySQL=(float)$_POST['extraMoney'];
$percentCorrectSQL=(float)$_POST['percentCorrect'];


$trial=$_POST['trial'];
$realTrial=$_POST['realTrial'];
$delayTimeMSSQL=$_POST['delayTimeMS'];

$impManipVert=$_POST['impManipVert'];
$impManipHor=$_POST['impManipHor'];


//srcoring: 
// Possible-correct:
if( ($whichIsBiggerSQL == 'right' && $number == 1) ||
	($whichIsBiggerSQL == 'left' && $number == -1) ||
	($whichIsBiggerSQL == 'bottom' && $number == -1) ||
	($whichIsBiggerSQL == 'top' && $number == 1)) {
	$correct=1;
	$showCorrect++;
	$showCorrectFromPos++;
}
// Possible-incorrect:
elseif(($whichIsBiggerSQL == 'left' && $number == 1) || 
	($whichIsBiggerSQL == 'right' && $number == -1) || 
	($whichIsBiggerSQL == 'bottom' && $number == 1) || 
	($whichIsBiggerSQL == 'top' && $number == -1)){
	$correct=0;
}
// Impossible-random:
elseif($whichIsBiggerSQL == 'equal'){
	if($trialLevelSQL=="impossibleVertical" && in_array($realTrial, $arrayTrue1ImpVerTop)){
		if( ($number*$impManipVert)==1 ){
			//correct:
			$correct=1;
			$showCorrect++;
		}
		elseif( ($number*$impManipVert)==-1 ){
			//incorrect:
			$correct=0;
		}
	}
	if($trialLevelSQL=="impossibleVertical" && in_array($realTrial, $arrayTrue1ImpVerBottom)){
		if( ($number*$impManipVert)==-1 ){
			//correct:
			$correct=1;
			$showCorrect++;
		}
		elseif( ($number*$impManipVert)==1 ){
			//incorrect:
			$correct=0;
		}
	}
	if($trialLevelSQL=="impossibleHorizontal" && in_array($realTrial, $arrayTrue1ImpHorRight)){
		if( ($number*$impManipHor)==1 ){
			//correct:
			$correct=1;
			$showCorrect++;
		}
		elseif( ($number*$impManipHor)==-1 ){
			//incorrect:
			$correct=0;
		}
	}
	if($trialLevelSQL=="impossibleHorizontal" && in_array($realTrial, $arrayTrue1ImpHorLeft)){
		if( ($number*$impManipHor)==-1 ){
			//correct:
			$correct=1;
			$showCorrect++;
		}
		elseif( ($number*$impManipHor)==1 ){
			//incorrect:
			$correct=0;
		}
	}				
}

// For status:
else{
	$correct=999; // the breaks, e.g. trial no. 31,62,...
}

$trial ++;

if($trial%31 == 0){
	$realTrial=30*floor($trial/31);
	$delayTimeMS=0;
}
else{
	$realTrial=30*floor($trial/31)+$trial%31;
	// Here we define the delay:
	if($realTrial<=240){ 
		$delayTimeMS=250; //500
	}
	else{
		$delayTimeMS=250; //2000
	}
}

$valDevArHorizontal=$arrayDevHorizontal[3*floor($realTrial/6)+($realTrial%6)-1];
$valDevArVertical=$arrayDevVertical[3*floor(($realTrial-3)/6)+(($realTrial-3)%6)-1];
$valLocArHorizontal=$arrayLocHorizontal[3*floor($realTrial/6)+($realTrial%6)-1];
$valLocArVertical=$arrayLocVertical[3*floor(($realTrial-3)/6)+(($realTrial-3)%6)-1];

$trialNew=$trial-1;
if($trialNew%31==0){
	$realTrialNew=30*floor($trialNew/30);
}
else{
	$realTrialNew=$trialNew-floor($trialNew/31);
}

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
.textarea1 {
    width: 100%;
    padding: 2px;
}  
.textarea2 {
    width: 40%;
    padding: 2px;
}  
.error {color: #FF0000;}

</style>
</head>
<body class="body" bgcolor="white">

<form class="form-horizontal" role="form" id="myForm" name="input" action="thankyou3feed90_2.php" method="post">

<p class="form_div">

<label for="comments">

Please click on the "End experiment" button below to complete the second experiment and receive the completion code.<br><br>

On the next page, we will also provide you with a link for the third experiment.<br>
<b>Please start the third experiment in 
<?php
print $experimentTypeNum1day;
?>
 from now.</b><br><br>

Please leave your email so we could let you know when it is time to start the third experiment.<br><br>
email (optional): <textarea class="textarea2" style="background-color:#FFFACD; font-family:serif; font-size:16px" name="email" rows="1" cols="30"></textarea> 
<br><br>
If you have any issues concerning your participation or comments about the experiment that you would like to share with us  
please enter them below (optional): <br><br>
</label>
<textarea class="textarea1" name="comments" style="background-color:#FFFACD; font-family:serif; font-size:16px" rows="3"></textarea>
<br><br>
<button type="submit" class="btn btn-primary btn-lg" style="font-family:serif; font-size:18px; height:35px; width:230px;">End experiment</button>
</p>
<input type="hidden" name="lastID" value="<?php print $ses_id?>">
<input type="hidden" name="workerID" id="workerID" value="<?print $workerID?>">
<input type="hidden" name="experimentType" id="experimentType" value="<?print $experimentType?>">
<input type="hidden" name="numberPartOfExp" id="numberPartOfExp" value="<?echo $numberPartOfExp ?>">
<input type="hidden" name="impManipVert" value="<?php print $impManipVert?>">
<input type="hidden" name="impManipHor" value="<?php print $impManipHor?>">
<input type="hidden" name="showCorrect" value="<?php print $showCorrect?>">
<input type="hidden" name="showCorrectFromPos" value="<?php print $showCorrectFromPos?>">
<input type="hidden" name="extraMoney" value="<?php print $extraMoneySQL?>">
<input type="hidden" name="percentCorrect" value="<?php print $percentCorrectSQL?>">
</form>



</body>
</html>

<?php


if($_POST){
	
	$sql= "INSERT INTO biastrials(ID,workerID,date,experimentType,numberOfTrial,numberOfRealTrial,delayTimeMS,timeBetweenDispSubmit,timeBetweenDisp1stPress,impossible1OrNot,x1Line,x2Line,y1Line,y2Line,x1Bisection,x2Bisection,y1Bisection,y2Bisection,leftRight,devFromMiddle,whichBigger,levelOfTrial,feedbackType,manipHor,manipVer,margin,topBottom,plusMinus1,valDevArHorizontal,valDevArVertical,valLocArHorizontal,valLocArVertical,devicePixelRatio,keyPressedAns,keyPressedString,isCorrect,countCorrect,countCorrectFromPos,extraFeeCents,percentCalculatedCorrect) 
	VALUES('$ses_id','$workerID',NOW(),'$experimentType','$trialNew','$realTrialNew','$delayTimeMSSQL','$timeIntervalDispSubmit','$timeIntervalDisp1stPress','$impossible1OrNot1SQL','$x1_lineSQL','$x2_lineSQL','$y1_lineSQL','$y2_lineSQL','$x1_bisectionSQL','$x2_bisectionSQL','$y1_bisectionSQL','$y2_bisectionSQL','$left_rightSQL','$dev_from_middleSQL','$whichIsBiggerSQL','$trialLevelSQL','$numberPartOfExp','$impManipHor','$impManipVert','$margSQL','$top_bottomSQL','$plusMinusSQL','$valDevArHorizontal','$valDevArVertical','$valLocArHorizontal','$valLocArVertical','$devicePixelRatioSQL','$number','$letter','$correct','$showCorrect','$showCorrectFromPos','$extraMoneySQL','$percentCorrectSQL')";
	
	if (mysqli_query($conn, $sql)) {
		//echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	
}
mysqli_close($conn);


?>