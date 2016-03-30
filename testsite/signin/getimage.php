<?php
include('PHPconnectionDB.php');
session_start(); // Starting Session
$user_name=$_SESSION["login_user"];
$sql = "SELECT thumbnail FROM images WHERE subject = '$user_name'";
$conn = connect();
$stid = oci_parse($conn, $sql);
oci_execute($stid);
$showrow = oci_fetch_row($stid);
if(!$showrow){
return;
}else{
$image=$showrow['0']->load();
header("Content-type: image/JPEG");
print $image;
print ("working");
}
?>