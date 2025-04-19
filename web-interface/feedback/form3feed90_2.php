<?php
$countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
ini_set('display_errors', 'On');
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$ses_id=session_id();
$workerID=$_POST['workerID'];
$numberPartOfExp=$_POST['numberPartOfExp'];
$servername = "";
$username = "";
$password = "";
$dbname = "timescale3feed902";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
$conn1 = mysqli_connect($servername, $username, $password, "timescale3feed901");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// check if exists in biastrials:
$sql1 = "SELECT * FROM biastrials WHERE workerID = '".$workerID."'";
$results1=mysqli_query($conn, $sql1);
$sumResults1 = mysqli_num_rows($results1);

$sql2 = "SELECT * FROM expcomments WHERE workerID = '".$workerID."'";
$sql2b = "SELECT DISTINCT experimentType FROM expcomments WHERE workerID = '".$workerID."' LIMIT 1";
$sql2HourDiff = "SELECT DISTINCT 
(TIMESTAMPDIFF(MINUTE, date, NOW())/60) AS hourDiff 
FROM expcomments 
WHERE workerID = '".$workerID."' 
ORDER BY hourDiff DESC LIMIT 1";

$results=mysqli_query($conn1, $sql2);
$rowExpType = mysqli_fetch_array(mysqli_query($conn1, $sql2b));
$experimentType=$rowExpType['experimentType'];

$sumResults = mysqli_num_rows($results);

$results_deltaHour=mysqli_query($conn1, $sql2HourDiff);

if ($results_deltaHour->num_rows > 0) {
    // output data of each row
    while($row = $results_deltaHour->fetch_assoc()) {
		$deltaHour = $row["hourDiff"];
    }
} 
else {
    //echo "0 results";
}


mysqli_close($conn1);



$dayCond = 1;


$idealHourDiff = 24;
$maxHourDiff = 24*($dayCond+2);
$HourDiff2Start = $idealHourDiff-$deltaHour;

if( $sumResults1>=1 ){ 
	$good=7; // already started this session. cannot continue
}
elseif( $sumResults>=1 && ( ($deltaHour >= $idealHourDiff) && ($deltaHour <= $maxHourDiff)  ) )
{
	$good=1; // can start the experiment
	$sql3 = "SELECT DISTINCT experimentType, manVer, manHor FROM matching WHERE workerID = '".substr($workerID, 0, 50)."'";
	$row3=mysqli_fetch_array(mysqli_query($conn, $sql3));
	$experimentType=$row3['experimentType'];
	$manHor=$row3['manHor'];
	$manVer=$row3['manVer'];
}
elseif( $sumResults>=1 && ($deltaHour < $idealHourDiff) )
{
	$good=9; // not yet time to start 
}
elseif( $sumResults>=1 && ($deltaHour > $maxHourDiff) )
{
	$good=8; // too late to start the experiment
}
else{
	$good=0; // cannot find workerID in our database
}
?>

<html>
<head>
<meta charset="utf-8"/>

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


<?php

$sql = "INSERT INTO part2 (ID,date)
VALUES ('$ses_id',NOW())";
if (mysqli_query($conn, $sql)) {
    //echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>

<form id="myForm" name="myForm" class="form-horizontal" action="instructions3feed90_2.php" method="post">

<p id="intro2" name="intro2" class="form_div">
	This worker ID does not exist in our database.<br>
	Please try retyping your worker ID again (with no spaces) in the 
	<a href="https://decision-making-lab.com/f3/pre_form_3feed90_2.php">
	previous page</a>.<br><br>
	If you see this message again then plesae email us at: 
	<a href="mailto:@gmail.com">@gmail.com</a>
</p>

<p id="introTime" name="introTime" class="form_div">
	You can start the second experiment in:  <b>
	<?php echo floor($HourDiff2Start/24); ?> days : 
	<?php echo (floor($HourDiff2Start)-(24*floor($HourDiff2Start/24))); ?> hours : 
	<?php echo (floor($HourDiff2Start*60)-(60*floor($HourDiff2Start))); ?> minutes</b>    from now.<br>
	<br>
	Note that once the countdown is over, you will have a time slot of <?php echo floor(($maxHourDiff-$idealHourDiff)/24) ; ?> 
	days to start the second experiment. 
	After this <?php echo floor(($maxHourDiff-$idealHourDiff)/24) ; ?>  days time slot passes, 
	it will no longer be possible to start the second experiment.<br><br>
	For further questions, please contact us at: 
	<a href="mailto:@gmail.com">@gmail.com</a>
	<br><br>
	<b>To check again for the time until the second experiment, please reload the page.</b>
	
</p>

<p id="introStarted" name="introStarted" class="form_div">
	It seems like you already participated in the second experiment.<br>
	It is not possible to participate in an experiment more than once.<br><br>
	If this seems like a mistake - please contact us at: 
	<a href="mailto:@gmail.com">@gmail.com</a>
	
</p>

<p id="introLate" name="introLate" class="form_div">
	You missed your time slot for starting the experiment.<br><br>
	For a new time slot, please contact us at: 
	<a href="mailto:@gmail.com">@gmail.com</a>
	
</p>

<p id="intro" name="intro" class="form_div">

<b>Welcome to the second experiment!</b><br><br>
The completion code for this HIT will be provided at the end of the following experiment.<br><br>

	<u>General instructions</u>:<br>
	After filling in the following form and pressing the "Submit" button, you will be given instructions about the tasks you are about to perform.<br>
	Please make sure that you understand the instructions before the experiment begins.<br><br>
	<b>If you usually use vision aids (i.e. eyeglasses or contact lens) please make sure to wear them during the experiment.</b>
	<br>
</p>

<div id="agePart" name="agePart" class="form_div">
	<span class="error">* required fields.</span><br>
	<b><u>General details</u>:</b><br><br>
	<label for="age" >Age:</label>
	<div class="col-sm-10">
	<select name="age" ng-model="selectedObject" ng-options="obj for obj in Objects" required>
		<option name="age" value="" ng-if="!selectedObject">-- fill in your age --</option>
		<?php 
			for($value = 18; $value <= 120; $value++){ 
				echo('<option name="age" value="' . $value . '">' . $value . '</option>');
			}
		?>
	</select>
	<span class="error">* <?php echo $nameErr;?></span>
	</div>
	<br>

    <label for="sex" >Sex:</label>
	<div class="col-sm-10">
	<select name="sex" ng-model="selectedObject" ng-options="obj for obj in Objects" required>
		<option name="sex" value="" ng-if="!selectedObject">-- fill in your sex --</option>
		<option name="sex" value="Female">Female</option>
		<option name="sex" value="Male">Male</option>
	</select>
	<span class="error">* <?php echo $nameErr;?></span>
	</div>
	<br>

    <label for="education" >Education:</label>
	<div class="col-sm-10">
	<select name="education" ng-model="selectedObject" ng-options="obj for obj in Objects" required>
		<option name="education" value="" ng-if="!selectedObject">-- fill in your education --</option>
		<option name="education" value="Primary">Primary education</option>
		<option name="education" value="Secondary">Secondary education</option>
		<option name="education" value="Undergraduate">Undergraduate</option>
		<option name="education" value="Masters">Masters</option>
		<option name="education" value="Doctorate">Doctorate</option>
	</select>
	<span class="error">* <?php echo $nameErr;?></span>
	</div>
	<br>

    <label for="dominantHand" >Dominant hand:</label>
	<div class="col-sm-10">
	<select name="dominantHand" ng-model="selectedObject" ng-options="obj for obj in Objects" required>
		<option name="dominantHand" value="" ng-if="!selectedObject">-- fill in your dominant hand --</option>
		<option name="dominantHand" value="Left">Left-handed</option>
		<option name="dominantHand" value="Right">Right-handed</option>
		<option name="dominantHand" value="Both">I write with both hands</option>
	</select>
	<span class="error">* <?php echo $nameErr;?></span>
	</div>
	<br>

    <label for="country" >Country of origin:</label>
    <div class="col-sm-10">
    <select name="country" ng-model="selectedObject" ng-options="obj for obj in Objects" required>
		<option name="country" value="" ng-if="!selectedObject">-- fill in your country --</option>
		<?php
		foreach($countries as $c)
			print "<option name=\"country\" value=\"$c\">$c</option>";
		?>
	</select>
    <span class="error">* <?php echo $nameErr;?></span>
   </div>
	<br>

	<label for="language" >Native language:</label>
		<div class="col-sm-10">
		<input type="text" name="language" class="form-control" id="language" placeholder="Enter Native language" required>
	   <span class="error">* <?php echo $nameErr;?></span>
	   </div>
	<br>


	<b><u>Vision</u>:</b><br><br>
		<label for="eyeVision" >My vision is:</label>
		<span class="error">* <?php echo $nameErr;?></span>
		<div class="radio">
		<label>
			<input type="radio" name="eyeVision" id="optionsRadios1" value="NormalCorrected" required>
			Normal or corrected vision (e.g. eyeglasses, contact lenses or eye surgery).<br>
		</label>
		<label>
			<input type="radio" name="eyeVision" id="optionsRadios2" value="limited" required>
			Limited vision (e.g. partial blindness, severe vision conditions or not using vision aids even though I should). <br>
		</label>
	   </div><br>
	<label for="explainVision">
	Please let us know if there are other issues that affect your vision (optional):
	</label><br>
	<textarea class="form-control" name="explainVision" rows="1" cols="40"></textarea>
	<br><br>

	<b><u>Other</u>:</b><br><br>
		<label for="neuroPsychiProblems" >Have you ever been diagnosed with a neurological or psychiatric condition(s)?</label>
		<div class="col-sm-10">
		<select name="neuroPsychiProblems" ng-model="selectedObject" ng-options="obj for obj in Objects" required>
			<option name="neuroPsychiProblems" value="" ng-if="!selectedObject">-- Choose an answer --</option>
			<option name="neuroPsychiProblems" value="yes">Yes.</option>
			<option name="neuroPsychiProblems" value="no">No.</option>
			<option name="neuroPsychiProblems" value="noAnswer">I prefer not to answer.</option>
		</select>
		<span class="error">* <?php echo $nameErr;?></span>
		</div>
	<br>
	<label for="explainNeuro">
	Please let us know what neurological or psychiatric conditions were you diagnosed with (optional):
	</label><br>
	<textarea class="form-control" name="explainNeuroPsychi" rows="1" cols="40"></textarea>
	<br><br>

    <label for="antipsychoticDrugs" >Have you ever used antipsychotic drugs?</label>
	<div class="col-sm-10">
	<select name="antipsychoticDrugs" ng-model="selectedObject" ng-options="obj for obj in Objects" required>
		<option name="antipsychoticDrugs" value="" ng-if="!selectedObject">-- Choose an answer --</option>
		<option name="antipsychoticDrugs" value="yesPresent">Yes, I currently use antipsychotic medications.</option>
		<option name="antipsychoticDrugs" value="yesPast">Yes, but in the past.</option>
		<option name="antipsychoticDrugs" value="no">No.</option>
		<option name="antipsychoticDrugs" value="noAnswer">I prefer not to answer.</option>
	</select>
	<span class="error">* <?php echo $nameErr;?></span>
	</div>
	<br>

    <label for="learningDisorder" >Have you ever been diagnosed with any learning disability (e.g. dyslexia, attention disorders)?</label>
	<div class="col-sm-10">
	<select name="learningDisorder" ng-model="selectedObject" ng-options="obj for obj in Objects" required>
		<option name="learningDisorder" value="" ng-if="!selectedObject">-- Choose an answer --</option>
		<option name="learningDisorder" value="yes">Yes.</option>
		<option name="learningDisorder" value="no">No.</option>
		<option name="learningDisorder" value="noAnswer">I prefer not to answer.</option>
	</select>
	<span class="error">* <?php echo $nameErr;?></span>
	</div>
	<br>

    <label for="screen" >Which monitor are you using right now (and will be using during the experiment)?</label>
	<div class="col-sm-10">
	<select name="screen" ng-model="selectedObject" ng-options="obj for obj in Objects" required>
		<option name="screen" value="" ng-if="!selectedObject">-- Choose an answer --</option>
		<option name="screen" value="laptop">Laptop.</option>
		<option name="screen" value="external">External screen.</option>
		<option name="screen" value="other">Other.</option>
	</select>
	<span class="error">* <?php echo $nameErr;?></span>
	</div>
	<br>

<button type="submit" name="submitButton" id="submitButton" class="btn btn-primary btn-lg" style="font-family:serif; font-size:18px; height:35px; width:100px; margin-left: auto; margin-right: auto;">Submit</button>
<br>
</div>

<input type="hidden" name="workerID" id="workerID" value="<?echo $workerID ?>">
<input type="hidden" name="experimentType" id="experimentType" value="<?echo $experimentType ?>">
<input type="hidden" name="numberPartOfExp" id="numberPartOfExp" value="<?echo $numberPartOfExp ?>">
<input type="hidden" name="manHor" id="manHor" value="<?echo $manHor ?>">
<input type="hidden" name="manVer" id="manVer" value="<?echo $manVer ?>">

<input type="hidden" id="input1" name="screenWidthSQL">
<input type="hidden" id="input2" name="screenHeightSQL">
<input type="hidden" id="input3" name="screenAvailWidthSQL">
<input type="hidden" id="input4" name="screenAvailHeightSQL">
<input type="hidden" id="input5" name="colorDepthSQL">
<input type="hidden" id="input6" name="pixelDepthSQL">
<input type="hidden" id="input7" name="innerWidthSQL">
<input type="hidden" id="input8" name="innerHeightSQL">
<input type="hidden" id="input9" name="devicePixelRatioSQL">

<script type="text/javascript">
document.getElementById("input1").value = screen.width;
document.getElementById("input2").value = screen.height;
document.getElementById("input3").value = screen.availWidth;
document.getElementById("input4").value = screen.availHeight;
document.getElementById("input5").value = screen.colorDepth;
document.getElementById("input6").value = screen.pixelDepth;
document.getElementById("input7").value = window.innerWidth;
document.getElementById("input8").value = window.innerHeight;
document.getElementById("input9").value = window.devicePixelRatio;
</script>


</form>

<script type="text/javascript">	
var filenamecheck = <?php echo $good; ?>;
if(filenamecheck!=null){
	if(filenamecheck==0){
		document.getElementById('intro').style.display = 'none';
		document.getElementById('introTime').style.display = 'none';
		document.getElementById('introStarted').style.display = 'none';
		document.getElementById('introLate').style.display = 'none';
		document.getElementById('intro2').style.display = 'block';
		document.getElementById('agePart').style.display = 'none';
		document.getElementById('sexPart').style.display = 'none';
		document.getElementById('educationPart').style.display = 'none';
		document.getElementById('dominantHandPart').style.display = 'none';
		document.getElementById('countryPart').style.display = 'none';
		document.getElementById('languagePart').style.display = 'none';
		document.getElementById('visionPart').style.display = 'none';
		document.getElementById('neuroPart').style.display = 'none';
		document.getElementById('drugsPart').style.display = 'none';
		document.getElementById('learningDisorderPart').style.display = 'none';
		document.getElementById('monitorPart').style.display = 'none';
		document.getElementById('submitButton').style.display = 'none';
	}
	if(filenamecheck==9){
		document.getElementById('intro').style.display = 'none';
		document.getElementById('intro2').style.display = 'none';
		document.getElementById('introLate').style.display = 'none';
		document.getElementById('introStarted').style.display = 'none';
		document.getElementById('introTime').style.display = 'block';
		document.getElementById('agePart').style.display = 'none';
		document.getElementById('sexPart').style.display = 'none';
		document.getElementById('educationPart').style.display = 'none';
		document.getElementById('dominantHandPart').style.display = 'none';
		document.getElementById('countryPart').style.display = 'none';
		document.getElementById('languagePart').style.display = 'none';
		document.getElementById('visionPart').style.display = 'none';
		document.getElementById('neuroPart').style.display = 'none';
		document.getElementById('drugsPart').style.display = 'none';
		document.getElementById('learningDisorderPart').style.display = 'none';
		document.getElementById('monitorPart').style.display = 'none';
		document.getElementById('submitButton').style.display = 'none';
	}
	if(filenamecheck==7){
		document.getElementById('intro').style.display = 'none';
		document.getElementById('intro2').style.display = 'none';
		document.getElementById('introLate').style.display = 'none';
		document.getElementById('introTime').style.display = 'none';
		document.getElementById('introStarted').style.display = 'block';
		document.getElementById('agePart').style.display = 'none';
		document.getElementById('sexPart').style.display = 'none';
		document.getElementById('educationPart').style.display = 'none';
		document.getElementById('dominantHandPart').style.display = 'none';
		document.getElementById('countryPart').style.display = 'none';
		document.getElementById('languagePart').style.display = 'none';
		document.getElementById('visionPart').style.display = 'none';
		document.getElementById('neuroPart').style.display = 'none';
		document.getElementById('drugsPart').style.display = 'none';
		document.getElementById('learningDisorderPart').style.display = 'none';
		document.getElementById('monitorPart').style.display = 'none';
		document.getElementById('submitButton').style.display = 'none';
	}
	if(filenamecheck==8){
		document.getElementById('intro').style.display = 'none';
		document.getElementById('intro2').style.display = 'none';
		document.getElementById('introTime').style.display = 'none';
		document.getElementById('introStarted').style.display = 'none';
		document.getElementById('introLate').style.display = 'block';
		document.getElementById('agePart').style.display = 'none';
		document.getElementById('sexPart').style.display = 'none';
		document.getElementById('educationPart').style.display = 'none';
		document.getElementById('dominantHandPart').style.display = 'none';
		document.getElementById('countryPart').style.display = 'none';
		document.getElementById('languagePart').style.display = 'none';
		document.getElementById('visionPart').style.display = 'none';
		document.getElementById('neuroPart').style.display = 'none';
		document.getElementById('drugsPart').style.display = 'none';
		document.getElementById('learningDisorderPart').style.display = 'none';
		document.getElementById('monitorPart').style.display = 'none';
		document.getElementById('submitButton').style.display = 'none';
	}
	if(filenamecheck==1){
		document.getElementById('intro2').style.display = 'none';
		document.getElementById('introTime').style.display = 'none';
		document.getElementById('introStarted').style.display = 'none';
		document.getElementById('introLate').style.display = 'none';
		document.getElementById('intro').style.display = 'block';			
	}
}
</script>

</body>
</html>

<?php
?>