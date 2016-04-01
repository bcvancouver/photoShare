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
$query = oci_parse($connection,"select count(*) from users where password='$password' AND user_name='$username'");
$r = 1;
$check = oci_execute($query); 
while ($row=oci_fetch_array($query,OCI_BOTH)){$r= $row[0];}
	    oci_free_statement($query);
	    oci_close($connection);
       // if username and password already exist in the database, we grant access
	    $result=FALSE;
	    if ($r!='0'){ $result=TRUE;}
	    if ($result){
        $_SESSION['login_user']=$username; // Initializing Session  
                header("location:main.php");
	    }
        else {
        print("not working");
header("location: signin.html");// Redirecting back to log in page
        }
 
}
?>
