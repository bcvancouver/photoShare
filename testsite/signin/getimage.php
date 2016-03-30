<?php
include('PHPconnectionDB.php');
session_start(); // Starting Session
$user_name=$_SESSION["login_user"];
$sql = "SELECT photo FROM images WHERE owner_name = '$user_name'";
$conn = connect();
print ("1working");
$stid = oci_parse($conn, $sql);
oci_execute($stid);
$showrow = oci_fetch_array($stid, OCI_ASSOC);
$image=$showrow['0']->load();
header("Content-type: image/JPEG");
print $image;
print ("3working");
}
?>

<?php

	$myblobid = $_GET['id'];;
	$myimgtype = $_GET['type'];
	include("connection_database.php");
	$conn=connect();
	$query = "SELECT ".$myimgtype." FROM images WHERE photo_id= :MYBLOBID";
	$stmt = oci_parse ($conn, $query);
	oci_bind_by_name($stmt, ':MYBLOBID', $myblobid);
	oci_execute($stmt);
	$arr = oci_fetch_array($stmt, OCI_ASSOC);
	$myimgtype = strtoupper($myimgtype);
	$result = $arr[$myimgtype]->load();
	header("Content-type: image/jpg");
	echo $result;
	oci_close($conn);
?>