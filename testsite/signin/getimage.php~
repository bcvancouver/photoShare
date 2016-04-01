<?php
include('PHPconnectionDB.php');
$id = $_GET['id'];
session_start(); // Starting Session
$user_name=$_SESSION["login_user"];
$sql = "SELECT PHOTO FROM images WHERE photo_id = '$id'";
$conn = connect();
$stid = oci_parse($conn, $sql);
oci_execute($stid);
$showrow = oci_fetch_array($stid,OCI_ASSOC+OCI_RETURN_NULLS);
if (!$showrow) {  print('Status: 404 Not Found');
    header('Status: 404 Not Found');
    die();
}
if ($showrow) {
  $img = $showrow['PHOTO']->load();
    header("Content-type: image/jpeg");
    print $img;
}
    
  
?>
