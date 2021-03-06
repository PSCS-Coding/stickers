<?php	
session_start(); 
?>
<!DOCTYPE html>
<html>
<?php // init

include_once("connection.php");
include_once("stickerfunctions.php");
include_once("function.php");

if(!empty($_GET['classid'])){
	$_SESSION['classid'] = $_GET['classid']; 
	
} elseif(!empty($_SESSION['classid'])){
	
} else {
	echo "A class has not been chosen";
}
$classid = $_SESSION['classid'];

include_once("connection.php");

$classquery = $db_stickers->query("SELECT * FROM offerings WHERE classid=$classid");
$classresult = array();
while ($data_result = $classquery->fetch_assoc()) {
	array_push($classresult, $data_result);
}

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="stickers.css">
<title><?php echo $classresult[0]['classname']; ?></title>
</head>
<body>

<div class="classdata">
<br>
<a class="back" href="index.php">Back</a>
<h3><?php echo $classresult[0]['classname'] . ", taught by " . $classresult[0]['facilitator']; ?></h3>
<p>


<?php echo $classresult[0]['description'];
if (preg_match('/<p/',$classresult[0]["image"])){
} else {
	?>
<?php	
}
?>
</p>
<img id="classimage" src='<?php echo $classresult[0]["image"]; ?>'>
<p>
<?php 
//render students that have stickered this class
$blackstickers = getstudents($classid,"blackstickers");
$greystickers = getstudents($classid,"greystickers");
$whitestickers = getstudents($classid,"whitestickers");

$blackstickers = explode(",", $blackstickers[0]);
$greystickers = explode(",", $greystickers[0]);
$whitestickers = explode(",", $whitestickers[0]);

if ($blackstickers[0] == 0 && $greystickers[0] == 0 && $whitestickers[0] == 0) {
	?>
		<h3> No Stickers on this class </h3>
	<?php
} else {
	?> <h3> Stickers on this class: </h3> <?php
}

foreach($blackstickers as $sticker){
	echo "<div class = " . "black" . ">" . idToName($sticker) . "</div>";
}

foreach($greystickers as $sticker){
	echo "<div class = " . "grey" . ">" . idToName($sticker) . "</div>";
}

foreach($whitestickers as $sticker){
	echo "<div class = " . "white" . ">" . idToName($sticker) . "</div>";
}

?>
<p>
</div>

</body>
</html>
<style>

#classimage {
	display:block;
	margin-right:auto;
	margin-left:auto;
	width:30%;
}

</style>