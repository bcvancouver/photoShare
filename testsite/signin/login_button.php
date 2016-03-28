<?php
include('PHPconnectionDB.php');
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
{
// Define $username and $password
$username=$_POST['User Name'];
$password=$_POST['Password'];
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
$connection = connect();
// SQL query to fetch information of registerd users and finds user match.
$query = oci_parse($connection,"select * from users where password='$password' AND user_name='$username'");
oci_execute($query);
$rows = oci_num_rows($query);
print("query working");
if ($rows == 1) {
$_SESSION['login_user']=$username; // Initializing Session
header("location: login_button.php"); // Redirecting To Other Page
} else {
header("location: login_button.php");
}
}
?>