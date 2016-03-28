<?php
session_start();
if(session_destroy()) // Destroying All Sessions
{
header("Location: main.html"); // Redirecting To Home Page
}
?>