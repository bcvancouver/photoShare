<?php 
session_start();
session_write_close();
if (!isset($_SESSION["login_user"]) ) {
	header("location:http://consort.cs.ualberta.ca/~wankinvi/photoShare391/testsite/signin/signin.html");
}
?>