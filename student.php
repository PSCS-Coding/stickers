<?php	
session_start(); 
?>
<!DOCTYPE html>
<html>
	<head>
		<title> Student page </title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="stickers.css">
	</head>
<body>
	<?php
	include_once("connection.php");	
	include_once("function.php");
	
	$studentquery = $db_attendance->query("SELECT studentid,firstname,lastname FROM studentdata WHERE current=1 ORDER BY firstname ASC");
	
	$studentinfo = array();
	while ($student_data = $studentquery->fetch_assoc()) {
		array_push($studentinfo, $student_data);
	}
	
	if(!empty($_POST['studentselect'])){
		$_SESSION['id'] = $_POST['studentselect'];
	}
	?>
	<div class='classdata'>
	<a class="back" href="index.php">Back</a>
	<form method='post' action='<?php echo basename($_SERVER['PHP_SELF']); ?>' id='main'>
	<select name='studentselect'>
		<?php 
			foreach($studentinfo as $student){
				echo "<option value=" . $student['studentid'] . ">". $student['firstname'] . " " . substr($student['lastname'], 0, 1) . "</option>";
			}
		?>
	</select>
	<input type="submit" value="Sign In" name="submit">
	<br>
	<br>
	</div>
	</form>
</body>
</html>