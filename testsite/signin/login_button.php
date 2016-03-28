<?php
include('PHPconnectionDB.php');
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
{
// Define $username and $password
$username=$_POST['inputEmail'];
$password=$_POST['inputPassword'];
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
$connection = connect();
// SQL query to fetch information of registerd users and finds user match.
$query = oci_parse($connection,"select * from users where password='$password' AND user_name='$username'");
$rows = oci_num_rows(oci_execute($query));
print($rows);
if ($rows == 1) {
$_SESSION['login_user']=$username; // Initializing Session
    print("You have loged in"); 
} else {
    print("not working");
//header("location: signin.html");// Redirecting back to log in page
}
}
  oci_close($connection);
?>