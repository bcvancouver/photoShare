
	<?php 
	include('PHPconnectionDB.php');

session_start(); // Starting Session
$user_name=$_SESSION["login_user"];
$n = $_GET['n'];
$conn = connect();

if ($user_name == "admin") {
		$query = "SELECT photo_id FROM images";	
	}
	elseif ($profile) { //own images
		$query = "select photo_id from images where owner_name = '$user_name'";
		//$query = "select photo_id from images where permitted = '1' or owner_name = '$user' or permitted in (select group_id from group_lists where friend_id = '$user' union select group_id from groups where user_name = '$user' )";
	}
	elseif ($n == "1") {
		//recent
		$query = "SELECT photo_id FROM images";	
				//$query = "select photo_id from images where permitted = '1' or owner_name = '$user' or permitted in (select group_id from group_lists where friend_id = '$user' union select group_id from groups where user_name = '$user' )";
	}
	elseif ($n == "2") {
		//oldest
		$query = "SELECT photo_id FROM images";	
				//$query = "select photo_id from images where permitted = '1' or owner_name = '$user' or permitted in (select group_id from group_lists where friend_id = '$user' union select group_id from groups where user_name = '$user' )";
	}
	elseif ($n == "3") {
		//top 5 popular images
		$query = "select photo_id, count(photo_id) as visits from photo_count where ROWNUM <=5 group by photo_id order by visits desc";
				//$query = "select photo_id from images where permitted = '1' or owner_name = '$user' or permitted in (select group_id from group_lists where friend_id = '$user' union select group_id from groups where user_name = '$user' )";
	}
	else {
		$query = "select photo_id from images where permitted = '1' or owner_name = '$user' or permitted in 
		(select group_id from group_lists where friend_id = '$user' union select group_id from groups where user_name = '$user' )";
	}
	function imagequery($query,$conn) {
		$stid = oci_parse ($conn, $query);
		oci_execute($stid);
		while ($arr = oci_fetch_array($stid, OCI_ASSOC)){
			$id = $arr['PHOTO_ID'];
			echo '<a href="getimage.php?id='.$id.'"><img src="getimage.php?id='.$id.'&type=thumbnail" width="200" height="200" /></a>';
		}	
	}
	imagequery($query,$conn);
	oci_close($conn);


?>