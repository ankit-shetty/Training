<?php
session_start();

include_once 'dbconnect.php';

    $email=$_REQUEST['user'];
    $pass=$_REQUEST['pass'];
    $query = "INSERT INTO userdetails(user_name,user_password) VALUES('$email','$password')";
    $res = mysql_query($query);
    header("Location: adminpage.php");

?>
