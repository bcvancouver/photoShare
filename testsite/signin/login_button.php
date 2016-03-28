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
print("connected");
// To protect MySQL injection for Security purpose
$username = stripslashes($username);
$password = stripslashes($password);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);
// SQL query to fetch information of registerd users and finds user match.
$query = oci_parse($connection,"select * from users where password='$password' AND username='$username'");
oci_execute($query);
$rows = oci_num_rows($query);
if ($rows == 1) {
$_SESSION['login_user']=$username; // Initializing Session
header("location: profile.php"); // Redirecting To Other Page
} else {
$error = "Username or Password is invalid";
}
}
?>