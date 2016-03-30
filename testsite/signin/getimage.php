<?php
include('PHPconnectionDB.php');
session_start(); // Starting Session
$user_name=$_SESSION["login_user"];
$sql = "SELECT photo FROM images WHERE owner_name = '$user_name'";
$conn = connect();
$stid = oci_parse($conn, $sql);
oci_execute($stid);
$showrow = oci_fetch_array($stid,OCI_ASSOC+OCI_RETURN_NULLS);
while ($showrow) {
    $img = $showrow['PHOTO']->load();
    header("Content-type: image/jpeg");
    print $img;
    
} else {
    print('Status: 404 Not Found');
    header('Status: 404 Not Found');
}
?>
