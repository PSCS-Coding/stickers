<?php
include_once("connection.php");
include_once("function.php");
include_once("stickerfunctions.php");
if(!empty($_GET)){
	if(!empty($_GET['students'])){
	$studentquery = $db_attendance->query("SELECT studentid,firstname,lastname FROM studentdata WHERE current=1 ORDER BY firstname DESC");
	
	$studentinfo = array();
		while ($student_data = $studentquery->fetch_assoc()) {
			array_push($studentinfo, $student_data);
		}
		foreach($studentinfo as $studentrow){
			echo $studentrow['studentid'] . "," . $studentrow['firstname'] . "," . $studentrow['lastname'] . "---";
		}
	} elseif (!empty($_GET['pass'])){
		if ($LoginResult = $db_stickers->query("SELECT student,admin FROM stickerpass")){
			$LoginRow = $LoginResult->fetch_assoc();
			$LoginResult->free();
		}
		$studentPW = $LoginRow['student'];
		$adminPW = $LoginRow['admin'];
		$SecureAdminPW = $adminPW;
		$SecureStudentPW = $studentPW;
		echo $SecureAdminPW . "," . $SecureStudentPW;
	}
}
?>