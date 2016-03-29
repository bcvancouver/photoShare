<?php
include('PHPconnectionDB.php');
session_start(); // Starting Session
$sql = "SELECT thumbnail FROM images WHERE subject = '$_GET['id']'" .;
$conn = connection();
$stid = oci_parse($conn, $sql);
oci_execute($stid);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
if (!$row) {
    header('Status: 404 Not Found');
} else {
    $img = $row['IMAGE']->load();
    header("Content-type: image/jpeg");
    print $img;
}
?>