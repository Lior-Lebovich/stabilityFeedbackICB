<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$ses_id=session_id();

$servername = "";
$username = "";
$password = "";
$dbname = "timescalegood";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


if(!$_POST){
	$sql2 = "SELECT DISTINCT workerID FROM biasform WHERE ID = '".substr($ses_id, 0, 26)."'";
	$row2=mysqli_fetch_array(mysqli_query($conn, $sql2));
	$workerID=$row2['workerID'];
	$sql3 = "SELECT DISTINCT experimentType FROM biasform WHERE ID = '".substr($ses_id, 0, 26)."'";
	$row3=mysqli_fetch_array(mysqli_query($conn, $sql3));
	$experimentType=$row3['experimentType'];
	
	$continueExp='demobl.php';
	//adding the offsets to the sides:
	$arrayBL = array(1,4,2,3); // 1=right is longer, 0=left is longer
	shuffle($arrayBL); //radomzing the 4
	$arrayBLString = serialize($arrayBL);

	$pastLongerBL=999;
	$showCorrect=0;
	$correct=0;
}

if($_POST){
$workerID=(string)$_POST['workerID'];
$experimentType=(string)$_POST['experimentType'];
$oldfilename=(string)$_POST["oldfilename"];
$left_rightSQL=(int)$_POST['left_rightSQL'];
$whichIsBiggerSQL=(string)$_POST['whichIsBiggerSQL'];
$newfilename2=(string)$_POST["newfilename"];
$arrayBLString=(string)$_POST["arrayBLString"];

$arrayBL=unserialize($arrayBLString);

$buttonPressed=$_POST['buttonPressed'];
$timeIntervalDispSubmit=$_POST['time2'];
$timeIntervalDisp1stPress=$_POST['time2firstpress'];

$number=$_POST['numberKey'];

$correct=(int)$_POST['correct'];
$showCorrect=$_POST['showCorrect'];

$trial=(int)$_POST['trial'];
$realTrial=(int)$_POST['realTrial'];
$delayTimeMSSQL=$_POST['delayTimeMS'];
//srcoring: 
if( ($whichIsBiggerSQL == 'equal') ||
	($whichIsBiggerSQL == 'right' && $number == 1) ||
	($whichIsBiggerSQL == 'left' && $number == -1)) {
	$correct=1;
	$showCorrect++;
}
elseif(($whichIsBiggerSQL == 'left' && $number == 1) || 
	($whichIsBiggerSQL == 'right' && $number == -1)){
	$correct=0;
}
else{
	$correct=999; // the breaks, e.g. trial no. 31,62,...
}


}

if($experimentType=="fast"){
	$delayTimeMS = 500;
}
elseif($experimentType=="slow"){
	$delayTimeMS = 2000;
}
else{
	$delayTimeMS = 500;
}

$trial ++;
if($trial%8 == 0 && $trial>1){
	$realTrial=8;
	//creating a new shuffle in case there would be another session:
	$arrayBL = array(1,4,2,3); // 1=right is longer, 0=left is longer:
	shuffle($arrayBL); //radomizing the 4
	$arrayBLString = serialize($arrayBL);
}
else{
	$realTrial=$trial%8;
}

//reseting $showCorrect, i.e. count of correct responses in a session:
if($trial%8 == 1 && $trial > 1 && $showCorrect != 4){
	$showCorrect=0;
}

if($trial%8 == 0 && $showCorrect != 4){ //do this demo session again
	$signal=999;
	$continueExp='demobl.php';
}
elseif($trial%8 == 0 && $showCorrect == 4){ //go to next demo session
	$signal=999;
	$continueExp='startdemo2.php';
}
elseif($trial%2 == 0){ //stay and show picture
	$signal=999;
	$continueExp='demobl.php';
}
elseif($trial%2 == 1){ //stay and give another trial
	$signal=1;
	$continueExp='demobl.php';
}

?>


<html>
<head>
<script type="text/javascript">
var l;	
function loadFunFixation(){
	
	l=document.getElementById('myImageFixation');
	document.body.style.cursor = 'none';
	l.style.display = 'block';

setTimeout(hideimageFixation,250);
}
</script>

<script type="text/javascript">		
	var n;

	function hideimageFixation() {
		document.getElementById('myImageFixation').style.display = 'none';
		document.body.style.cursor = 'none';
		document.getElementById('myImage').style.display = 'block';
		setTimeout(function(){ 
			alert("Press the space bar key once you decided which circle is bigger. Then click on the left/right arrow button to report your response. Click on the central button to continue to the next trial. You will not see this message during the experiment."); 
			}, 100);
		
		var date1 = new Date();
		n =  date1.getTime();

		document.onkeydown = checkKey;
		function checkKey(e) {
			e = e || window.event;	
			// detecting answer buttons (arrow keys) - only when form was not pseudo-submitted (if answer buttons are not disabled)
			if(document.getElementById('buttonIDright')!=null && document.getElementById('buttonIDright').disabled==false)
			{
				if (e.keyCode == '32' && document.getElementById('buttonID').disabled==true) {//'spacebar'
					document.getElementById('buttonID').style.display = 'block'; // the submit button appears, but is hidden. If we don't want to have it at all - we should put it in a comment.
					document.getElementById("buttonID").style.visibility = 'hidden'; // hiding the submit button
					spaceanswer();
					hideimage();
				}
			}
		}		
	}			
</script>

<script type="text/javascript">		

	function hideimage() {
		document.getElementById('myImage').style.display = 'none';
		document.body.style.cursor = 'initial';
		document.getElementById('buttonID').style.display = 'block';
		
		if(document.getElementById('text_div')!=null){
			document.getElementById('text_div').style.display = 'block';
		}
		if(document.getElementById('buttonIDright')!=null)
		{
			document.getElementById('buttonIDright').style.display = 'block';
			document.getElementById('buttonIDleft').style.display = 'block';
		}
		document.getElementById('myForm').style.display = 'block';
		document.getElementById('inputQOrP').style.display = 'block';
	}			
</script>

<script type="text/javascript">		
function loadFun(){
	if(document.getElementById('myImageFixation')!=null){
		document.getElementById('myImageFixation').style.display = 'none';
	}
	l=document.getElementById('myImage');
	document.body.style.cursor = 'none';
	l.style.display = 'block';

setTimeout(hideimage,1000);
}
</script>

</head>
<body bgcolor="#000000">
<TABLE BORDER="0" width="100%" height=100%>
<form id="myForm" name="myForm" action="<?php print $continueExp?>" method="post">

<tr align="center" align="20px">
	<td colspan="5"></td>
</tr>

<tr align="center" align="20px">
	<td rowspan="3">
	<?php if($signal==1){
			print '<input type="button" id="buttonIDleft" value="&#8592;" 
			style="background:#DCDCDC; font-size:45px; height:80px; width:80px; margin-left:auto; margin-right:auto; display:none"
			onclick="leftanswer();">';}
	?>
	</td> 
	
	
	<td rowspan="3"></td>
	<td>
	</td> 
	<td rowspan="3"></td>
	<td rowspan="3">
	<?php if($signal==1){
			print '<input type="button" id="buttonIDright" value="&#8594;" 
			style="background:#DCDCDC; font-size:45px; height:80px; width:80px; margin-left:auto; margin-right:auto; display:none"
			onclick="rightanswer();">';}
	?>
	</td>
</tr>
  
<tr align="center" align="20px">
	<td>

	
	
<?php
$pic_num=$arrayBL[floor($realTrial/2)];
if($pic_num==1){
	$fixationfilename="nofixation.png";
	$newfilename="demoexamplecircle1.png";
	$left_right=1;
	$whichIsBigger="right";
	}
elseif($pic_num==2){
	$fixationfilename="nofixation.png";
	$newfilename="demoexamplecircle2.png";
	$left_right=1;
	$whichIsBigger="right";
	}
elseif($pic_num==3){
	$fixationfilename="nofixation.png";
	$newfilename="demoexamplecircle3.png";
	$left_right=0;
	$whichIsBigger="left";
	}
elseif($pic_num==4){
	$fixationfilename="nofixation.png";
	$newfilename="demoexamplecircle4.png";
	$left_right=0;
	$whichIsBigger="left";
	}

if($signal==1){
	echo "<img src=$fixationfilename style=\"display:none\" id='myImageFixation' onload=\"loadFunFixation()\"/>";
	echo "<img src=$newfilename style=\"display:none\" id='myImage'/>";
}
if($signal==999){
	if($left_rightSQL == 1){
		$correctSide="right";
	}
	elseif($left_rightSQL == 0){
		$correctSide="left";
	}
	$buttonImagename='button'.$correctSide.'.png';
	if($correct == 1){
		$fixationfilenamesmiley = "smileyhappy.png";
		$goodBadNote="Good job!";
	}
	elseif($correct == 0){
		$fixationfilenamesmiley = "smileysad.png";
		$goodBadNote="Your answer was incorrect.";
	}

	echo "<img src=$fixationfilenamesmiley style=\"display:none\" id='myImage' onload=\"loadFun()\"/>";
	$Note1=$goodBadNote;
	$Note2="because the ".$correctSide." circle is bigger.";
	echo "<div id=\"text_div\" style=\"display:none\">";
	echo "<img style='border:1px solid blue' src=$oldfilename id='myImage2'/>";
	echo "<br>";
	echo "<div style='font-size: large; font-family: sans-serif; color:yellow; text-align:center'> $Note1 </div>";
	echo "<div style='font-size: large; font-family: sans-serif; color:yellow; text-align:center'> The correct answer was: </div>";
	echo "<img style='width:65px' src=$buttonImagename id='myImage3'/>";
	echo "<div style='font-size: large; font-family: sans-serif; color:yellow; text-align:center'> $Note2 </div>";

	echo "</div>";
}

?>

<input type="hidden" name="trial" value="<?php print $trial?>">
<input type="hidden" name="realTrial" value="<?php print $realTrial?>">
<input type="hidden" id="delayTimeMS" name="delayTimeMS" value="<?php print $delayTimeMS?>">
<input type="hidden" name="correct" value="<?php print $correct?>">
<input type="hidden" name="showCorrect" value="<?php print $showCorrect?>">
<input type="hidden" name="newfilename" value="<?php print $newfilename?>">

<input type="hidden" name="left_rightSQL" value="<?php print $left_right?>">
<input type="hidden" name="dev_from_middleSQL" value="<?php print $dev_from_middle?>">
<input type="hidden" name="whichIsBiggerSQL" value="<?php print $whichIsBigger?>">
<input type="hidden" name="arrayBLString" value="<?php print $arrayBLString?>">
<input type="hidden" name="trialLevelSQL" value="<?php print $trialLevel?>">
<input type="hidden" id="inputnumber" name="numberKey">
<input type="hidden" id="inputletter" name="letterKey">
<input type="hidden" id="input1" name="time2">
<input type="hidden" id="inputQOrP" name="buttonPressed">
<input type="hidden"  name="workerID" id="workerID" value="<?print $workerID?>">
<input type="hidden"  name="experimentType" id="experimentType" value="<?print $experimentType?>">
<input type="hidden" id="input1stbutton" name="time2firstpress">
<input type="hidden" id="oldfilename" name="oldfilename" value="<?print $newfilename?>">

<button type="submit" id="buttonID" 
 <?php
	if($signal == 1){
	print "disabled ";}
	else{
	print "enabled ";}
 ?>
 
 <?php
	if($signal == 1){
	print "name=\"whichButtonPressed\" value=\"go\" style=\"font-size:45px; margin-left:auto; margin-right:auto; display:none\" onclick=\"pseudoSubmit();\"";}
	else{
	print "name=\"whichButtonPressed\" value=\"go\" style=\"font-size:15px; height:35px; margin-left:auto; margin-right:auto; display:none\" onclick=\"pseudoSubmit();\"";}
?>
>

 <?php
	if($signal == 1){
	print "&#10070;";}
	else{
	print "Continue";}
 ?>
 </button>
 
 </td>
</tr>

<tr align="center" align="20px">
	<td>
	</td>
</tr>

<tr align="center" align="20px">
	<td colspan="5"></td>
</tr>
<script type="text/javascript">
	
	var timeRe1stPress;
	var date21stPress;
	var b1stPress;

function spaceanswer() {
	var k = 0;
	var number1;
	var ks = "S";
	var letter1;	
	number1=document.getElementById('inputnumber');
	number1.value=k;
	letter1=document.getElementById('inputletter');
	letter1.value += ks;	
	if(document.getElementById('input1stbutton').value == null || document.getElementById('input1stbutton').value == "")
		{
		date21stPress = new Date();
		b1stPress = date21stPress.getTime();
		timeRe1stPress=document.getElementById('input1stbutton');
		timeRe1stPress.value=b1stPress-n;	
		}		
}	
	
function leftanswer() {
	var x = -1;
	var number1;
	var xs = "L";
	var letter1;
	document.getElementById("buttonID").style.visibility = 'visible'; // showing the submit button
	document.getElementById("buttonID").disabled = false;
	document.getElementById("buttonIDleft").style.background = "#1E90FF";
	document.getElementById("buttonIDright").style.background = "#DCDCDC";
	number1=document.getElementById('inputnumber');
	number1.value=x;
	letter1=document.getElementById('inputletter');
	letter1.value += xs;	
	if(document.getElementById('input1stbutton').value == null || document.getElementById('input1stbutton').value == "")
		{
		date21stPress = new Date();
		b1stPress = date21stPress.getTime();
		timeRe1stPress=document.getElementById('input1stbutton');
		timeRe1stPress.value=b1stPress-n;	
		}		
}

function rightanswer() {
	var y = 1;
	var number2;
	var ys = "R";
	var letter2;
	document.getElementById("buttonID").style.visibility = 'visible'; // showing the submit button
	document.getElementById("buttonID").disabled = false;
	document.getElementById("buttonIDright").style.background = "#1E90FF";
	document.getElementById("buttonIDleft").style.background = "#DCDCDC";
	number2=document.getElementById('inputnumber');
	number2.value=y;
	letter2=document.getElementById('inputletter');
	letter2.value += ys;
	if(document.getElementById('input1stbutton').value == null || document.getElementById('input1stbutton').value == "")
		{
		date21stPress = new Date();
		b1stPress = date21stPress.getTime();
		timeRe1stPress=document.getElementById('input1stbutton');
		timeRe1stPress.value=b1stPress-n;	
		}	
}

	var timeRe;
	var date2;
	var b;
	function pseudoSubmit(){
		// time between stimulus onset and pseudoSubmit press
		 date2 = new Date();
		 b = date2.getTime();
		 timeRe=document.getElementById('input1');
		 timeRe.value=b-n;		
		// blank screen:
		document.body.style.cursor = 'none';
		document.getElementById('buttonID').style.display = 'none';
		document.getElementById("buttonID").disabled = true;
		if(document.getElementById('buttonIDright')!=null)
		{
			document.getElementById('buttonIDright').style.display = 'none';
			document.getElementById('buttonIDleft').style.display = 'none';
			document.getElementById("buttonIDright").disabled = true;
			document.getElementById("buttonIDleft").disabled = true;
		}
		if(document.getElementById('myImage2')!=null)
		{
			document.getElementById('myImage2').style.display = 'none';
			document.getElementById('myImage3').style.display = 'none';
			document.getElementById('text_div').style.display = 'none';
		}
		// delay beween pseudo-submitting and actual submit (and next trial onset)
		setTimeout(function(){ document.forms["myForm"].submit(); }, document.getElementById("delayTimeMS").value);
	}		

</script>

</form>
</table>
</body>
</html>

<?php
$valImpArBL=$arrayBL[floor($realTrial/2)];

if($realTrial==1){
	$realTrialNew=8;
}
else{
	$realTrialNew=$realTrial-1;
}

if($_POST){
	$trialNew=$trial-1;//check if changing this and next is needed
	
	$sql= "INSERT INTO demobl(ID,workerID,experimentType,numberOfTrial,numberOfRealTrial,delayTimeMS,timeBetweenDispSubmit,timeBetweenDisp1stPress,date,leftRight,whichBigger,valImpArBL,keyPressedAns,isCorrect,countCorrect) 
	VALUES('$ses_id','$workerID','$experimentType','$trialNew','$realTrialNew','$delayTimeMSSQL','$timeIntervalDispSubmit','$timeIntervalDisp1stPress',NOW(),'$left_rightSQL','$whichIsBiggerSQL','$valImpArBL','$number','$correct','$showCorrect')";
	if (mysqli_query($conn, $sql)) {
		//echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	
}
mysqli_close($conn);

?>
