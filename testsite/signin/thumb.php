
	<?php 
	include('PHPconnectionDB.php');

session_start(); // Starting Session
$user_name=$_SESSION["login_user"];
$n = $_GET['n'];


if ($n == '1') { //top 5
$sql = "SELECT photo_id, count(*) FROM views where ROWNUM <=5 group by photo_id desc";
}
if ($n == '2') { // most recent
$sql = "SELECT photo_id FROM images";
}
if ($n == '3') { // most oldest
$sql = "SELECT photo_id FROM images";
}
if ($n == '4') { // ranking
$sql = "SELECT photo_id FROM images";
}
if ($n == 'top5') { // ranking
$sql = "SELECT photo_id FROM images";
}
else {
$sql = "SELECT photo_id FROM images";
}



$conn = connect();
$stid = oci_parse($conn, $sql);
oci_execute($stid);
while($showrow = oci_fetch_array($stid,OCI_ASSOC+OCI_RETURN_NULLS)) {

  		$id = $showrow['PHOTO_ID'];
  		echo "<img src='getimage.php?id=$id' width=100 height=100 />";

}

?>