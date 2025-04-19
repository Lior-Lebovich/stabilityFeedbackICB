<?php
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
$dbname = "timescalegood";
// Create connection
// Check connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(!$_POST){
$newfilename='bisectionLine.png';
$fixationfilename='fixation.png';
$verticalfilename='vertical.png';
$endfilename='beforePassing.png';
$continueExp='experimenttime.php';

$arrayDevHorizontal = array(-10,6,10,0,4,2,0,2,-10,-4,8,-4,0,-4,4,8,8,-6,0,4,6,-4,-6,-10,0,-2,2,2,8,-2,0,-6,-8,0,10,-10,-8,8,2,6,-2,-6,0,-8,4,0,6,-8,4,10,-2,-4,6,10,-2,-8,10,0,-10,-6,-6,2,-4,0,-6,-6,0,2,4,6,-8,-4,0,-2,-2,4,10,-2,0,-4,2,-2,-8,8,-8,-8,8,0,8,4,-10,6,-4,-8,6,6,0,-6,-2,0,10,8,0,-10,2,-6,8,10,0,4,-10,0,-10,10,10,-10,-4,2,4,6,-10,6,10,0,4,2,0,2,-10,-4,8,-4,0,-4,4,8,8,-6,0,4,6,-4,-6,-10,0,-2,2,2,8,-2,0,-6,-8,0,10,-10,-8,8,2,6,-2,-6,0,-8,4,0,6,-8,4,10,-2,-4,6,10,-2,-8,10,0,-10,-6,-6,2,-4,0,-6,-6,0,2,4,6,-8,-4,0,-2,-2,4,10,-2,0,-4,2,-2,-8,8,-8,-8,8,0,8,4,-10,6,-4,-8,6,6,0,-6,-2,0,10,8,0,-10,2,-6,8,10,0,4,-10,0,-10,10,10,-10,-4,2,4,6);
$arrayDevVertical = array(-4,10,-10,2,-4,6,0,2,-10,6,10,-2,0,-2,4,-10,2,-2,0,10,-4,0,-8,8,4,-6,4,0,4,6,0,8,8,-6,-8,-2,0,8,-8,-10,2,2,0,6,6,-6,-10,-8,0,-4,-4,-6,8,4,-8,-2,-6,0,10,10,0,6,-6,-2,6,4,0,2,10,0,-4,2,-8,-10,-2,0,-8,2,8,-6,-4,-10,10,-4,0,8,-2,8,-8,2,-6,-6,-10,0,6,10,-8,-4,8,-8,4,4,0,4,8,0,10,4,2,-4,-2,0,6,6,0,-6,-2,-10,10,-10,-4,10,-10,2,-4,6,0,2,-10,6,10,-2,0,-2,4,-10,2,-2,0,10,-4,0,-8,8,4,-6,4,0,4,6,0,8,8,-6,-8,-2,0,8,-8,-10,2,2,0,6,6,-6,-10,-8,0,-4,-4,-6,8,4,-8,-2,-6,0,10,10,0,6,-6,-2,6,4,0,2,10,0,-4,2,-8,-10,-2,0,-8,2,8,-6,-4,-10,10,-4,0,8,-2,8,-8,2,-6,-6,-10,0,6,10,-8,-4,8,-8,4,4,0,4,8,0,10,4,2,-4,-2,0,6,6,0,-6,-2,-10,10,-10);
$arrayLocHorizontal = array(180,340,180,380,60,20,100,60,20,180,260,380,60,340,220,100,60,140,60,260,140,220,220,220,260,340,180,300,140,20,100,60,340,300,300,140,180,180,380,220,100,180,20,300,340,340,380,220,140,140,60,60,180,260,180,380,220,260,100,340,260,140,300,180,300,100,140,100,100,60,20,140,340,380,140,300,380,260,140,260,220,300,260,300,100,140,340,20,20,20,300,260,100,60,20,300,220,20,220,180,60,220,380,340,260,380,380,100,220,180,60,300,260,340,20,380,20,340,380,100,180,340,180,380,60,20,100,60,20,180,260,380,60,340,220,100,60,140,60,260,140,220,220,220,260,340,180,300,140,20,100,60,340,300,300,140,180,180,380,220,100,180,20,300,340,340,380,220,140,140,60,60,180,260,180,380,220,260,100,340,260,140,300,180,300,100,140,100,100,60,20,140,340,380,140,300,380,260,140,260,220,300,260,300,100,140,340,20,20,20,300,260,100,60,20,300,220,20,220,180,60,220,380,340,260,380,380,100,220,180,60,300,260,340,20,380,20,340,380,100);
$arrayLocVertical = array(380,220,260,260,300,140,340,140,180,260,180,380,20,20,140,140,380,340,220,260,60,140,180,340,60,380,220,260,260,180,220,20,140,140,380,60,100,380,100,380,180,20,340,20,60,300,300,60,20,140,100,60,260,180,260,300,340,380,60,20,380,100,100,140,380,20,60,60,140,140,20,100,340,340,100,260,300,300,60,220,180,60,300,340,300,220,260,300,140,220,20,180,100,300,220,380,220,220,100,20,100,340,180,380,180,100,100,300,340,260,180,60,340,300,180,260,220,220,340,20,380,220,260,260,300,140,340,140,180,260,180,380,20,20,140,140,380,340,220,260,60,140,180,340,60,380,220,260,260,180,220,20,140,140,380,60,100,380,100,380,180,20,340,20,60,300,300,60,20,140,100,60,260,180,260,300,340,380,60,20,380,100,100,140,380,20,60,60,140,140,20,100,340,340,100,260,300,300,60,220,180,60,300,340,300,220,260,300,140,220,20,180,100,300,220,380,220,220,100,20,100,340,180,380,180,100,100,300,340,260,180,60,340,300,180,260,220,220,340,20);


$arrayDevHorizontalString = serialize($arrayDevHorizontal);
$arrayDevVerticalString = serialize($arrayDevVertical);
$arrayLocHorizontalString = serialize($arrayLocHorizontal);
$arrayLocVerticalString = serialize($arrayLocVertical);

$showCorrect=0;
$showCorrectFromPos=0;
$correct=0;
}

if($_POST){
$impossible1OrNot1SQL=(int)$_POST['impossible1OrNot1SQL'];

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

$arrayDevHorizontalString=(string)$_POST["arrayDevHorizontalString"];
$arrayDevVerticalString=(string)$_POST["arrayDevVerticalString"];
$arrayLocHorizontalString=(string)$_POST["arrayLocHorizontalString"];
$arrayLocVerticalString=(string)$_POST["arrayLocVerticalString"];

$arrayDevHorizontal=unserialize($arrayDevHorizontalString);
$arrayDevVertical=unserialize($arrayDevVerticalString);
$arrayLocHorizontal=unserialize($arrayLocHorizontalString);
$arrayLocVertical=unserialize($arrayLocVerticalString);

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
	$correct=rand(0,1);
	$showCorrect=$showCorrect+$correct;
}
// For status:
else{
	$correct=999; // the breaks, e.g. trial no. 31,62,...
}

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





if($trial == 496){ 
	$signal=999;
	$continueExp='endexperimenttime.php';
}
elseif($trial%31 == 0){
	$signal=999;
	$continueExp='experimenttime.php';
}
elseif(($realTrial%6 == 1 || $realTrial%6 == 2 || $realTrial%6 == 3) && trial<496){ 
	$signal=1;
	$continueExp='experimenttime.php';
}
elseif(($realTrial%6 == 4 || $realTrial%6 == 5 || $realTrial%6 == 0) && $trial<496){ 
	$signal=2;
	$continueExp='experimenttime.php';
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
		
		var date1 = new Date();
		n =  date1.getTime();

		document.onkeydown = checkKey;
		function checkKey(e) {
			e = e || window.event;	
			// detecting answer buttons (arrow keys) - only when form was not pseudo-submitted (if answer buttons are not disabled)
			if(document.getElementById('buttonIDtop')!=null && document.getElementById('buttonIDtop').disabled==false)
			{
				if (e.keyCode == '32' && document.getElementById('buttonID').disabled==true) {//'spacebar'
					document.getElementById('buttonID').style.display = 'block'; // the submit button appears, but is hidden. If we don't want to have it at all - we should put it in a comment.
					document.getElementById("buttonID").style.visibility = 'hidden'; // hiding the submit button
					spaceanswer();
					hideimage();
				}
			}
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
		document.getElementById('text_div').style.display = 'block';
		
		document.getElementById('buttonID').style.display = 'block';

		if(document.getElementById('buttonIDright')!=null)
		{
			document.getElementById('buttonIDright').style.display = 'block';
			document.getElementById('buttonIDleft').style.display = 'block';
		}
		if(document.getElementById('buttonIDtop')!=null){
			document.getElementById('buttonIDtop').style.display = 'block';
			document.getElementById('buttonIDbottom').style.display = 'block';
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
			onclick="leftanswer();">';
	}
	?>
	</td> 
	
	
	<td rowspan="3"></td>
	<td><?php if($signal==2){
			print '<input type="button" id="buttonIDtop" display:none value="&#8593;" 
			style="background:#DCDCDC; font-size:45px; height:80px; width:80px; margin-left:auto; margin-right:auto; display:none"
			onclick="topanswer();">';}
	?>
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
if($signal==1){
	horizontalFixation($realTrial,$arrayDevHorizontal,$arrayLocHorizontal);
	horizontalByLevel($realTrial,$arrayDevHorizontal,$arrayLocHorizontal);
}
if($signal==2){
	verticalFixation($realTrial,$arrayDevVertical,$arrayLocVertical);
	verticalByLevel($realTrial,$arrayDevVertical,$arrayLocVertical);
}
if($signal==999){
	showStatus($trial);
}
?>

<div id="text_div" style="display:none">
<?php
$lior=$arrayDevHorizontal[3*floor($realTrial/6)+(($realTrial)%6)-1];
$lior2=$arrayDevVertical[3*floor(($realTrial-3)/6)+(($realTrial-3)%6)-1];
$extraMoney=0.5*$showCorrect;

$percentCorrect = round(10000*$showCorrect/$realTrial)/100;

if($signal == 999){
	$Note1="You have successfully completed ".$realTrial." out of 480 trials and answered ".$showCorrect." of them 
	correctly: ".$percentCorrect."% correct responses.";
	$Note2="Thus far, you have managed to collect extra ".$extraMoney." cents";
	echo "<div style='font-size: large; font-family: sans-serif; color:yellow; text-align:center'> $Note1 </div>";
	echo "<div style='font-size: large; font-family: sans-serif; color:yellow; text-align:center'> $Note2 </div>";
	echo "<div style='font-size: large; font-family: sans-serif; color:#7FFF00; text-align:center'> $Note3 </div>";
	echo "<div style='font-size: large; font-family: sans-serif; color:#7FFF00; text-align:center'> $Note4 </div>";

	echo "<br><br>";
}

?>
</div>


<input type="hidden" name="trial" value="<?php print $trial?>">
<input type="hidden" name="realTrial" value="<?php print $realTrial?>">
<input type="hidden" id="delayTimeMS" name="delayTimeMS" value="<?php print $delayTimeMS?>">
<input type="hidden" name="correct" value="<?php print $correct?>">
<input type="hidden" name="showCorrect" value="<?php print $showCorrect?>">
<input type="hidden" name="showCorrectFromPos" value="<?php print $showCorrectFromPos?>">
<input type="hidden" name="extraMoney" value="<?php print $extraMoney?>">
<input type="hidden" name="percentCorrect" value="<?php print $percentCorrect?>">
<input type="hidden" name="x1_lineSQL" value="<?php print $x1_line?>">
<input type="hidden" name="x2_lineSQL" value="<?php print $x2_line?>">
<input type="hidden" name="y1_lineSQL" value="<?php print $y1_line?>">
<input type="hidden" name="y2_lineSQL" value="<?php print $y2_line?>">
<input type="hidden" name="x1_bisectionSQL" value="<?php print $x1_bisection?>">
<input type="hidden" name="x2_bisectionSQL" value="<?php print $x2_bisection?>">
<input type="hidden" name="y1_bisectionSQL" value="<?php print $y1_bisection?>">
<input type="hidden" name="y2_bisectionSQL" value="<?php print $y2_bisection?>">
<input type="hidden" name="left_rightSQL" value="<?php print $left_right?>">
<input type="hidden" name="impossible1OrNot1SQL" value="<?php print $impossible1OrNot1?>">
<input type="hidden" name="dev_from_middleSQL" value="<?php print $dev_from_middle?>">
<input type="hidden" name="whichIsBiggerSQL" value="<?php print $whichIsBigger?>">
<input type="hidden" name="margSQL" value="<?php print $marg?>">
<input type="hidden" name="top_bottomSQL" value="<?php print $top_bottom?>">
<input type="hidden" name="plusMinusSQL" value="<?php print $plusMinus?>">

<input type="hidden" name="arrayDevHorizontalString" value="<?php print $arrayDevHorizontalString?>">
<input type="hidden" name="arrayDevVerticalString" value="<?php print $arrayDevVerticalString?>">
<input type="hidden" name="arrayLocHorizontalString" value="<?php print $arrayLocHorizontalString?>">
<input type="hidden" name="arrayLocVerticalString" value="<?php print $arrayLocVerticalString?>">

<input type="hidden" name="trialLevelSQL" value="<?php print $trialLevel?>">
<input type="hidden" id="inputnumber" name="numberKey">
<input type="hidden" id="inputletter" name="letterKey">
<input type="hidden" id="input1" name="time2">
<input type="hidden" id="input1stbutton" name="time2firstpress">
<input type="hidden" id="inputQOrP" name="buttonPressed">

<button type="button" id="buttonID"
<?php
	if($signal == 1 || $signal == 2){
	print "disabled ";}
	else{
	print "enabled ";}
?>
  <?php
	if($signal == 1 || $signal == 2){
	print "name=\"whichButtonPressed\" value=\"go\" style=\"font-size:45px; margin-left:auto; margin-right:auto; display:none\" onclick=\"pseudoSubmit();\"";}
	else{
	print "name=\"whichButtonPressed\" value=\"go\" style=\"font-size:15px; height:35px; margin-left:auto; margin-right:auto; display:none\" onclick=\"pseudoSubmit();\"";}
	?> 
>
 <?php
	if($signal == 1 || $signal == 2){
	print "&#10070;";}
	else{
	print "Continue";}
?>
</button>
 
 </td>
</tr>

<tr align="center" align="20px">
	<td><?php if($signal==2){
			print '<input type="button" id="buttonIDbottom" display:none value="&#8595;" 
			style="background:#DCDCDC; font-size:45px; height:80px; width:80px; margin-left:auto; margin-right:auto; display:none"
			onclick="bottomanswer();">';}
	?>
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

function bottomanswer() {
	var t = -1;
	var number3;
	var ts = "B";
	var letter3;
	document.getElementById("buttonID").style.visibility = 'visible'; // showing the submit button
	document.getElementById("buttonID").disabled = false;
	document.getElementById("buttonIDbottom").style.background = "#1E90FF";
	document.getElementById("buttonIDtop").style.background = "#DCDCDC";
	number3=document.getElementById('inputnumber');
	number3.value=t;
	letter3=document.getElementById('inputletter');
	letter3.value += ts;
	if(document.getElementById('input1stbutton').value == null || document.getElementById('input1stbutton').value == "")
		{
		date21stPress = new Date();
		b1stPress = date21stPress.getTime();
		timeRe1stPress=document.getElementById('input1stbutton');
		timeRe1stPress.value=b1stPress-n;	
		}	
}

function topanswer() {
	var w = 1;
	var number4;
	var ws = "T";
	var letter4;
	document.getElementById("buttonID").style.visibility = 'visible'; // showing the submit button
	document.getElementById("buttonID").disabled = false;
	document.getElementById("buttonIDtop").style.background = "#1E90FF";
	document.getElementById("buttonIDbottom").style.background = "#DCDCDC";
	number4=document.getElementById('inputnumber');
	number4.value=w;
	letter4=document.getElementById('inputletter');
	letter4.value += ws;
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
		if(document.getElementById('buttonIDtop')!=null){
			document.getElementById('buttonIDtop').style.display = 'none';
			document.getElementById('buttonIDbottom').style.display = 'none';
			document.getElementById("buttonIDtop").disabled = true;
			document.getElementById("buttonIDbottom").disabled = true;
		}
		// delay beween pseudo-submitting and actual submit (and next trial onset)
		setTimeout(function(){ document.forms["myForm"].submit(); }, document.getElementById("delayTimeMS").value);
	}		

</script>


<script type="text/javascript">	
</script>


</form>
</table>
</body>
</html>

<?php
function horizontalFixation($realTrial,$arrayDevHorizontal,$arrayLocHorizontal){
	global $x1_horizontal;
	global $x2_horizontal;
	global $y1_horizontal;
	global $y2_horizontal;
	global $x1_vertical;
	global $x2_vertical;
	global $y1_vertical;
	global $y2_vertical;	
	global $devFix;
	global $locFix;
	
	$placeInVector=3*floor($realTrial/6)+(($realTrial)%6)-1;
	$lineLength = 200;
	$fixLength = 10;
	
	$im=imagecreatetruecolor(400,400);
	$background_color=ImageColorAllocate($im,0,0,0);
	$text_color=ImageColorAllocate($im,0,0,0);
	
	$devFix=$arrayDevHorizontal[$placeInVector];
	$locFix=$arrayLocHorizontal[$placeInVector];
	
	$x1_horizontal=$lineLength-0.5*$fixLength;
	$x2_horizontal=$lineLength+0.5*$fixLength;
	$y1_horizontal=abs($devFix)+75+(0.5*$locFix);
	$y2_horizontal=abs($devFix)+75+(0.5*$locFix);
	
	$y1_vertical=abs($devFix)+75+(0.5*$locFix)-0.5*$fixLength;
	$y2_vertical=abs($devFix)+75+(0.5*$locFix)+0.5*$fixLength;
	$x1_vertical=$lineLength;
	$x2_vertical=$lineLength;
		
	imagelinethick($im,$x1_horizontal,$y1_horizontal,$x2_horizontal,$y2_horizontal,$text_color,$thick = 2.5);
	imagelinethick($im,$x1_vertical,$y1_vertical,$x2_vertical,$y2_vertical,$text_color,$thick = 2.5);
	
if(isset($_SESSION['old_file5'])){ 
                        unlink($_SESSION['old_file5']); 
                    }
if(!$_POST){
	$fixationfilename='fixation.png';
}else{
	$fixationfilename=uniqid().'.png';
}
$_SESSION['old_file5'] = $fixationfilename;
Imagepng($im,$fixationfilename);
	imagedestroy($im);
	echo "<img src=$fixationfilename style=\"display:none\" id='myImageFixation' onload=\"loadFunFixation()\"/>";
}

?>

<?php
function verticalFixation($realTrial,$arrayDevVertical,$arrayLocVertical){
	global $x1_horizontal;
	global $x2_horizontal;
	global $y1_horizontal;
	global $y2_horizontal;
	global $x1_vertical;
	global $x2_vertical;
	global $y1_vertical;
	global $y2_vertical;	
	global $devFix;
	global $locFix;
	
	$placeInVector=3*floor(($realTrial-3)/6)+(($realTrial-3)%6)-1;
	$lineLength = 200;
	$fixLength = 10;
	
	$im=imagecreatetruecolor(400,400);
	$background_color=ImageColorAllocate($im,0,0,0);
	$text_color=ImageColorAllocate($im,0,0,0);
	
	$devFix=$arrayDevVertical[$placeInVector];
	$locFix=$arrayLocVertical[$placeInVector];
	
	$x1_horizontal=$locFix-0.5*$fixLength;
	$x2_horizontal=$locFix+0.5*$fixLength;
	$y1_horizontal=$devFix+110;
	$y2_horizontal=$devFix+110;
	
	$y1_vertical=$devFix-0.5*$fixLength+110;
	$y2_vertical=$devFix+0.5*$fixLength+110;
	$x1_vertical=$locFix;
	$x2_vertical=$locFix;
		
	imagelinethick($im,$x1_horizontal,$y1_horizontal,$x2_horizontal,$y2_horizontal,$text_color,$thick = 2.5);
	imagelinethick($im,$x1_vertical,$y1_vertical,$x2_vertical,$y2_vertical,$text_color,$thick = 2.5);
	
if(isset($_SESSION['old_file4'])){ 
                        unlink($_SESSION['old_file4']); 
                    }
if(!$_POST){
	$fixationfilename='fixation.png';
}else{
	$fixationfilename=uniqid().'.png';
}
$_SESSION['old_file4'] = $fixationfilename;
Imagepng($im,$fixationfilename);
	imagedestroy($im);
	echo "<img src=$fixationfilename style=\"display:none\" id='myImageFixation' onload=\"loadFunFixation()\"/>";
}

?>

<?php
function showStatus($trial){
	global $trialLevel;
	$trialLevel="status";
	$width_height = 400;
	$im=imagecreatetruecolor($width_height,$width_height);
	$background_color=ImageColorAllocate($im,0,0,0);
	$text_color=ImageColorAllocate($im,255,255,255);
	$font = 'arial.ttf';
	$text = 'Good job!';
	$size = 60;
	$continueExp='endexperimenttime.php';
	imagettftext($im,$size,0,20,200,$text_color,$font,$text);
	if(isset($_SESSION['old_file3'])){ 
                        unlink($_SESSION['old_file3']); 
						}
	if(!$_POST){
	$endfilename='beforePassing.png';
	}else{
			$endfilename=uniqid().'.png';
	}
	$_SESSION['old_file3'] = $endfilename;
	imagepng($im, $endfilename);
	echo "<img src=$endfilename style=\"display:none\" id='myImage' onload=\"loadFun()\"/>";	
	imagedestroy($im);
}



function horizontalByLevel($realTrial,$arrayDevHorizontal,$arrayLocHorizontal){
		//Note that this function uses 2 Gaussian circles, given the their radiuses, from existing PNGs.
	//PAY ATTENTION: there's a MATLAB function that created them for 1<R<200. If you use longer R -> use that function to create more relevant PNGs.
	global $trialLevel;
	global $x1_line;
	global $x2_line;
	global $y1_line;
	global $y2_line;
	global $x1_bisection;
	global $x2_bisection;
	global $y1_bisection;
	global $y2_bisection;	
	global $left_right;
	global $impossible1OrNot1;
	global $dev_from_middle;
	global $whichIsBigger;
	global $marg;
	global $plusMinus;
	
	global $circleImpossibleRadius;
	global $distBetweenCircles;
	global $circle1radius;
	global $circle2radius;
	global $circle1widthAndHeight;
	global $circle2widthAndHeight;
	global $maximalRadiusFrom2;
	
	$placeInVector=3*floor($realTrial/6)+(($realTrial)%6)-1;
	
	$width_height = 400;
	$lineLength = 200;
	$marg = 0;
	$circleImpossibleRadius=75;  // 75
	$distBetweenCircles=2;//50; // was really 2
	
	$im=imagecreatetruecolor($width_height,$width_height);
	$background_color=ImageColorAllocate($im,0,0,0);
	$text_color=ImageColorAllocate($im,255,255,255);
	
	if($arrayDevHorizontal[$placeInVector] == 0){
		$impossible1OrNot1=1;	
		$plusMinus=0;
		$left_right=999;
		$trialLevel="impossibleHorizontal";
		$whichIsBigger="equal";
	}
	elseif($arrayDevHorizontal[$placeInVector] > 0){
		$impossible1OrNot1=0;
		$plusMinus=-1;
		$left_right=0;
		$trialLevel="possibleHorizontal";
		$whichIsBigger="left";
	}
	elseif($arrayDevHorizontal[$placeInVector] < 0){
		$impossible1OrNot1=0;
		$plusMinus=1;
		$left_right=1;
		$trialLevel="possibleHorizontal";
		$whichIsBigger="right";
	}
	else{//ERROR
		$impossible1OrNot1=8888;
		$whichIsBigger="ERROR";
	}
	
	$dev_from_middle=$arrayDevHorizontal[$placeInVector];

	$circle1radius=$circleImpossibleRadius+$dev_from_middle; // left
	$circle2radius=$circleImpossibleRadius-$dev_from_middle; // right
	$circle1widthAndHeight=2*$circle1radius;
	$circle2widthAndHeight=2*$circle2radius;
	$maximalRadiusFrom2=max($circle1radius,$circle2radius);
	
	//defining the circles' location
	$y1_line=$arrayLocHorizontal[$placeInVector];	
	if($circle1radius > $circle2radius){
		$circle1yStartCoords=0.5*$y1_line;
		$circle2yStartCoords=(0.5*$y1_line)+$circle1radius-$circle2radius;
	}
	else{
		$circle2yStartCoords=0.5*$y1_line;
		$circle1yStartCoords=(0.5*$y1_line)+$circle2radius-$circle1radius;
	}
	$circle1xStartCoords=99-$circle1radius;
	$circle2xStartCoords=301-$circle2radius;
	$x1_bisection=$circle1xStartCoords;
	$y1_bisection=$circle1yStartCoords;
	$x2_bisection=$circle2xStartCoords;
	$y2_bisection=$circle2yStartCoords;
	
	$str1 = "circleRadius" . $circle1radius . ".png";
	$str2 = "circleRadius" . $circle2radius . ".png";
	$src1 = imagecreatefrompng($str1);
	$src2 = imagecreatefrompng($str2);
	imagecopymerge($im,$src1,$circle1xStartCoords,$circle1yStartCoords,0,0,$circle1widthAndHeight,$circle1widthAndHeight,100);
	imagecopymerge($im,$src2,$circle2xStartCoords,$circle2yStartCoords,0,0,$circle2widthAndHeight,$circle2widthAndHeight,100);

if(isset($_SESSION['old_file1'])){ 
                        unlink($_SESSION['old_file1']); 
                    }
if(!$_POST){
$newfilename='bisectionLine.png';
}else{
        $newfilename=uniqid().'.png';
}
$_SESSION['old_file1'] = $newfilename;
       imagepng($im, $newfilename);
	imagedestroy($im);
	echo "<img src=$newfilename style=\"display:none\" id='myImage'/>";
}

?>

<?php
function verticalByLevel($realTrial,$arrayDevVertical,$arrayLocVertical){
	global $trialLevel;
	global $x1_line;
	global $x2_line;
	global $y1_line;
	global $y2_line;
	global $x1_bisection;
	global $x2_bisection;
	global $y1_bisection;
	global $y2_bisection;	
	global $top_bottom;
	global $impossible1OrNot1;
	global $dev_from_middle;
	global $whichIsBigger;
	global $marg;
	global $plusMinus;
	$placeInVector=3*floor(($realTrial-3)/6)+(($realTrial-3)%6)-1;
	$width_height = 400;
	$lineLength = 200;
	$bisectionLineWidth = 20;
	$marg = 0.5*$bisectionLineWidth;
	$im=imagecreatetruecolor($width_height,$width_height);
	$background_color=ImageColorAllocate($im,0,0,0);
	$text_color=ImageColorAllocate($im,255,255,255);
	$y1_line=10;
	$y2_line=$y1_line+$lineLength;
	$x1_line=$arrayLocVertical[$placeInVector];
	$x2_line=$x1_line;
	$x1_bisection=$x1_line-0.5*$bisectionLineWidth;
	$x2_bisection=$x1_line+0.5*$bisectionLineWidth;

	if($arrayDevVertical[$placeInVector] == 0){
		$impossible1OrNot1=1;	
		$plusMinus=0;
		$top_bottom=999;
		$trialLevel="impossibleVertical";
		$whichIsBigger="equal";
	}
	elseif($arrayDevVertical[$placeInVector] > 0){
		$impossible1OrNot1=0;
		$plusMinus=-1;
		$top_bottom=1;
		$trialLevel="possibleVertical";
		$whichIsBigger="top";
	}
	elseif($arrayDevVertical[$placeInVector] < 0){
		$impossible1OrNot1=0;
		$plusMinus=1;
		$top_bottom=0;
		$trialLevel="possibleVertical";
		$whichIsBigger="bottom";
	}
	else{//ERROR
		$impossible1OrNot1=8888;
		$whichIsBigger="ERROR";
	}
	
	$dev_from_middle=$arrayDevVertical[$placeInVector];
	$y1_bisection=0.5*($y1_line+$y2_line)+$dev_from_middle;	
	$y2_bisection=$y1_bisection;

	imagelinethick($im,$x1_line,$y1_line,$x2_line,$y2_line,$text_color,$thick = 2.5);
	imagelinethick($im,$x1_bisection,$y1_bisection,$x2_bisection,$y2_bisection,$text_color,$thick = 2.5);
	
if(isset($_SESSION['old_file2'])){ 
                        unlink($_SESSION['old_file2']); 
                    }
if(!$_POST){
	$verticalfilename='vertical.png';
}else{
	$verticalfilename=uniqid().'.png';
}
$_SESSION['old_file2'] = $verticalfilename;
Imagepng($im,$verticalfilename);
	imagedestroy($im);
	echo "<img src=$verticalfilename style=\"display:none\" id='myImage'/>";
}

?>

<?php
function imagelinethick($image, $x1, $y1, $x2, $y2, $color, $thick = 1){
    if ($thick == 1) {
        return imageline($image, $x1, $y1, $x2, $y2, $color);
    }
    $t = $thick / 2 - 0.5;
    if ($x1 == $x2 || $y1 == $y2) {
        return imagefilledrectangle($image, round(min($x1, $x2) - $t), round(min($y1, $y2) - $t), round(max($x1, $x2) + $t), round(max($y1, $y2) + $t), $color);
    }
    $k = ($y2 - $y1) / ($x2 - $x1); //y = kx + q
    $a = $t / sqrt(1 + pow($k, 2));
    $points = array(
        round($x1 - (1+$k)*$a), round($y1 + (1-$k)*$a),
        round($x1 - (1-$k)*$a), round($y1 - (1+$k)*$a),
        round($x2 + (1+$k)*$a), round($y2 - (1-$k)*$a),
        round($x2 + (1-$k)*$a), round($y2 + (1+$k)*$a),
    );
    imagefilledpolygon($image, $points, 4, $color);
    return imagepolygon($image, $points, 4, $color);
}
?>

<?php
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


if($_POST){

	$sql= "INSERT INTO biastrials(ID,numberOfTrial,numberOfRealTrial,delayTimeMS,timeBetweenDispSubmit,timeBetweenDisp1stPress,impossible1OrNot,x1Line,x2Line,y1Line,y2Line,x1Bisection,x2Bisection,y1Bisection,y2Bisection,leftRight,devFromMiddle,whichBigger,levelOfTrial,margin,topBottom,plusMinus1,valDevArHorizontal,valDevArVertical,valLocArHorizontal,valLocArVertical,keyPressedAns,keyPressedString,isCorrect,countCorrect,countCorrectFromPos,extraFeeCents,percentCalculatedCorrect) 
	VALUES('$ses_id','$trialNew','$realTrialNew','$delayTimeMSSQL','$timeIntervalDispSubmit','$timeIntervalDisp1stPress','$impossible1OrNot1SQL','$x1_lineSQL','$x2_lineSQL','$y1_lineSQL','$y2_lineSQL','$x1_bisectionSQL','$x2_bisectionSQL','$y1_bisectionSQL','$y2_bisectionSQL','$left_rightSQL','$dev_from_middleSQL','$whichIsBiggerSQL','$trialLevelSQL','$margSQL','$top_bottomSQL','$plusMinusSQL','$valDevArHorizontal','$valDevArVertical','$valLocArHorizontal','$valLocArVertical','$number','$letter','$correct','$showCorrect','$showCorrectFromPos','$extraMoneySQL','$percentCorrectSQL')";
	
	if (mysqli_query($conn, $sql)) {
		//echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

}
mysqli_close($conn);

?>
