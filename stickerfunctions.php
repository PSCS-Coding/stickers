<?php
function addsticker($studentid,$classid,$stickertype){
	global $db_attendance;
	global $db_stickers;
	
	$stickertype = $stickertype . "stickers";
	
	$getstickers = $db_stickers->query("SELECT $stickertype FROM offerings WHERE classid=$classid");
	
		$stickersresult = array();
		while($data_result = $getstickers->fetch_assoc()) {
			array_push($stickersresult, $data_result);
		}
	$cell = $stickersresult[0][$stickertype];
	
	if($cell == "0"){
		echo "there are not stickers so just add";
		
		$stmt = $db_stickers->prepare("UPDATE offerings SET $stickertype = ? WHERE classid=$classid");
		$stmt->bind_param('s', $studentid);
		$stmt->execute();
		
	} elseif(strpos($cell,$studentid . ",") OR strpos($cell,"," . $studentid)){
		echo $studentid . " is alread in there";
		
	} elseif(strpos($cell,",")) {
		echo "explode implode";
		$cellarray = explode(",",$cell);
		
		if(!in_array($studentid,$cellarray)){	
			
			array_push($cellarray,$studentid);
			$celldata = implode(",",$cellarray);
			$stmt = $db_stickers->prepare("UPDATE offerings SET $stickertype = ? WHERE classid=$classid");
			$stmt->bind_param('s', $celldata);
			$stmt->execute();
		}
		
	}  elseif($cell == $studentid) {
		echo "thats the only student in there";
	
	} else {
		echo "theres only one value";
		
		$updatedstudentid = $cell . "," . $studentid;
		$stmt = $db_stickers->prepare("UPDATE offerings SET $stickertype = ? WHERE classid=$classid");
		$stmt->bind_param('s', $updatedstudentid);
		$stmt->execute();
	}

}

?>