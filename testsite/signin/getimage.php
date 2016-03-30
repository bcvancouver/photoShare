<?php
include('PHPconnectionDB.php');
session_start(); // Starting Session
$user_name=$_SESSION["login_user"];
$sql = "SELECT photo FROM images WHERE owner_name = '$user_name'";
$conn = connect();
print ("1working");
$stid = oci_parse($conn, $sql);
oci_execute($stid);
$showrow = oci_fetch_array($stid);
echo '<img src="data:image/jpeg;base64,'.base64_encode( $result['image'] ).'"/>';
print ("2working");
if(!$showrow){
print("Error in oci_fetch_row");
return;
}else{
$image=$showrow['0']->load();
header("Content-type: image/JPEG");
print $image;
print ("3working");
}
?>